@extends('layouts.app')

@section('title', '| New Insurer')

@section('content')

  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h1>Create New Insurance:</h1>
        </div>
        <div class="panel-body">
          {!! Form::open(array('route' => 'insurers.store')) !!}
              <div class="form-group">  
              {{ Form::label('code', 'Insurer Code:') }}
              {{ Form::text('code', null, array('class'=>'form-control', 'placeholder'=>'AAA00')) }}
              </div>
              {{ Form::label('name', 'Insurer Name:') }}
              {{ Form::text('name', null, array('class'=>'form-control', 'placeholder'=>'Insurer Name...')) }}
              {{ Form::label('street1', 'Street:') }}
              {{ Form::text('street1', null, array('class'=>'form-control', 'placeholder'=>'Street...')) }}
              {{ Form::label('street2', 'Street:') }}
              {{ Form::text('street2', null, array('class'=>'form-control', 'placeholder'=>'Street...')) }}
              {{ Form::label('city', 'City:') }}
              {{ Form::text('city', null, array('class'=>'form-control', 'placeholder'=>'City...', 'value'=>'St. John\'s')) }}
              {{ Form::label('prov', 'Province:') }}
              {{ Form::text('prov', null, array('class'=>'form-control', 'placeholder'=>'Province...', 'value'=>'NL')) }}
              {{ Form::label('country', 'Country:') }}
              {{ Form::text('country', null, array('class'=>'form-control', 'placeholder'=>'Country...', 'value'=>'Canada')) }}
              {{ Form::label('postcode', 'Post Code:') }}
              {{ Form::text('postcode', null, array('class'=>'form-control', 'placeholder'=>'Post Code...')) }}
              {{ Form::label('phone', 'Phone Number:') }}
              {{ Form::text('phone', null, array('class'=>'form-control', 'placeholder'=>'(xxx) xxx-xxxx')) }}
              {{ Form::label('fax', 'Fax Number:') }}
              {{ Form::text('fax', null, array('class'=>'form-control', 'placeholder'=>'(xxx) xxx-xxxx')) }}
              {{ Form::submit('Create Insurer', array('class'=>'btn btn-success btn-lg btn-block', 'style'=>'margin-top: 20px;' ))}}
          {!! Form::close() !!}
        </div>
      </div>
    </div>
  </div>


@endsection
