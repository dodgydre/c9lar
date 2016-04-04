@extends('layouts.app')

@section('title', '| Patient')

@section('styles')
<link rel="stylesheet" href="{{ URL::asset('css/bootstrap-datepicker.min.css') }}">
@endsection

@section('content')

  <div class="row">

    <div class="col-md-8">
      <div class="row">
        <div class="col-md-6">
          <ul class="list-group">
            <li class="list-group-item list-group-item-info">
              <span class="pull-left"><strong>Name:</strong> {{ $patient->first_name }} {{ $patient->middle_name }} {{$patient->last_name }}</span>
              <span class="pull-right">Chart Number: <strong>{{ $patient->chart_number }}</strong></span>
              <div class="clearfix">

              </div>
             </li>
            <li class="list-group-item"> <strong>Gender:</strong> {{ $patient->gender }} </li>
            <li class="list-group-item"> <strong>Date of Birth:</strong> {{ $patient->dob }}</li>
            <li class="list-group-item"> <strong>Address:</strong> <br />
              @if(!empty($patient->street1))
                &nbsp;&nbsp;{{ $patient->street1 }}<br />
              @endif
              @if(!empty($patient->street2))
                &nbsp;&nbsp;{{ $patient->street2 }}<br />
              @endif
              @if(!empty($patient->city))
                &nbsp;&nbsp;{{ $patient->city }}
              @endif
              @if(!empty($patient->prov))
                &nbsp;&nbsp; {{ $patient->prov }}<br />
              @elseif(!empty($patient->city))
                <br />
              @endif
              @if(!empty($patient->postcode))
                &nbsp;&nbsp;{{ $patient->postcode }}<br />
              @endif
              @if(!empty($patient->country))
                &nbsp;&nbsp;{{ $patient->country }}<br />
              @endif
            </li>
            <li class="list-group-item"> <strong>Phone 1:</strong> {{ $patient->phone1 }} <br />
            <strong>Phone 2:</strong> {{ $patient->phone2 }} <br />
            <strong>Phone 3:</strong> {{ $patient->phone3 }} </li>
            <li class="list-group-item"> <strong>Email:</strong> {{ $patient->email }} </li>
          </ul>
        </div> <!-- close .col-md-6 -->
        <div class="col-md-6">
          <ul class="list-group">
            <li class="list-group-item list-group-item-info">
              Insurance
            </li>
            <li class="list-group-item {{ isset($patient->insurer1) ? '' : 'hidden'}}" id="insurer1_info">
              <span class="pull-left">Insurer 1: {{ $patient->insurance1->name or '' }}</span>
              <span class="pull-right"><button class="btn btn-sm btn-info" id="button_insurer1">change</button></span>
              <div class="clearfix"> </div>
            </li>
            <li class="list-group-item {{ isset($patient->insurer1) ? 'hidden' : '' }}" id="insurer1_form">
              {!! Form::open(array('route' => 'patients.assignInsurer', 'class' => 'form-inline')) !!}
              {{ Form::hidden('patient_id', $patient->id) }}
              {{ Form::hidden('insurer_num', 1) }}
                <div class="form-group">
                  <label for="insurer">Insurer 1: </label>
                  <select class="form-control" name="insurer" id="select_insurer1">
                    <option disabled selected value> -- Add Insurer -- </option>
                    @foreach($insurers as $insurer)
                      <option value="{{$insurer->code}}"> {{$insurer->name}} </option>
                    @endforeach
                  </select>
                </div>

              {{ Form::button('<i class="fa fa-plus"></i>', array('class'=>'btn btn-success btn-sm', 'type'=>'submit', 'id'=>'submit_insurer1', 'disabled' )) }}
              {!! Form::close() !!}
            </li>

            <li class="list-group-item {{ isset($patient->insurer2) ? '' : 'hidden'}}" id="insurer2_info">
              <span class="pull-left">Insurer 2: {{ $patient->insurance1->name or '' }}</span>
              <span class="pull-right"><button class="btn btn-sm btn-info" id="button_insurer2">change</button></span>
              <div class="clearfix"> </div>
            </li>

            <li class="list-group-item {{ isset($patient->insurer2) ? 'hidden' : '' }}" id="insurer2_form">
              {!! Form::open(array('route' => 'patients.assignInsurer', 'class' => 'form-inline')) !!}
              {{ Form::hidden('patient_id', $patient->id) }}
              {{ Form::hidden('insurer_num', 2) }}
                <div class="form-group">
                  <label for="insurer">Insurer 2: </label>
                  <select class="form-control" name="insurer" id="select_insurer1">
                    <option disabled selected value> -- Add Insurer -- </option>
                    @foreach($insurers as $insurer)
                      <option value="{{$insurer->code}}"> {{$insurer->name}} </option>
                    @endforeach
                  </select>
                </div>

              {{ Form::button('<i class="fa fa-plus"></i>', array('class'=>'btn btn-success btn-sm', 'type'=>'submit', 'id'=>'submit_insurer1', 'disabled' )) }}
              {!! Form::close() !!}
            </li>

            <li class="list-group-item {{ isset($patient->insurer3) ? '' : 'hidden'}}" id="insurer3_info">
              <span class="pull-left">Insurer 1: {{ $patient->insurance3->name or '' }}</span>
              <span class="pull-right"><button class="btn btn-sm btn-info" id="button_insurer1">change</button></span>
              <div class="clearfix"> </div>
            </li>
            <li class="list-group-item {{ isset($patient->insurer3) ? 'hidden' : '' }}" id="insurer3_form">
              {!! Form::open(array('route' => 'patients.assignInsurer', 'class' => 'form-inline')) !!}
              {{ Form::hidden('patient_id', $patient->id) }}
              {{ Form::hidden('insurer_num', 3) }}
                <div class="form-group">
                  <label for="insurer">Insurer 3: </label>
                  <select class="form-control" name="insurer" id="select_insurer1">
                    <option disabled selected value> -- Add Insurer -- </option>
                    @foreach($insurers as $insurer)
                      <option value="{{$insurer->code}}"> {{$insurer->name}} </option>
                    @endforeach
                  </select>
                </div>

              {{ Form::button('<i class="fa fa-plus"></i>', array('class'=>'btn btn-success btn-sm', 'type'=>'submit', 'id'=>'submit_insurer1', 'disabled' )) }}
              {!! Form::close() !!}
            </li>
           </ul>
         </div>
      </div>
    </div>

