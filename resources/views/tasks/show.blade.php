@extends('layouts.app')

@section('title', '| Task')

@section('content')

  <div class="row">
    <div class="col-md-8">

      <div class="panel panel-default z-depth-5">
        <div class="panel-heading">
          <h3 class="panel-title">{{ $task->name }}</h3>
        </div>
        <div class="panel-body">
          <h4>Task Description</h4>
          <p>
            {{ $task->description }}
          </p>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="well">
          <dl>
            <dt>Created at:</dt>
            <dd>{{ date('F j, Y, g:i a' ,strtotime($task->created_at)) }} </dd>
            <dt>Last updated at:</dt>
            <dd>{{ date('F j, Y, g:i a' ,strtotime($task->updated_at)) }} </dd>
          </dl>
          <hr />

          <div class="row">
            <div class="col-sm-6">
              <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-block btn-primary"><i class="fa fa-pencil-square-o"></i> Edit</a>
            </div>
            <div class="col-sm-6">
              <form method='POST' action="{{ route('tasks.destroy', [$task->id]) }}">
                {!! csrf_field() !!}
                {!! method_field('DELETE') !!}
                @if(Entrust::hasRole('admin'))
                  <button class="btn btn-block btn-danger" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-trash"></i> Delete</button>
                @endif
              </form>

            </div>
            <div class="col-sm-12">
              <a href="{{route('tasks.index')}}" class="btn btn-default btn-block btn-h1-spacing"><i class="fa fa-arrow-left"></i> Show All Tasks</a>
            </div>
          </div>

      </div>

    </div>
  </div>

@endsection
