@extends('layouts.app')

@section('page_title')
  Create Transaction
@endsection

@section('page_header')
  <h1>
    Transaction
    <small>Create Transaction</small>
  </h1>
@endsection

@section('additional_styles')

@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('transaction') }}"><i class="fa fa-money"></i> Transaction</a></li>
    <li><a href="{{ URL::to('cash/'.$cash->id) }}"><i class="fa fa-cube"></i> {{ $cash->name }}</a></li>
    <li class="active"><i></i> Create</li>
  </ol>
@endsection
  
@section('content')
  <div class="row">
    <div class="col-md-12">
      <!--BOX Basic Informations-->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Form Create Transaction on {{ $cash->name }}</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          {!! Form::open(['route'=>'transaction.store','role'=>'form','class'=>'form-horizontal','id'=>'form-create-transaction','files'=>true]) !!}
          
          <div class="form-group{{ $errors->has('cash_id') ? ' has-error' : '' }}">
            {!! Form::label('cash_id', 'Cash', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {!! Form::text('cash_name',$cash->name,['class'=>'form-control', 'placeholder'=>'cash_name of the transaction', 'id'=>'cash_name', 'readonly'=>true]) !!}
              {!! Form::text('cash_id',$cash->id,['class'=>'form-control', 'placeholder'=>'cash of the transaction', 'id'=>'cash']) !!}
              @if ($errors->has('cash_id'))
                <span class="help-block">
                  <strong>{{ $errors->first('cash_id') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <div class="form-group{{ $errors->has('refference') ? ' has-error' : '' }}">
            {!! Form::label('refference', 'Refference', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {{ Form::select('refference', $refference_opts, null, ['class'=>'form-control', 'placeholder'=>'Select an option', 'id'=>'refference']) }}
              @if ($errors->has('refference'))
                <span class="help-block">
                  <strong>{{ $errors->first('refference') }}</strong>
                </span>
              @endif
            </div>
          </div>

          <!-- Group Internal Request -->
          <div class="form-group{{ $errors->has('internal_request_id') ? ' has-error' : '' }} groupper internal_request">
            {!! Form::label('internal_request_id', 'Internal Request', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {{ Form::select('internal_request_id',$internal_request_opts, null, ['class'=>'form-control', 'id'=>'internal_request_id', 'placeholder'=>'Select Internal Request']) }}
              @if ($errors->has('internal_request_id'))
                <span class="help-block">
                  <strong>{{ $errors->first('internal_request_id') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <!-- ENDGroup Internal Request -->

          <!-- Group Settlement -->
          <div class="form-group{{ $errors->has('settlement_id') ? ' has-error' : '' }} groupper settlement">
            {!! Form::label('settlement_id', 'Settlement', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {{ Form::select('settlement_id',$settlement_opts, null, ['class'=>'form-control', 'id'=>'settlement_id', 'placeholder'=>'Select Settlement']) }}
              @if ($errors->has('settlement_id'))
                <span class="help-block">
                  <strong>{{ $errors->first('settlement_id') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <!-- ENDGroup Settlement -->

          <!-- Group Cashbond -->
          <div class="form-group{{ $errors->has('cashbond_id') ? ' has-error' : '' }} groupper cashbond">
            {!! Form::label('cashbond_id', 'Cash Bond', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {{ Form::select('cashbond_id',$cashbond_opts, null, ['class'=>'form-control', 'id'=>'cashbond_id', 'placeholder'=>'Select Cashbond']) }}
              @if ($errors->has('cashbond_id'))
                <span class="help-block">
                  <strong>{{ $errors->first('cashbond_id') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <!-- ENDGroup Cashbond -->

          <div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
            {!! Form::label('amount', 'Amount', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {!! Form::text('amount',null,['class'=>'form-control', 'placeholder'=>'Amount of the transaction', 'id'=>'amount']) !!}
              @if ($errors->has('amount'))
                <span class="help-block">
                  <strong>{{ $errors->first('amount') }}</strong>
                </span>
              @endif
            </div>
          </div>

          <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
            {!! Form::label('type', 'Type', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {{ Form::select('type', ['debet'=>'Debet', 'credit'=>'Credit'], null, ['class'=>'form-control', 'placeholder'=>'--Select type--', 'id'=>'type']) }}
              @if ($errors->has('type'))
                <span class="help-block">
                  <strong>{{ $errors->first('type') }}</strong>
                </span>
              @endif
            </div>
          </div>
          
          <div class="form-group">
              {!! Form::label('', '', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              <a href="{{ url('transaction') }}" class="btn btn-default">
                <i class="fa fa-repeat"></i>&nbsp;Cancel
              </a>&nbsp;
              <button type="submit" class="btn btn-info" id="btn-submit-transaction">
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



    $('.groupper.internal_request').prop('hidden', true);
    $('.groupper.settlement').prop('hidden', true);
    $('.groupper.cashbond').prop('hidden', true);

    
    $('#refference').select2({
      placeholder: 'Select an option',
      allowClear: true
    });

    $('#refference').on('select2:select', function(){
      var refference = $(this).val();
      if(refference == 'internal_request'){
        $('.groupper.internal_request').prop('hidden', false);
        $('.groupper:not(.internal_request)').prop('hidden', true);
      }
      else if(refference == 'settlement'){
        $('.groupper.settlement').prop('hidden', false);
        $('.groupper:not(.settlement)').prop('hidden', true);
        
      }
      else if(refference == 'cashbond'){
        $('.groupper.cashbond').prop('hidden', false);
        $('.groupper:not(.cashbond)').prop('hidden', true);
      }
      else{
        alert('You have selected '+$(this).val());
      }

    });

    //Block internal request select2 builder
    $('#internal_request_id').select2({
      placeholder: 'Select Internal Request',
      allowClear : true,
      ajax: {
        url: '/transaction/selectInternalRequest',
        dataType: 'json',
        delay: 250,
        data: function (params) {
          return {
            q: params.term, // search term
          };
        },
        processResults: function (data) {
          return {
            results: data
          };
        },
        cache: true,

      },
      templateResult: internalRequestTemplateResult,
      templateSelection : internalRequestTemplateSelect,
      dropdownAutoWidth : true,
      width: '100%'
    });

    function internalRequestTemplateResult(data){
      console.log(data);
      return $('<div class="ir_class" data-amount="'+data.amount+'"><strong>'+data.code+'</strong></div>');
    }

    function internalRequestTemplateSelect(data){
      return $('<div>'+data.amount+'</div>');
    }

    //ENDBlock internal request select2 builder

    //Block settlement select2 builder
    $('#settlement_id').select2({
          placeholder: 'Select Settlement',
          allowClear : true,
          ajax: {
            url: '/transaction/selectSettlement',
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
              return {
                results:  $.map(data, function (item) {
                      return {
                          text: item.code,
                          id: item.id
                      }
                  })
              };
            },
            cache: true
          },
          dropdownAutoWidth : true,
          width: '100%'
        });
    //ENDBlock settlement select2 builder

    //Block cashbond select2 builder
    $('#cashbond_id').select2({
          placeholder: 'Select Cashbond',
          allowClear : true,
          ajax: {
            url: '/transaction/selectCashbond',
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
              return {
                results:  $.map(data, function (item) {
                      return {
                          text: item.code,
                          id: item.id
                      }
                  })
              };
            },
            cache: true
          }
        });
    //ENDBlock cashbond select2 builder


    function group_displayer(){
      var refference_val = $('#refference').val();
      if(refference_val == 'internal_request'){
        $('.groupper.internal_request').prop('hidden', false);
      }
      if(refference_val == 'settlement'){
        $('.groupper.settlement').prop('hidden', false);
        
      }
      if(refference_val == 'cashbond'){
        $('.groupper.cashbond').prop('hidden', false);
      }

    }

    group_displayer();


    $('#form-create-transaction').on('submit', function(){
      $('#btn-submit-transaction').prop('disabled', true);
    });
  </script>
@endsection