@extends('layouts.app')

@section('title', '| Procedures')

@section('styles')

<link rel="stylesheet" href="{{ URL::asset('css/datatables.min.css') }}">

@endsection

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
          <p>Charges (click to hide):
            <button type="button" class="btn btn-info btn-sm toggle-btn" id="A_button">Procedure</button>
            <button type="button" class="btn btn-info btn-sm toggle-btn" id="B_button">Product</button>
            <button type="button" class="btn btn-info btn-sm toggle-btn" id="H_button">Billing</button>
            Show/Hide All:
            <button type="button" class="btn btn-info btn-sm" id="all_button">Hide</button>
          </p>
          <p>Payments (click to hide):
            <button type="button" class="btn btn-info btn-sm toggle-btn" id="I_button">Insurance Pay.</button>
            <button type="button" class="btn btn-info btn-sm toggle-btn" id="J_button">Cash Co-Pay.</button>
            <button type="button" class="btn btn-info btn-sm toggle-btn" id="K_button">Check Co-Pay.</button>
            <button type="button" class="btn btn-info btn-sm toggle-btn" id="L_button">CC Co-Pay.</button>
            <button type="button" class="btn btn-info btn-sm toggle-btn" id="M_button">Cash Pay.</button>
            <button type="button" class="btn btn-info btn-sm toggle-btn" id="N_button">Check Pay.</button>
            <button type="button" class="btn btn-info btn-sm toggle-btn" id="O_button">CC Pay.</button>
            <button type="button" class="btn btn-info btn-sm toggle-btn" id="P_button">Deductible</button>
            <button type="button" class="btn btn-info btn-sm toggle-btn" id="S_button">Adjust.</button>
            <button type="button" class="btn btn-info btn-sm toggle-btn" id="T_button">Insurance Adjust.</button>
          </p>
              <table class="table table-striped" id="procedure_table">
                <thead>
                  <tr>
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
                    <tr class="type{{$procedure->type}} procedure_row">
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

@section('scripts')

<script type="text/javascript" src="{{ URL::asset('js/datatables.min.js') }}"></script>

<script type="text/javascript">

$(document).ready(function() {

  $('#procedure_table').DataTable({
      "paging": false,
      "columns": [
        null,
        null,
        null,
        null,
        null,
        { "orderable": false }
      ]
  });

  $('#A_button').click(function() {
    $('.typeA').toggleClass('hidden');
    $(this).toggleClass('btn-default').toggleClass('btn-info');
  });
  $('#B_button').click(function() {
    $('.typeB').toggleClass('hidden');
    $(this).toggleClass('btn-default').toggleClass('btn-info');
  });
  $('#H_button').click(function() {
    $('.typeH').toggleClass('hidden');
    $(this).toggleClass('btn-default').toggleClass('btn-info');
  });
  $('#I_button').click(function() {
    $('.typeI').toggleClass('hidden');
    $(this).toggleClass('btn-default').toggleClass('btn-info');
  });
  $('#J_button').click(function() {
    $('.typeJ').toggleClass('hidden');
    $(this).toggleClass('btn-default').toggleClass('btn-info');
  });
  $('#K_button').click(function() {
    $('.typeK').toggleClass('hidden');
    $(this).toggleClass('btn-default').toggleClass('btn-info');
  });
  $('#L_button').click(function() {
    $('.typeL').toggleClass('hidden');
    $(this).toggleClass('btn-default').toggleClass('btn-info');
  });
  $('#M_button').click(function() {
    $('.typeM').toggleClass('hidden');
    $(this).toggleClass('btn-default').toggleClass('btn-info');
  });
  $('#N_button').click(function() {
    $('.typeN').toggleClass('hidden');
    $(this).toggleClass('btn-default').toggleClass('btn-info');
  });
  $('#O_button').click(function() {
    $('.typeO').toggleClass('hidden');
    $(this).toggleClass('btn-default').toggleClass('btn-info');
  });
  $('#P_button').click(function() {
    $('.typeP').toggleClass('hidden');
    $(this).toggleClass('btn-default').toggleClass('btn-info');
  });
  $('#S_button').click(function() {
    $('.typeS').toggleClass('hidden');
    $(this).toggleClass('btn-default').toggleClass('btn-info');
  });
  $('#T_button').click(function() {
    $('.typeT').toggleClass('hidden');
    $(this).toggleClass('btn-default').toggleClass('btn-info');
  });

  $('#all_button').click(function() {
    if($(this).text() == 'Hide') {
      $(this).toggleClass('btn-default').toggleClass('btn-info').text('Show');
      $('.procedure_row').addClass('hidden');
      $('.toggle-btn').addClass('btn-default').removeClass('btn-info');
    }
    else {
      $(this).toggleClass('btn-default').toggleClass('btn-info').text('Hide');
      $('.procedure_row').removeClass('hidden');
      $('.toggle-btn').addClass('btn-info').removeClass('btn-default');

    }
  });

});

</script>

@endsection
