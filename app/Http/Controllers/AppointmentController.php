<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\GoogleCalendar;
use App\Http\Requests;
use Input;
use Carbon\Carbon;
use DB;

use App\Appointment;
use App\Patient;
use App\Provider;
use App\Calendar;

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

    public function getCalendarID()
      {
        $calendar = new GoogleCalendar;
        $calendarId = 'pn0qnhkiai0calfpf7b1lvojfg@group.calendar.google.com';
        //$nextSyncToken = "CIDcx-GamMwCEIDcx-GamMwCGAQ=";
        $nextSyncToken = '';
        $params = ['syncToken'=>$nextSyncToken];

        $result = $calendar->getEvents($calendarId, $params);
        dd($result);
        //$result = $calendar->get($calendarId);
        //$result = $this->addEvent($calendarId);
      }


    public function showCalendar($provider_id) {
      $calendar = new GoogleCalendar;
      $patients = Patient::orderBy('last_name')->get();
      $patientList = [];
      foreach($patients as $patient) {
        $patientList[$patient->id] = $patient->last_name . ', ' . $patient->first_name;
      }

      $provider = Provider::find($provider_id);
      $provider_calendar = $provider->calendar;
      $calendarId = $provider_calendar->calendar_id;
      $nextSyncToken = $provider_calendar->syncToken;

      $params = ['syncToken'=>$nextSyncToken];
      $results = $calendar->getEvents($calendarId, $params);
      // set the new sync token
      $provider_calendar->syncToken = $results->nextSyncToken;
      $provider_calendar->save();

      // update the appointments table
      foreach($results as $result) {
        // if cancelled, remove the old one
        if($result->status == 'cancelled') {
          $event = Appointment::where('uuid', '=', $result->id)->first();
            if($event) $event->delete();
        }
        // if not cancelled then check if it's a new one or update anyway
        else {
          //echo $event->start->dateTime . "<br>";
          // update the record in the appointments table
          $event = Appointment::firstOrCreate(['uuid' => $result->id]);
          $event->title = $result->summary;
          $event->allDay = 0; // ADD FULL DAY SOMEHOW HERE
          $event->start = Carbon::createFromFormat('Y-m-d\TH:i:sO', $result->start->dateTime);
          $event->end = Carbon::createFromFormat('Y-m-d\TH:i:sO', $result->end->dateTime);
          $event->uuid = $result->id;
          $event->provider = $provider->code;
          $event->description = $result->description;
          $event->save();
        }
      }

     $events = [];
     $eloquentEvents = Appointment::where('provider', '=', $provider->code)->get();
     foreach($eloquentEvents as $event) {
       $events[] = \Calendar::event(
        $event->title,
        $event->allDay,
        $event->start,
        $event->end,
        $event->uuid,
        [
          'provider' => $event->provider,
          'className' => $event->provider . '_appt',
          'description' => $event->description
        ]
      );
     }

     $events[] = \Calendar::event(
      'no Overlap Event',
      false,
      '2016-04-20 15:00:00',
      '2016-04-20 16:00:00',
      'fffff',
      [
        'provider' => "JEG",
        'overlap' => false,
      ]
    );

     $calendar = \Calendar::setId('pbcc_calendar')
      ->addEvents($events)
      ->setOptions([
          'firstDay'=>1,
          'editable'=>true,
          'disableDragging'=>false,
          'defaultView'=>'agendaDay',
          'slotEventOverlap' => false,
          'slotDuration'=>'00:15',
          'slotLabelFormat' => 'h:mma',
          'slotLabelInterval' => '00:30',
          'selectable' => true,
          'selectHelper' => true,
          'allDaySlot' => false,
          'minTime' => '08:00:00',
          'maxTime' => '20:00:00',
          'timezone' => 'local',
          'header' => [
            'left' => 'prev,next today',
            'center' => 'title',
            'right' => 'agendaDay, basicDay, agendaWeek, month'
            ],
          'hiddenDays' => [ 0, 6 ]
        ])->setCallbacks([
          // UPDATE EXISTING EVENT
          // Add check for overlaps to the resize function.
          'eventDrop' => "function(calEvent, delta, revertFunc, jsEvent, ui, view) {
            // check overlapping

            var start = new Date(calEvent.start);
            var end = new Date(calEvent.end);

            // loop through all of the events looking for overlaps
            var overlap = $('#calendar-pbcc_calendar').fullCalendar('clientEvents', function(ev) {

              if( ev == calEvent) { return false; }

              var estart = new Date(ev.start);
              var eend = new Date(ev.end);

              // check overlaps
              return (
                (Math.round(start/1000) > Math.round(estart/1000) && Math.round(end/1000) < Math.round(eend/1000)) ||
                (Math.round(end/1000) > Math.round(estart/1000) && Math.round(end/100) < Math.round(eend/100)) ||
                (Math.round(start/100) < Math.round(eend/100) && Math.round(end/100) > Math.round(eend/100)) ||
                (Math.round(start/100) == Math.round(estart/100)) ||
                (Math.round(end/100) == Math.round(eend/100))
              );

            });

            if (overlap.length > 2){
              revertFunc();
              return false;
             }

             // end check overlap

            var url = '/calendar/" . $provider_id . "/updateEvent';
            var post = {};
            post.id = calEvent.id;
            // google calendar format
            post.gstart = calEvent.start.toISOString();
            post.gend = calEvent.end.toISOString();
            // local format
            post.start = calEvent.start.format('YYYY-MM-DD HH:mm:ss');
            post.end = calEvent.end.format('YYYY-MM-DD HH:mm:ss');
            post.title = calEvent.title;
            // TODO: Google Calendar allows for a description.  Add extra text to modal.
            post.description = 'description';
            /*$.ajax({
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
            });*/
            return true;
            // change the border color just for fun
            //$(this).css('border-color', 'red');
          }",  // UPDATE EXISTING EVENT
          'eventResize' => "function(calEvent, delta, revertFunc, jsEvent, view) {
            // check overlapping

            var start = new Date(calEvent.start);
            var end = new Date(calEvent.end);

            // loop through all of the events looking for overlaps
            var overlap = $('#calendar-pbcc_calendar').fullCalendar('clientEvents', function(ev) {

              if( ev == calEvent) { return false; }

              var estart = new Date(ev.start);
              var eend = new Date(ev.end);
              // check overlaps
              return (
                (Math.round(start/1000) > Math.round(estart/1000) && Math.round(end/1000) < Math.round(eend/1000)) ||
                (Math.round(end/1000) > Math.round(estart/1000) && Math.round(end/100) < Math.round(eend/100)) ||
                (Math.round(start/100) < Math.round(eend/100) && Math.round(end/100) > Math.round(eend/100)) ||
                (Math.round(start/100) == Math.round(estart/100)) ||
                (Math.round(end/100) == Math.round(eend/100))
              );

            });

            if (overlap.length > 2){
              revertFunc();
              return false;
             }
             // end check overlap

            var url = '/calendar/" . $provider_id . "/updateEvent';
            var post = {};
            post.id = calEvent.id;
            // google calendar format
            post.gstart = calEvent.start.toISOString();
            post.gend = calEvent.end.toISOString();
            // local format
            post.start = calEvent.start.format('YYYY-MM-DD HH:mm:ss');
            post.end = calEvent.end.format('YYYY-MM-DD HH:mm:ss');
            post.title = calEvent.title;
            /*$.ajax({
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
            });*/
            return true;
          }",  // CREATE NEW EVENT
          'select' => "function(start, end, jsEvent, view) {
            //var title = prompt('Event Title:');
            $('#createEventModal #apptStartTime').val(start);
            $('#createEventModal #apptEndTime').val(end);
            $('#createEventModal').modal('show');
          }",
          //  playing with event width
          'eventAfterRender' => "function(event, element, view) {
            if( $(element).css('z-index') == 1) {
              $(element).css('width', '33.33%');
              $(element).css('left', '0%');
            }
            else if( $(element).css('z-index') == 2) {
              $(element).css('width', '33.33%');
              $(element).css('left', '33.33%');
            }
            else if( $(element).css('z-index') == 3) {
              $(element).css('width', '33.33%');
              $(element).css('left', '66.66%');
            }
          }",
          'eventRender' => "function(event, element) {
            element.popover({
              html:true,
              title: event.title,
              placement: 'right',
              content: event.description
            }).click(function() {
              setTimeout(function() {
                $('.popover').popover('hide');
              }, 2000);
            });
          }"
        ]);

     return view('calendar.show', compact('calendar', 'provider', 'provider_id', 'patientList'));

    }

    public function updateEvent(Request $request, $provider_id) {
      if($request->ajax())
      {
        $data = $request->all();

        $calendar = new GoogleCalendar;

        $provider = Provider::find($provider_id);
        $provider_calendar = $provider->calendar;
        $calendar_id = $provider_calendar->calendar_id;

        //$provider = DB::table('google_calendar_settings')->where('name', '=', 'calendar' . $provider_id . '_provider')->value('value');
        //$calendarId = DB::table('google_calendar_settings')->where('name', '=', 'calendar' . $provider_id . '_id')->value('value');

        $eventId = $data['id'];

        $event = new \Google_Service_Calendar_Event(array(
          'summary' => $data['title'],
          'start' => array(
            'dateTime' => $data['gstart'],
            'timeZone' => 'Canada/Newfoundland',
          ),
          'end' => array(
            'dateTime' => $data['gend'],
            'timeZone' => 'Canada/Newfoundland',
          ),
        ));
        $result = $calendar->updateEvent($calendarId, $eventId, $event);

        $uuid = $data['id'];
        $appointment = Appointment::where('uuid', '=', $uuid)->first();
        $appointment->start = $data['start'];
        $appointment->end = $data['end'];
        $appointment->title = $data['title'];
        $appointment->save();
        $string = "Appointment #" . $uuid . " changed - Start: " . $appointment->start . " - End " . $appointment->end;
        return $string;
      }
    }

    // TODO: Check this at home... CORS request from here.
    public function createEvent(Request $request, $provider_id) {
      //dd($data);
      if($request->ajax())
      {
        $data = $request->all();
        $calendar = new GoogleCalendar;
        $patient = Patient::find($data['patientId']);

        $provider = Provider::find($provider_id);
        $provider_calendar = $provider->calendar;
        $calendar_id = $provider_calendar->calendar_id;

        //$provider = DB::table('google_calendar_settings')->where('name', '=', 'calendar' . $provider_id . '_provider')->value('value');
        //$calendarId = DB::table('google_calendar_settings')->where('name', '=', 'calendar' . $provider_id . '_id')->value('value');

        $event = new \Google_Service_Calendar_Event(array(
          'summary' => $data['title'],
          'description' => $patient->phone1,
          'start' => array(
            'dateTime' => $data['gstart'],
            'timeZone' => 'Canada/Newfoundland',
          ),
          'end' => array(
            'dateTime' => $data['gend'],
            'timeZone' => 'Canada/Newfoundland',
          ),
        ));
        $result = $calendar->addEvent($calendarId, $event);
        $uuid = $result->id;

        $appointment = new Appointment;
        $appointment->start = $data['start'];
        $appointment->end = $data['end'];
        $appointment->title = $data['title'];
        $appointment->allDay = $data['allDay'];
        $appointment->phone1 = $patient->phone1;
        $appointment->name = $patient->first_name . " " . $patient->last_name;
        $appointment->chart_number = $patient->chart_number;
        $appointment->provider = $provider->code;
        $appointment->uuid = $uuid;
        $appointment->save();
        $string = "Appointment #" . $appointment->id . " created - Start: " . $appointment->start . " - End " . $appointment->end;
        return $string;
      }//2016-04-15T09:00:00-02:30
    }
}
