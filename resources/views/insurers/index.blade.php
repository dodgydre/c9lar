@extends('layouts.app')

@section('title', '| Insurers')

@section('content')

  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <div class="panel panel-default z-depth-2">
        <div class="panel-heading">
          <h3 class="panel-title pull-left">All Insurers</h3>
          <a href="{{ route('insurers.create') }}" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Create New Insurer</a>
          <div class="clearfix"></div>
        </div> <!-- end .panel-heading -->
        <div class="panel-body">
          <table class="table table-striped">
            <thead>
              <tr>
                <th> # </th>
                <th> Code </th>
                <th> Name </th>
                <th> Phone </th>
                <th> Fax </th>
                <th> Updated At </th>
                <th> </th>
              </tr>
            </thead>
            <tbody>
              @foreach($insurers as $insurer)
                <tr>
                  <td> {{ $insurer->id }}</td>
                  <td> {{ $insurer->code }}</td>
                  <td> {{ $insurer->name }}</td>
                  <td> {{ $insurer->phone }}</td>
                  <td> {{ $insurer->fax }}</td>
                  <td> {{ date('M j, Y', strtotime($insurer->updated_at)) }}</td>
                  <td>
                    <form method='POST' action="{{ route('insurers.destroy', [$insurer->id]) }}">
                      {!! csrf_field() !!}
                      {!! method_field('DELETE') !!}
                      <a href="{{ route('insurers.show', $insurer->id) }}" class="btn btn-sm btn-default"><i class="fa fa-eye"></i> View</a>
                      <a href="{{ route('insurers.edit', $insurer->id) }}" class="btn btn-sm btn-default"><i class="fa fa-pencil-square-o"></i> Edit</a>
                      @if(Entrust::hasRole('admin'))
                        <button class="btn btn-sm btn-danger"  onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-trash"></i> Delete</button>
                      @endif
                    </form>
                  </td>
                </tr>

              @endforeach

            </tbody>
          </table>
        </div> <!-- end .panel-body -->
      </div> <!-- end .panel -->
    </div> <!-- end .col-md-10 -->
  </div> <!-- end .row -->


@endsection
