@extends('layouts.app')

@section('page_title')
  Payroll
@endsection

@section('additional_styles')
  <style type="text/css">
    table#table-salary-description{
      width: 100%;
    }
    table#table-salary-description td{
      padding: 4px;
      vertical-align: top;
      border: 1px solid;
    }

    table#table-manhour-summary td{
      text-align: center;
      border:1px solid;
    }
  </style>
@endsection

@section('page_header')
  <h1>
    Payroll
    <small>Detail</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('payroll') }}"><i class="fa fa-clock-o"></i> Payroll</a></li>
    <li class="active"><i></i> Create</li>
  </ol>
@endsection

@section('content')
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading">
          <div class="panel-title">
            <i class="fa fa-credit-card"></i>&nbsp;Create Payroll
          </div>
        </div>
        <div class="panel-body">
          {!! Form::open(['route'=>'payroll.store','role'=>'form','class'=>'form-horizontal','id'=>'form-create-payroll','files'=>true]) !!}

          <div class="form-group{{ $errors->has('user_id') ? ' has-error' : '' }}">
            {!! Form::label('user_id', 'User', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {{ Form::select('user_id', [], null, ['class'=>'form-control', 'placeholder'=>'Select User', 'id'=>'user_id']) }}
              @if ($errors->has('user_id'))
                <span class="help-block">
                  <strong>{{ $errors->first('user_id') }}</strong>
                </span>
              @endif
            </div>
          </div>

          <div class="form-group{{ $errors->has('period_id') ? ' has-error' : '' }}">
            {!! Form::label('period_id', 'Period', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {{ Form::select('period_id', $period_opts, null, ['class'=>'form-control', 'placeholder'=>'Select Period', 'id'=>'period_id']) }}
              @if ($errors->has('period_id'))
                <span class="help-block">
                  <strong>{{ $errors->first('period_id') }}</strong>
                </span>
              @endif
            </div>
          </div>

          <div class="form-group">
            {!! Form::label('', '', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              <a href="{{ url('payroll') }}" class="btn btn-default">
                <i class="fa fa-repeat"></i>&nbsp;Cancel
              </a>&nbsp;
              <button type="submit" class="btn btn-info" id="btn-submit-payroll">
                <i class="fa fa-save"></i>&nbsp;Submit
              </button>
            </div>
          </div>
          {!! Form::close() !!}

        </div>
      </div>
    </div>

    
  </div>

 
@endsection

@section('additional_scripts')
<script type="text/javascript">
  //Block User Selection
    $('#user_id').select2({
      placeholder: 'Select Member',
      ajax: {
        url: '{!! url('select2User') !!}',
        dataType: 'json',
        delay: 250,
        processResults: function (data) {
          return {
            results:  $.map(data, function (item) {
                  return {
                      text: item.name,
                      id: item.id
                  }
              })
          };
        },
        cache: true
      }
    });
    //ENDBlock User Selection
</script>
@endsection