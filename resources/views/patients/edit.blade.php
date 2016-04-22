@extends('layouts.app')

@section('title', '| Edit Patient')

@section('content')

  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <div class="panel panel-default z-depth-2">
        <div class="panel-heading">
          <h3 class="panel-title">Edit Patient - {{ $patient->chart_number}}:</h3>
        </div>
        <div class="panel-body">
          {!! Form::model($patient, ['route' => ['patients.update', $patient->id], 'method'=>'PUT', 'class'=>'form-horizontal']) !!}
            <div class="form-group">
              {{ Form::label('first_name', 'First Name:', array('class'=>'col-md-2 control-label')) }}
              <div class="col-md-10">
                {{ Form::text('first_name', null, array('class'=>'form-control', 'placeholder'=>'First Name...')) }}
              </div>
            </div>

            <div class="form-group">
              {{ Form::label('middle_name', 'Middle Name:', array('class'=>'col-md-2 control-label')) }}
              <div class="col-md-10">
                {{ Form::text('middle_name', null, array('class'=>'form-control', 'placeholder'=>'Middle Name...')) }}
              </div>
            </div>

            <div class="form-group">
              {{ Form::label('last_name', 'Last Name:', array('class'=>'col-md-2 control-label')) }}
              <div class="col-md-10">
                {{ Form::text('last_name', null, array('class'=>'form-control', 'placeholder'=>'Last Name...')) }}
              </div>
            </div>

            <div class="form-group">
              {{ Form::label('gender', 'Gender:', array('class'=>'col-md-2 control-label')) }}
              <div class="col-md-10">
                {{ Form::select('gender', array('Male' => 'Male', 'Female' => 'Female'), null, ['class'=>'form-control']) }}
              </div>
            </div>

            <div class="form-group">
              {{ Form::label('dob', 'Date of Birth:', array('class'=>'col-md-2 control-label')) }}
              <div class="col-md-10">
                {{ Form::date('dob', \Carbon\Carbon::now(), array('class'=>'form-control')) }}
              </div>
            </div>

            <div class="form-group">
              {{ Form::label('street1', 'Street 1:', array('class'=>'col-md-2 control-label')) }}
              <div class="col-md-10">
                {{ Form::text('street1', null, array('class'=>'form-control', 'placeholder'=>'Street 1...')) }}
              </div>
            </div>

            <div class="form-group">
              {{ Form::label('street2', 'Street 2:', array('class'=>'col-md-2 control-label')) }}
              <div class="col-md-10">
                {{ Form::text('street2', null, array('class'=>'form-control', 'placeholder'=>'Street 2...')) }}
              </div>
            </div>

            <div class="form-group">
              {{ Form::label('city', 'City:', array('class'=>'col-md-2 control-label')) }}
              <div class="col-md-10">
                {{ Form::text('city', 'St. John\'s', array('class'=>'form-control', 'placeholder'=>'City...')) }}
              </div>
            </div>

            <div class="form-group">
              {{ Form::label('province', 'Province:', array('class'=>'col-md-2 control-label')) }}
              <div class="col-md-10">
                {{ Form::text('province', 'Newfoundland', array('class'=>'form-control', 'placeholder'=>'Province...')) }}
              </div>
            </div>

            <div class="form-group">
              {{ Form::label('postcode', 'Post Code:', array('class'=>'col-md-2 control-label')) }}
              <div class="col-md-10">
                {{ Form::text('postcode', null, array('class'=>'form-control', 'placeholder'=>'Post Code...')) }}
              </div>
            </div>

            <div class="form-group">
              {{ Form::label('country', 'Country:', array('class'=>'col-md-2 control-label')) }}
              <div class="col-md-10">
                {{ Form::text('country', 'Canada', array('class'=>'form-control', 'placeholder'=>'Country...')) }}
              </div>
            </div>

            <div class="form-group">
              {{ Form::label('phone1', 'Phone 1:', array('class'=>'col-md-2 control-label')) }}
              <div class="col-md-10">
                {{ Form::text('phone1', null, array('class'=>'form-control phone', 'placeholder'=>'(xxx) xxx-xxxx', 'data-mask'=>'(999) 999-9999')) }}
              </div>
            </div>

            <div class="form-group">
              {{ Form::label('phone2', 'Phone 2:', array('class'=>'col-md-2 control-label')) }}
              <div class="col-md-10">
                {{ Form::text('phone2', null, array('class'=>'form-control phone', 'placeholder'=>'(xxx) xxx-xxxx', 'data-mask'=>'(999) 999-9999')) }}
              </div>
            </div>

            <div class="form-group">
              {{ Form::label('phone3', 'Phone 3:', array('class'=>'col-md-2 control-label')) }}
              <div class="col-md-10">
                {{ Form::text('phone3', null, array('class'=>'form-control phone', 'placeholder'=>'(xxx) xxx-xxxx', 'data-mask'=>'(999) 999-9999')) }}
              </div>
            </div>

            <div class="form-group">
              {{ Form::label('email', 'Email Address:', array('class'=>'col-md-2 control-label')) }}
              <div class="col-md-10">
                {{ Form::text('email', null, array('class'=>'form-control', 'placeholder'=>'Email Address...')) }}
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                {!! Html::decode(link_to_route('patients.show', '<i class="fa fa-times"></i> &nbsp;&nbsp;Cancel', array($patient->id), array('class'=>'btn btn-danger btn-block'))) !!}
              </div>
              <div class="col-md-6">
                {{ Form::button('<i class="fa fa-floppy-o"></i> &nbsp;&nbsp; Save Patient', array('class'=>'btn btn-success btn-block', 'type'=>'submit' )) }}
              </div>
            </div>

          {!! Form::close() !!}
        </div>
      </div>
    </div>
  </div>


@endsection
