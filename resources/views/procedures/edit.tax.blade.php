@extends('layouts.app')

@section('title', '| Edit Tax Rate')

@section('content')

  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <div class="panel panel-default z-depth-2">
        <div class="panel-heading">
          <h3 class="panel-title">Edit Tax Rate </h3>
        </div>
        <div class="panel-body">
          {!! Form::model($procedure, ['route'=> ['procedures.update', $procedure->id], 'method'=>'PUT', 'class'=>'form-horizontal']) !!}
            <div class="form-group">
              {{ Form::label('code', 'Procedure Code:', array('class'=>'col-md-2 control-label')) }}
              <div class="col-md-10">
                {{ Form::text('code', null, ['class'=>'form-control input-lg', 'disabled']) }}
              </div>
            </div>

            <div class="form-group">
              {{ Form::label('description', 'Procedure Description:', array('class'=>'col-md-2 control-label')) }}
              <div class="col-md-10">
                {{ Form::text('description', null, ['class'=>'form-control input-lg']) }}
              </div>
            </div>

            <div class="form-group">
              {{ Form::label('amount', 'Tax Rate (%):', array('class'=>'col-md-2 control-label')) }}
              <div class="col-md-10">
                {{ Form::text('amount', null, ['class'=>'form-control input-lg']) }}
              </div>
            </div>

            <div class="row">
              <hr />
              <div class="col-sm-6">
                {!! Html::decode(link_to_route('procedures.show', '<i class="fa fa-times"></i> &nbsp;&nbsp;Cancel', array($procedure->id), array('class'=> 'btn btn-danger btn-block'))) !!}

              </div>
              <div class="col-sm-6">
                {{ Form::button('<i class="fa fa-floppy-o"></i> &nbsp;&nbsp;Save Procedure', ['class'=>'btn btn-success btn-block', 'type'=>'submit']) }}
              </div>
            </div>
          {!! Form::close() !!}

        </div>
      </div>
    </div>
  </div><!-- close .row -->

@endsection
