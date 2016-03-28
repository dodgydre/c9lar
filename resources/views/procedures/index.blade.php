@extends('layouts.app')

@section('title', '| Procedures')

@section('content')

  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <div class="panel panel-default z-depth-2">
        <div class="panel-heading">
          <h3 class="panel-title pull-left">All Procedures</h3>

          <a href="{{ route('procedures.create') }}" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> &nbsp;Add Procedure</a>
          <div class="clearfix"> </div>
        </div> <!-- end .panel-heading -->

        <div class="panel-body">

              <table class="table table-striped">
                <thead>
                  <tr>
                    <th> # </th>
                    <th> Code </th>
                    <th> Type </th>
                    <th> Description </th>
                    <th> Cost </th>
                    <th> Updated At </th>
                    <th> </th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($procedures as $procedure)
                    <tr>
                      <th> {{ $procedure->id }}</th>
                      <td> {{ $procedure->code }}</td>
                      <td> {{ $procedure->type }}</td>
                      <td> {{ $procedure->description }}</td>
                      <td> ${{ $procedure->amount }}</td>
                      <td> {{ date('M j, Y', strtotime($procedure->updated_at)) }}</td>
                      <td>
                      <form method='POST' action="{{ route('procedures.destroy', [$procedure->id]) }}">
                        {!! csrf_field() !!}
                        {!! method_field('DELETE') !!}

                        <a href="{{ route('procedures.show', $procedure->id) }}" class="btn btn-sm btn-default"><i class="fa fa-eye"></i> View</a>
                        <a href="{{ route('procedures.edit', $procedure->id) }}" class="btn btn-sm btn-default"><i class="fa fa-pencil-square-o"></i> Edit</a>
                        @if(Entrust::hasRole('admin'))
                          <button class="btn btn-sm btn-danger"  onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-trash"></i> Delete</button>
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
