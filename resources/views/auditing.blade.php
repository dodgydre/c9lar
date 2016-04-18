@extends('layouts.app')

@section('content')

<ol>
  @forelse($logs as $log)
    <li>
      {{ $log->customMessage }}
    </li>
  @empty
    <li>
      No Logs
    </li>
  @endforelse
</ol>

@endsection
