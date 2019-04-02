@extends('layouts.app')


@section('page_title')
    Invoice Vendor
@endsection

@section('additional_styles')
  {!! Html::style('css/datepicker/datepicker3.css') !!}
@endsection

@section('page_header')
  <h1>
    Invoice Vendor
    <small>Edit Invoice Vendor</small>
  </h1>
@endsection



@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('invoice-vendor') }}"><i class="fa fa-credit-card"></i> Invoice Vendor</a></li>
    <li><i></i> {{ $invoice_vendor->code }}</li>
    <li class="active"><i></i> Edit</li>
  </ol>
@endsection
  
@section('content')
  <div class="row">
    <div class="col-md-9">
      <!--BOX Basic Informations-->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Form Edit Invoice Vendor</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          {!! Form::model($invoice_vendor, ['route'=>['invoice-vendor.update', $invoice_vendor->id], 'role'=>'form', 'class'=>'form-horizontal', 'id'=>'form-edit-invoice-vendor', 'method'=>'put', 'files'=>true]) !!}
          
          <div class="form-group{{ $errors->has('code') ? ' has-error' : '' }}">
            {!! Form::label('code', 'Invoice Number', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {!! Form::text('code',null,['class'=>'form-control', 'placeholder'=>'Invoice Number ', 'id'=>'code']) !!}
              @if ($errors->has('code'))
                <span class="help-block">
                  <strong>{{ $errors->first('code') }}</strong>
                </span>
              @endif
            </div>
          </div>

          <div class="form-group{{ $errors->has('tax_number') ? ' has-error' : '' }}">
            {!! Form::label('tax_number', 'Tax Number', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {!! Form::text('tax_number',null,['class'=>'form-control', 'placeholder'=>'Tax Number of the Invoice', 'id'=>'tax_number']) !!}
              @if ($errors->has('tax_number'))
                <span class="help-block">
                  <strong>{{ $errors->first('tax_number') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <div class="form-group{{ $errors->has('purchase_order_vendor_id') ? ' has-error' : '' }}">
            {!! Form::label('purchase_order_vendor_id', 'Puchase Order Vendor', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              <select name="purchase_order_vendor_id" id="purchase_order_vendor_id" class="form-control">
                <option value="{{ $invoice_vendor->purchase_order_vendor->id }}" selected> {{ $invoice_vendor->purchase_order_vendor->code }}</option>
                @if(Request::old('purchase_order_vendor_id') != NULL)
                  <option value="{{Request::old('purchase_order_vendor_id')}}">
                    {{ \App\PurchaseOrderVendor::find(Request::old('purchase_order_vendor_id'))->code }}
                  </option>
                @endif
              </select>
              @if ($errors->has('purchase_order_vendor_id'))
                <span class="help-block">
                  <strong>{{ $errors->first('purchase_order_vendor_id') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <div class="form-group{{ $errors->has('project_id') ? ' has-error' : '' }}">
            {!! Form::label('project_id', 'Project', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {!! Form::text('project_name',$invoice_vendor->project->name,['class'=>'form-control', 'placeholder'=>'Project Name', 'id'=>'project_name', 'readonly'=>true]) !!}
              {!! Form::hidden('project_id',null,['class'=>'form-control', 'placeholder'=>'Project ID', 'id'=>'project_id']) !!}
              @if ($errors->has('project_id'))
                <span class="help-block">
                  <strong>{{ $errors->first('project_id') }}</strong>
                </span>
              @endif
            </div>
          </div>
          
          <div class="form-group{{ $errors->has('sub_total') ? ' has-error' : '' }}">
            {!! Form::label('sub_total', 'Sub Total', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-3">
              {!! Form::text('sub_total',$invoice_vendor->purchase_order_vendor->sub_amount,['class'=>'form-control', 'placeholder'=>'', 'id'=>'sub_total', 'readonly'=>true]) !!}
              @if ($errors->has('sub_total'))
                <span class="help-block">
                  <strong>{{ $errors->first('sub_total') }}</strong>
                </span>
              @endif
            </div>
          </div>

          <div class="form-group{{ $errors->has('discount') ? ' has-error' : '' }}">
            {!! Form::label('discount', 'Discount', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-2">
              <div class="input-group">
                {!! Form::text('discount',$invoice_vendor->purchase_order_vendor->discount,['class'=>'form-control', 'placeholder'=>'', 'id'=>'discount', 'readonly'=>true]) !!}
                <span class="input-group-btn">
                  <button class="btn btn-default" type="button">%</button>
                </span>
                @if ($errors->has('discount'))
                  <span class="help-block">
                    <strong>{{ $errors->first('discount') }}</strong>
                  </span>
                @endif
              </div>
            </div>
          </div>

          <div class="form-group{{ $errors->has('after_discount') ? ' has-error' : '' }}">
            {!! Form::label('after_discount', 'After Discount', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-3">
              {!! Form::text('after_discount',$invoice_vendor->purchase_order_vendor->after_discount,['class'=>'form-control', 'placeholder'=>'', 'id'=>'after_discount', 'readonly'=>true]) !!}
              @if ($errors->has('after_discount'))
                <span class="help-block">
                  <strong>{{ $errors->first('after_discount') }}</strong>
                </span>
              @endif
            </div>
          </div>

          <div class="form-group{{ $errors->has('vat') ? ' has-error' : '' }}">
            {!! Form::label('vat', 'VAT', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-2">
              <div class="input-group">
                {!! Form::text('vat',$invoice_vendor->purchase_order_vendor->vat,['class'=>'form-control', 'placeholder'=>'', 'id'=>'vat', 'readonly'=>true]) !!}
                <span class="input-group-btn">
                  <button class="btn btn-default" type="button">%</button>
                </span>
                @if ($errors->has('vat'))
                  <span class="help-block">
                    <strong>{{ $errors->first('vat') }}</strong>
                  </span>
                @endif
              </div>
            </div>
          </div>

          <div class="form-group{{ $errors->has('vat_amount') ? ' has-error' : '' }}">
            {!! Form::label('vat_amount', 'VAT Amount', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-3">
              {!! Form::text('vat_amount',$invoice_vendor->purchase_order_vendor->vat / 100 * $invoice_vendor->purchase_order_vendor->sub_amount,['class'=>'form-control', 'placeholder'=>'', 'id'=>'vat_amount', 'readonly'=>true]) !!}
              @if ($errors->has('vat_amount'))
                <span class="help-block">
                  <strong>{{ $errors->first('vat_amount') }}</strong>
                </span>
              @endif
              
            </div>
          </div>

          <div class="form-group{{ $errors->has('wht_amount') ? ' has-error' : '' }}">
            {!! Form::label('wht_amount', 'WHT Amount', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-3">
              {!! Form::text('wht_amount',$invoice_vendor->purchase_order_vendor->wht,['class'=>'form-control', 'placeholder'=>'', 'id'=>'wht_amount', 'readonly'=>true]) !!}
              @if ($errors->has('wht_amount'))
                <span class="help-block">
                  <strong>{{ $errors->first('wht_amount') }}</strong>
                </span>
              @endif
              
            </div>
          </div>
          <div class="form-group{{ $errors->has('amount_before_type') ? ' has-error' : '' }}">
            {!! Form::label('amount_before_type', 'Pre Defined Amount', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-3">
              {!! Form::text('amount_before_type',$invoice_vendor->purchase_order_vendor->amount,['class'=>'form-control', 'placeholder'=>'', 'id'=>'amount_before_type', 'readonly'=>true]) !!}
              @if ($errors->has('amount_before_type'))
                <span class="help-block">
                  <strong>{{ $errors->first('amount_before_type') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
            {!! Form::label('type', 'Type', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-2">
              <div class="radio">
                <label>
                  {!! Form::radio('type','dp') !!}
                  DP
                </label>
              </div>
              <div class="radio">
                <label>
                  {!! Form::radio('type','term') !!}
                  Term
                </label>
              </div>
              <div class="radio">
                <label>
                  {!! Form::radio('type','pelunasan') !!}
                  Pelunasan
                </label>
              </div>
              <div class="radio">
                <label>
                  {!! Form::radio('type','billing') !!}
                  Bill
                </label>
              </div>
              @if ($errors->has('type'))
                <span class="help-block">
                  <strong>{{ $errors->first('type') }}</strong>
                </span>
              @endif
            </div>
            <div class="col-sm-4">
              <div class="input-group">
                {!! Form::text('type_percent',null,['class'=>'form-control', 'placeholder'=>'(%)', 'id'=>'type_percent']) !!}
                <span class="input-group-btn">
                  <button class="btn btn-default" type="button">%</button>
                </span>
                @if ($errors->has('type_percent'))
                  <span class="help-block">
                    <strong>{{ $errors->first('type_percent') }}</strong>
                  </span>
                @endif
              </div>
              <br/>
              <div class="input-group">
                {!! Form::text('amount_from_type',null,['class'=>'form-control', 'placeholder'=>'Amount from type', 'id'=>'amount_from_type', 'readonly'=>true]) !!}
                
                @if ($errors->has('amount_from_type'))
                  <span class="help-block">
                    <strong>{{ $errors->first('amount_from_type') }}</strong>
                  </span>
                @endif
              </div>
            </div>
          </div>
          <div class="form-group{{ $errors->has('bill_amount') ? ' has-error' : '' }}">
            {!! Form::label('bill_amount', 'Bill Amount', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-3">
              {!! Form::text('bill_amount',null,['class'=>'form-control', 'placeholder'=>'', 'id'=>'bill_amount']) !!}
              @if ($errors->has('bill_amount'))
                <span class="help-block">
                  <strong>{{ $errors->first('bill_amount') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
            {!! Form::label('amount', 'Amount', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-3">
              {!! Form::text('amount',null,['class'=>'form-control', 'placeholder'=>'', 'id'=>'amount', 'readonly'=>true]) !!}
              @if ($errors->has('amount'))
                <span class="help-block">
                  <strong>{{ $errors->first('amount') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <div class="form-group{{ $errors->has('received_date') ? ' has-error' : '' }}">
            {!! Form::label('received_date', 'Received Date', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-3">
              {!! Form::text('received_date',null,['class'=>'form-control', 'placeholder'=>'Received Date of the Invoice', 'id'=>'received_date']) !!}
              @if ($errors->has('received_date'))
                <span class="help-block">
                  <strong>{{ $errors->first('received_date') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <div class="form-group{{ $errors->has('due_date') ? ' has-error' : '' }}">
            {!! Form::label('due_date', 'Due Date', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-3">
              {!! Form::text('due_date',null,['class'=>'form-control', 'placeholder'=>'Due Date of the Invoice', 'id'=>'due_date']) !!}
              @if ($errors->has('due_date'))
                <span class="help-block">
                  <strong>{{ $errors->first('due_date') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <div class="form-group{{ $errors->has('tax_date') ? ' has-error' : '' }}">
            {!! Form::label('tax_date', 'Tax Date', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-3">
              {!! Form::text('tax_date',null,['class'=>'form-control', 'placeholder'=>'Tax Date of the Invoice', 'id'=>'tax_date']) !!}
              @if ($errors->has('tax_date'))
                <span class="help-block">
                  <strong>{{ $errors->first('tax_date') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <div class="form-group">
              {!! Form::label('', '', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              <a href="{{ url('invoice-vendor/'.$invoice_vendor->id.'') }}" class="btn btn-default">
                <i class="fa fa-repeat"></i>&nbsp;Cancel
              </a>&nbsp;
              <button type="submit" class="btn btn-info" id="btn-submit-invoice-vendor">
                <i class="fa fa-save"></i>&nbsp;Submit
              </button>
            </div>
          </div>
          {!! Form::close() !!}
          
        </div><!-- /.box-body -->
      </div>
      <!--ENDBOX Basic Informations-->
    </div>

    <div class="col-md-3">
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">
            <i class="fa fa-bookmark-o"></i>&nbsp;Purchase Order Vendor
          </h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          <strong>PO Number</strong>
          <p class="text-muted" id="po_vendor_code"></p>
          <strong>Amount</strong>
          <p class="text-muted" id="po_vendor_amount"></p>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('additional_scripts')
  {!! Html::script('js/datepicker/bootstrap-datepicker.js') !!}
  {!! Html::script('js/autoNumeric.js') !!}
  <script type="text/javascript">
    
    $('#sub_total, #amount_before_type, #amount_from_type, #bill_amount, #amount, #vat,#vat_amount, #wht_amount, #after_discount' ).autoNumeric('init',{
        aSep:',',
        aDec:'.'
    });

    $('#type_percent').autoNumeric('init', {
      vMin : 0,
      vMax : 100
    });


    //hide bill amount at first
    $('#bill_amount').hide();
    if($('input[name=type]:checked').val() == 'billing'){
      $('#bill_amount').show();
    }
    $('input[name=type]').on('click', function(){
      if($(this).val() == 'billing'){
        $('#bill_amount').show();
      }else{
        $('#bill_amount').autoNumeric('set',0).hide();
      }
    });

    $('#bill_amount').on('keyup', function(){
      $('#amount').val($(this).val());
    });

    //Block purchase order vendor selection
    $('#purchase_order_vendor_id').select2({
      placeholder: 'Purchae Order Vendor',
      ajax: {
        url: '{!! url('select2PurchaseOrderVendorForInvoiceVendor') !!}',
        dataType: 'json',
        delay: 250,
        processResults: function (data) {
          return {
            results:  $.map(data, function (item) {
                  return {
                      text: item.code,
                      id: item.id,
                      purchase_request: item.purchase_request ? item.purchase_request : null,
                      project : item.purchase_request ? item.purchase_request.project : null,
                  }
              })
          };
        },
        cache: true
      },
      allowClear : true,
      templateResult : templateResultPurchaseOrderVendor,
    }).on('select2:select', function(){
      //console.log($(this));
      var selected = $('#purchase_order_vendor_id').select2('data')[0];
      //console.log(selected.purchase_request.sub_amount);
      $('#project_name').val(selected.project.name);
      $('#project_id').val(selected.project.id);
      $('#sub_total').autoNumeric('set', selected.purchase_request.sub_amount);
      $('#discount').val(selected.purchase_request.discount);
      $('#after_discount').autoNumeric('set', selected.purchase_request.after_discount);
      $('#vat').autoNumeric('set', selected.purchase_request.vat);
      $('#wht_amount').autoNumeric('set', selected.purchase_request.wht);
      $('#amount_before_type').autoNumeric('set', selected.purchase_request.amount);
      $('#bill_amount').autoNumeric('set',0);
      $('#amount').autoNumeric('set', selected.purchase_request.amount);
      $('#po_vendor_code').text(selected.text);
      $('#po_vendor_amount').text(selected.purchase_request.amount);
      update_vat_amount_value();
    });

    function templateResultPurchaseOrderVendor(results){
      if(results.loading){
        return "Searching...";
      }
      var markup = '<span>';
          markup+=  results.text;
          markup+=  '<br/>';
          markup+=  results.project ? results.project.name : "";
          markup+= '</span>';
      return $(markup);
    }
    //ENDBlock purchase order vendor selection


    //Block get VAT value
    function get_vat_value()
    {
      var result = 0;
      if($('#vat').val() == ""){
        result = 0;
      }
      else{
        result = $('#vat').val().replace(/,/g, '');
      }
      return result;
    }
    //ENDBlock get VAT value

    //Block get after_discount_value
    function get_after_discount_value(){
      var result = 0;
      if($('#after_discount').val() == ""){
        result = 0;
      }
      else{
        result = $('#after_discount').val().replace(/,/g, '');
      }
      return result;
    }
    //ENDBlock get after_discount_value

    //Block function update vat_value input value
    function update_vat_amount_value(){
      //initiate vat_value_value
      var vat_value_value = 0;
      //get the value of #after_discount
      var after_discount = get_after_discount_value();
      //get the value of #vat
      var vat = get_vat_value();

      vat_value_value = vat/100*after_discount;

      $('#vat_amount').autoNumeric('set', vat_value_value);
    }
      
    $('#type_percent').on('keyup', function(){
      update_amount_from_type();
      update_amount();

    });


    function update_amount()
    {
      var amount_before_type = get_amount_before_type();
      var amount_from_type = get_amount_from_type();
      var amount = amount_before_type - amount_from_type;
      if(amount_from_type == 0){
        $('#amount').autoNumeric('set', amount);
      }else{
        $('#amount').autoNumeric('set', amount_from_type);
      }
      
    }

    function get_amount_from_type(){
      var result = 0;
      if($('#amount_from_type').val() == ""){
        result = 0;
      }
      else{
        result = $('#amount_from_type').val().replace(/,/g, '');
      }
      return result;
    }

    function get_amount_before_type(){
      var result = 0;
      if($('#amount_before_type').val() == ""){
        result = 0;
      }
      else{
        result = $('#amount_before_type').val().replace(/,/g, '');
      }
      return result;
    }

    function get_type_percent(){
      var result = 0;
      if($('#type_percent').val() == ""){
        result = 0;
      }
      else{
        result = $('#type_percent').val().replace(/,/g, '');
      }
      return result;
    }

    function update_amount_from_type(){
      var type_percent = get_type_percent();
      var amount_before_type = get_amount_before_type();
      var amount_from_type = (type_percent / 100)*amount_before_type;
      $('#amount_from_type').autoNumeric('set', amount_from_type);
    }

    //Block Due Date input
    $('#due_date').on('keydown', function(event){
      event.preventDefault();
    });
    $('#due_date').datepicker({
      format : 'yyyy-mm-dd'
    });
    //ENDBlock Due Date input

    //Block Received Date input
    $('#received_date').on('keydown', function(event){
      event.preventDefault();
    });
    $('#received_date').datepicker({
      format : 'yyyy-mm-dd'
    });
    //ENDBlock Received Date input

    //Block Tax Date input
    $('#tax_date').on('keydown', function(event){
      event.preventDefault();
    });
    $('#tax_date').datepicker({
      format : 'yyyy-mm-dd'
    });
    //ENDBlock Tax Date input

    $('#form-edit-invoice-vendor').on('submit', function(){
      $('#btn-submit-invoice-vendor').prop('disabled', true);
    });
  </script>
@endsection