@extends('layouts.app')

@section('title', '| Apply Payment')

@section('content')

  <!-- Charges -->
  <!-- TODO: Colors: No Payment (warning), Partially Paid (info), Overpaid (danger), Paid (white) -->

  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-info">
        <div class="panel-heading">
          <span class="pull-left"><h3 class="panel-title">Apply Payments</h3><br><button id="hide_fully_paid" class="btn btn-primary btn-sm">Hide Fully Paid</button></span>
            <span class="pull-right text-right">
              Payor: {{ $who_paid }} <br />
              Payment Amount: $ <span id="span_total">{{ number_format($thisTransaction->total,2,'.','') }}</span><br />
              Amount Applied: $ <span id="span_applied_amount" class="has_error">{{ number_format($thisTransaction->total - $thisTransaction->unapplied_amount,2,'.','') }}</span><br />
              Unapplied Amount: $<span id="span_unapplied_amount" class="has_error">{{ $thisTransaction->unapplied_amount }}</span>
            </span>
          <div class="clearfix"> </div>
        </div>
        <div class="panel-body">
          <table class="table table-striped">
            <thead>
              <tr>
                <th style="width: 10%"> Date </th>
                <th style="width: 10%"> Procedure </th>
                <th style="width: 10%"> Charge </th>
                <th style="width: 10%"> Balance </th>
                <th style="width: 10%"> Payor Total </th>
                <th style="width: 5%"> This Payment </th>
                <th style="width: 5%"> </th>
              </tr>
            </thead>
            <tbody>
              {!! Form::open(array('route' => 'patients.applyPayment')) !!}
              {{ Form::hidden('patient_id', $patient->id) }}
              {{ Form::hidden('transaction_id', $thisTransaction->id) }}
              {{ Form::hidden('payor', $payor) }}

              @foreach($patient->charges as $charge)
                <?php $thisPayment = 0; ?>
                <tr class="{{$charge->paidClass()}}">
                  <td> {{ date('d/m/Y' ,strtotime($charge->date_from)) }} </td>
                  <td> {{ $charge->procedure_code }} </td>
                  <td> {{ $charge->total }} </td>
                  <td> {{ number_format((float)$charge->unapplied(), 2, '.', '') }} </td>
                  <td>
                    @if($payor == 'G')
                      {{ $charge->g_amount_paid }}
                      <?php
                        if($charge->onePayment($thisTransaction->id)->count() > 0) {
                          $thisPayment = abs((float)$charge->onePayment($thisTransaction->id)->first()->pivot->amount);
                        }
                      ?>
                    @elseif($payor == '1')
                      {{ $charge->i1_amount_paid }}
                      <?php
                        if($charge->onePayment($thisTransaction->id)->count() > 0) {
                          $thisPayment = abs((float)$charge->onePayment($thisTransaction->id)->firstOrFail()->pivot->amount);
                        }
                      ?>
                    @elseif($payor == '2')
                      {{ $charge->i2_amount_paid }}
                      <?php
                        if($charge->onePayment($thisTransaction->id)->count() > 0) {
                          $thisPayment = abs((float)$charge->onePayment($thisTransaction->id)->firstOrFail()->pivot->amount);
                        }
                      ?>
                    @elseif($payor == '3')
                      {{ $charge->i3_amount_paid }}
                      <?php
                        if($charge->onePayment($thisTransaction->id)->count() > 0) {
                          $thisPayment = abs((float)$charge->onePayment($thisTransaction->id)->firstOrFail()->pivot->amount);
                        }
                      ?>
                    @endif
                  </td>
                  <td> <input class="form-control" name="toapply[{{$charge->id}}]" value="{{ $thisPayment }}" id="toapply[{{$charge->id}}]"/> </td>
                  <td> </td>
                </tr>
              @endforeach

            </tbody>
          </table>
          <div class="row">
            <div class="col-md-6">
              {!! Html::decode(link_to_route('patients.show', '<i class="fa fa-times"></i> &nbsp;&nbsp;Cancel', array($patient->id), array('class'=>'btn btn-danger btn-block'))) !!}
            </div>
            <div class="col-md-6">
              {{ Form::button('<i class="fa fa-floppy-o"></i> Apply Payments', array('class'=>'btn btn-success btn-block', 'type'=>'submit' )) }}              
              {!! Form::close() !!}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


@endsection

@section('scripts')

<script type="text/javascript">

  $(document).ready(function() {
    if(parseFloat($('#span_unapplied_amount').text()) < 0 ) {
      $('#span_unapplied_amount').removeClass('has_error');
      $('#span_applied_amount').removeClass('has_error');
    }

    $('input').on('focusin', function(){
        if($(this).val() == '')
        console.log("Saving value " + $(this).val());
        $(this).data('val', $(this).val());
    });


    $('input').on('change', function(){
        var prev = $(this).data('val');
        var current = $(this).val();
        console.log ('prev: ' + prev);
        console.log('current: ' + current);

        var new_unapplied_amount = parseFloat($('#span_unapplied_amount').text()) - parseFloat(prev) + parseFloat(current);
        var new_unapplied_amount = parseFloat(new_unapplied_amount).toFixed(2);
        var new_applied_amount = parseFloat($('#span_total').text()).toFixed(2) - parseFloat(new_unapplied_amount).toFixed(2);
        var new_applied_amount = parseFloat(new_applied_amount).toFixed(2);

        if(new_unapplied_amount > 0) {
          $('#span_unapplied_amount').text(new_unapplied_amount + ' (OVER)').addClass('has_error').removeClass('has_success');
          $('#span_applied_amount').text(new_applied_amount).addClass('has_error').removeClass('has_success');
          //$('#amount_to_apply').addClass('error');
        }
        if(new_unapplied_amount == 0) {
          $('#span_unapplied_amount').text(new_unapplied_amount).addClass('has_success').removeClass('has_error');
          $('#span_applied_amount').text(new_applied_amount).addClass('has_success').removeClass('has_error');
        }
        else {
          $('#span_unapplied_amount').text(new_unapplied_amount).removeClass('has_error').removeClass('has_success');
          $('#span_applied_amount').text(new_applied_amount).removeClass('has_error').removeClass('has_success');
        }
    });

    $('#hide_fully_paid').click(function() {
      $('.fully_paid').toggleClass('hidden');
      if($(this).text() == 'Hide Fully Paid') {
        $(this).text('Show Fully Paid').addClass('btn-primary');
      } else { $(this).text('Hide Fully Paid').removeClass('btn-primary'); }
    });


  });



</script>

@endsection
