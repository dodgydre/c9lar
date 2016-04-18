<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Input;
use App\Appointment;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    //
    public function generate_uuid() {
      return sprintf('%04x%04x-%04x-%04x-%04x%04x%04x%04x',
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0x0fff) | 0x4000,
        mt_rand(0, 0x3fff) | 0x8000,
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff)
      );
    }

    public function showCalendar() {
      $events = [];

      /*$events[] = \Calendar::event(
        'Event One',
        false,
        '2016-04-15T10:00:00-02:30',
        '2016-04-15T11:00:00-02:30',
        $this->generate_uuid(),
        [
          'className' =>
        ]
     );*/

     $eloquentEvent = Appointment::all();
     foreach($eloquentEvent as $event) {
       $events[] = \Calendar::event(
        $event->title,
        $event->allDay,
        $event->start,
        $event->end,
        $event->id,
        [
          'provider' => $event->provider,
        ]
      );
     }

     $calendar = \Calendar::setId('pbcc_calendar')
      ->addEvents($events)
      ->setOptions([
          'firstDay'=>1,
          'editable'=>true,
          'disableDragging'=>false,
          'defaultView'=>'agendaDay',
          'slotEventOverlap' => false,
          'slotDuration'=>'00:15',
          'slotLabelFormat' => 'h(:mm)a',
          'slotLabelInterval' => '00:30',
          'selectable' => true,
          'selectHelper' => true,
          'allDaySlot' => false,
          'minTime' => '08:00:00',
          'maxTime' => '20:00:00',
        ])->setCallbacks([
          'eventDrop' => "function(calEvent, jsEvent, view) {
            //alert('/move/event/' + calEvent.id + '/' + calEvent.start + '/' + calEvent.end);
            var url = '/calendar/updateEvent';
            var post = {};
            post.id = calEvent.id;
            post.start = calEvent.start.format('YYYY-MM-DD HH:mm:ss');
            console.log(calEvent.start.format('YYYY-MM-DD HH:mm:ss'));
            post.end = calEvent.end.format('YYYY-MM-DD HH:mm:ss');
            post.title = calEvent.title;
            $.ajax({
              headers: {
                'X-CSRF-TOKEN': $('meta[name=\"csrf-token\"]').attr('content')
              },
              type: 'POST',
              url: url,
              data: post,
              cache: false,
              success: function(data) {
                return data;
              }
            });
            return false;
            // change the border color just for fun
            //$(this).css('border-color', 'red');
          }",
          'eventResize' => "function(calEvent, jsEvent, view) {
            //alert('/move/event/' + calEvent.id + '/' + calEvent.start + '/' + calEvent.end);
            var url = '/calendar/updateEvent';
            var post = {};
            post.id = calEvent.id;
            post.start = calEvent.start.format('YYYY-MM-DD HH:mm:ss');
            post.end = calEvent.end.format('YYYY-MM-DD HH:mm:ss');
            post.title = calEvent.title;
            $.ajax({
              headers: {
                'X-CSRF-TOKEN': $('meta[name=\"csrf-token\"]').attr('content')
              },
              type: 'POST',
              url: url,
              data: post,
              cache: false,
              success: function(data) {
                return data;
              }
            });
            return false;
          }",
          'select' => "function(start, end, allDay) {
            var title = prompt('Event Title:');
            if(title) {
              $('#calendar-pbcc_calendar').fullCalendar('renderEvent',
              {
                title: title,
                start: start,
                end: end,
                allDay: ! start.hasTime()
              },
              true
              );

              // save the event
              var url = '/calendar/createEvent';
              var post = {};

              post.start = start.format('YYYY-MM-DD HH:mm:ss');
              post.end = end.format('YYYY-MM-DD HH:mm:ss');
              post.title = title;
              post.allDay = ! start.hasTime();
              $.ajax({
                headers: {
                  'X-CSRF-TOKEN': $('meta[name=\"csrf-token\"]').attr('content')
                },
                type: 'POST',
                url: url,
                data: post,
                cache: false,
                success: function(data) {
                  return data;
                }
              });
            }
            $('#calendar-pbcc_calendar').fullCalendar('unselect');

          }",
          'eventRender' => "function(event, element) {
            console.log(event.id);
            if(event.provider == 'JEG') {
              console.log('JEG');
              element.addClass('JEG');
            }
            else if(event.provider == 'CH') {
              console.log('CH');
              element.addClass('CH');
            }
          }",
          'eventAfterRender' => "function(event, element, view) {
            var width = $('.fc-widget-content').width();
            var left = elemet.left();
            width = width/3;
            $(element).css('width', width + 'px');
          }"
        ]);

     return view('calendar.show', compact('calendar'));

    }

    public function updateEvent(Request $request) {
      $data = $request->all();
      //dd($data);
      if($request->ajax())
      {
        $id = $data['id'];
        $appointment = Appointment::find($id);
        $appointment->start = $data['start'];
        $appointment->end = $data['end'];
        $appointment->title = $data['title'];
        $appointment->save();
        $string = "Appointment #" . $id . " changed - Start: " . $appointment->start . " - End " . $appointment->end;
        return $string;
      }//2016-04-15T09:00:00-02:30
    }

    public function createEvent(Request $request) {
      $data = $request->all();
      //dd($data);
      if($request->ajax())
      {
        $appointment = new Appointment;
        $appointment->start = $data['start'];
        $appointment->end = $data['end'];
        $appointment->title = $data['title'];
        $appointment->allDay = $data['allDay'];
        $appointment->save();
        $string = "Appointment #" . $appointment->id . " created - Start: " . $appointment->start . " - End " . $appointment->end;
        return $string;
      }//2016-04-15T09:00:00-02:30
    }

}