<!-- SOME INFO  -->
  <div class="col-md-4">
    <div class="well">
        <dl>
          <dt>Created at:</dt>
          <dd>{{ date('F j, Y, g:i a' ,strtotime($patient->created_at)) }} </dd>
          <dt>Last updated at:</dt>
          <dd>{{ date('F j, Y, g:i a' ,strtotime($patient->updated_at)) }} </dd>
          <dt>Remaining Balance</dt>
          <dd>{{ $patient->remaining_balance }}</dd>
        </dl>
        <hr />

        <div class="row">
          <div class="col-sm-6">
            <a href="{{ route('patients.edit', $patient->id) }}" class="btn btn-block btn-primary"><i class="fa fa-pencil-square-o"></i> Edit</a>
          </div>
          <div class="col-sm-6">
            <form method='POST' action="{{ route('patients.destroy', [$patient->id]) }}">
              {!! csrf_field() !!}
              {!! method_field('DELETE') !!}
              @if(Entrust::hasRole('admin'))
                <button class="btn btn-block btn-danger" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-trash"></i> Delete</button>
              @endif
            </form>

          </div>
          <div class="col-sm-12">
            <a href="{{route('patients.index')}}" class="btn btn-default btn-block btn-h1-spacing"><i class="fa fa-arrow-left"></i> Show All Patients</a>
          </div>
        </div>

    </div>

  </div> <!-- close .col-md-4 -->
</div> <!-- close .row -->

