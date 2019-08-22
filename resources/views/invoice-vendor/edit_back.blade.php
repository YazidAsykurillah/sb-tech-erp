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
    <div class="col-md-12">
      <!--BOX Basic Informations-->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Form Edit Invoice Vendor</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          {!! Form::model($invoice_vendor, ['route'=>['invoice-vendor.update', $invoice_vendor->id], 'role'=>'form', 'class'=>'form-horizontal', 'id'=>'form-edit-invoice-vendor', 'method'=>'put', 'files'=>true]) !!}
          <div class="form-group{{ $errors->has('code') ? ' has-error' : '' }}">
            {!! Form::label('code', 'Invoice Number', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {!! Form::text('code',null,['class'=>'form-control', 'placeholder'=>'Tax Number of the Invoice', 'id'=>'code', 'disabled'=>true]) !!}
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
              {!! Form::text('sub_total',null,['class'=>'form-control', 'placeholder'=>'', 'id'=>'sub_total', 'readonly'=>true]) !!}
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
                {!! Form::text('discount',null,['class'=>'form-control', 'placeholder'=>'', 'id'=>'discount', 'readonly'=>true]) !!}
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
              {!! Form::text('after_discount',null,['class'=>'form-control', 'placeholder'=>'', 'id'=>'after_discount', 'readonly'=>true]) !!}
              @if ($errors->has('after_discount'))
                <span class="help-block">
                  <strong>{{ $errors->first('after_discount') }}</strong>
                </span>
              @endif
            </div>
          </div>

          <div class="form-group{{ $errors->has('vat') ? ' has-error' : '' }}">
            {!! Form::label('vat', 'Vat', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-2">
              <div class="input-group">
                {!! Form::text('vat',null,['class'=>'form-control', 'placeholder'=>'', 'id'=>'vat', 'readonly'=>true]) !!}
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
              {!! Form::text('vat_amount',null,['class'=>'form-control', 'placeholder'=>'', 'id'=>'vat_amount', 'readonly'=>true]) !!}
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
              {!! Form::text('wht_amount',null,['class'=>'form-control', 'placeholder'=>'', 'id'=>'wht_amount', 'readonly'=>true]) !!}
              @if ($errors->has('wht_amount'))
                <span class="help-block">
                  <strong>{{ $errors->first('wht_amount') }}</strong>
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
          <div class="form-group">
              {!! Form::label('', '', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              <a href="{{ url('invoice-vendor') }}" class="btn btn-default">
                <i class="fa fa-repeat"></i>&nbsp;Cancel
              </a>&nbsp;
              <button type="submit" class="btn btn-info" id="btn-update-invoice-vendor">
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
  {!! Html::script('js/datepicker/bootstrap-datepicker.js') !!}
  {!! Html::script('js/autoNumeric.js') !!}
  <script type="text/javascript">

    $('#sub_total, #amount,#vat,#vat_amount, #wht_amount, #after_discount' ).autoNumeric('init',{
        aSep:',',
        aDec:'.'
    });

    //Block purchase order vendor selection
    var $select = $('#purchase_order_vendor_id');

    var init_po_vendor_id = '{{ $invoice_vendor->purchase_order_vendor->id }}';
    $select.select2({
      placeholder: 'Purchase Order Vendor',
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
                      purchase_request: item.purchase_request ? item.purchase_request : '',
                      project : item.purchase_request ? item.purchase_request.project : '',
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
      $('#project_name').val(selected.project ? selected.project.name : '');
      $('#project_id').val(selected.project ? selected.project.id : '');
      $('#sub_total').autoNumeric('set', selected.purchase_request ? selected.purchase_request.sub_amount : 0);
      $('#discount').val(selected.purchase_request ? selected.purchase_request.discount : 0);
      $('#after_discount').autoNumeric('set', selected.purchase_request? selected.purchase_request.after_discount : 0);
      $('#vat').autoNumeric('set', selected.purchase_request ? selected.purchase_request.vat : 0);
      $('#wht_amount').autoNumeric('set', selected.purchase_request ? selected.purchase_request.wht : 0);
      $('#amount').autoNumeric('set', selected.purchase_request ? selected.purchase_request.amount : 0);
      update_vat_amount_value();
    });
    var s2 = $select.data('select2'); 
    s2.trigger('select', { 
      data: {"id":init_po_vendor_id, text:"{{$invoice_vendor->purchase_order_vendor->code }}", purchase_request : "{{ $invoice_vendor->purchase_order_vendor->purchase_request ? $invoice_vendor->purchase_order_vendor->purchase_request : [] }} "} 
    });
    /*$select.select2("trigger", "select", {
        data: {
          id: init_po_vendor_id,
          text : "{{ $invoice_vendor->purchase_order_vendor->code }}",
          purchase_request : "{{ $invoice_vendor->purchase_order_vendor->purchase_request ? $invoice_vendor->purchase_order_vendor->purchase_request : '' }}",
          project : "{{ $invoice_vendor->purchase_request ? $invoice_vendor->purchase_request.project : '' }}",
        }
    });*/
    
    /*var $option = $('<option value="{{ $invoice_vendor->purchase_order_vendor->id}}" data-purchase_request="{{ $invoice_vendor->purchase_order_vendor->purchase_request ? $invoice_vendor->purchase_order_vendor->purchase_request : '' }}">{{ $invoice_vendor->purchase_order_vendor->code }}</option>');

    $select.append($option).trigger('change'); // append the option and update Select2*/


    function templateResultPurchaseOrderVendor(results){
      if(results.loading){
        return "Searching...";
      }
      var markup = '<span>';
          markup+=  results.text;
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

    $('#form-edit-invoice-vendor').on('submit', function(){
      $('#btn-update-invoice-vendor').prop('disabled', true);
    });
  </script>
@endsection