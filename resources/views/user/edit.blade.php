@extends('layouts.app')

@section('page_title')
  Edit Member
@endsection

@section('additional_styles')
  {!! Html::style('css/datepicker/datepicker3.css') !!}
@endsection

@section('page_header')
  <h1>
    Member
    <small>Edit Member</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('user') }}"><i class="fa fa-users"></i> Member</a></li>
    <li><a href="{{ URL::to('user/'.$user->id) }}">{{ $user->name }}</a></li>
    <li class="active"><i></i> Edit</li>
  </ol>
@endsection

@section('content')
  {!! Form::model($user, ['route'=>['user.update', $user->id], 'class'=>'form-horizontal','id'=>'form-edit-user', 'method'=>'put', 'files'=>true]) !!}
  <div class="row">
    <div class="col-md-8">
      <!--BOX Basic Informations-->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">General Information</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          <div class="form-group{{ $errors->has('number_id') ? ' has-error' : '' }}">
            {!! Form::label('number_id', 'NIK', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {!!Form::text('number_id',$user->nik,['class'=>'form-control', 'placeholder'=>'NIK of the member', 'id'=>'number_id'])!!}
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
              {{ Form::select('role_id', $role_options, $user->roles->first()->id, ['class'=>'form-control', 'placeholder'=>'Select Role', 'id'=>'role_id']) }}
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
            <div class="col-sm-10">
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
      <!--ENDBOX Basic Informations-->

      <!--Box Salary and Allowance-->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Salary &amp; Allowances</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          <div class="form-group{{ $errors->has('salary') ? ' has-error' : '' }}">
            {!! Form::label('salary', 'Basic Salary', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {!!Form::text('salary',null,['class'=>'form-control', 'placeholder'=>'Salary of the member', 'id'=>'salary'])!!}
              @if ($errors->has('salary'))
                <span class="help-block">
                  <strong>{{ $errors->first('salary') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <div class="form-group{{ $errors->has('man_hour_rate') ? ' has-error' : '' }}">
            {!! Form::label('man_hour_rate', 'Man Hour Rate', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {!!Form::text('man_hour_rate',null,['class'=>'form-control', 'placeholder'=>'man_hour_rate of the member', 'id'=>'man_hour_rate'])!!}
              @if ($errors->has('man_hour_rate'))
                <span class="help-block">
                  <strong>{{ $errors->first('man_hour_rate') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <div class="form-group{{ $errors->has('eat_allowance') ? ' has-error' : '' }}">
            {!! Form::label('eat_allowance', 'Eat Allowance', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {!!Form::text('eat_allowance',null,['class'=>'form-control', 'placeholder'=>'eat_allowance of the member', 'id'=>'eat_allowance'])!!}
              @if ($errors->has('eat_allowance'))
                <span class="help-block">
                  <strong>{{ $errors->first('eat_allowance') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <div class="form-group{{ $errors->has('transportation_allowance') ? ' has-error' : '' }}">
            {!! Form::label('transportation_allowance', 'Transportation Allowance', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {!!Form::text('transportation_allowance',null,['class'=>'form-control', 'placeholder'=>'transportation_allowance of the member', 'id'=>'transportation_allowance'])!!}
              @if ($errors->has('transportation_allowance'))
                <span class="help-block">
                  <strong>{{ $errors->first('transportation_allowance') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <div class="form-group{{ $errors->has('medical_allowance') ? ' has-error' : '' }}">
            {!! Form::label('medical_allowance', 'Medical Allowance', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {!!Form::text('medical_allowance',null,['class'=>'form-control', 'placeholder'=>'medical_allowance of the member', 'id'=>'medical_allowance'])!!}
              @if ($errors->has('medical_allowance'))
                <span class="help-block">
                  <strong>{{ $errors->first('medical_allowance') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <div class="form-group{{ $errors->has('has_workshop_allowance') ? ' has-error' : '' }}">
            {!! Form::label('has_workshop_allowance', 'Workshop Allowance', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              @if($user->has_workshop_allowance == TRUE )
                <input type="checkbox" name="has_workshop_allowance" id="has_workshop_allowance" checked />
                {!!Form::text('workshop_allowance_amount',null,['class'=>'form-control', 'placeholder'=>'workshop_allowance_amount of the member', 'id'=>'workshop_allowance_amount'])!!}
              @else
                <input type="checkbox" name="has_workshop_allowance" id="has_workshop_allowance" />
                {!!Form::text('workshop_allowance_amount',null,['class'=>'form-control', 'placeholder'=>'workshop_allowance_amount of the member', 'id'=>'workshop_allowance_amount'])!!}
              @endif
              @if ($errors->has('has_workshop_allowance'))
                <span class="help-block">
                  <strong>{{ $errors->first('has_workshop_allowance') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <div class="form-group{{ $errors->has('incentive_week_day') ? ' has-error' : '' }}">
            {!! Form::label('incentive_week_day', 'Incentive_week_day', ['class'=>'col-sm-2 control-label']) !!}
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
            {!! Form::label('incentive_week_end', 'Incentive_week_end', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {!!Form::text('incentive_week_end',null,['class'=>'form-control', 'placeholder'=>'incentive_week_end of the member', 'id'=>'incentive_week_end'])!!}
              @if ($errors->has('incentive_week_end'))
                <span class="help-block">
                  <strong>{{ $errors->first('incentive_week_end') }}</strong>
                </span>
              @endif
            </div>
          </div>
        </div>
      </div>
      <!-- END Box Salary and Allowance -->
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
              @if($user->profile_picture != NULL)
                <div class="thumbnail" style="width:171px;">
                  {!! Html::image('img/user/thumb_'.$user->profile_picture.'', $user->profile_picture) !!}
                </div>
              @endif
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
                <i class="fa fa-save"></i>&nbsp;Update
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
    $('#salary, #man_hour_rate, #eat_allowance, #transportation_allowance, #medical_allowance, #workshop_allowance_amount, #incentive_week_day, #incentive_week_end, #bpjs_ke, #bpjs_tk').autoNumeric('init',{
        aSep:',',
        aDec:'.'
    });

    $('#role_id').select2({
      allowClear : true
    });

    //Block Work activation date input
    $('#work_activation_date').on('keydown', function(event){
      event.preventDefault();
    });
    $('#work_activation_date').datepicker({
      format : 'yyyy-mm-dd'
    });
    //ENDBlock Work activation date input

    //Handling has workshop alloawance

    //ENDHandling has workshop alloawance
    $('#form-edit-user').on('submit', function(){
      $('#btn-submit-user').prop('disabled', true);
    });


  </script>
@endsection