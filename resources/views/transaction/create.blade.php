@extends('layouts.app')

@section('page_title')
  Create Transaction
@endsection

@section('additional_styles')
  {!! Html::style('css/datepicker/datepicker3.css') !!}
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
              {!! Form::hidden('cash_id',$cash->id,['class'=>'form-control', 'placeholder'=>'cash of the transaction', 'id'=>'cash']) !!}
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

          <div class="form-group{{ $errors->has('notes') ? ' has-error' : '' }}">
            {!! Form::label('notes', 'Notes', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {!! Form::textarea('notes',null,['class'=>'form-control', 'placeholder'=>'notes of the transaction', 'id'=>'notes']) !!}
              @if ($errors->has('notes'))
                <span class="help-block">
                  <strong>{{ $errors->first('notes') }}</strong>
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

          <!-- Group Invoice Customer -->
          <div class="form-group{{ $errors->has('invoice_customer_id') ? ' has-error' : '' }} groupper invoice_customer">
            {!! Form::label('invoice_customer_id', 'Invoice Customer', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {{ Form::select('invoice_customer_id',$invoice_customer_opts, null, ['class'=>'form-control', 'id'=>'invoice_customer_id', 'placeholder'=>'Select Invoice Customer']) }}
              @if ($errors->has('invoice_customer_id'))
                <span class="help-block">
                  <strong>{{ $errors->first('invoice_customer_id') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <!-- ENDGroup Invoice Customer -->

          <!-- Group Invoice Vendor -->
          <div class="form-group{{ $errors->has('invoice_vendor_id') ? ' has-error' : '' }} groupper invoice_vendor">
            {!! Form::label('invoice_vendor_id', 'Invoice Vendor', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {{ Form::select('invoice_vendor_id',$invoice_vendor_opts, null, ['class'=>'form-control', 'id'=>'invoice_vendor_id', 'placeholder'=>'Select Invoice Vendor']) }}
              @if ($errors->has('invoice_vendor_id'))
                <span class="help-block">
                  <strong>{{ $errors->first('invoice_vendor_id') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <!-- ENDGroup Invoice Vendor -->

          <!-- Group Bank Administration -->
          <div class="form-group{{ $errors->has('bank_administration_id') ? ' has-error' : '' }} groupper bank_administration">
            {!! Form::label('bank_administration_id', 'Bank Administration', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {{ Form::select('bank_administration_id',$bank_administration_opts, null, ['class'=>'form-control', 'id'=>'bank_administration_id', 'placeholder'=>'Select Bank Administration']) }}
              @if ($errors->has('bank_administration_id'))
                <span class="help-block">
                  <strong>{{ $errors->first('bank_administration_id') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <!-- ENDGroup Bank Administration -->


          <div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
            {!! Form::label('amount', 'Amount', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {!! Form::text('amount',null,['class'=>'form-control', 'placeholder'=>'Amount of the transaction', 'id'=>'amount', 'readonly'=>true]) !!}
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
          <div class="form-group{{ $errors->has('accounting_expense_id') ? ' has-error' : '' }}">
            {!! Form::label('accounting_expense_id', 'Accounting Expense', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {{ Form::select('accounting_expense_id', $accountingExpenseOpts, null, ['class'=>'form-control', 'placeholder'=>'--Select accounting_expense_id--', 'id'=>'accounting_expense_id']) }}
              @if ($errors->has('accounting_expense_id'))
                <span class="help-block">
                  <strong>{{ $errors->first('accounting_expense_id') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <div class="form-group{{ $errors->has('transaction_date') ? ' has-error' : '' }}">
            {!! Form::label('transaction_date', 'Transaction Date', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {!!Form::text('transaction_date',null,['class'=>'form-control', 'placeholder'=>'Transaction Date', 'id'=>'transaction_date'])!!}
              @if ($errors->has('transaction_date'))
                <span class="help-block">
                  <strong>{{ $errors->first('transaction_date') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <div class="form-group">
              {!! Form::label('', '', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              <a href="{{ url('cash/'.$cash->id) }}" class="btn btn-default">
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
  {!! Html::script('js/datepicker/bootstrap-datepicker.js') !!}
  <script type="text/javascript">

    var current_cash_id = '{!! $cash->id !!}';
    var init_refference_value = $('#refference').val();
    if(init_refference_value != 'manual'){
      //make amount input is NOT editable
      $('#amount').prop('readonly', true);
      //make notes is hidden
      //$('#notes').hide();
    }else{
      $('#amount').prop('readonly', false);
      //make notes is shown
      //$('#notes').show();
    }

    $('#amount').autoNumeric('init',{
        aSep:',',
        aDec:'.'
    });
    $('#type').select2();

    $('.groupper').prop('hidden',true);
    /*$('.groupper.internal_request').prop('hidden', true);
    $('.groupper.settlement').prop('hidden', true);
    $('.groupper.cashbond').prop('hidden', true);
    $('.groupper.invoice_customer').prop('hidden', true);
    $('.groupper.invoice_vendor').prop('hidden', true);
    $('.groupper.invoice_vendor').prop('hidden', true);*/

    
    $('#refference').select2({
      placeholder: 'Select an option',
      allowClear: true
    });

    $('#refference').on('select2:select', function(){
      var refference = $(this).val();

      if(refference == 'internal_request'){
        $('.groupper.internal_request').prop('hidden', false);
        $('.groupper:not(.internal_request)').prop('hidden', true);
        $('#internal_request_id').val('').trigger('change');
        $('#settlement_id').val('').trigger('change');
        $('#invoice_customer_id').val('').trigger('change');
        $('#invoice_vendor_id').val('').trigger('change');
        $('#cashbond_id').val('').trigger('change');
        $('#bank_administration_id').val('').trigger('change');
        $('#amount').val('');
        $('#amount').prop('readonly', true);
        $('#type').val('').trigger('change');
      }
      else if(refference == 'settlement'){
        $('.groupper.settlement').prop('hidden', false);
        $('.groupper:not(.settlement)').prop('hidden', true);
        $('#internal_request_id').val('').trigger('change');
        $('#settlement_id').val('').trigger('change');
        $('#invoice_customer_id').val('').trigger('change');
        $('#invoice_vendor_id').val('').trigger('change');
        $('#cashbond_id').val('').trigger('change');
        $('#bank_administration_id').val('').trigger('change');
        $('#amount').val('');
        $('#amount').prop('readonly', true);
        $('#type').val('').trigger('change');
        
      }
      else if(refference == 'cashbond'){
        $('.groupper.cashbond').prop('hidden', false);
        $('.groupper:not(.cashbond)').prop('hidden', true);
        $('#settlement_id').val('').trigger('change');
        $('#internal_request_id').val('').trigger('change');
        $('#invoice_customer_id').val('').trigger('change');
        $('#invoice_vendor_id').val('').trigger('change');
        $('#cashbond_id').val('').trigger('change');
        $('#bank_administration_id').val('').trigger('change');
        $('#amount').val('');
        $('#amount').prop('readonly', true);
        $('#type').val('').trigger('change');
      }
      else if(refference == 'invoice_customer'){
        $('.groupper.invoice_customer').prop('hidden', false);
        $('.groupper:not(.invoice_customer)').prop('hidden', true);
        $('#settlement_id').val('').trigger('change');
        $('#internal_request_id').val('').trigger('change');
        $('#invoice_customer_id').val('').trigger('change');
        $('#invoice_vendor_id').val('').trigger('change');
        $('#cashbond_id').val('').trigger('change');
        $('#bank_administration_id').val('').trigger('change');
        $('#amount').val('');
        $('#amount').prop('readonly', true);
        $('#type').val('').trigger('change');
      }
      else if(refference == 'invoice_vendor'){
        $('.groupper.invoice_vendor').prop('hidden', false);
        $('.groupper:not(.invoice_vendor)').prop('hidden', true);
        $('#settlement_id').val('').trigger('change');
        $('#internal_request_id').val('').trigger('change');
        $('#invoice_customer_id').val('').trigger('change');
        $('#invoice_vendor_id').val('').trigger('change');
        $('#cashbond_id').val('').trigger('change');
        $('#bank_administration_id').val('').trigger('change');
        $('#amount').val('');
        $('#amount').prop('readonly', true);
        $('#type').val('').trigger('change');
      }
      else if(refference == 'bank_administration'){
        $('.groupper.bank_administration').prop('hidden', false);
        $('.groupper:not(.bank_administration)').prop('hidden', true);
        $('#settlement_id').val('').trigger('change');
        $('#internal_request_id').val('').trigger('change');
        $('#invoice_customer_id').val('').trigger('change');
        $('#invoice_vendor_id').val('').trigger('change');
        $('#cashbond_id').val('').trigger('change');
        $('#bank_administration_id').val('').trigger('change');
        $('#amount').val('');
        $('#amount').prop('readonly', true);
        $('#type').val('').trigger('change');
      }
      else if(refference == 'manual'){
        $('.groupper.manual').prop('hidden', false);
        $('.groupper:not(.manual)').prop('hidden', true);
        $('#settlement_id').val('').trigger('change');
        $('#internal_request_id').val('').trigger('change');
        $('#invoice_customer_id').val('').trigger('change');
        $('#invoice_vendor_id').val('').trigger('change');
        $('#cashbond_id').val('').trigger('change');
        $('#manual_id').val('').trigger('change');
        $('#amount').val('');
        $('#amount').prop('readonly', false);
        $('#type').val('').trigger('change');
      }
      else if(refference == 'site_internal_request'){
        $('.groupper.site_internal_request').prop('hidden', false);
        $('.groupper:not(.site_internal_request)').prop('hidden', true);
        $('#settlement_id').val('').trigger('change');
        $('#internal_request_id').val('').trigger('change');
        $('#invoice_customer_id').val('').trigger('change');
        $('#invoice_vendor_id').val('').trigger('change');
        $('#cashbond_id').val('').trigger('change');
        $('#site_internal_request_id').val('').trigger('change');
        $('#amount').val('');
        $('#amount').prop('readonly', false);
        $('#type').val('debet').trigger('change');
      }
      else{
        alert('You have selected '+$(this).val());
      }
      $('#amount').val('');

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
                q: params.term,
                remitter_bank_id: current_cash_id,
                page: params.page
           };
       },
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

    $('#internal_request_id').on('select2:select', function(){
      var internal_request_id = $(this).val();
      var token = $('meta[name="csrf-token"]').attr('content');
      $.ajax({
        url : '/transaction/getInternalRequestData',
        type : 'POST',
        data : 'internal_request_id='+internal_request_id+'&_token='+token,
        beforeSend : function(){},
        success:function(response){
          obj = $.parseJSON(response);
          $('#amount').val(obj.amount);
          //internal request always resulting transaction "DEBET"
          $('#type').val('debet').trigger('change');
        }
      });
      
    });
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

    $('#settlement_id').on('select2:select', function(){
      var settlement_id = $(this).val();
      var token = $('meta[name="csrf-token"]').attr('content');
      $.ajax({
        url : '/transaction/getSettlementData',
        type : 'POST',
        data : 'settlement_id='+settlement_id+'&_token='+token,
        beforeSend : function(){},
        success:function(response){
          obj = $.parseJSON(response);
          //fill the amount using the difference / balance from it's internal request amount
          $('#amount').val(obj.difference);
          if(obj.transaction_type == 'debet'){
            $('#type').val('debet').trigger('change');
          }
          else{
            $('#type').val('credit').trigger('change');
          }
        }
      });
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
      },
      dropdownAutoWidth : true,
      width: '100%'
    });

    $('#cashbond_id').on('select2:select', function(){
      var cashbond_id = $(this).val();
      var token = $('meta[name="csrf-token"]').attr('content');
      $.ajax({
        url : '/transaction/getCashbondData',
        type : 'POST',
        data : 'cashbond_id='+cashbond_id+'&_token='+token,
        beforeSend : function(){},
        success:function(response){
          obj = $.parseJSON(response);
          $('#amount').val(obj.amount);
          //Transaction type from cashbond is always DEBET
          $('#type').val('debet').trigger('change');

        }
      });
    });
    //ENDBlock cashbond select2 builder

    //Block Invoice Customer select2 builder
    $('#invoice_customer_id').select2({
      placeholder: 'Select Invoice Customer',
      allowClear : true,
      ajax: {
        url: '/transaction/selectInvoiceCustomer',
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

    $('#invoice_customer_id').on('select2:select', function(){
      var invoice_customer_id = $(this).val();
      var token = $('meta[name="csrf-token"]').attr('content');
      $.ajax({
        url : '/transaction/getInvoiceCustomerData',
        type : 'POST',
        data : 'invoice_customer_id='+invoice_customer_id+'&_token='+token,
        beforeSend : function(){},
        success:function(response){
          obj = $.parseJSON(response);
          $('#amount').val(obj.amount);
          //Transaction type from invoice customer is always DEBET
          $('#type').val('credit').trigger('change');

        }
      });
    });
    //ENDBlock Invoice Customer select2 builder

    //Block Invoice Vendor select2 builder
    $('#invoice_vendor_id').select2({
      placeholder: 'Select Invoice Vendor',
      allowClear : true,
      ajax: {
        url: '/transaction/selectInvoiceVendor',
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

    $('#invoice_vendor_id').on('select2:select', function(){
      var invoice_vendor_id = $(this).val();
      var token = $('meta[name="csrf-token"]').attr('content');
      $.ajax({
        url : '/transaction/getInvoiceVendorData',
        type : 'POST',
        data : 'invoice_vendor_id='+invoice_vendor_id+'&_token='+token,
        beforeSend : function(){},
        success:function(response){
          obj = $.parseJSON(response);
          $('#amount').val(obj.amount);
          //Transaction type from invoice vendor is always DEBET
          $('#type').val('debet').trigger('change');

        }
      });
    });
    //ENDBlock Invoice Vendor select2 builder


    //Block Bank Administration select2 builder
    $('#bank_administration_id').select2({
      placeholder: 'Select Bank Administration',
      allowClear : true,
      ajax: {
        url: '/transaction/selectBankAdministration',
        data: function (params) {
           return {
                q: params.term,
                cash_id: current_cash_id,
                page: params.page
           };
       },
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

    $('#bank_administration_id').on('select2:select', function(){
      var bank_administration_id = $(this).val();
      var token = $('meta[name="csrf-token"]').attr('content');
      $.ajax({
        url : '/transaction/getBankAdministrationData',
        type : 'POST',
        data : 'bank_administration_id='+bank_administration_id+'&_token='+token,
        beforeSend : function(){},
        success:function(response){
          obj = $.parseJSON(response);
          $('#amount').val(obj.amount);
          //Transaction type from bank administration is has to be manualy selected
          $('#type').val('').trigger('change');
        }
      });
    });
    //ENDBlock Bank Administration select2 builder


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
      if(refference_val == 'invoice_customer'){
        $('.groupper.invoice_customer').prop('hidden', false);
      }
      if(refference_val == 'invoice_vendor'){
        $('.groupper.invoice_vendor').prop('hidden', false);
      }
      if(refference_val == 'bank_administration'){
        $('.groupper.bank_administration').prop('hidden', false);
      }
    }

    group_displayer();


    //Block Transaction Date
    $('#transaction_date').on('keydown', function(event){
      event.preventDefault();
    });
    $('#transaction_date').datepicker({
      format : 'yyyy-mm-dd'
    });
    //ENDBlock Transaction Date

    $('#form-create-transaction').on('submit', function(){
      $('#btn-submit-transaction').prop('disabled', true);
    });
  </script>
@endsection