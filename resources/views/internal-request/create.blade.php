@extends('layouts.app')

@section('page_title')
    Internal Request
@endsection

@section('page_header')
  <h1>
    Internal Request
    <small>Create Internal Request</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('internal-request') }}"><i class="fa fa-tag"></i> Internal Request</a></li>
    <li class="active"><i></i> Create </li>
  </ol>
@endsection
  
@section('content')
  <div class="row">
    <div class="col-md-12">
      <!--BOX Basic Informations-->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Form Create Internal Request</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          {!! Form::open(['route'=>'internal-request.store','role'=>'form','class'=>'form-horizontal','id'=>'form-create-internal-request','files'=>true]) !!}
          
          <div class="form-group{{ $errors->has('requester_id') ? ' has-error' : '' }}">
            {!! Form::label('requester_id', 'Requester', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              @if(\Auth::user()->can('create-internal-request-to-other'))
                {{ Form::select('requester_id', $requester_opts, null, ['class'=>'form-control', 'placeholder'=>'Select Requester', 'id'=>'requester_id']) }}
              @else
                {!! Form::text('requester_name',\Auth::user()->name,['class'=>'form-control', 'placeholder'=>'Requester NAME', 'id'=>'requester_name', 'disabled'=>true]) !!}
                {!! Form::hidden('requester_id',\Auth::user()->id,['class'=>'form-control', 'placeholder'=>'Requester ID', 'id'=>'requester_id']) !!}
              @endif
              @if ($errors->has('requester_id'))
                <span class="help-block">
                  <strong>{{ $errors->first('requester_id') }}</strong>
                </span>
              @endif
            </div>
          </div>

          <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
            
            {!! Form::label('type', 'Type', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {{ Form::select('type', $type_opts, null, ['class'=>'form-control', 'placeholder'=>'Select Type', 'id'=>'type']) }}
              @if($internal_request_lock_state == 1)
              <span class="help-block">
                  <strong><i class="fa fa-info-circle"></i>&nbsp;For now, you can only select internal type "Material"</strong>
              </span>
              @endif
              @if ($errors->has('type'))
                <span class="help-block">
                  <strong>{{ $errors->first('type') }}</strong>
                </span>
              @endif
            </div>
          </div>

          <div class="form-group{{ $errors->has('project_id') ? ' has-error' : '' }}">
            {!! Form::label('project_id', 'Project', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {{ Form::select('project_id', $project_opts, null, ['class'=>'form-control', 'placeholder'=>'Select Project', 'id'=>'project_id']) }}
              @if ($errors->has('project_id'))
                <span class="help-block">
                  <strong>{{ $errors->first('project_id') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <!-- Selection Vendor-->
          
          <!-- ENDSelection Vendor-->
          <div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
            {!! Form::label('amount', 'Amount', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {!! Form::text('amount',null,['class'=>'form-control', 'placeholder'=>'Amount of the Internal Request', 'id'=>'amount']) !!}
              @if ($errors->has('amount'))
                <span class="help-block">
                  <strong>{{ $errors->first('amount') }}</strong>
                </span>
              @endif
            </div>
          </div>

          <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
            {!! Form::label('description', 'Description', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {!! Form::textarea('description',null,['class'=>'form-control', 'placeholder'=>'Description of the Internal Request', 'id'=>'description']) !!}
              @if ($errors->has('description'))
                <span class="help-block">
                  <strong>{{ $errors->first('description') }}</strong>
                </span>
              @endif
            </div>
          </div>
          
          <div class="form-group{{ $errors->has('is_petty_cash') ? ' has-error' : '' }}">
            {!! Form::label('is_petty_cash', 'Petty Cash', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {!! Form:: checkbox('is_petty_cash', null) !!} Check if this IR is petty cash
              @if ($errors->has('is_petty_cash'))
                <span class="help-block">
                  <strong>{{ $errors->first('is_petty_cash') }}</strong>
                </span>
              @endif
            </div>
          </div>

          
          
          <div class="form-group">
              {!! Form::label('', '', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              <a href="{{ url('internal-request') }}" class="btn btn-default">
                <i class="fa fa-repeat"></i>&nbsp;Cancel
              </a>&nbsp;
              <button type="submit" class="btn btn-info" id="btn-submit-internal-request">
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

    $('#amount').autoNumeric('init',{
        aSep:',',
        aDec:'.'
    });

    //Block Project Selection
    $('#project_id').select2({
      placeholder: 'Select Project',
      ajax: {
        url: '{!! url('select2Project') !!}',
        dataType: 'json',
        delay: 250,
        processResults: function (data) {
          return {
            results:  $.map(data, function (item) {
                  return {
                      text: item.code,
                      id: item.id,
                      name : item.name
                  }
              })
          };
        },
        cache: true
      },
      templateResult : templateResultProject,
      allowClear:true
    });
    //ENDBlock Project Selection

    function templateResultProject(results){
      if(results.loading){
        return "Searching...";
      }
      var markup = '<span>';
          markup+=  results.text;
          markup+=  '<br/>'+results.name;
          markup+= '</span>';
      return $(markup);
    }

    $('#type').select2({
      placeholder : 'Tipe internal request',
      allowClear: true
    });
    
    //Block Vendor id Selection
    $('#vendor_id').select2({
      placeholder: 'Vendor',
      ajax: {
        url: '{!! url('select2Vendor') !!}',
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
    //ENDBlock Vendor id Selection

    //Block Remitter Bank Selection
    $('#remitter_bank_id').select2({
      placeholder: 'Bank Pengirim',
      ajax: {
        url: '{!! url('select2Cash') !!}',
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
    //ENDBlock Remitter Bank Selection

    //Block Beneficiary Bank Selection
    $('#beneficiary_bank_id').select2({
      placeholder: 'Bank Penerima',
      ajax: {
        url: '{!! url('select2BankAccount') !!}',
        dataType: 'json',
        delay: 250,
        data: function (params) {
           return {
                q: params.term,
                user_id: $('#requester_id').val(),
                page: params.page
           };
       },
        processResults: function (data) {
          return {
            results:  $.map(data, function (item) {
                return {
                    text: item.name,
                    id: item.id,
                    account_number : item.account_number
                }
              })
          };
        },
        cache: true
      },
      allowClear : true,
      templateResult : templateResultBankAccount,
    });

    function templateResultBankAccount(results){
      
      if(results.loading){
        return "Searching...";
      }
      var markup = '<span>';
          markup+=  results.text;
          markup+=  '<br/>'+results.account_number;
          markup+= '</span>';
      return $(markup);

    }
    //ENDBlock Beneficiary Bank Selection

    $('#form-create-internal-request').on('submit', function(){
      $('#btn-submit-internal-request').prop('disabled', true);
    });
  </script>
@endsection