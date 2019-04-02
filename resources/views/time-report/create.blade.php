@extends('layouts.app')

@section('page_title')
  Register Time Sheet
@endsection

@section('page_header')
  <h1>
    Period
    <small>Register Time Report Sheet</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('period') }}"><i class="fa fa-clock-o"></i> Period</a></li>
    <li><a href="{{ URL::to('period/'.$period->id) }}"><i class="fa fa-clock-o"></i> {{ $period->code }}</a></li>
    <li class="active"><i></i> Register Time Report Sheet</li>
  </ol>
@endsection

@section('content')
  <div class="row">
    <div class="col-md-5">
      <!--BOX Basic Informations-->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-clock-o"></i>&nbsp;Period Information</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          <div class="table-responsive">
            <table class="table">
              <tr>
                <td style="width: 20%;">Code</td>
                <td style="width: 1%;">:</td>
                <td>{{ $period->code }}</td>
              </tr>
              <tr>
                <td style="width: 20%;">Start Date</td>
                <td style="width: 1%;">:</td>
                <td>{{ $period->start_date }}</td>
              </tr>
              <tr>
                <td style="width: 20%;">End Date</td>
                <td style="width: 1%;">:</td>
                <td>{{ $period->end_date }}</td>
              </tr>
              
            </table>
          </div>
        </div><!-- /.box-body -->
        <div class="box-footer clearfix">
          
        </div>
      </div>
      <!--ENDBOX Basic Informations-->
    </div>
    <div class="col-md-7">
      <!--BOX Time Report Informations-->
      {!! Form::open(['route'=>'time-report.store','role'=>'form','class'=>'form-horizontal','id'=>'form-create-time-report','files'=>true]) !!}
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-clock-o"></i>&nbsp;Form Register Time Report Sheet</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          <div class="table-responsive">
            <table class="table">
              
              <thead>
                <tr>
                  <th>Date</th>
                  <th>Day Type</th>
                </tr>
              </thead>
              <tbody>

              @foreach($time_report_dates as $time_report_date)
                <tr>
                  <td>
                    {{ $time_report_date }}
                    {!! Form::hidden('the_date[]',$time_report_date,['class'=>'form-control', 'placeholder'=>'The Date']) !!}
                  </td>
                  <td>
                    {{ Form::select('type[]', ['usual'=>"Usual", 'week_end'=>"Week End", 'day_off'=>"Day Off"],
                    'usual', ['class'=>'form-control', 'placeholder'=>'Select Day Type']) }}
                  </td>
                </tr>
              @endforeach
              </tbody>
              <tfoot>
                
              </tfoot>
            </table>
          </div>
        </div><!-- /.box-body -->
        <div class="box-footer clearfix">
          <input type="hidden" name="period_id" value="{{ $period->id }}" />
          <button type="submit" class="btn btn-info" id="btn-submit-time-report">
            <i class="fa fa-save"></i>&nbsp;Register
          </button>
        </div>
      </div>
      {!! Form::close() !!}
      <!--ENDBOX Time Report Informations-->
    </div>
  </div>
@endsection

@section('additional_scripts')
  
@endsection