<!-- Charges -->
<!-- TODO: Colors: No Payment (warning), Partially Paid (info), Overpaid (danger), Paid (white) -->
<div class="row">
  <div class="col-md-12">
    <div class="panel panel-info">
      <div class="panel-heading">
        <h3 class="panel-title">Charges</h3>
      </div>
      <div class="panel-body charges-panel">
        <table class="table table-striped">
          <thead>
            <tr>
              <th style='width: 20%'> Date </th>
              <th style='width: 10%'> Procedure Code </th>
              <th style='width: 20%'> Procedure Description </th>
              <th style='width: 15%'> Provider </th>
              <th style='width: 10%'> Units </th>
              <th style='width: 10%'> Cost / Unit </th>
              <th style='width: 10%'> Total Amount </th>
              <th style='width: 10%'> Unapplied </th>
              <th style='width: 5%'> </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              {!! Form::open(array('route' => 'patients.addCharge')) !!}
              {{ Form::hidden('patient_id', $patient->id) }}
              <td>
                <div class="input-group date" data-provide="datepicker">
                  <input type="text" class="form-control" id="charge_date_from" name="date_from" value="{{ \Carbon\Carbon::now()->format('d/m/Y') }}"/>
                  <div class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                  </div>
                </div>
              <td>
                <input type="hidden" class="form-control" name="procedure_code" id="charge_procedure_code_hid" />
                <input type="text" class="form-control" disabled id="charge_procedure_code_dis" />
              </td>
              <td> <select class="form-control" name="procedure_description" id="charge_procedure_description">
                <option disabled selected value> -- Select Procedure --</option>
                @foreach($procedures as $procedure)
                  <option data-amount="{{$procedure->amount}}" value="{{$procedure->code}}">{{$procedure->description}}</option>
                @endforeach
                </select>
              </td>
              <td> {{ Form::select('attending_provider', array('JEG' => 'Dr. Grace', 'CH'=>'C. Hounsell'), null, array('class'=>'form-control')) }} </td>
              <td> {{ Form::text('units', 1, array('class'=>'form-control', 'id'=>'charge_units')) }} </td>
              <td> {{ Form::text('amount', null, array('class'=>'form-control', 'id'=>'charge_amount')) }} </td>
              <td>
                <input type="hidden" name="total" id="charge_total_hid" />
                <input type="text" id="charge_total_dis" class="form-control" disabled />
              </td>
              <td> </td>
              <td> {{ Form::button('<i class="fa fa-plus"></i>', array('class'=>'btn btn-success btn-sm', 'type'=>'submit' )) }} </td>
              {!! Form::close() !!}
            </tr>
            @foreach($patient->charges as $charge)
              <tr class="{{ $charge->paidClass() }}">
                <td> {{ date('d/m/Y' ,strtotime($charge->date_from)) }} </td>
                <td> {{ $charge->procedure_code }} </td>
                <td> {{ $charge->procedure_description }} </td>
                <td> {{ $charge->attending_provider }} </td>
                <td> {{ $charge->units }} </td>
                <td> {{ $charge->amount }} </td>
                <td> {{ $charge->total }} </td>
                <td> {{ $charge->unapplied() }} </td>
                <td> </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Payments -->
<!-- TODO: Color Coding - Not Applied (warning), Partially Applied (info), Over-Applied (danger), Fully Applied (white) -->
<div class="row">
  <div class="col-md-12">
    <div class="panel panel-info">
      <div class="panel-heading">
        <h3 class="panel-title">Payments</h3>
      </div>
      <div class="panel-body payments-panel">
        <table class="table table-striped">
          <thead>
            <tr>
              <th style='width: 20%'> Date </th>
              <th style='width: 10%'> Pay/Adj Code </th>
              <th style='width: 20%'> Payment Description </th>
              <th style='width: 15%'> Who Paid </th>
              <th style='width: 10%'> Provider </th>
              <th style='width: 10%'> Total </th>
              <th style='width: 10%'> Check # </th>
              <th style='width: 10%'> Unapplied </th>
              <th style='width: 5%'> </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              {!! Form::open(array('route' => 'patients.addPayment')) !!}
              {{ Form::hidden('patient_id', $patient->id) }}
              <td>
                <div class="input-group date" data-provide="datepicker">
                  <input type="text" class="form-control" id="payment_date_from" name="date_from" value="{{ \Carbon\Carbon::now()->format('d/m/Y') }}"/>
                  <div class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                  </div>
                </div>
              <td>
                <input type="hidden" class="form-control" name="payment_code" id="payment_procedure_code_hid" />
                <input type="text" class="form-control" disabled id="payment_procedure_code_dis" />
              </td>
              <td> <select class="form-control" name="payment_description" id="payment_procedure_description">
                <option disabled selected value> -- Select Payment Type --</option>
                @foreach($payments as $payment)
                  <option data-amount="{{$payment->amount}}" value="{{$payment->code}}">{{$payment->description}}</option>
                @endforeach
                </select>
              </td>
              <td>
                <select class="form-control" name="who_paid">
                  <option value="G">Patient </option>
                  @if(isset($patient->insurance1))
                    <option value="1">{{$patient->insurance1->name}} </option>
                  @endif
                  @if(isset($patient->insurance2))
                    <option value="2">{{$patient->insurance2->name}} </option>
                  @endif
                  @if(isset($patient->insurance3))
                    <option value="3">{{$patient->insurance3->name}} </option>
                  @endif

                </select>
              </td>
              <td> {{ Form::select('attending_provider', array('JEG' => 'Dr. Grace', 'CH'=>'C. Hounsell'), null, array('class'=>'form-control')) }} </td>
              <td> {{ Form::text('total', null, array('class'=>'form-control', 'id'=>'payment_total')) }} </td>
              <td> </td>
              <td> {{ '' /*Form::text('check', null, array('class'=>'form-control')) */}} </td>
              <td> {{ Form::button('<i class="fa fa-plus"></i>', array('class'=>'btn btn-success btn-sm', 'type'=>'submit' )) }} </td>
              {!! Form::close() !!}
            </tr>
            @foreach($patient->payments as $payment)
              <tr class="{{ $payment->appliedClass() }}">
                <td> {{ date('d/m/Y' ,strtotime($payment->date_from)) }} </td>
                <td> {{ $payment->procedure_code }} </td>
                <td> {{ $payment->procedure_description }} </td>
                <td> {{ $payment->who_paid }} </td>
                <td> {{ $payment->provider }} </td>
                <td> {{ $payment->total }} </td>
                <td> {{ $payment->deposit_id }} </td>
                <td> {{ $payment->unapplied_amount }} </td>
                <td>
                  <?php
                    if($payment->unapplied_amount == 0) { $button_class = "btn-default"; }
                    else { $button_class = "btn-primary"; }
                  ?>
                  <a href="/patients/{{$patient->id}}/apply/{{$payment->id}}/from/{{$payment->who_paid}}"><button class="btn {{$button_class}} btn-sm">Apply</button></a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

