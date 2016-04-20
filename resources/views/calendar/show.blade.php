@extends('layouts.app')
@section('title')
  Schedule - {{ $provider }}
@endsection

@section('styles')
  <link rel="stylesheet" href="/fullcalendar/fullcalendar.css" />
  <!--
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.css"/>
-->
  <style>
    .JEG {
      background: green;
    }
    .CH {
      background: purple;
    }
  </style>
@endsection

@section('content')
<div class="row">

  <div class="col-md-8 col-md-offset-2">
    <h1>Schedule for {{ $provider }}</h1>

  {!! $calendar->calendar() !!}

  </div>

</div>
@endsection

@section('scripts')
  <script src="/fullcalendar/lib/jquery.min.js"></script>
  <script src="/fullcalendar/lib/moment.min.js"></script>
  <script src="/fullcalendar/fullcalendar.js"></script>
  <!--
  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.js"></script>
  -->

  {!! $calendar->script() !!}

  <script>

  </script>
@endsection
