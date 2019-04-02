@extends('layouts.app')

@section('page_title')
  Input Time Report Sheet
@endsection

@section('page_header')
  <h1>
    Member
    <small>Input Time Report Sheet</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('user') }}"><i class="fa fa-users"></i> Member</a></li>
    <li><a href="{{ URL::to('user/'.$user->id) }}"><i class="fa fa-users"></i> {{ $user->name }}</a></li>
    <li class="active"><i></i> Input Time Report Sheet</li>
  </ol>
@endsection

@section('content')
  <div class="row">
    <div class="col-md-12">
      <!--BOX Time Report Informations-->
      {!! Form::open(['url'=>'user/time-report/store','role'=>'form','class'=>'form-horizontal','id'=>'form-store-user-time-report','files'=>true]) !!}
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-clock-o"></i>&nbsp;Form Input Time Report Sheet</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          <div class="table-responsive">
            <p>
              <i class="fa fa-info-circle"></i>&nbsp;<text class="text-danger">Days with red background is week end</text>
            </p>
            <table class="table">
              <thead>
                <tr>
                  <th style="width:15%;">Date</th>
                  <th style="width:15%;">Allowance</th>
                  <th style="width:10%;">Incentive</th>
                  <th style="width:10%;text-align:center;">Normal Time</th>
                  <th colspan="4" style="text-align: center;">Over Time</th>
                </tr>
                <tr>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th style="text-align: center;">I</th>
                  <th style="text-align: center;">II</th>
                  <th style="text-align: center;">III</th>
                  <th style="text-align: center;">IV</th>
                </tr>
              </thead>
              <tbody>

              @foreach($time_reports as $time_report)
                <tr>
                  <td style="width:15%;">
                    <text class="{{ $time_report->type=='week_end' ? 'alert alert-error' : '' }} ">
                      {{ $time_report->the_date }}
                    </text>
                    {!! Form::hidden('time_report_id[]',$time_report->id,['class'=>'form-control', 'placeholder'=>'Time Report ID', 'id'=>'time_report_id']) !!}
                  </td>
                  <td>
                    {{ Form::select('allowance[]', $allowance_opts, ['allowance'], ['class'=>'form-control allowance_input', 'placeholder'=>'--Select Allowance--']) }}
                  </td>
                  <td style="text-align:center;">
                    {{ Form::select('incentive[]', $incentive_opts, ['non'], ['class'=>'form-control incentive_input', 'placeholder'=>'--Select Incentive--']) }}
                  </td>
                  <td style="text-align:center;">
                    {!! Form::text('normal_time[]',null,['class'=>'form-control normal_time_input', 'placeholder'=>'Normal Time']) !!}
                  </td>
                  <td style="text-align: center; width: 10%;">
                    {!! Form::text('overtime_one[]',null,['class'=>'form-control overtime_input', 'placeholder'=>'Overtime I']) !!}
                  </td>
                  <td style="text-align: center; width: 10%;">
                    {!! Form::text('overtime_two[]',null,['class'=>'form-control overtime_input', 'placeholder'=>'Overtime II']) !!}
                  </td>
                  <td style="text-align: center; width: 10%;">
                    {!! Form::text('overtime_three[]',null,['class'=>'form-control overtime_input', 'placeholder'=>'Overtime III']) !!}
                  </td>
                  <td style="text-align: center; width: 10%;">
                    {!! Form::text('overtime_four[]',null,['class'=>'form-control overtime_input', 'placeholder'=>'Overtime IV']) !!}
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
          {{ Form::hidden('user_id', $user->id) }}
          {{ Form::hidden('period_id', $period->id) }}
          <button type="submit" class="btn btn-info" id="btn-submit-user-time-report">
            <i class="fa fa-save"></i>&nbsp;Save
          </button>
        </div>
      </div>
      {!! Form::close() !!}
      <!--ENDBOX Time Report Informations-->
    </div
  </div>
@endsection

@section('additional_scripts')
  {!! Html::script('js/autoNumeric.js') !!}
  <script type="text/javascript">
    $('.overtime_input').autoNumeric('init',{
        aSep:',',
        aDec:'.',
        mDec : '0',
        vMax : '24'
    });

    $('.normal_time_input').autoNumeric('init',{
        aSep:',',
        aDec:'.',
        mDec : '0',
        vMax : '24'
    });

    $('.allowance_input').on('change', function(){
      
    });

    $('#form-store-user-time-report').on('submit', function(){
      $('#btn-submit-user-time-report').prop('disabled', true);
    });
  </script>
@endsection