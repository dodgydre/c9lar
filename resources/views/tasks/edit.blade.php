@extends('layouts.app')

@section('title', '| Edit Task')

@section('content')

  <div class="row">
    <div class="col-md-10 col-md-offset-1">

      <div class="panel panel-default z-depth-2">
        <div class="panel-heading">
          <h3 class="panel-title">Edit Task - {{ $task->name }}</h3>
        </div>

        <div class="panel-body">
          {!! Form::model($task, ['route'=> ['tasks.update', $task->id], 'method'=>'PUT', 'class'=>'form-horizontal']) !!}
            <div class="form-group">
              {{ Form::label('name', 'Task Name:', array('class'=>'col-md-2 control-label')) }}
              <div class="col-md-10">
                {{ Form::text('name', null, ['class'=>'form-control']) }}
              </div>
            </div>

            <div class="form-group">
              {{ Form::label('type', 'Task Description:', array('class'=>'col-md-2 control-label')) }}
              <div class="col-md-10">
              {{ Form::text('description', null, ['class'=>'form-control']) }}
              </div>
            </div>

            <div class="row">
              <hr />
              <div class="col-sm-6">
                {!! Html::decode(link_to_route('tasks.show', '<i class="fa fa-times"></i> &nbsp;&nbsp;Cancel', array($task->id), array('class'=> 'btn btn-danger btn-block'))) !!}

              </div>
              <div class="col-sm-6">
                {{ Form::button('<i class="fa fa-floppy-o"></i> &nbsp;&nbsp;Save Task', ['class'=>'btn btn-success btn-block', 'type'=>'submit']) }}
              </div>
            </div>
          {!! Form::close() !!}

        </div>
      </div>
    </div>
  </div><!-- close .row -->

@endsection
