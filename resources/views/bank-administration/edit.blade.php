@extends('layouts.app')

@section('page_title')
    Bank Administration
@endsection

@section('page_header')
  <h1>
    Bank Administration
    <small>Create Bank Administration</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('bank-administration') }}"><i class="fa fa-book"></i> Bank Administration</a></li>
    <li class="active"><i></i> Edit</li>
  </ol>
@endsection

@section('content')
  <div class="row">
    <div class="col-md-12">
      <!--BOX Basic Informations-->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Form Edit Bank Administration</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          {!! Form::model($bank_administration, ['route'=>['bank-administration.update', $bank_administration->id], 'class'=>'form-horizontal','method'=>'put', 'files'=>true]) !!}
          <div class="form-group{{ $errors->has('code') ? ' has-error' : '' }}">
            {!! Form::label('code', 'Code ', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {!! Form::text('code',null,['class'=>'form-control', 'placeholder'=>'Code of the Bank Administration', 'id'=>'code', 'disabled'=>true]) !!}
              @if ($errors->has('code'))
                <span class="help-block">
                  <strong>{{ $errors->first('code') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <div class="form-group{{ $errors->has('refference_number') ? ' has-error' : '' }}">
            {!! Form::label('refference_number', 'Refference Number ', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {!! Form::text('refference_number',null,['class'=>'form-control', 'placeholder'=>'Refference number of the bank administration', 'id'=>'refference_number']) !!}
              @if ($errors->has('refference_number'))
                <span class="help-block">
                  <strong>{{ $errors->first('refference_number') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
            {!! Form::label('description', 'Description', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {!! Form::text('description',null,['class'=>'form-control', 'placeholder'=>'Description of the bank administration', 'id'=>'description']) !!}
              @if ($errors->has('description'))
                <span class="help-block">
                  <strong>{{ $errors->first('description') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
            {!! Form::label('amount', 'Amount', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {!! Form::text('amount',null,['class'=>'form-control', 'placeholder'=>'Amount of the bank administration', 'id'=>'amount']) !!}
              @if ($errors->has('amount'))
                <span class="help-block">
                  <strong>{{ $errors->first('amount') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <div class="form-group">
              {!! Form::label('', '', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              <a href="{{ url('bank-administration') }}" class="btn btn-default">
                <i class="fa fa-repeat"></i>&nbsp;Cancel
              </a>&nbsp;
              <button type="submit" class="btn btn-info" id="btn-submit-bank-administration">
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
  {!! Html::script('js/autoNumeric.js') !!}
  <script type="text/javascript">
   
    //Block Amount input
    $('#amount').autoNumeric('init',{
        aSep:',',
        aDec:'.'
    });
    //ENDBLock Amount input

    $('#form-create-bank-administration').on('submit', function(){
      $('#btn-submit-bank-administration').prop('disabled', true);
    });
  </script>
@endsection