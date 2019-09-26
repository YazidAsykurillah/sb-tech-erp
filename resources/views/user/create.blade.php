@extends('layouts.app')

@section('page_title')
  Create Member
@endsection

@section('additional_styles')
  {!! Html::style('css/datepicker/datepicker3.css') !!}
@endsection

@section('page_header')
  <h1>
    Member
    <small>Create Member</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('user') }}"><i class="fa fa-users"></i> Member</a></li>
    <li class="active"><i></i> Create</li>
  </ol>
@endsection

@section('content')
  {!! Form::open(['route'=>'user.store','role'=>'form','class'=>'form-horizontal','id'=>'form-create-user','files'=>true]) !!}
  <div class="row">
    <div class="col-md-8">
      <!--BOX General Informations-->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">General Information</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          <div class="form-group{{ $errors->has('number_id') ? ' has-error' : '' }}">
            {!! Form::label('number_id', 'NIK', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {!!Form::text('number_id',null,['class'=>'form-control', 'placeholder'=>'Number id of the member', 'id'=>'number_id'])!!}
              @if ($errors->has('number_id'))
                <span class="help-block">
                  <strong>{{ $errors->first('number_id') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            {!! Form::label('name', 'Member Name', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {!! Form::text('name',null,['class'=>'form-control', 'placeholder'=>'Name of the member', 'id'=>'name']) !!}
              @if ($errors->has('name'))
                <span class="help-block">
                  <strong>{{ $errors->first('name') }}</strong>
                </span>
              @endif
            </div>
          </div>

          <div class="form-group{{ $errors->has('role_id') ? ' has-error' : '' }}">
            {!! Form::label('role_id', 'Role', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {{ Form::select('role_id', $role_options, null, ['class'=>'form-control', 'placeholder'=>'--Select role--', 'id'=>'role_id']) }}
              @if ($errors->has('role_id'))
                <span class="help-block">
                  <strong>{{ $errors->first('role_id') }}</strong>
                </span>
              @endif
            </div>
          </div>

          <div class="form-group{{ $errors->has('position') ? ' has-error' : '' }}">
            {!! Form::label('position', 'Position', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {!! Form::text('position',null,['class'=>'form-control', 'placeholder'=>'position of the member', 'id'=>'position']) !!}
              @if ($errors->has('position'))
                <span class="help-block">
                  <strong>{{ $errors->first('position') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            {!! Form::label('email', 'Email', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {!! Form::text('email',null,['class'=>'form-control', 'placeholder'=>'Email of the member', 'id'=>'email']) !!}
              @if ($errors->has('email'))
                <span class="help-block">
                  <strong>{{ $errors->first('email') }}</strong>
                </span>
              @endif
            </div>
          </div>
          

          <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
            {!! Form::label('type', 'Type', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-4">
              {{ Form::select('type', ['office'=>'Office', 'outsource'=>'Outsource'], null, ['class'=>'form-control', 'placeholder'=>'--Select Type--', 'id'=>'type']) }}
              @if ($errors->has('type'))
                <span class="help-block">
                  <strong>{{ $errors->first('type') }}</strong>
                </span>
              @endif
            </div>
          </div>

          <div class="form-group{{ $errors->has('work_activation_date') ? ' has-error' : '' }}">
            {!! Form::label('work_activation_date', 'Work Active Date', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-4">
              {!! Form::text('work_activation_date',null,['class'=>'form-control', 'placeholder'=>'Tanggal aktif kerja member', 'id'=>'work_activation_date']) !!}
              @if ($errors->has('work_activation_date'))
                <span class="help-block">
                  <strong>{{ $errors->first('work_activation_date') }}</strong>
                </span>
              @endif
            </div>
          </div>
          
          
        </div><!-- /.box-body -->
      </div>
      <!--ENDBOX General Informations-->

      <!--BOX Salary and Allowance-->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Salary and Allowances</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          <div class="form-group{{ $errors->has('salary') ? ' has-error' : '' }}">
            {!! Form::label('salary', 'Salary', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {!!Form::text('salary',null,['class'=>'form-control', 'placeholder'=>'Salary of the member', 'id'=>'salary'])!!}
              @if ($errors->has('salary'))
                <span class="help-block">
                  <strong>{{ $errors->first('salary') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <div class="form-group{{ $errors->has('eat_allowance') ? ' has-error' : '' }}">
            {!! Form::label('eat_allowance', 'Eat Allowance', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {!!Form::text('eat_allowance',null,['class'=>'form-control', 'placeholder'=>'Uang Makan / Hari', 'id'=>'eat_allowance'])!!}
              @if ($errors->has('eat_allowance'))
                <span class="help-block">
                  <strong>{{ $errors->first('eat_allowance') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <div class="form-group{{ $errors->has('eat_allowance_non_local') ? ' has-error' : '' }}">
            {!! Form::label('eat_allowance_non_local', 'Eat Allowance Non Local', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {!!Form::text('eat_allowance_non_local',null,['class'=>'form-control', 'placeholder'=>'Uang Makan / Hari', 'id'=>'eat_allowance_non_local'])!!}
              @if ($errors->has('eat_allowance_non_local'))
                <span class="help-block">
                  <strong>{{ $errors->first('eat_allowance_non_local') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <div class="form-group{{ $errors->has('transportation_allowance') ? ' has-error' : '' }}">
            {!! Form::label('transportation_allowance', 'Transportation Allowance', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {!!Form::text('transportation_allowance',null,['class'=>'form-control', 'placeholder'=>'Transportasi / Hari', 'id'=>'transportation_allowance'])!!}
              @if ($errors->has('transportation_allowance'))
                <span class="help-block">
                  <strong>{{ $errors->first('transportation_allowance') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <div class="form-group{{ $errors->has('transportation_allowance_non_local') ? ' has-error' : '' }}">
            {!! Form::label('transportation_allowance_non_local', 'Transportation Allowance Non Local', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {!!Form::text('transportation_allowance_non_local',null,['class'=>'form-control', 'placeholder'=>'Transportasi / Hari', 'id'=>'transportation_allowance_non_local'])!!}
              @if ($errors->has('transportation_allowance_non_local'))
                <span class="help-block">
                  <strong>{{ $errors->first('transportation_allowance_non_local') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <div class="form-group{{ $errors->has('medical_allowance') ? ' has-error' : '' }}">
            {!! Form::label('medical_allowance', 'Medical Allowance', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {!!Form::text('medical_allowance',null,['class'=>'form-control', 'placeholder'=>'Tunjangan Kesehatan / Bulan', 'id'=>'medical_allowance'])!!}
              @if ($errors->has('medical_allowance'))
                <span class="help-block">
                  <strong>{{ $errors->first('medical_allowance') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <div class="form-group{{ $errors->has('incentive_week_day') ? ' has-error' : '' }}">
            {!! Form::label('incentive_week_day', 'Weekday Incentive', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {!!Form::text('incentive_week_day',null,['class'=>'form-control', 'placeholder'=>'incentive_week_day of the member', 'id'=>'incentive_week_day'])!!}
              @if ($errors->has('incentive_week_day'))
                <span class="help-block">
                  <strong>{{ $errors->first('incentive_week_day') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <div class="form-group{{ $errors->has('incentive_week_end') ? ' has-error' : '' }}">
            {!! Form::label('incentive_week_end', 'Weekend Incentive', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {!!Form::text('incentive_week_end',null,['class'=>'form-control', 'placeholder'=>'incentive_week_end of the member', 'id'=>'incentive_week_end'])!!}
              @if ($errors->has('incentive_week_end'))
                <span class="help-block">
                  <strong>{{ $errors->first('incentive_week_end') }}</strong>
                </span>
              @endif
            </div>
          </div>
        </div><!-- /.box-body -->
      </div>
      <!--ENDBOX Salary and Allowance-->

      <!--BOX BPJS-->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">BPJS</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          <div class="form-group{{ $errors->has('bpjs_tk') ? ' has-error' : '' }}">
            {!! Form::label('bpjs_tk', 'BPJS Tenaga Kerja', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {!!Form::text('bpjs_tk',null,['class'=>'form-control', 'placeholder'=>'bpjs_tk of the member', 'id'=>'bpjs_tk'])!!}
              @if ($errors->has('bpjs_tk'))
                <span class="help-block">
                  <strong>{{ $errors->first('bpjs_tk') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <div class="form-group{{ $errors->has('bpjs_ke') ? ' has-error' : '' }}">
            {!! Form::label('bpjs_ke', 'BPJS Kesehatan', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {!!Form::text('bpjs_ke',null,['class'=>'form-control', 'placeholder'=>'bpjs_ke of the member', 'id'=>'bpjs_ke'])!!}
              @if ($errors->has('bpjs_ke'))
                <span class="help-block">
                  <strong>{{ $errors->first('bpjs_ke') }}</strong>
                </span>
              @endif
            </div>
          </div>
        </div><!-- /.box-body -->
      </div>
      <!--ENDBOX BPJS-->
    </div>

    <div class="col-md-4">
      <!--BOX Image-->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Profile Picture</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
            {!! Form::label('image', 'Profile Picture', ['class'=>'col-sm-4 control-label']) !!}
            <div class="col-sm-8">
              {{ Form::file('image', ['class']) }}
              @if ($errors->has('image'))
                <span class="help-block">
                  <strong>{{ $errors->first('image') }}</strong>
                </span>
              @endif
            </div>
          </div>
        </div><!-- /.box-body -->
      </div>
      <!--ENDBOX Image-->
    </div>
  </div>

  <div class="row">
    <div class="col-md-8">
      <div class="box">
        <div class="box-body">
          <div class="form-group">
              {!! Form::label('', '', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              <a href="{{ url('user') }}" class="btn btn-default">
                <i class="fa fa-repeat"></i>&nbsp;Cancel
              </a>&nbsp;
              <button type="submit" class="btn btn-info" id="btn-submit-user">
                <i class="fa fa-save"></i>&nbsp;Submit
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  {!! Form::close() !!}
@endsection

@section('additional_scripts')
  {!! Html::script('js/datepicker/bootstrap-datepicker.js') !!}
  {!! Html::script('js/autoNumeric.js') !!}
  <script type="text/javascript">
    $('#salary').autoNumeric('init',{
        aSep:',',
        aDec:'.'
    });
    $('#eat_allowance').autoNumeric('init',{
        aSep:',',
        aDec:'.'
    });
    $('#eat_allowance_non_local').autoNumeric('init',{
        aSep:',',
        aDec:'.'
    });
    $('#transportation_allowance').autoNumeric('init',{
        aSep:',',
        aDec:'.'
    });
    $('#transportation_allowance_non_local').autoNumeric('init',{
        aSep:',',
        aDec:'.'
    });
    $('#medical_allowance').autoNumeric('init',{
        aSep:',',
        aDec:'.'
    });

    $('#incentive_week_day').autoNumeric('init',{
        aSep:',',
        aDec:'.'
    });

    $('#incentive_week_end').autoNumeric('init',{
        aSep:',',
        aDec:'.'
    });

    $('#bpjs_tk').autoNumeric('init',{
        aSep:',',
        aDec:'.'
    });
    $('#bpjs_ke').autoNumeric('init',{
        aSep:',',
        aDec:'.'
    });

    $('#form-create-user').on('submit', function(){
      $('#btn-submit-user').prop('disabled', true);
    });
    
    //Block Work activation date input
    $('#work_activation_date').on('keydown', function(event){
      event.preventDefault();
    });
    $('#work_activation_date').datepicker({
      format : 'yyyy-mm-dd'
    });
    //ENDBlock Work activation date input
  </script>
@endsection