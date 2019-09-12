@extends('layouts.app')

@section('page_title')
  Report
@endsection

@section('page_header')
  <h1>
    Report
    <small>Project Report</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="#"><i class="fa fa-database"></i> Report</a></li>
    <li class="active"><i></i> Project</li>
  </ol>
@endsection

@section('content')
  <div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Project Chart</h3>
            </div><!-- /.box-header -->
            <div class="box-body">
              <div class="row">
                <div class="col-md-12">
                  <div id="chart_div"></div>    
                </div>
              </div>
              
            </div>
          </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div>
  </div>

  
@endsection

@section('additional_scripts')
  <script type="text/javascript">
    
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawProjectChart);
    
    function drawProjectChart() {

      // Some raw data (not necessarily accurate)
      var data = google.visualization.arrayToDataTable([
        ['Month', 'Bolivia', 'Ecuador', 'Madagascar', 'Papua New Guinea', 'Rwanda', 'Average'],
        ['2004/05',  165,      938,         522,             998,           450,      614.6],
        ['2005/06',  135,      1120,        599,             1268,          288,      682],
        ['2006/07',  157,      1167,        587,             807,           397,      623],
        ['2007/08',  139,      1110,        615,             968,           215,      609.4],
        ['2008/09',  136,      691,         629,             1026,          366,      569.6]
      ]);

      var options = {
        title : 'Monthly Coffee Production by Country',
        vAxis: {title: 'Cups'},
        hAxis: {title: 'Month'},
        height:350,
        seriesType: 'bars',
        series: {5: {type: 'line'}}
      };

      var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
      chart.draw(data, options);

    }


  </script>

  
@endsection