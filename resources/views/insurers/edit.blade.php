@extends('layouts.app')

@section('title', '| Edit Insurer')

@section('content')

  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <div class="panel panel-default z-depth-2">
        <div class="panel-heading">
          <h3 class="panel-title">Edit Insurer - {{ $insurer->code }}</h3>
        </div>
        <div class="panel-body">
          {!! Form::model($insurer, ['route'=> ['insurers.update', $insurer->id], 'method'=>'PUT']) !!}
            <div class="form-group">
              {{ Form::label('code', 'Insurer Code:') }}
              {{ Form::text('code', null, ['class'=>'form-control input-lg', 'disabled']) }}
            </div>
            <div class="form-group">
              {{ Form::label('name', 'Insurer Name:') }}
              {{ Form::text('name', null, ['class'=>'form-control input-lg']) }}
            </div>
            <div class="form-group">
              {{ Form::label('street1', 'Street 1:') }}
              {{ Form::text('street1', null, ['class'=>'form-control input-lg']) }}
            </div>
            <div class="form-group">
              {{ Form::label('street2', 'Street 2:') }}
              {{ Form::text('street2', null, ['class'=>'form-control input-lg']) }}
            </div>

            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  {{ Form::label('city', 'City:') }}
                  {{ Form::text('city', null, ['class'=>'form-control input-lg']) }}
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  {{ Form::label('prov', 'Province:') }}
                  {{ Form::text('prov', null, ['class'=>'form-control input-lg']) }}
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  {{ Form::label('postcode', 'Post Code:') }}
                  {{ Form::text('postcode', null, ['class'=>'form-control input-lg']) }}
                </div>
              </div>
            </div>

            <div class="form-group">
              {{ Form::label('country', 'Country:') }}
              {{ Form::text('country', null, ['class'=>'form-control input-lg']) }}
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  {{ Form::label('phone', 'Phone Number:') }}
                  {{ Form::text('phone', null, ['class'=>'form-control input-lg']) }}
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  {{ Form::label('fax', 'Fax Number:') }}
                  {{ Form::text('fax', null, ['class'=>'form-control input-lg']) }}
                </div>
              </div>
            </div>

            <div class="row">
              <hr />
              <div class="col-sm-6">
                {!! Html::decode(link_to_route('insurers.show', '<i class="fa fa-times"></i> &nbsp;&nbsp;Cancel', array($insurer->id), array('class'=> 'btn btn-danger btn-block'))) !!}

              </div>
              <div class="col-sm-6">
                {{ Form::button('<i class="fa fa-floppy-o"></i> &nbsp;&nbsp;Save Insurer', ['class'=>'btn btn-success btn-block', 'type'=>'submit']) }}
              </div>
            </div>
          {!! Form::close() !!}

        </div>
      </div>
    </div>
  </div><!-- close .row -->

@endsection
