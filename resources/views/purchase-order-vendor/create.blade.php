@extends('layouts.app')

@section('page_title')
    Purchase Order Vendor
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
    <li class="active"><i></i> Create</li>
  </ol>
@endsection

@section('content')
  <div class="row">
    <div class="col-md-12">
      <!--BOX Basic Informations-->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Form Create Purchase Order Vendor</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          {!! Form::open(['route'=>'purchase-order-vendor.store','role'=>'form','class'=>'form-horizontal','id'=>'form-create-purchase-order-vendor','files'=>true]) !!}
          <div class="form-group{{ $errors->has('purchase_request_id') ? ' has-error' : '' }}">
            {!! Form::label('purchase_request_id', 'Purchase Request', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              <select name="purchase_request_id" id="purchase_request_id" class="form-control" style="width:100%;">
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
              {!! Form::textarea('description',null,['class'=>'form-control', 'placeholder'=>'Description of the purchase order', 'id'=>'description']) !!}
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
              {!!Form::text('sub_amount',null,['class'=>'form-control', 'placeholder'=>'sub_amount of the Purchase Order Vendor', 'id'=>'sub_amount', 'readonly'=>true])!!}
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
                {!! Form::text('discount',0,['class'=>'form-control', 'placeholder'=>'discount of the PO Vendor', 'id'=>'discount']) !!}
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
          <div class="form-group{{ $errors->has('discount_value') ? ' has-error' : '' }}">
            {!! Form::label('discount_value', 'Discount Value', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-4">
              {!! Form::text('discount_value',0,['class'=>'form-control', 'placeholder'=>'discount_value of the PO Vendor', 'id'=>'discount_value', 'readonly'=>true]) !!}
              @if ($errors->has('discount_value'))
                <span class="help-block">
                  <strong>{{ $errors->first('discount_value') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <div class="form-group{{ $errors->has('after_discount') ? ' has-error' : '' }}">
            {!! Form::label('after_discount', 'After Discount', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-4">
              {!! Form::text('after_discount',0,['class'=>'form-control', 'placeholder'=>'after_discount of the PO Vendor', 'id'=>'after_discount', 'readonly'=>true]) !!}
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
                {!! Form::text('vat',0,['class'=>'form-control', 'placeholder'=>'VAT of the PO Vendor', 'id'=>'vat']) !!}
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
              {!! Form::text('wht',null,['class'=>'form-control', 'placeholder'=>'WHT of the Purchase Order Vendor', 'id'=>'wht']) !!}
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
              {!!Form::text('amount',null,['class'=>'form-control', 'placeholder'=>'Amount of the Purchase Order Vendor', 'id'=>'amount', 'readonly'=>true])!!}
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
              {!! Form::textarea('terms',null,['class'=>'form-control', 'placeholder'=>'Terms and Conditions of the Purchase Order Vendor', 'id'=>'terms']) !!}
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
              <a href="{{ url('purchase-order-vendor') }}" class="btn btn-default">
                <i class="fa fa-repeat"></i>&nbsp;Cancel
              </a>&nbsp;
              <button type="submit" class="btn btn-info" id="btn-submit-purchase-order-vendor">
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

    //Block initialize autonumerical inputs
    $('#amount, .quantity, #vat, #wht, .price, #sub_amount, #total_sub_amount, #discount, #discount_value, #after_discount' ).autoNumeric('init',{
        aSep:',',
        aDec:'.'
    });

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
          markup+=  results.text+'<br/>';
          markup+= '</span>';
      return $(markup);
    }
    //ENDBlock Purchase request selection



    //Block function update amount input value
    function update_amount_value(){
      /*var vat_value = parseFloat(get_vat_value());
      var total_sub_amount_value = parseFloat(get_total_sub_amount_value());
      var real_vat_value = vat_value / parseFloat(100) * total_sub_amount_value;
      var wht_value = parseFloat(get_wht_value());
      total_amount = real_vat_value+total_sub_amount_value+wht_value;
      
      $('#amount').autoNumeric('set', total_amount);*/

      var vat_value = parseFloat(get_vat_value());
      var after_discount_value = parseFloat(get_after_discount_value());
      var real_vat_value = vat_value / parseFloat(100) * after_discount_value;
      var wht_value = parseFloat(get_wht_value());
      total_amount = real_vat_value+after_discount_value+wht_value;
      console.log(real_vat_value);
      $('#amount').autoNumeric('set', total_amount);

    }
    //ENDBlock function update amount input value
    
    //Block register onkeyup event handler to vat and wht input
    $('#vat, #wht').on('keyup', function(){
      update_amount_value();
    });
    //ENDBlock register onkeyup event handler to vat and wht input

    //Block register onkeyup event handler to discount input
    $('#discount').on('keyup', function(){
      update_discount_value_value();
      update_amount_value();
    });
    //ENDBlock register onkeyup event handler to discount input

    //Block update input DISCOUNT VALUE
    function update_discount_value_value(){
      //get the value of #discount field
      var discount = parseFloat(get_discount_value());
      //get the value of #total_sub_amount_value;
      var total_sub_amount_value = parseFloat(get_total_sub_amount_value());
      //set the value of #discount_value
      var discount_value = discount/parseFloat(100)*total_sub_amount_value;
      $('#discount_value').autoNumeric('set', discount_value);
      update_after_discount_value();
    }
    //ENDBlock update input DISCOUNT VALUE

    //Block update input AFTER DISCOUNT value
    function update_after_discount_value(){
      //get the value of #discount_value
      var discount_value = parseFloat(get_discount_value_value());
      //get the_value of #total_sub_amount
      var total_sub_amount_value = parseFloat(get_total_sub_amount_value());
      var after_discount_value = total_sub_amount_value-discount_value;
      $('#after_discount').autoNumeric('set', after_discount_value);
    }
    //ENDBlock update input AFTER DISCOUNT value



    //Block get total_sub_amount_value
    function get_total_sub_amount_value(){
      var result = 0;
      if($('#sub_amount').val() == ""){
        result = 0;
      }
      else{
        result = $('#sub_amount').val().replace(/,/g, '');
      }
      return result;
    }
    //ENDBlock get total_sub_amount_value

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

    //Block get WHT value
    function get_wht_value()
    {
      var result = 0;
      if($('#wht').val() == ""){
        result = 0;
      }
      else{
        result = $('#wht').val().replace(/,/g, '');
      }
      return result;
    }
    //ENDBlock get WHT value

    //Block get DISCOUNT value
    function get_discount_value()
    {
      var result = 0;
      if($('#discount').val() == ""){
        result = 0;
      }
      else{
        result = $('#discount').val().replace(/,/g, '');
      }
      return result;
    }
    //ENDBlock get DISCOUNT value

    //Block get DISCOUNT VALUE value
    function get_discount_value_value()
    {
      var result = 0;
      if($('#discount_value').val() == ""){
        result = 0;
      }
      else{
        result = $('#discount_value').val().replace(/,/g, '');
      }
      return result;
    }
    //ENDBlock get DISCOUNT VALUE value

    //Block get AFTER DISCOUNT value
    function get_after_discount_value()
    {
      var result = 0;
      if($('#after_discount').val() == ""){
        result = 0;
      }
      else{
        result = $('#after_discount').val().replace(/,/g, '');
      }
      return result;
    }
    //ENDBlock get AFTER DISCOUNT value

    //Block Form submit handler
    $('#form-create-purchase-order-vendor').on('submit', function(){
      $('#btn-submit-purchase-order-vendor').prop('disabled', true);
    });
    //ENDBlock Form submit handler
    
  </script>
@endsection