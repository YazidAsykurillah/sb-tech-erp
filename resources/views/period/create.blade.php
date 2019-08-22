@extends('layouts.app')

@section('page_title')
  Create Period
@endsection

@section('additional_styles')
  {!! Html::style('css/datepicker/datepicker3.css') !!}
@endsection

@section('page_header')
  <h1>
    Period
    <small>Create Period</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('period') }}"><i class="fa fa-clock-o"></i> Period</a></li>
    <li class="active"><i></i> Create</li>
  </ol>
@endsection

@section('content')
  <div class="row">
    <div class="col-md-12">
      <!--BOX Basic Informations-->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Form Create period</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          {!! Form::open(['route'=>'period.store','role'=>'form','class'=>'form-horizontal','id'=>'form-create-period','files'=>true]) !!}
          <div class="form-group{{ $errors->has('the_year') ? ' has-error' : '' }}">
            {!! Form::label('the_year', 'Year', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {{ Form::select('the_year', $the_year_opts, null, ['class'=>'form-control', 'placeholder'=>'Select Year', 'id'=>'the_year']) }}
              @if ($errors->has('the_year'))
                <span class="help-block">
                  <strong>{{ $errors->first('the_year') }}</strong>
                </span>
              @endif
            </div>
          </div>
          
          <div class="form-group{{ $errors->has('the_month') ? ' has-error' : '' }}">
            {!! Form::label('the_month', 'Month', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {{ Form::select('the_month', $the_month_opts, null, ['class'=>'form-control', 'placeholder'=>'Select Month', 'id'=>'the_month']) }}
              @if ($errors->has('the_month'))
                <span class="help-block">
                  <strong>{{ $errors->first('the_month') }}</strong>
                </span>
              @endif
            </div>
          </div>

          <div class="form-group{{ $errors->has('start_date') ? ' has-error' : '' }}">
              {!! Form::label('start_date', 'Start Date', ['class'=>'col-sm-2 control-label']) !!}
              <div class="col-sm-10">
                {!! Form::text('start_date',null,['class'=>'form-control', 'placeholder'=>'start_date of the period', 'id'=>'start_date']) !!}
                @if ($errors->has('start_date'))
                  <span class="help-block">
                    <strong>{{ $errors->first('start_date') }}</strong>
                  </span>
                @endif
              </div>
          </div>

          <div class="form-group{{ $errors->has('end_date') ? ' has-error' : '' }}">
              {!! Form::label('end_date', 'End Date', ['class'=>'col-sm-2 control-label']) !!}
              <div class="col-sm-10">
                {!! Form::text('end_date',null,['class'=>'form-control', 'placeholder'=>'end_date of the period', 'id'=>'end_date']) !!}
                @if ($errors->has('end_date'))
                  <span class="help-block">
                    <strong>{{ $errors->first('end_date') }}</strong>
                  </span>
                @endif
              </div>
          </div>

          <div class="form-group">
              {!! Form::label('', '', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              <a href="{{ url('period') }}" class="btn btn-default">
                <i class="fa fa-repeat"></i>&nbsp;Cancel
              </a>&nbsp;
              <button type="submit" class="btn btn-info" id="btn-submit-period">
                <i class="fa fa-save"></i>&nbsp;Submit
              </button>
            </div>
          </div>
          {!! Form::close() !!}
          
        </div><!-- /.box-body -->
      </div>
      <!--ENDBOX Basic Informations-->
    </div>
  </div>
@endsection

@section('additional_scripts')
  {!! Html::script('js/datepicker/bootstrap-datepicker.js') !!}
  <script type="text/javascript">

    //Block Start Date input
    $('#start_date').on('keydown', function(event){
      event.preventDefault();
    });
    $('#start_date').datepicker({
      format : 'yyyy-mm-dd'
    });
    //ENDBlock Start Date input

    //Block End Date input
    $('#end_date').on('keydown', function(event){
      event.preventDefault();
    });
    $('#end_date').datepicker({
      format : 'yyyy-mm-dd'
    });
    //ENDBlock End Date input

    $('#form-create-period').on('submit', function(){
      $('#btn-submit-period').prop('disabled', true);
    });
  </script>
@endsection