@extends('layouts.app')

@section('page_title')
  Tax Flow
@endsection

@section('page_header')
  <h1>
    Tax Flow
    <small>{{ $year }}</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ url('report/cash-flow') }}"><i class="fa fa-random"></i> Tax Flow</a></li>
    <li class="active"><i></i> {{ $year }}</li>
  </ol>
@endsection

@section('content')
  <div class="row">
    <div class="col-md-12">
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
                      <th>Keluaran</th>
                      <th>Masukan</th>
                      <th>Credit</th>
                    </tr>
                  </thead>
                  <tbody>
                  @foreach($predictive_taxflow_data as $ptd)
                    <tr>
                      <td>{{ $ptd['year_month'] }}</td>
                      <td>{{ $ptd['tax_out'] }}</td>
                      <td>{{ $ptd['tax_in'] }}</td>
                      <td>{{ $ptd['credit'] }}</td>
                    </tr>
                  @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div>
  </div>

  
@endsection

@section('additional_scripts')
  <script type="text/javascript"></script>

  
@endsection