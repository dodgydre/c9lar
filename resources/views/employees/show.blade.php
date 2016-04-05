@extends('layouts.app')

@section('title', '| Employee')

@section('content')

  <div class="row">
    <div class="col-md-8">

      <div class="panel panel-default z-depth-2">
        <div class="panel-heading">
          <h3 class="panel-title">{{ $employee->first_name }} {{ $employee->last_name }}</h3>
        </div>
        <div class="panel-body">
          <div class="row">
            <div class="col-xs-4"><strong>Address:</strong><br /></div>
            <div class="col-xs-6">
                  <p>

                  {{ $employee->street1 }} <br />
                  @if($employee->street2)
                    {{ $employee->street2 }} <br />
                  @endif
                  {{ $employee->city }} {{ $employee->prov }} <br />
                  {{ $employee->post_code }} <br />
                  {{ $employee->country }}<br />
                </p>
              </div>
            </div>
            <div class="row"><div class="col-xs-4"><strong>Phone Number:</strong></div> <div class="col-xs-6">{{ $employee->phone }} </div></div>
            <div class="row"><div class="col-xs-4"><strong>Email Address:</strong></div> <div class="col-xs-6">{{ $employee->email }} </div></div>
            <div class="row"><div class="col-xs-4"><strong>Birth Date:</strong></div> <div class="col-xs-6">{{ $employee->birth_date }} </div></div>
            <div class="row"><div class="col-xs-4"><strong>Hire Date:</strong></div> <div class="col-xs-6">{{ $employee->hire_date }} </div></div>
            <div class="row"><div class="col-xs-4"><strong>Employment Status:</strong></div> <div class="col-xs-6">{{ ($employee->status == 1) ? 'Currently Employed' : 'Previously Employed' }} </div></div>

        </div>
      </div>
    </div> <!-- close .col-md-8 -->

    <div class="col-md-4">
      <div class="well">
          <dl>
            <dt>Created at:</dt>
            <dd>{{ date('F j, Y, g:i a' ,strtotime($employee->created_at)) }} </dd>
            <dt>Last updated at:</dt>
            <dd>{{ date('F j, Y, g:i a' ,strtotime($employee->updated_at)) }} </dd>
          </dl>
          <hr />

          <div class="row">
            <div class="col-sm-6">
              <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-block btn-primary"><i class="fa fa-pencil-square-o"></i> Edit</a>
            </div>
            <div class="col-sm-6">
              <form method='POST' action="{{ route('employees.destroy', [$employee->id]) }}">
                {!! csrf_field() !!}
                {!! method_field('DELETE') !!}
                @if(Entrust::hasRole('admin'))
                  <button class="btn btn-block btn-danger" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-trash"></i> Delete</button>
                @endif
              </form>

            </div>
            <div class="col-sm-12">
              <a href="{{route('employees.index')}}" class="btn btn-default btn-block btn-h1-spacing"><i class="fa fa-arrow-left"></i> Show All Employees</a>
            </div>
          </div>

      </div>

    </div> <!-- close .col-md-4 -->
  </div> <!-- close .row -->
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default z-depth-2">
        <div class="panel-heading">
          <h3 class="panel-title">Payroll</h3>
        </div>
        <div class="panel-body">
          <table class="table table-striped">
            <thead>
              <tr>
                <th width="14%"> Pay Period End </th>
                <th width="14%"> Gross Pay </th>
                <th width="14%"> CPP </th>
                <th width="14%"> EI </th>
                <th width="14%"> Federal Tax </th>
                <th width="14%"> Provincial Tax </th>
                <th width="14%"> Net Pay </th>
              </tr>
            </thead>
            <tbody>
              @foreach($employee->paystubs as $paystub)
                <tr>
                  <td> {{ $paystub->ppe }} </td>
                  <td> {{ $paystub->gross }} </td>
                  <td> {{ $paystub->cpp }} </td>
                  <td> {{ $paystub->ei }} </td>
                  <td> {{ $paystub->fed_tax }} </td>
                  <td> {{ $paystub->prov_tax }} </td>
                  <td> {{ $paystub->net }} </td>
                </tr>
              @endforeach
            </tbody>
            <tfoot>
              <tr>
                <td colspan=7>
                  {{ $employee->eiToDate('2016') }}
                </td>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </div>
  </div>

@endsection
