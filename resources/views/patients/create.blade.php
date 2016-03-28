@extends('layouts.app')

@section('title', '| New Patient')

@section('content')

  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h2 class="panel-title">Register New Patient:</h2>
        </div>
        <div class="panel-body">
          {!! Form::open(array('route' => 'patients.store')) !!}
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    {{ Form::label('first_name', 'First Name:') }}
                    {{ Form::text('first_name', null, array('class'=>'form-control', 'placeholder'=>'First Name...')) }}
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    {{ Form::label('middle_name', 'Middle Name:') }}
                    {{ Form::text('middle_name', null, array('class'=>'form-control', 'placeholder'=>'Middle Name...')) }}
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    {{ Form::label('last_name', 'Last Name:') }}
                    {{ Form::text('last_name', null, array('class'=>'form-control', 'placeholder'=>'Last Name...')) }}
                  </div>
                </div>
              </div>
              
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    {{ Form::label('gender', 'Gender:') }}
                    {{ Form::select('gender', array('M' => 'Male', 'F' => 'Female'), null, ['class'=>'form-control']) }}
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    {{ Form::label('dob', 'Date of Birth:') }}
                    {{ Form::date('dob', \Carbon\Carbon::now(), array('class'=>'form-control')) }}
                  </div>
                </div>
              </div>
              
              <div class="form-group">
                {{ Form::label('street1', 'Street 1:') }}
                {{ Form::text('street1', null, array('class'=>'form-control', 'placeholder'=>'Street 1...')) }}
              </div>
              <div class="form-group">
                {{ Form::label('street2', 'Street 2:') }}
                {{ Form::text('street2', null, array('class'=>'form-control', 'placeholder'=>'Street 2...')) }}
              </div>
              
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    {{ Form::label('city', 'City:') }}
                    {{ Form::text('city', 'St. John\'s', array('class'=>'form-control', 'placeholder'=>'City...')) }}
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    {{ Form::label('province', 'Province:') }}
                    {{ Form::text('province', 'Newfoundland', array('class'=>'form-control', 'placeholder'=>'Province...')) }}
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    {{ Form::label('postcode', 'Post Code:') }}
                    {{ Form::text('postcode', null, array('class'=>'form-control', 'placeholder'=>'Post Code...')) }}
                  </div>
                </div>
              </div>
              
              <div class="form-group">
                {{ Form::label('country', 'Country:') }}
                {{ Form::text('country', 'Canada', array('class'=>'form-control', 'placeholder'=>'Country...')) }}
              </div>
              
              <div class="form-group">
                {{ Form::label('phone1', 'Phone 1:') }}
                {{ Form::text('phone1', null, array('class'=>'form-control', 'placeholder'=>'(xxx) xxx-xxxx')) }}
              </div>
              <div class="form-group">
                {{ Form::label('phone2', 'Phone 2:') }}
                {{ Form::text('phone2', null, array('class'=>'form-control', 'placeholder'=>'(xxx) xxx-xxxx')) }}
              </div>
              <div class="form-group">
                {{ Form::label('phone3', 'Phone 3:') }}
                {{ Form::text('phone3', null, array('class'=>'form-control', 'placeholder'=>'(xxx) xxx-xxxx')) }}
              </div>
              <div class="form-group">
                {{ Form::label('phone4', 'Phone 4:') }}
                {{ Form::text('phone4', null, array('class'=>'form-control', 'placeholder'=>'(xxx) xxx-xxxx')) }}
              </div>
              <div class="form-group">
                {{ Form::label('phone5', 'Phone 5:') }}
                {{ Form::text('phone5', null, array('class'=>'form-control', 'placeholder'=>'(xxx) xxx-xxxx')) }}
              </div>
              <div class="form-group">
                {{ Form::label('email', 'Email Address:') }}
                {{ Form::text('email', null, array('class'=>'form-control', 'placeholder'=>'Email Address...')) }}
              </div>

              {{ Form::button('<i class="fa fa-floppy-o"></i> &nbsp;&nbsp; Create Patient', array('class'=>'btn btn-success btn-lg btn-block', 'style'=>'margin-top: 20px;', 'type'=>'submit' )) }}
          {!! Form::close() !!}
        </div>
      </div>
    </div>
  </div>


@endsection
