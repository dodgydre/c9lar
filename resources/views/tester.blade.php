@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
               <div class="panel-heading">Who are you:</div>
               <div class="panel-body">
                    @if (Auth::guest())
                       <h2>Guest</h2>
                    @elseif(Auth::user()->hasRole('admin'))
                       <h2>Admin</h2>
                      {{ Auth::user()->name }}
                    @elseif(Auth::user()->hasRole('subscriber'))
                        <h2>Subscriber</h2>
                    @endif
               </div>
            </div>
        </div>
    </div>
</div>
@endsection



 
                   