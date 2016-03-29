@extends('layouts.app')

@section('title', '| Patient')

@section('content')

  <div class="row">
  <div class="col-md-8">
    <h1> {{ $patient->chart_number }}</h1>

    <p> <strong>Name:</strong> {{ $patient->first_name }} {{ $patient->middle_name }} {{$patient->last_name }}</p>
    <p> <strong>Gender:</strong> {{ $patient->gender }} </p>

    <p> <strong>Date of Birth:</strong> {{ $patient->dob }}</p>

    <p> <strong>Address:</strong> </p>
    <p>
      @if(!empty($patient->street1))
        &nbsp;&nbsp;{{ $patient->street1 }}<br />
      @endif
      @if(!empty($patient->street2))
        &nbsp;&nbsp;{{ $patient->street2 }}<br />
      @endif
      @if(!empty($patient->city))
        &nbsp;&nbsp;{{ $patient->city }}
      @endif
      @if(!empty($patient->prov))
        &nbsp;&nbsp; {{ $patient->prov }}<br />
      @elseif(!empty($patient->city))
        <br />
      @endif
      @if(!empty($patient->postcode))
        &nbsp;&nbsp;{{ $patient->postcode }}<br />
      @endif
      @if(!empty($patient->country))
        &nbsp;&nbsp;{{ $patient->country }}<br />
      @endif
    </p>
    <p> <strong>Phone 1:</strong> {{ $patient->phone1 }} </p>
    <p> <strong>Phone 2:</strong> {{ $patient->phone2 }} </p>
    <p> <strong>Phone 3:</strong> {{ $patient->phone3 }} </p>
    <p> <strong>Email:</strong> {{ $patient->email }} </p>
  </div>

  <div class="col-md-4">
    <div class="well">
        <dl>
          <dt>Created at:</dt>
          <dd>{{ date('F j, Y, g:i a' ,strtotime($patient->created_at)) }} </dd>
          <dt>Last updated at:</dt>
          <dd>{{ date('F j, Y, g:i a' ,strtotime($patient->updated_at)) }} </dd>
        </dl>
        <hr />

        <div class="row">
          <div class="col-sm-6">
            <a href="{{ route('patients.edit', $patient->id) }}" class="btn btn-block btn-primary"><i class="fa fa-pencil-square-o"></i> Edit</a>
          </div>
          <div class="col-sm-6">
            <form method='POST' action="{{ route('patients.destroy', [$patient->id]) }}">
              {!! csrf_field() !!}
              {!! method_field('DELETE') !!}
              @if(Entrust::hasRole('admin'))
                <button class="btn btn-block btn-danger" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-trash"></i> Delete</button>
              @endif
            </form>

          </div>
          <div class="col-sm-12">
            <a href="{{route('patients.index')}}" class="btn btn-default btn-block btn-h1-spacing"><i class="fa fa-arrow-left"></i> Show All Patients</a>
          </div>
        </div>

    </div>

  </div>
</div>


@endsection
