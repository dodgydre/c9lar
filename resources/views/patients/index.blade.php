@extends('layouts.app')

@section('title', '| Patients')

@section('content')

  <div class="row">
    <div class="col-sm-12">
      <div class="panel panel-default z-depth-2">
        <div class="panel-heading">
          <h1 class="panel-title pull-left">All Patients</h1>

          <a href="{{ route('patients.create') }}" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> &nbsp;New Patient</a>
          <div class="clearfix"> </div>

        </div> <!-- end .panel-heading -->

        <div class="panel-body">

              <table class="table table-striped" id="patients_table">
                <thead>
                  <tr>
                    <th> Chart Number </th>
                    <th> First Name </th>
                    <th> Last Name </th>
                    <th class="hidden-xs"> Date of Last Payment </th>
                    <th class="hidden-xs"> Last Payment </th>
                    <th class="hidden-xs"> Remaining Balance </th>
                    <th> View | Edit {{ (Entrust::hasRole('admin')) ? '| Delete' : '' }}</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($patients as $patient)
                    <tr>
                      <td> {{ $patient->chart_number }}</td>
                      <td> {{ $patient->first_name }}</td>
                      <td> {{ $patient->last_name }}</td>
                      <td class="hidden-xs"> {{ isset($patient->date_of_last_pmt) ? date('M j, Y', strtotime($patient->date_of_last_pmt)) : '-' }} </td>
                      <td class="hidden-xs"> {{ isset($patient->last_pmt) ? '$' . $patient->last_pmt : '-' }}</td>
                      <td class="hidden-xs"> {{ isset($patient->remaining_balance) ? '$' . $patient->remaining_balance : '-' }}</td>
                      <td>
                      <form method='POST' action="{{ route('patients.destroy', [$patient->id]) }}">
                        {!! csrf_field() !!}
                        {!! method_field('DELETE') !!}

                        <a href="{{ route('patients.show', $patient->id) }}" class="btn btn-sm btn-primary"><i class="fa fa-eye fa-lg"></i></a>
                        <a href="{{ route('patients.edit', $patient->id) }}" class="btn btn-sm btn-success"><i class="fa fa-pencil-square-o fa-lg"></i></a>
                        @if(Entrust::hasRole('admin'))
                          <button class="btn btn-sm btn-danger"  onclick="return confirm('Are you sure you want to delete this patient?');"><i class="fa fa-trash fa-lg"></i></button>
                        @endif
                      </form>

                      </td>
                    </tr>

                  @endforeach

                </tbody>
              </table>

        </div>

      </div>
    </div>
  </div> <!-- end of .row -->

@endsection

@section('scripts')

<script type="text/javascript">

$(document).ready(function() {

  $('#patients_table').DataTable({
      "paging": false,
      "columns": [
        null,
        null,
        null,
        null,
        null,
        null,
        { "orderable": false }
      ]
  });
  $('#patients_table_filter').addClass('pull-right');
  $("<span class='glyphicon glyphicon-search' style='padding-left: 1em;'></span>").insertBefore($('#patients_table_filter').find('input'));
});
</script>

@endsection
