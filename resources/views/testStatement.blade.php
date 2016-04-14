<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Statement</title>
  <link rel="stylesheet" href="css/statement2.css" media="all" />

  <style>
    .page-break {
      page-break-after: always;
    }
  </style>
</head>
<body>
  <header class="clearfix">
    <div class="logo">
      <img src="logo.jpg" />
    </div>
    <div class="address_block">
    25 Allandale Road<br />
    St. John's, NL, A1B 2Z6<br />
    (709)-726-4343<br />
    </div>

    <hr class="top_line"/>

    <table class="patient_instructions_table">
      <tr>
        <td class="patient">
          Patient:<br />
                  <br />
                  <br />
                  <br />
                  <br />
          Chart #:<br />
        </td>
        <td class="address">
           {{ $patient->first_name }} {{ $patient->last_name }}<br />
           {{ $patient->street1 }}<br />
           {{ isset($patient->street2) ? $patient->street2 . '<br />' : '' }}
           {{ isset($patient->city) ? $patient->city . ', ' : '' }} {{ isset($patient->province) ? $patient->province . ', ' : '' }} {{ $patient->postcode }}<br />
           {{ $patient->country }}<br />
           <br />
           {{ $patient->chart_number }}
        </td>
        <td class="instructions">
          <span>Instructions:</span><br />

          Complete the patient information portion of your insurance<br />
          claim form. Attach this bill, signed and dated and all other<br />
          bills pertaining to this claim. If you have a deductible policy<br />
          hold your claim forms until you have met your deductible<br />
          Mail directly to your insurance carrier. <br /><br />
        </td>
      </tr>
    </table>
    </header>

    <main>

      <table class="procedures_table">
        <thead>
          <tr>
            <th class="date">Date</th>
            <th class="desc">Description</th>
            <th class="proc">Procedure</th>
            <th class="units">Units</th>
            <th class="total">Charge</th>
          </tr>
        </thead>
        <tbody>
          
          
          @foreach($transactions as $transaction)
            <tr>
              <td class="date">{{ date('d/m/Y' ,strtotime($transaction->date_from)) }} </td>
              <td class="desc">{{ $transaction->procedure_description }}</td>
              <td class="proc">{{ $transaction->procedure_code }}</td>
              <td class="units">{{ $transaction->units or 1}}</td>
              <td class="total">${{ number_format($transaction->total,2) }}</td>
            </tr>
          @endforeach

          @if($transactions->count() < 17)
            @for($i = 0; $i < 18-$transactions->count(); $i++)
              <tr> <td> </td> <td>&nbsp; </td> <td> </td> <td> </td> <td> </td> </tr>
            @endfor
          @endif
          <!--<tr> <td> </td> <td>&nbsp; </td> <td> </td> <td> </td> <td> </td> </tr>
          <tr> <td> </td> <td>&nbsp; </td> <td> </td> <td> </td> <td> </td> </tr>
          <tr> <td> </td> <td>&nbsp; </td> <td> </td> <td> </td> <td> </td> </tr>
          <tr> <td> </td> <td>&nbsp; </td> <td> </td> <td> </td> <td> </td> </tr>-->

          <tr>
            <td colspan="2" rowspan="5" class="provider_info">
              <div class="provider_div">
                <span>Provider Name:</span>Janice Grace<br />
                <span>Licence: </span>69 <br />
              </div>

            </td>
            <td colspan="2" class="total_text"> Total Charges: </td>
            <td class="total_num"> ${{ number_format($sum_charges,2) }} </td>
          </tr>
          <tr>
            <td colspan="2" class="total_text"> Total Payments: </td>
            <td class="total_num"> ${{ number_format($sum_payments,2) }} </td>
          </tr>
          <!--<tr>
            <td colspan="2" class="total_text"> Total Adjustments: </td>
            <td class="total_num"> $0.00 </td>
          </tr>-->
          <tr>
            <td colspan="2" class="total_text"> Total Due This Visit: </td>
            <td class="total_num"> ${{ number_format($sum_charges - $sum_payments,2) }} </td>
          </tr>
          <tr>
            <td colspan="2" class="total_text"> Total Account Balance: </td>
            <td class="total_num"> ${{ number_format($patient->remaining_balance,2) }} </td>
          </tr>

        </tbody>
      </table>

      <hr class="top_line"/>
      <!--
        <span class="release">Assign and Release:</span>I hereby authorize payment of medical benefits to this physician for the services described<br />
        <span class="release"></span>above. I also authorize the release of any information necessary to process this claim.<br />
        <br />
        <br />
        <br />
        <table class="sig_table">
          <tr>
            <td class="sig_pat_text"> Patient Signature </td>
            <td class="sig_line"> &nbsp; </td>
            <td class="sig_date_text"> Date </td>
            <td class="sig_date_line"> &nbsp; </td>
          </tr>
        </table>
      -->
      <div class="page-break"></div>
      <header class="clearfix">
    <div class="logo">
      <img src="logo.jpg" />
    </div>
    <div class="address_block">
    25 Allandale Road<br />
    St. John's, NL, A1B 2Z6<br />
    (709)-726-4343<br />
    </div>

    <hr class="top_line"/>

    <table class="patient_instructions_table">
      <tr>
        <td class="patient">
          Patient:<br />
                  <br />
                  <br />
                  <br />
                  <br />
          Chart #:<br />
        </td>
        <td class="address">
           {{ $patient->first_name }} {{ $patient->last_name }}<br />
           {{ $patient->street1 }}<br />
           {{ isset($patient->street2) ? $patient->street2 . '<br />' : '' }}
           {{ isset($patient->city) ? $patient->city . ', ' : '' }} {{ isset($patient->province) ? $patient->province . ', ' : '' }} {{ $patient->postcode }}<br />
           {{ $patient->country }}<br />
           <br />
           {{ $patient->chart_number }}
        </td>
        <td class="instructions">
          <span>Instructions:</span><br />

          Complete the patient information portion of your insurance<br />
          claim form. Attach this bill, signed and dated and all other<br />
          bills pertaining to this claim. If you have a deductible policy<br />
          hold your claim forms until you have met your deductible<br />
          Mail directly to your insurance carrier. <br /><br />
        </td>
      </tr>
    </table>
    </header>
      <br /><br />
    </main>

    <footer>


    </footer>
</body>
</html>
