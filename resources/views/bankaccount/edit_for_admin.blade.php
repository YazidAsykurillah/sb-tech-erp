@extends('layouts.app')

@section('page_title')
    Bank Account | Create
@endsection

@section('page_header')
  <h1>
    Bank Account
    <small>Edit Bank Account</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('bank-account') }}"><i class="fa fa-building"></i> Bank Account</a></li>
    <li class="active"><i></i> Edit</li>
  </ol>
@endsection

@section('content')
  
  <div class="row">
    <div class="col-md-12">
      <!--BOX Basic Informations-->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Form Update Bank Account</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          {!! Form::model($bank_account, ['route'=>['bank-account.update', $bank_account->id], 'class'=>'form-horizontal','method'=>'put', 'files'=>true]) !!}
          
          <div class="form-group{{ $errors->has('user_id') ? ' has-error' : '' }}">
            {!! Form::label('user_id', 'Owner', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {{ Form::select('user_id', $user_opts, null, ['class'=>'form-control', 'placeholder'=>'Select User', 'id'=>'user_id']) }}
              @if ($errors->has('user_id'))
                <span class="help-block">
                  <strong>{{ $errors->first('user_id') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            {!! Form::label('name', 'Bank Account Name', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {!! Form::text('name',null,['class'=>'form-control', 'placeholder'=>'Name of the bank', 'id'=>'name']) !!}
              @if ($errors->has('name'))
                <span class="help-block">
                  <strong>{{ $errors->first('name') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <div class="form-group{{ $errors->has('account_number') ? ' has-error' : '' }}">
            {!! Form::label('account_number', 'Account Number', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {!! Form::text('account_number',null,['class'=>'form-control', 'placeholder'=>'Account number of the bank', 'id'=>'account_number']) !!}
              @if ($errors->has('account_number'))
                <span class="help-block">
                  <strong>{{ $errors->first('account_number') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <div class="form-group">
            {!! Form::label('', '', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              <a href="{{ url('bank-account') }}" class="btn btn-default">
                <i class="fa fa-repeat"></i>&nbsp;Cancel
              </a>&nbsp;
              <button type="submit" class="btn btn-info" id="btn-submit-bank-account">
                <i class="fa fa-save"></i>&nbsp;Update
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
    $('#form-create-bank-account').on('submit', function(){
      $('#btn-submit-bank-account').prop('disabled', true);
    });
  </script>
@endsection