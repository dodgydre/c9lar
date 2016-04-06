@extends('layouts.app')

@section('title', '| New Procedure')

@section('content')

  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <div class="panel panel-default z-depth-2">
        <div class="panel-heading">
          <h3 class="panel-title">Create New Procedure:</h3>
        </div>
        <div class="panel-body">
          {!! Form::open(array('route' => 'procedures.store', 'class'=>'form-horizontal')) !!}

            <div class="form-group">
            {{ Form::label('code', 'Procedure Code:', array('class'=>'col-md-2 control-label')) }}
              <div class="col-md-10">
                {{ Form::text('code', null, array('class'=>'form-control', 'placeholder'=>'Procedure Code...')) }}
              </div>
            </div>

            <div class="form-group">
              {{ Form::label('type', 'Procedure Type:', array('class'=>'col-md-2 control-label')) }}
              <div class="col-md-10">
                <?php
                echo Form::select('type', array(
                  'A' => 'Procedure Charge',
                  'B' => 'Product Charge',
                  'H' => 'Billing Charge',
                  'I' => 'Insurance Payment',
                  'J' => 'Cash Co-Payment',
                  'K' => 'Check Co-Payment',
                  'L' => 'Credit Card Co-Payment',
                  'M' => 'Cash Payment',
                  'N' => 'Check Payment',
                  'O' => 'Credit Card Payment',
                  'P' => 'Deductible',
                  'S' => 'Adjustment',
                  'T' => 'Insurance Adjustment'), null, ['class'=>'form-control'] );
                ?>
              </div>
            </div>

            <div class="form-group">
              {{ Form::label('description', 'Procedure Description:', array('class'=>'col-md-2 control-label')) }}
              <div class="col-md-10">
                {{ Form::text('description', null, array('class'=>'form-control', 'placeholder'=>'Procedure Description...')) }}
              </div>
            </div>

            <div class="form-group">
              {{ Form::label('amount', 'Amount for Procedure ($):', array('class'=>'col-md-2 control-label')) }}
              <div class="col-md-10">
                {{ Form::text('amount', null, array('class'=>'form-control', 'placeholder'=>'xx.xx')) }}
              </div>
            </div>

            <div class="form-group">
              {{ Form::label('taxable', 'Taxable:', array('class'=>'col-md-2 control-label')) }}
              <div class="col-md-10">
                {{ Form::hidden('taxable', '0') }}
                {{ Form::checkbox('taxable', '1') }}
              </div>
            </div>

            <div class="form-group">
              {{ Form::label('inactive', 'Inactive:', array('class'=>'col-md-2 control-label')) }}
              <div class="col-md-10">
                {{ Form::hidden('inactive', '0') }}
                {{ Form::checkbox('inactive', '1') }}
              </div>
            </div>

            {{ Form::submit('Create Procedure', array('class'=>'btn btn-success btn-lg btn-block', 'style'=>'margin-top: 20px;' )) }}
          {!! Form::close() !!}
        </div>
      </div>
    </div>
  </div>


@endsection
