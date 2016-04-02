@extends('layouts.app')

@section('content')

  <div id="myDiv" style="width: 1200px; height: 400px;"><!-- Plotly chart will be drawn inside this DIV --></div>

@endsection

@section('scripts')

  <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>

  <script type="text/javascript">
    var data = [{
    x:  <?php echo json_encode($x) ?>,
    y:  <?php echo json_encode($y) ?>,
    type: 'bar'
    }];

    Plotly.newPlot('myDiv', data);
  </script>

@endsection
