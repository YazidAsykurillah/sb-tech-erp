@extends('layouts.app')

@section('page_title')
    Purchase Order Vendor
@endsection

@section('page_header')
  <h1>
    Purchase Order Vendor
    <small>Edit Purchase Order Vendor</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('purchase-order-vendor') }}"><i class="fa fa-bookmark-o"></i> PO Vendor</a></li>
    <li><i></i> {{ $purchase_order_vendor->code }}</li>
    <li class="active"><i></i> Edit</li>
  </ol>
@endsection

@section('content')
  <div class="row">
    <div class="col-md-12">
      <!--BOX Basic Informations-->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Form Edit Purchase Order Vendor</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          {!! Form::model($purchase_order_vendor, ['route'=>['purchase-order-vendor.update', $purchase_order_vendor->id], 'class'=>'form-horizontal','id'=>'form-edit-purchase-order-vendor', 'method'=>'put', 'files'=>true]) !!}
          
          <div class="form-group{{ $errors->has('code') ? ' has-error' : '' }}">
            {!! Form::label('code', 'PO Number', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {!!Form::text('code',null,['class'=>'form-control', 'placeholder'=>'Purchase order number', 'id'=>'code', 'disabled'=>true])!!}
              @if ($errors->has('code'))
                <span class="help-block">
                  <strong>{{ $errors->first('code') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <div class="form-group{{ $errors->has('vendor_id') ? ' has-error' : '' }}">
            {!! Form::label('vendor_id', 'Vendor', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {{ Form::select('vendor_id', $vendor_opts, null, ['class'=>'form-control', 'placeholder'=>'--Select Vendor--', 'id'=>'vendor_id']) }}
              @if ($errors->has('vendor_id'))
                <span class="help-block">
                  <strong>{{ $errors->first('vendor_id') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <div class="form-group{{ $errors->has('purchase_request_id') ? ' has-error' : '' }}">
            {!! Form::label('purchase_request_id', 'Purchase Request', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {{ Form::select('purchase_request_id', $purchase_request_opts, null, ['class'=>'form-control', 'placeholder'=>'--Select Purchase Request--', 'id'=>'purchase_request_id']) }}
              @if ($errors->has('purchase_request_id'))
                <span class="help-block">
                  <strong>{{ $errors->first('purchase_request_id') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <div class="form-group{{ $errors->has('quotation_vendor_id') ? ' has-error' : '' }}">
            {!! Form::label('quotation_vendor_id', 'Quotation Vendor', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {{ Form::select('quotation_vendor_id', $quotation_vendor_opts, null, ['class'=>'form-control', 'placeholder'=>'--Select Quotation Vendor--', 'id'=>'quotation_vendor_id']) }}
              @if ($errors->has('quotation_vendor_id'))
                <span class="help-block">
                  <strong>{{ $errors->first('quotation_vendor_id') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
            {!! Form::label('description', 'Description', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {!! Form::textarea('description',null,['class'=>'form-control', 'placeholder'=>'Description of the purchase order', 'id'=>'description']) !!}
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
              {!!Form::text('amount',null,['class'=>'form-control', 'placeholder'=>'Amount of the purchase order', 'id'=>'amount'])!!}
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
              <a href="{{ url('purchase-order-vendor/'.$purchase_order_vendor->id) }}" class="btn btn-default">
                <i class="fa fa-repeat"></i>&nbsp;Cancel
              </a>&nbsp;
              <button type="submit" class="btn btn-info" id="btn-submit-purchase-order-vendor">
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
  {!! Html::script('js/autoNumeric.js') !!}
  <script type="text/javascript">

    $('#amount').autoNumeric('init',{
        aSep:',',
        aDec:'.'
    });

    //Block Form submit handler
    $('#form-edit-purchase-order-vendor').on('submit', function(){
      $('#btn-submit-purchase-order-vendor').prop('disabled', true);
    });
    //ENDBlock Form submit handler

    //Block Vendor selection
    $('#vendor_id').select2({
      placeholder: 'Select Vendor',
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
    //ENDBlock Vendor selection
    
    //Block Purchase request selection
    $('#purchase_request_id').select2({
      placeholder: 'Select Purchase Request',
      ajax: {
        url: '{!! url('select2PurchaseRequestForPOVendor') !!}',
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
    //ENDBlock Purchase request selection

    //Block Quotation Vendor selection
    $('#quotation_vendor_id').select2({
      placeholder: 'Select Quotation Vendor',
      ajax: {
        url: '{!! url('select2QuotationVendorForPOvendor') !!}',
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
      allowClear:true
    });
    //ENDBlock Quotation Vendor selection

  </script>
@endsection