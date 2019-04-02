@extends('layouts.app')

@section('page_title')
  Time Report Sheet Detail
@endsection

@section('page_header')
  <h1>
    Member
    <small>Time Report Sheet Detail</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('user') }}"><i class="fa fa-users"></i> Member</a></li>
    <li><a href="{{ URL::to('user/'.$user->id) }}"><i class="fa fa-users"></i> {{ $user->name }}</a></li>
    <li class="active"><i></i> Time Report Sheet</li>
  </ol>
@endsection

@section('content')
  <div class="row">
    <div class="col-md-12">
      <!--BOX Time Report Informations-->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-clock-o"></i>&nbsp;User Time Report Sheet</h3>
          <a href="{{ url('user/print_salary/?user_id='.$user->id.'&period_id='.$period->id.'') }}" class="btn btn-xs btn-default pull-right">Print Salary</a>
        </div><!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col-md-2">Period</div>
            <div class="col-md-10">{{ $period->start_date}} s/d {{ $period->end_date }}</div>
          </div>
          <br/>
          <div class="table-responsive">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th style="width:15%;">Date</th>
                  <th style="width:20%;text-align:center;" colspan="3">Incentive</th>
                  <th style="width:15%; text-align:center;" colspan="2">Allowance</th>
                  <th style="width:10%;text-align:center;">Normal Time</th>
                  <th colspan="4" style="text-align: center;">Over Time</th>
                </tr>
                <tr>
                  <th></th>
                  <th style="text-align:center;">Non</th>
                  <th style="text-align:center;">Week Day</th>
                  <th style="text-align:center;">Week End</th>
                  <th style="text-align:center;">Allowance</th>
                  <th style="text-align:center;">Non Allowance</th>
                  <th style="text-align:center;"></th>
                  <th style="text-align:center;">I</th>
                  <th style="text-align:center;">II</th>
                  <th style="text-align:center;">III</th>
                  <th style="text-align:center;">IV</th>
                </tr>
              </thead>
              <tbody>
              @foreach($time_report_users as $time_report_user)
                <tr>
                  <td>{{ $time_report_user->the_date }}</td>
                  <td style="text-align:center;">
                    <input type="checkbox" disabled {{ $time_report_user->pivot->incentive == 'non' ? 'checked' : '' }} />
                  </td>
                  <td style="text-align:center;">
                    <input type="checkbox" disabled {{ $time_report_user->pivot->incentive == 'week_day' ? 'checked' : '' }} />
                  </td>
                  <td style="text-align:center;">
                    <input type="checkbox" disabled {{ $time_report_user->pivot->incentive == 'week_end' ? 'checked' : '' }} />
                  </td>
                  <td style="text-align:center;">
                    <input type="checkbox"  disabled {{ $time_report_user->pivot->allowance == TRUE ? 'checked' : '' }} />
                  </td>
                  <td style="text-align:center;">
                    <input type="checkbox"  disabled {{ $time_report_user->pivot->non_allowance == TRUE ? "checked" : "" }} />
                  </td>
                  <td style="text-align:center;">{{ $time_report_user->pivot->normal_time }}</td>
                  <td style="text-align:center;">{{ $time_report_user->pivot->overtime_one}}</td>
                  <td style="text-align:center;">{{ $time_report_user->pivot->overtime_two }}</td>
                  <td style="text-align:center;">{{ $time_report_user->pivot->overtime_three }}</td>
                  <td style="text-align:center;">{{ $time_report_user->pivot->overtime_four }}</td>
                </tr>
              @endforeach
              </tbody>
              <tfoot>
                <tr>
                  <td>Total</td>
                  <td style="text-align:center;">{{ $total_incentive_non }}</td>
                  <td style="text-align:center;">{{ $total_incentive_week_day }}</td>
                  <td style="text-align:center;">{{ $total_incentive_week_end }}</td>
                  <td style="text-align:center;">{{ $total_allowance }}</td>
                  <td style="text-align:center;">{{ $total_non_allowance }}</td>
                  <td style="text-align:center;">{{ $total_normal_time }}</td>
                  <td style="text-align:center;">{{ $total_overtime_one * 1.5 }}</td>
                  <td style="text-align:center;">{{ $total_overtime_two * 2 }}</td>
                  <td style="text-align:center;">{{ $total_overtime_three * 3 }}</td>
                  <td style="text-align:center;">{{ $total_overtime_four * 4 }}</td>
                </tr>
              </tfoot>
            </table>
          </div>
        </div><!-- /.box-body -->
      </div>
      <!--ENDBOX Time Report Informations-->
    </div>
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

    $('#form-store-user-time-report').on('submit', function(){
      $('#btn-submit-user-time-report').prop('disabled', true);
    });
  </script>
@endsection