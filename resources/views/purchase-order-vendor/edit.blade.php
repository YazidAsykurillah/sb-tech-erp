@extends('layouts.app')

@section('page_title')
    Purchase Order Vendor
@endsection

@section('additional_styles')
  {!! Html::style('css/datepicker/datepicker3.css') !!}
@endsection

@section('page_header')
  <h1>
    Purchase Order Vendor
    <small>Create Purchase Order Vendor</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('purchase-order-vendor') }}"><i class="fa fa-bookmark-o"></i> PO Vendor</a></li>
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
            {!! Form::label('code', 'PO Code', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-4">
              {!! Form::text('code',null,['class'=>'form-control', 'placeholder'=>'Code of the PO Vendor', 'id'=>'code']) !!}
              @if ($errors->has('code'))
                <span class="help-block">
                  <strong>{{ $errors->first('code') }}</strong>
                </span>
              @endif
            </div>
          </div>

          <div class="form-group{{ $errors->has('date') ? ' has-error' : '' }}">
            {!! Form::label('date', 'Tanggal', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-4">
              {!! Form::text('date',null,['class'=>'form-control', 'id'=>'date', 'placeholder'=>'Date of PO Vendor']) !!}
              @if ($errors->has('date'))
                <span class="help-block">
                  <strong>{{ $errors->first('date') }}</strong>
                </span>
              @endif
            </div>
          </div>
          
          <div class="form-group{{ $errors->has('purchase_request_id') ? ' has-error' : '' }}">
            {!! Form::label('purchase_request_id', 'Purchase Request', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              <select name="purchase_request_id" id="purchase_request_id" class="form-control" style="width:100%;">
                @if($purchase_order_vendor->purchase_request)
                <option value="{{ $purchase_order_vendor->purchase_request->id }}">{{ $purchase_order_vendor->purchase_request->code }}</option>
                @endif
                @if(Request::old('purchase_request_id') != NULL)
                  <option value="{{Request::old('purchase_request_id')}}">
                    {{ \App\PurchaseRequest::find(Request::old('purchase_request_id'))->code }}
                  </option>
                @endif
              </select>
              @if ($errors->has('purchase_request_id'))
                <span class="help-block">
                  <strong>{{ $errors->first('purchase_request_id') }}</strong>
                </span>
              @endif
            </div>
          </div>
          
          <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
            {!! Form::label('description', 'Description', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {!! Form::textarea('description', null,['class'=>'form-control', 'placeholder'=>'Description of the purchase order', 'id'=>'description']) !!}
              @if ($errors->has('description'))
                <span class="help-block">
                  <strong>{{ $errors->first('description') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <div class="form-group{{ $errors->has('sub_amount') ? ' has-error' : '' }}">
            {!! Form::label('sub_amount', 'Sub Amount', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-4">
              {!!Form::text('sub_amount',$purchase_order_vendor->purchase_request->sub_amount,['class'=>'form-control', 'placeholder'=>'sub_amount of the Purchase Order Vendor', 'id'=>'sub_amount', 'readonly'=>true])!!}
              @if ($errors->has('sub_amount'))
                <span class="help-block">
                  <strong>{{ $errors->first('sub_amount') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <div class="form-group{{ $errors->has('discount') ? ' has-error' : '' }}">
            {!! Form::label('discount', 'Discount', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-4">
              <div class="input-group">
                {!! Form::text('discount',$purchase_order_vendor->purchase_request->discount,['class'=>'form-control', 'placeholder'=>'discount of the PO Vendor', 'id'=>'discount']) !!}
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
            <div class="col-sm-4">
              {!! Form::text('after_discount', $purchase_order_vendor->purchase_request->after_discount,['class'=>'form-control', 'placeholder'=>'after_discount of the PO Vendor', 'id'=>'after_discount', 'readonly'=>true]) !!}
              @if ($errors->has('after_discount'))
                <span class="help-block">
                  <strong>{{ $errors->first('after_discount') }}</strong>
                </span>
              @endif
            </div>
          </div>

          <div class="form-group{{ $errors->has('vat') ? ' has-error' : '' }}">
            {!! Form::label('vat', 'VAT', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-4">
              <div class="input-group">
                {!! Form::text('vat',$purchase_order_vendor->purchase_request->vat,['class'=>'form-control', 'placeholder'=>'VAT of the PO Vendor', 'id'=>'vat']) !!}
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
          <div class="form-group{{ $errors->has('wht') ? ' has-error' : '' }}">
            {!! Form::label('wht', 'WHT', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-4">
              {!! Form::text('wht',$purchase_order_vendor->purchase_request->wht,['class'=>'form-control', 'placeholder'=>'WHT of the Purchase Order Vendor', 'id'=>'wht']) !!}
              @if ($errors->has('wht'))
                <span class="help-block">
                  <strong>{{ $errors->first('wht') }}</strong>
                </span>
              @endif
            </div>
          </div>
          
          <div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
            {!! Form::label('amount', 'Amount', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-4">
              {!!Form::text('amount',$purchase_order_vendor->purchase_request->amount,['class'=>'form-control', 'placeholder'=>'Amount of the Purchase Order Vendor', 'id'=>'amount', 'readonly'=>true])!!}
              @if ($errors->has('amount'))
                <span class="help-block">
                  <strong>{{ $errors->first('amount') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <div class="form-group{{ $errors->has('terms') ? ' has-error' : '' }}">
            {!! Form::label('terms', 'Terms and Condition', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-4">
              {!! Form::textarea('terms',$purchase_order_vendor->purchase_request->terms,['class'=>'form-control', 'placeholder'=>'Terms and Conditions of the Purchase Order Vendor', 'id'=>'terms']) !!}
              @if ($errors->has('terms'))
                <span class="help-block">
                  <strong>{{ $errors->first('terms') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <div class="form-group">
              {!! Form::label('', '', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              <a href="{{ url('purchase-order-vendor/'.$purchase_order_vendor->id.'') }}" class="btn btn-default">
                <i class="fa fa-repeat"></i>&nbsp;Cancel
              </a>&nbsp;
              <button type="submit" class="btn btn-info" id="btn-update-purchase-order-vendor">
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
  {!! Html::script('js/autoNumeric.js') !!}
  <script type="text/javascript">

    //Block initialize autonumerical inputs
    $('#amount, .quantity, #vat, #wht, .price, #sub_amount, #total_sub_amount, #discount, #discount_value, #after_discount' ).autoNumeric('init',{
        aSep:',',
        aDec:'.'
    });

    //Block DATE
    $('#date').on('keydown', function(event){
      event.preventDefault();
    });
    $('#date').datepicker({
      format : 'yyyy-mm-dd'
    });
    //ENDBlock DATE
    
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
                      id: item.id,
                      description : item.description,
                      sub_amount : item.sub_amount,
                      discount : item.discount,
                      after_discount : item.after_discount,
                      vat : item.vat,
                      wht : item.wht,
                      amount : item.amount,
                      terms : item.terms,
                  }
              })
          };
        },
        cache: true
      },
      allowClear:true,
      templateResult : templateResultPurchaseRequest
    }).on('select2:select', function(){
      var selected = $('#purchase_request_id').select2('data')[0];
      $('#description').val(selected.description);
      $('#sub_amount').autoNumeric('set', selected.sub_amount);
      $('#discount').val(selected.discount);
      $('#after_discount').autoNumeric('set', selected.after_discount);
      $('#vat').autoNumeric('set', selected.vat);
      $('#wht').autoNumeric('set', selected.wht);
      $('#amount').autoNumeric('set', selected.amount);
      $('#terms').val(selected.terms);
    });

    function templateResultPurchaseRequest(results){

      if(results.loading){
        return "Searching...";
      }
      var markup = '<span>';
          markup+=  results.text;
          markup+= '</span>';
      return $(markup);
    }
    //ENDBlock Purchase request selection


    //Block Form submit handler
    $('#form-edit-purchase-order-vendor').on('submit', function(){
      $('#btn-update-purchase-order-vendor').prop('disabled', true);
    });
    //ENDBlock Form submit handler
    
  </script>
@endsection