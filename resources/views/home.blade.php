@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <div class="panel panel-default">
        <div class="panel-heading">Dashboard</div>

        <div class="panel-body">
          You are logged in!
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-4">
      <div class="panel panel-info">
        <div class="panel-heading">
          <h3 class="panel-title">Open Tasks</h3>
        </div>
        <div class="panel-body">
          <div class="list-group">
            @foreach($tasks as $task)
              <a href="{{route('tasks.show', $task->id)}}" class="list-group-item">
                {{$task->name}}
              </a>
            @endforeach
          </div>
          <a href="/tasks">View all tasks</a>
        </div>
      </div>
    </div>
    <div class="col-md-8">
      <div class="panel panel-info">

        <div class="panel-body">
          <div id="revenueChart" style="width: 100%; height: 400px;"><!-- Plotly chart will be drawn inside this DIV --></div>
        </div>
      </div>
    </div>
  </div>

</div>
@endsection

@section('scripts')

  <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>

  <script type="text/javascript">

    var data = [{
      x:  <?php echo json_encode($x) ?>,
      y:  <?php echo json_encode($y) ?>,
      type: 'bar',
    }];

    var layout = {
      title: 'Monthly Revenue (2010-2016)',
      xaxis: {
        title: 'Month',
        showline: true,
        mirror: 'allticks',
        ticks: 'inside'
      },
      yaxis: {
        title: 'Revenue ($)',
        showline: true,
        mirror: 'allticks',
        ticks: 'inside'
      },
      //margin: {l: 40, b: 40, t: 60}
    };


    Plotly.newPlot('revenueChart', data, layout);
  </script>

@endsection
