@extends('layouts.app')

@section('title', '| Patients')

@section('content')

  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <div class="panel panel-default z-depth-2">
        <div class="panel-heading">
          <h1 class="panel-title pull-left">All Patients</h1>

          <a href="{{ route('patients.create') }}" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> &nbsp;New Patient</a>
          <div class="clearfix"> </div>
        </div> <!-- end .panel-heading -->

        <div class="panel-body">

              <table class="table table-striped">
                <thead>
                  <tr>
                    <th> # </th>
                    <th> Chart Number </th>
                    <th> First Name </th>
                    <th> Last Name </th>
                    <th> Date of Last Payment </th>
                    <th> Last Payment </th>
                    <th> Remaining Balance </th>
                    <th> </th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($patients as $patient)
                    <tr>
                      <td> {{ $patient->id }}</td>
                      <td> {{ $patient->chart_number }}</td>
                      <td> {{ $patient->first_name }}</td>
                      <td> {{ $patient->last_name }}</td>
                      <td> {{ isset($patient->date_of_last_pmt) ? date('M j, Y', strtotime($patient->date_of_last_pmt)) : '-' }} </td>
                      <td> {{ isset($patient->last_pmt) ? '$' . $patient->last_pmt : '-' }}</td>
                      <td> {{ isset($patient->remaining_balance) ? '$' . $patient->remaining_balance : '-' }}</td>
                      <td>
                      <form method='POST' action="{{ route('patients.destroy', [$patient->id]) }}">
                        {!! csrf_field() !!}
                        {!! method_field('DELETE') !!}

                        <a href="{{ route('patients.show', $patient->id) }}" class="btn btn-sm btn-default"><i class="fa fa-eye"></i> View</a>
                        <a href="{{ route('patients.edit', $patient->id) }}" class="btn btn-sm btn-default"><i class="fa fa-pencil-square-o"></i> Edit</a>
                        @if(Entrust::hasRole('admin'))
                          <button class="btn btn-sm btn-danger"  onclick="return confirm('Are you sure you want to delete this patient?');"><i class="fa fa-trash"></i> Delete</button>
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
