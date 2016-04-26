@extends('layouts.app')
@section('title')
  Schedule - {{ $provider }}
@endsection

@section('styles')
  <link rel="stylesheet" href="/css/fullcalendar.css" />
@endsection

@section('content')
<div class="row">

  <div class="col-md-8 col-md-offset-2">
    <h1>Schedule for {{ $provider->name() }}</h1>

  {!! $calendar->calendar() !!}

  </div>

</div>

<div id="createEventModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
          <h3 id="myModalLabel1">Create Appointment</h3>
      </div>
      <div class="modal-body">
        {!! Form::open(array('class'=>'form form-horizontal', 'id'=>'newEventForm')) !!}
          <input type="hidden" id="apptStartTime"/>
          <input type="hidden" id="apptEndTime"/>

          <div class="control-group">
              <label class="control-label" for="patientName">Patient:</label>
              {{ Form::select('patientName', $patientList, null, ['id' => 'patientName', 'class'=>'form-control', 'placeholder' => 'select patient...']) }}
          </div>
        {!! Form::close() !!}

      </div>
      <div class="modal-footer">
          <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
          <button type="submit" class="btn btn-primary" id="submitButton">Save</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
  <script src="/js/moment.min.js"></script>
  <script src="/js/fullcalendar.js"></script>

  {!! $calendar->script() !!}
  <script>
  $(document).ready(function() {
    // Add selectize dropdown
    var $select = $('#patientName').selectize({
        create: false,
    });

    // if the modal closes without being submitted still unselect the event.
    $('#createEventModal').on('hidden.bs.modal', function () {
      var selected = $select[0].selectize;
      selected.clear();
      $('#calendar-pbcc_calendar').fullCalendar('unselect');
    });

    $('#submitButton').on('click', function(e){
      // We don't want this to act as a link so cancel the link action
      e.preventDefault();
      doSubmit();
    });

    function doSubmit()
    {
      $("#createEventModal").modal('hide');
      console.log($('#apptStartTime').val());
      console.log($('#apptEndTime').val());
      console.log($('#patientName').val());
      //alert("form submitted");
      title = $('#patientName').val();

      if(title)
      {
        var start = moment(new Date($('#apptStartTime').val()));
        var end = moment(new Date($('#apptEndTime').val()));

        // first put an event in the local calendar display
        $('#calendar-pbcc_calendar').fullCalendar('renderEvent',
        {
          title: $("#patientName option:selected").text(),
          start: start,
          end: end,
          allDay: ($('#apptAllDay').val() == "true"),
          provider: '{{ $provider->code }}',
          className: '{{ $provider->code }}',
          description: 'DESCRiption'
        });

        // save the event
        var url = '/calendar/{{$provider_id}}/createEvent';
        var post = {};
        // local format
        post.start = start.format('YYYY-MM-DD HH:mm:ss');
        post.end = end.format('YYYY-MM-DD HH:mm:ss');
        // google calendar format
        post.gstart = start.toISOString();
        post.gend = end.toISOString();
        post.patientId = $('#patientName').val();
        post.title = $('#patientName option:selected').text();
        post.allDay = ($('#apptAllDay').val() == "true");
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
    }
  });
  </script>
@endsection