@endsection

@section('scripts')

<script type="text/javascript" src="{{ URL::asset('js/bootstrap-datepicker.min.js') }}"></script>

<script type="text/javascript">
  $('#charge_procedure_description').change(function() {
    $('#charge_procedure_code_hid').attr('value', $('#charge_procedure_description').val());
    $('#charge_procedure_code_dis').attr('value', $('#charge_procedure_description').val());
    $('#charge_amount').attr('value', $(this).find(':selected').attr('data-amount'));

    $('#charge_total_hid').attr('value', $('#charge_units').val() * $('#charge_amount').val() );
    $('#charge_total_dis').attr('value', $('#charge_units').val() * $('#charge_amount').val() );
  });

  $('#charge_units').change(function() {
    $('#charge_total_hid').attr('value', $('#charge_units').val() * $('#charge_amount').val() );
    $('#charge_total_dis').attr('value', $('#charge_units').val() * $('#charge_amount').val() );
  });

  $('#charge_amount').change(function() {
    $('#charge_total_hid').attr('value', $('#charge_units').val() * $('#charge_amount').val() );
    $('#charge_total_dis').attr('value', $('#charge_units').val() * $('#charge_amount').val() );
  });

  $('#payment_procedure_description').change(function() {
    $('#payment_procedure_code_hid').attr('value', $('#payment_procedure_description').val());
    $('#payment_procedure_code_dis').attr('value', $('#payment_procedure_description').val());
    $('#payment_total').attr('value', $(this).find(':selected').attr('data-amount'));
  });

  $('#select_insurer1').change(function() {
    if($('#select_insurer1').val != '') {
      $('#submit_insurer1').removeAttr('disabled');
    }
  });
  $('#select_insurer2').change(function() {
    if($('#select_insurer2').val != '') {
      $('#submit_insurer2').removeAttr('disabled');
    }
  });
  $('#select_insurer3').change(function() {
    if($('#select_insurer3').val != '') {
      $('#submit_insurer3').removeAttr('disabled');
    }
  });

  $('#button_insurer1').click(function() {
    $('#insurer1_info').addClass('hidden');
    $('#insurer1_form').removeClass('hidden');
  });
  $('#button_insurer2').click(function() {
    $('#insurer2_info').addClass('hidden');
    $('#insurer2_form').removeClass('hidden');
  });
  $('#button_insurer3').click(function() {
    $('#insurer3_info').addClass('hidden');
    $('#insurer3_form').removeClass('hidden');
  });

  $('.date').datepicker({
      format: 'dd/mm/yyyy',
      todayHighlight: 'TRUE',
      autoclose: true,
      keyboardNavigation: true,
  });
  /*$('.datepicker').on("changeDate", function() {
    $(this).val = $(this).datepicker('getFormattedDate');
  });*/

</script>
@endsection
