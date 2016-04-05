@extends('layouts.app')

@section('title', '| Tasks')

@section('content')

  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <div class="panel panel-default z-depth-2">
        <div class="panel-heading">
          <h3 class="panel-title pull-left">All Tasks</h3>

          <a href="{{ route('tasks.create') }}" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> &nbsp;Add Task</a>
          <div class="clearfix"> </div>
        </div> <!-- end .panel-heading -->

        <div class="panel-body">

              <table class="table table-striped" id="procedure_table">
                <thead>
                  <tr>
                    <th width="10%"> Status </th>
                    <th width="20%"> Name </th>
                    <th> Description </th>
                    <th width="20%"> View | Edit | Delete</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($tasks as $task)
                    <tr class="task{{$task->status}}">
                      <td>
                        <form id="taskStatus{{$task->id}}" class="status_form">
                          <input type="hidden" name="id" value="{{ $task->id }}" />
                          <button class="btn btn-sm {{ $task->status == 1 ? 'btn-success' : 'btn-warning' }}" type="submit">
                            <span class="glyphicon glyphicon-{{ $task->status == 1 ? 'check' : 'unchecked' }}"></span>
                          </button>
                        </form>
                      </td>
                      <td> {{ $task->name }}</td>
                      <td> {{ str_limit($task->description, 50) }}</td>
                      <td>
                      <form method='POST' action="{{ route('tasks.destroy', [$task->id]) }}">
                        {!! csrf_field() !!}
                        {!! method_field('DELETE') !!}

                        <a href="{{ route('tasks.show', $task->id) }}" class="btn btn-sm btn-default"><i class="fa fa-eye"></i></a>
                        <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-sm btn-default"><i class="fa fa-pencil-square-o"></i></a>
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
  $.ajaxSetup({

  });

  $('.status_form').submit(function( event ) {
    $form = $(this);
    event.preventDefault();
    $.ajax({
        url: '/ajaxTaskStatus',
        type: 'post',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: $(this).serialize(), // Remember that you need to have your csrf token included
        dataType: 'json',
        success: function( _response ){
            $form.find('button').toggleClass('btn-success').toggleClass('btn-warning');
            $form.find('span').toggleClass('glyphicon-check').toggleClass('glyphicon-unchecked');
        },
        error: function( _response ){
            console.log("error");
        }
    });
  });

</script>

@endsection
