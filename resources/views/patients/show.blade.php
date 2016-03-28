@extends('layouts.app')

@section('title', '| Procedure')

@section('content')

  <div class="row">
  <div class="col-md-8">
    <h1> Procedure Code: {{ $procedure->code }}</h1>

    <p> Procedure Type: {{ $procedure->type }} </p>
    <p> Procedure Description: {{ $procedure->description }} </p>
    <p> Procedure Amount: ${{ $procedure->amount }} </p>
  </div>
  <div class="col-md-4">
    <div class="well">
        <dl>
          <dt>Created at:</dt>
          <dd>{{ date('F j, Y, g:i a' ,strtotime($procedure->created_at)) }} </dd>
          <dt>Last updated at:</dt>
          <dd>{{ date('F j, Y, g:i a' ,strtotime($procedure->updated_at)) }} </dd>
        </dl>
        <hr />

        <div class="row">
          <div class="col-sm-6">
            <a href="{{ route('procedures.edit', $procedure->id) }}" class="btn btn-block btn-primary"><i class="fa fa-pencil-square-o"></i> Edit</a>
          </div>
          <div class="col-sm-6">
            <form method='POST' action="{{ route('procedures.destroy', [$procedure->id]) }}">
              {!! csrf_field() !!}
              {!! method_field('DELETE') !!}
              @if(Entrust::hasRole('admin'))
                <button class="btn btn-block btn-danger" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-trash"></i> Delete</button>
              @endif
            </form>

          </div>
          <div class="col-sm-12">
            <a href="{{route('procedures.index')}}" class="btn btn-default btn-block btn-h1-spacing"><i class="fa fa-arrow-left"></i> Show All Procedures</a>
          </div>
        </div>

    </div>

  </div>
</div>

@endsection
