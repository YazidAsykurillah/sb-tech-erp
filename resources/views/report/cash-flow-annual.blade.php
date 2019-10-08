@extends('layouts.app')

@section('page_title')
  Cash Flow
@endsection

@section('page_header')
  <h1>
    Cash Flow
    <small>{{ $year }}</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ url('report/cash-flow') }}"><i class="fa fa-random"></i> Cash Flow</a></li>
    <li class="active"><i></i> {{ $year }}</li>
  </ol>
@endsection

@section('content')
  <div class="row">
    <div class="col-md-12">
        <!--Box Predictive Cash Flow Data-->
        <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Prediksi</h3>
            </div><!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table class="table">
                  <thead>
                    <tr>
                      <th>Masa</th>
                      <th>Keluaran (Invoice Vendor)</th>
                      <th>Masukan (Invoice Customer)</th>
                      <th>Balance</th>
                    </tr>
                  </thead>
                  <tbody>
                  @foreach($predictive_cashflow_data as $pcd)
                    <tr>
                      <td>{{ $pcd['year_month'] }}</td>
                      <td>{{ $pcd['cash_out'] }}</td>
                      <td>{{ $pcd['cash_in'] }}</td>
                      <td>{{ $pcd['balance'] }}</td>
                    </tr>
                  @endforeach
                  </tbody>
                </table>
              </div>
            </div>
        </div>
        <!--ENDBox Predictive Cash Flow Data-->

        <!--Box Actual Cash Flow Data-->
        <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Actual</h3>
            </div><!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table class="table">
                  <thead>
                    <tr>
                      <th>Masa</th>
                      <th>Keluaran (Debet)</th>
                      <th>Masukan (Credit)</th>
                      <th>Balance</th>
                    </tr>
                  </thead>
                  <tbody>
                  @foreach($actual_cashflow_data as $pcd)
                    <tr>
                      <td>{{ $pcd['year_month'] }}</td>
                      <td>{{ $pcd['cash_out'] }}</td>
                      <td>{{ $pcd['cash_in'] }}</td>
                      <td>{{ $pcd['balance'] }}</td>
                    </tr>
                  @endforeach
                  </tbody>
                </table>
              </div>
            </div>
        </div>
        <!--ENDBox Actual Cash Flow Data-->
    </div>
  </div>

  
@endsection

@section('additional_scripts')
  <script type="text/javascript"></script>

  
@endsection