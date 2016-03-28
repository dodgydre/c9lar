@extends('layouts.app')

@section('title', '| Insurer')

@section('content')

  <div class="row">
  <div class="col-md-8">
    <h1> <strong>Insurer Code:</strong> {{ $insurer->code }}</h1>

    <p> <strong>Name:</strong> {{ $insurer->name }} </p>
    <p> <strong>Address:</strong> </p>
    <p>
      @if(!empty($insurer->street1))
        &nbsp;&nbsp;{{ $insurer->street1 }}<br />
      @endif
      @if(!empty($insurer->street2))
        &nbsp;&nbsp;{{ $insurer->street2 }}<br />
      @endif
      @if(!empty($insurer->city))
        &nbsp;&nbsp;{{ $insurer->city }}
      @endif
      @if(!empty($insurer->prov))
        &nbsp;&nbsp; {{ $insurer->prov }}<br />
      @elseif(!empty($insurer->city))
        <br />
      @endif
      @if(!empty($insurer->postcode))
        &nbsp;&nbsp;{{ $insurer->postcode }}<br />
      @endif
      @if(!empty($insurer->country))
        &nbsp;&nbsp;{{ $insurer->country }}<br />
      @endif
    </p>
    <p> <strong>Phone:</strong> {{ $insurer->phone }} </p>
    <p> <strong>Fax:</strong> {{ $insurer->fax }} </p>
  </div>

  <div class="col-md-4">
    <div class="well">
        <dl>
          <dt>Created at:</dt>
          <dd>{{ date('F j, Y, g:i a' ,strtotime($insurer->created_at)) }} </dd>
          <dt>Last updated at:</dt>
          <dd>{{ date('F j, Y, g:i a' ,strtotime($insurer->updated_at)) }} </dd>
        </dl>
        <hr />

        <div class="row">
          <div class="col-sm-6">
            <a href="{{ route('insurers.edit', $insurer->id) }}" class="btn btn-block btn-primary"><i class="fa fa-pencil-square-o"></i> Edit</a>
          </div>
          <div class="col-sm-6">
            <form method='POST' action="{{ route('insurers.destroy', [$insurer->id]) }}">
              {!! csrf_field() !!}
              {!! method_field('DELETE') !!}
              @if(Entrust::hasRole('admin'))
                <button class="btn btn-block btn-danger" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-trash"></i> Delete</button>
              @endif
            </form>

          </div>
          <div class="col-sm-12">
            <a href="{{route('insurers.index')}}" class="btn btn-default btn-block btn-h1-spacing"><i class="fa fa-arrow-left"></i> Show All Insurers</a>
          </div>
        </div>

    </div>

  </div>
</div>


@endsection
