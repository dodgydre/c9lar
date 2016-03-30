@extends('layouts.app')

@section('title', '| Patient')

@section('content')

  <div class="row">
  <div class="col-md-8">

    <ul class="list-group">
      <li class="list-group-item list-group-item-info">
        <span class="pull-left"><strong>Name:</strong> {{ $patient->first_name }} {{ $patient->middle_name }} {{$patient->last_name }}</span>
        <span class="pull-right">Chart Number: <strong>{{ $patient->chart_number }}</strong></span>
        <div class="clearfix">

        </div>
       </li>
      <li class="list-group-item"> <strong>Gender:</strong> {{ $patient->gender }} </li>
      <li class="list-group-item"> <strong>Date of Birth:</strong> {{ $patient->dob }}</li>
      <li class="list-group-item"> <strong>Address:</strong> <br />
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
      </li>
      <li class="list-group-item"> <strong>Phone 1:</strong> {{ $patient->phone1 }} <br />
      <strong>Phone 2:</strong> {{ $patient->phone2 }} <br />
      <strong>Phone 3:</strong> {{ $patient->phone3 }} </li>
      <li class="list-group-item"> <strong>Email:</strong> {{ $patient->email }} </li>
    </ul>
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

  </div> <!-- close .col-md-4 -->
</div> <!-- close .row -->

<!-- Charges -->
<div class="row">
  <div class="col-md-12">
    <div class="panel panel-info">
      <div class="panel-heading">
        <h3 class="panel-title">Charges</h3>
      </div>
      <div class="panel-body charges-panel">
        <table class="table table-striped">
          <thead>
            <tr>
              <th style='width: 10%'> Date </th>
              <th style='width: 10%'> Procedure Code </th>
              <th style='width: 20%'> Procedure Description </th>
              <th style='width: 15%'> Provider </th>
              <th style='width: 10%'> Units </th>
              <th style='width: 10%'> Cost / Unit </th>
              <th style='width: 10%'> Total Amount </th>
              <th style='width: 5%'> </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              {!! Form::open(array('route' => 'patients.addCharge')) !!}
              {{ Form::hidden('patient_id', $patient->id) }}
              <td> {{ Form::date('date_from', \Carbon\Carbon::now(), array('class'=>'form-control')) }} </td>
              <td> {{ Form::text('procedure_code', null, array('class'=>'form-control')) }} </td>
              <td> {{ Form::text('procedure_description', null, array('class'=>'form-control')) }} </td>
              <td> {{ Form::select('attending_provider', array('JEG' => 'Dr. Grace', 'CH'=>'C. Hounsell'), null, array('class'=>'form-control')) }} </td>
              <td> {{ Form::text('units', null, array('class'=>'form-control')) }} </td>
              <td> {{ Form::text('amount', null, array('class'=>'form-control')) }} </td>
              <td> {{ Form::text('total', null, array('class'=>'form-control')) }} </td>
              <td> {{ Form::button('<i class="fa fa-plus"></i>', array('class'=>'btn btn-success btn-sm', 'type'=>'submit' )) }} </td>
              {!! Form::close() !!}
            </tr>
            @foreach($patient->charges as $charge)
              <tr>
                <td> {{ date('d/m/Y' ,strtotime($charge->date_from)) }} </td>
                <td> {{ $charge->procedure_code }} </td>
                <td> {{ $charge->procedure_description }} </td>
                <td> {{ $charge->attending_provider }} </td>
                <td> {{ $charge->units }} </td>
                <td> {{ $charge->amount }} </td>
                <td> {{ $charge->total }} </td>
                <td> </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>


<!-- Payments -->
<?php /*
<div class="row">
  <div class="col-md-12">
    <div class="panel panel-warning">
      <div class="panel-heading">
        <h3 class="panel-title">Payments</h3>
      </div>
      <div class="panel-body payments-panel">
        <table class="table table-striped">
          <thead>
            <tr>
              <th> Date </th>
              <th> Procedure Code </th>
              <th> Procedure Description </th>
              <th> Provider </th>
              <th> Unit </th>
              <th> Cost / Unit </th>
              <th> Total Amount </th>
            </tr>
          </thead>
          <tbody>
            @foreach($patient->charges as $charge)
              <tr>
                <td> {{ date('d/m/Y' ,strtotime($charge->date_from)) }} </td>
                <td> {{ $charge->procedure_code }} </td>
                <td> {{ $charge->procedure_description }} </td>
                <td> {{ $charge->provider }} </td>
                <td> {{ $charge->unit }} </td>
                <td> {{ $charge->amount }} </td>
                <td> {{ $charge->total }} </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
*/ ?>
@endsection
