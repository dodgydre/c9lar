@extends('layouts.app')

@section('title', '| New Procedure')

@section('content')

  <div class="row">
    <div class="col-md-8 col-md-offset-2">

      <h1>Create New Procedure:</h1>
      <hr />
      {!! Form::open(array('route' => 'procedures.store')) !!}
          {{ Form::label('code', 'Procedure Code:') }}
          {{ Form::text('code', null, array('class'=>'form-control', 'placeholder'=>'Procedure Code...')) }}
          {{ Form::label('type', 'Procedure Type:') }}
          {{ Form::text('type', null, array('class'=>'form-control', 'placeholder'=>'Procedure Type...')) }}
          {{ Form::label('description', 'Procedure Description:') }}
          {{ Form::text('description', null, array('class'=>'form-control', 'placeholder'=>'Procedure Description...')) }}
          {{ Form::label('amount', 'Amount for Procedure ($):') }}
          {{ Form::text('amount', null, array('class'=>'form-control', 'placeholder'=>'xx.xx')) }}
          {{ Form::submit('Create Procedure', array('class'=>'btn btn-success btn-lg btn-block', 'style'=>'margin-top: 20px;' ))}}
      {!! Form::close() !!}

    </div>
  </div>


@endsection
