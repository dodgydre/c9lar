@extends('layouts.app')

@section('title', '| New Task')

@section('content')

  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <div class="panel panel-default z-depth-2">
        <div class="panel-heading">
          <h3 class="panel-title">Create New Task:</h3>
        </div>
        <div class="panel-body">
          <form action="{{ route('tasks.store') }}" method="POST" class="form-horizontal">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group">
              <label for="name" class="control-label col-md-4">Task Name:</label>
              <div class="col-md-8">
                <input name="name" class="form-control" />
              </div>
            </div>

            <div class="form-group">
              <label for="description" class="control-label col-md-4">Task Description</label>
              <div class="col-md-8">
                <textarea name="description" class="form-control"></textarea>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 col-md-offset-3">
                <div class="form-group">
                  <button class="btn btn-success btn-lg btn-block">Create Task</button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>


@endsection
