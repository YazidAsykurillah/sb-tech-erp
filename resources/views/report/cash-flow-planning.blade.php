@extends('layouts.app')

@section('page_title')
  Report
@endsection

@section('page_header')
  <h1>
    Report
    <small>Cash Flow Planning Report</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="#"><i class="fa fa-database"></i> Report</a></li>
    <li class="active"><i></i> Cash Flow Planning Report</li>
  </ol>
@endsection

@section('content')
  <div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Cash Flow Planning</h3>
            </div><!-- /.box-header -->
            <div class="box-body">
              <div class="row">
                <div class="col-md-12">
                  <ul class="list-group">
                    @foreach($years as $year)
                      <a href="{{ url('report/cash-flow-planning/?year='.$year.'') }}" class="list-group-item {{ $year==date('Y') ? 'active' : '' }}">
                        {{$year}}
                      </a>
                    @endforeach
                  </ul>
                  
                </div>
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