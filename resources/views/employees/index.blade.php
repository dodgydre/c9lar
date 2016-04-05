@extends('layouts.app')

@section('title', '| Employees')

@section('content')

  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <div class="panel panel-default z-depth-2">
        <div class="panel-heading">
          <h3 class="panel-title pull-left">All Employees</h3>

          <a href="{{ route('employees.create') }}" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> &nbsp;Add Employee</a>
          <div class="clearfix"> </div>
        </div> <!-- end .panel-heading -->

        <div class="panel-body">

              <table class="table table-striped" id="procedure_table">
                <thead>
                  <tr>
                    <th width="10%"> Status </th>
                    <th width="15%"> First Name </th>
                    <th width="15%"> Last Name </th>
                    <th width="20%"> Phone Number </th>
                    <th width="25%"> Email Address </th>
                    <th width="15%"> View | Edit | Delete</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($employees as $employee)
                    <tr class="employee_status{{$employee->status}}">
                      <td>
                        <span class="glyphicon glyphicon-{{ $employee->status == 1 ? 'thumbs-up has_success' : 'thumbs-down has_error' }}"></span>
                      </td>
                      <td> {{ $employee->first_name }}</td>
                      <td> {{ $employee->last_name }}</td>
                      <td> {{ $employee->phone }}</td>
                      <td> {{ $employee->email }}</td>
                      <td>
                      <form method='POST' action="{{ route('employees.destroy', [$employee->id]) }}">
                        {!! csrf_field() !!}
                        {!! method_field('DELETE') !!}

                        <a href="{{ route('employees.show', $employee->id) }}" class="btn btn-sm btn-default"><i class="fa fa-eye"></i></a>
                        <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-sm btn-default"><i class="fa fa-pencil-square-o"></i></a>
                        @if(Entrust::hasRole('admin'))
                          <button class="btn btn-sm btn-danger"  onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-trash"></i></button>
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

<script>

</script>

@endsection
