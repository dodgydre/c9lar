@extends('layouts.app')

@section('title', '| Edit Procedure')

@section('content')

  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <div class="panel panel-default z-depth-2">
        <div class="panel-heading">
          <h3 class="panel-title">Edit Procedure - {{ $procedure->code }}</h3>
        </div>
        <div class="panel-body">
          {!! Form::model($procedure, ['route'=> ['procedures.update', $procedure->id], 'method'=>'PUT']) !!}
            {{ Form::label('code', 'Procedure Code:') }}
            {{ Form::text('code', null, ['class'=>'form-control input-lg', 'disabled']) }}

            {{ Form::label('type', 'Procedure Type:') }}
            {{ Form::text('type', null, ['class'=>'form-control input-lg']) }}

            {{ Form::label('description', 'Procedure Description:') }}
            {{ Form::text('description', null, ['class'=>'form-control input-lg']) }}

            {{ Form::label('amount', 'Procedure Amount($):') }}
            {{ Form::text('amount', null, ['class'=>'form-control input-lg']) }}
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
