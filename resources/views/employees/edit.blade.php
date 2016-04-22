@extends('layouts.app')

@section('title', '| Edit Employee')

@section('content')

  <div class="row">
    <div class="col-md-8 col-md-offset-2">

      <div class="panel panel-default z-depth-2">
        <div class="panel-heading">
          <h3 class="panel-title">Edit Employee - {{ $employee->first_name }} {{ $employee->last_name }}</h3>
        </div>

        <div class="panel-body">
          {!! Form::model($employee, ['route'=> ['employees.update', $employee->id], 'method'=>'PUT', 'class'=>'form-horizontal']) !!}

            <div class="form-group">
              {{ Form::label('first_name', 'First Name:', array('class'=>'col-md-3 control-label')) }}
              <div class="col-md-8">
                {{ Form::text('first_name', null, ['class'=>'form-control']) }}
              </div>
            </div>
            <div class="form-group">
              {{ Form::label('last_name', 'Last Name:', array('class'=>'col-md-3 control-label')) }}
              <div class="col-md-8">
                {{ Form::text('last_name', null, ['class'=>'form-control']) }}
              </div>
            </div>
            <div class="form-group">
              {{ Form::label('street1', 'Street 1:', array('class'=>'col-md-3 control-label')) }}
              <div class="col-md-8">
                {{ Form::text('street1', null, ['class'=>'form-control']) }}
              </div>
            </div>
            <div class="form-group">
              {{ Form::label('street2', 'Street 2:', array('class'=>'col-md-3 control-label')) }}
              <div class="col-md-8">
                {{ Form::text('street2', null, ['class'=>'form-control']) }}
              </div>
            </div>
            <div class="form-group">
              {{ Form::label('city', 'City:', array('class'=>'col-md-3 control-label')) }}
              <div class="col-md-8">
                {{ Form::text('city', null, ['class'=>'form-control']) }}
              </div>
            </div>
            <div class="form-group">
              {{ Form::label('prov', 'Province:', array('class'=>'col-md-3 control-label')) }}
              <div class="col-md-8">
                {{ Form::text('prov', null, ['class'=>'form-control']) }}
              </div>
            </div>
            <div class="form-group">
              {{ Form::label('post_code', 'Post Code:', array('class'=>'col-md-3 control-label')) }}
              <div class="col-md-8">
                {{ Form::text('post_code', null, ['class'=>'form-control']) }}
              </div>
            </div>
            <div class="form-group">
              {{ Form::label('country', 'Country:', array('class'=>'col-md-3 control-label')) }}
              <div class="col-md-8">
                {{ Form::text('country', null, ['class'=>'form-control']) }}
              </div>
            </div>
            <div class="form-group">
              {{ Form::label('phone', 'Phone Number:', array('class'=>'col-md-3 control-label')) }}
              <div class="col-md-8">
                {{ Form::text('phone', null, ['class'=>'form-control phone_us', 'placeholder'=>'(xxx) xxx-xxxx']) }}
              </div>
            </div>
            <div class="form-group">
              {{ Form::label('email', 'Email:', array('class'=>'col-md-3 control-label')) }}
              <div class="col-md-8">
                {{ Form::text('email', null, ['class'=>'form-control']) }}
              </div>
            </div>
            <div class="form-group">
              {{ Form::label('sin', 'Social Insurance #:', array('class'=>'col-md-3 control-label')) }}
              <div class="col-md-8">
                {{ Form::text('sin', null, ['class'=>'form-control']) }}
              </div>
            </div>
            <div class="form-group">
              {{ Form::label('birth_date', 'Birth Date:', array('class'=>'col-md-3 control-label')) }}
              <div class="col-md-8">
                <div class="input-group date" data-provide="datepicker">
                  {{ Form::text('birth_date', null, ['class'=>'form-control', 'id'=>'birth_date']) }}
                  <div class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                  </div>
                </div>
              </div>
            </div>

            <div class="form-group">
              {{ Form::label('hire_date', 'Hire Date:', array('class'=>'col-md-3 control-label')) }}
              <div class="col-md-8">
                <div class="input-group date" data-provide="datepicker">
                  {{ Form::text('hire_date', null, ['class'=>'form-control', 'id'=>'hire_date']) }}
                  <div class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                  </div>
                </div>
              </div>
            </div>

            <div class="form-group">
              {{ Form::label('status', 'Status:', array('class'=>'col-md-3 control-label')) }}
              <div class="col-md-8">
                {{ Form::select('status', array(1=>'Current Employee', 0=>'Prior Employee'), 1, ['class'=>'form-control']) }}
              </div>
            </div>



            <div class="row">
              <hr />
              <div class="col-sm-6">
                {!! Html::decode(link_to_route('employees.show', '<i class="fa fa-times"></i> &nbsp;&nbsp;Cancel', array($employee->id), array('class'=> 'btn btn-danger btn-block'))) !!}

              </div>
              <div class="col-sm-6">
                {{ Form::button('<i class="fa fa-floppy-o"></i> &nbsp;&nbsp;Save Employee', ['class'=>'btn btn-success btn-block', 'type'=>'submit']) }}
              </div>
            </div>
          {!! Form::close() !!}

        </div>
      </div>
    </div>
  </div><!-- close .row -->

@endsection

@section('scripts')
  <script type="text/javascript">
    $(document).ready(function() {
      $('.phone_us').mask('(000) 000-0000');

      $('.date').datepicker({
          todayHighlight: 'TRUE',
          autoclose: true,
          keyboardNavigation: true,
      });
    });

  </script>
@endsection
