@extends('layouts.app')

@section('title', '| Apply Payment')

@section('content')

  <!-- Charges -->
  <!-- TODO: Colors: No Payment (warning), Partially Paid (info), Overpaid (danger), Paid (white) -->

  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-info">
        <div class="panel-heading">
          <h3 class="panel-title">Apply Payments</h3>
          <br />
            <span class="pull-left">Payor: {{ $who_paid }}</span> <span class="pull-right">Amount to Apply: <span id="amount_to_apply">{{ $thisTransaction->unapplied_amount }}</span></span>
          <div class="clearfix"> </div>
        </div>
        <div class="panel-body charges-panel">
          <table class="table table-striped">
            <thead>
              <tr>
                <th style="width: 10%"> Date </th>
                <th style="width: 10%"> Procedure </th>
                <th style="width: 10%"> Charge </th>
                <th style="width: 10%"> Balance </th>
                <th style="width: 10%"> Payor Total </th>
                <th style="width: 10%"> This Payment </th>
                <th style="width: 5%"> </th>
              </tr>
            </thead>
            <tbody>
              @foreach($patient->charges as $charge)
                <tr>
                  <td> {{ date('d/m/Y' ,strtotime($charge->date_from)) }} </td>
                  <td> {{ $charge->procedure_code }} </td>
                  <td> {{ $charge->total }} </td>
                  <td> {{ ($charge->total + $charge->g_amount_paid + $charge->i1_amount_paid + $charge->i2_amount_paid + $charge->i3_amount_paid) }} </td>
                  <td>
                    @if($payor == 'G')
                      {{ $charge->g_amount_paid }}
                    @elseif($payor == 1)
                      {{ $charge->i1_amount_paid }}
                    @elseif($payor == 2)
                      {{ $charge->i2_amount_paid }}
                    @elseif($payor == 3)
                      {{ $charge->i3_amount_paid }}
                    @endif
                  </td>
                  <td> this </td>
                  <td> blank </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>


@endsection
