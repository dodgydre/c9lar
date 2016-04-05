@extends('layouts.app')

@section('title', '| New Employee')

@section('styles')
  <link rel="stylesheet" href="{{ URL::asset('css/bootstrap-datepicker.min.css') }}">
@endsection

@section('content')

  <div class="row">
    <div class="col-md-6 col-md-offset-3">
      <div class="panel panel-default z-depth-2">
        <div class="panel-heading">
          <h3 class="panel-title">Add New Employee:</h3>
        </div>
        <div class="panel-body">
          <form action="{{ route('employees.store') }}" method="POST" class="form-horizontal">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="form-group">
              <label for="first_name" class="control-label col-md-3">First Name:</label>
              <div class="col-md-8">
                <input name="first_name" class="form-control" />
              </div>
            </div>
            <div class="form-group">
              <label for="last_name" class="control-label col-md-3">Last Name:</label>
              <div class="col-md-8">
                <input name="last_name" class="form-control" />
              </div>
            </div>
            <div class="form-group">
              <label for="street1" class="control-label col-md-3">Street 1:</label>
              <div class="col-md-8">
                <input name="street1" class="form-control" />
              </div>
            </div>
            <div class="form-group">
              <label for="street2" class="control-label col-md-3">Street 2:</label>
              <div class="col-md-8">
                <input name="street2" class="form-control" />
              </div>
            </div>
            <div class="form-group">
              <label for="city" class="control-label col-md-3">City:</label>
              <div class="col-md-8">
                <input name="city" class="form-control" value="St. John's"/>
              </div>
            </div>
            <div class="form-group">
              <label for="prov" class="control-label col-md-3">Province:</label>
              <div class="col-md-8">
                <input name="prov" class="form-control" value="Newfoundland"/>
              </div>
            </div>
            <div class="form-group">
              <label for="post_code" class="control-label col-md-3">Post Code:</label>
              <div class="col-md-8">
                <input name="post_code" class="form-control" />
              </div>
            </div>
            <div class="form-group">
              <label for="country" class="control-label col-md-3">Country:</label>
              <div class="col-md-8">
                <input name="country" class="form-control" value="Canada" />
              </div>
            </div>

            <div class="form-group">
              <label for="phone" class="control-label col-md-3">Phone Number:</label>
              <div class="col-md-8">
                <input name="phone" class="form-control phone_us" placeholder="(xxx) xxx-xxxx"	 />
              </div>
            </div>
            <div class="form-group">
              <label for="email" class="control-label col-md-3">Email:</label>
              <div class="col-md-8">
                <input name="email" class="form-control" />
              </div>
            </div>
            <div class="form-group">
              <label for="sin" class="control-label col-md-3">Social Insurance #:</label>
              <div class="col-md-8">
                <input name="sin" class="form-control" />
              </div>
            </div>
            <div class="form-group">
              <label for="birth_date" class="control-label col-md-3">Birth Date:</label>
              <div class="col-md-8">
                <div class="input-group date" data-provide="datepicker">
                  <input type="text" class="form-control" id="birth_date" name="birth_date" value="{{ \Carbon\Carbon::now()->format('m/d/Y') }}"/>
                  <div class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="hire_date" class="control-label col-md-3">Hire Date:</label>
              <div class="col-md-8">
                <div class="input-group date" data-provide="datepicker">
                  <input type="text" class="form-control" id="hire_date" name="hire_date" value="{{ \Carbon\Carbon::now()->format('m/d/Y') }}"/>
                  <div class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                  </div>
                </div>
              </div>
            </div>


            <div class="row">
              <div class="col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1">
                <div class="form-group">
                  <button class="btn btn-success btn-lg btn-block">Add Employee</button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>


@endsection

@section('scripts')
  <script type="text/javascript" src="{{ URL::asset('js/bootstrap-datepicker.min.js') }}"></script>
  <script type="text/javascript" src="{{ URL::asset('js/jquery.mask.min.js') }}"></script>

  <script type="text/javascript">
    $(document).ready(function() {
      $('.phone_us').mask('(000) 000-0000');

      $('.date').datepicker({
          todayHighlight: 'TRUE',
          autoclose: true,
          keyboardNavigation: true,
      });
    });

  </script>

@endsection
