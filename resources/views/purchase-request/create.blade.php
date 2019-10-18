@extends('layouts.app')

@section('page_title')
    Purchase Request
@endsection

@section('additional_styles')
  {!! Html::style('css/datepicker/datepicker3.css') !!}
@endsection

@section('page_header')
  <h1>
    Purchase Request
    <small>Create Purchase Request</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('purchase-request') }}"><i class="fa fa-tag"></i> Purchase Request</a></li>
    <li class="active"><i></i> Create</li>
  </ol>
@endsection

@section('content')
  
  <div class="row">
    <div class="col-md-12">
      <!--BOX Basic Informations-->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Form Create Purchase Request</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          {!! Form::open(['route'=>'purchase-request.store','role'=>'form','class'=>'form-horizontal','id'=>'form-create-purchase-request','files'=>true]) !!}
          <div class="form-group{{ $errors->has('project_id') ? ' has-error' : '' }}">
            {!! Form::label('project_id', 'Project', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              @if(\Request::get('project_id'))
                {{ Form::select('project_id', $project_opts, \Request::get('project_id'), ['class'=>'form-control', 'placeholder'=>'Select Project', 'id'=>'project_id']) }}
              @else
                {{ Form::select('project_id', $project_opts, null, ['class'=>'form-control', 'placeholder'=>'Select Project', 'id'=>'project_id']) }}
              @endif
              
              @if ($errors->has('project_id'))
                <span class="help-block">
                  <strong>{{ $errors->first('project_id') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <!-- Selection Quotation Vendor-->
          <div class="form-group{{ $errors->has('quotation_vendor_id') ? ' has-error' : '' }}">
            {!! Form::label('quotation_vendor_id', 'Quotation Vendor', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              <div class="input-group">
                <select name="quotation_vendor_id" id="quotation_vendor_id" class="form-control">
                  @if(Request::old('quotation_vendor_id') != NULL)
                    <option value="{{Request::old('quotation_vendor_id')}}">
                      {{ \App\QuotationVendor::find(Request::old('quotation_vendor_id'))->code }}
                    </option>
                  @endif
                </select>
                <span class="input-group-btn">
                  <button type="button" class="btn btn-default" id="btn-add-quotation-vendor"><i class="fa fa-plus"></i></button>
                </span>
              </div>
              @if ($errors->has('quotation_vendor_id'))
                <span class="help-block">
                  <strong>{{ $errors->first('quotation_vendor_id') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <!-- ENDSelection Quotation Vendor-->

          <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
            {!! Form::label('description', 'Description', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {!! Form::textarea('description',null,['class'=>'form-control', 'placeholder'=>'Description of purchase request', 'id'=>'description']) !!}
              @if ($errors->has('description'))
                <span class="help-block">
                  <strong>{{ $errors->first('description') }}</strong>
                </span>
              @endif
            </div>
          </div>

          <!-- Group items -->
          <div class="form-group">
            {!! Form::label('item', 'Item(s)', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-8">
              <div class="table-responsive">
                <table id="table-items" class="table">
                  <thead>
                    <tr>
                      <th>Item</th>
                      <th style="width:10%;">Qty</th>
                      <th style="width:10%;">Unit</th>
                      <th style="width:20%;">Price/Unit</th>
                      <th style="width:20%;">Sub Amount</th>
                      <th style="width:5%">
                        <button id="btn-add-item" class="btn btn-primary btn-xs" type="button">Add Item</button>
                        
                      </th>
                    </tr>
                  </thead>
                  <tbody id="table_items_body">
                    <!-- Build row items from occured item validation error-->
                    @if(Form::old('item'))
                       @foreach(old('item') as $key => $val)
                          <tr id="row_index_{{$key}}">
                            <td class="{{ $errors->has('item.'.$key.'') ? ' has-error' : '' }}">
                              <textarea name="item[{{ $key }}]" class="form-control item ">{{ old('item.'.$key.'') }}</textarea>
                               @if ($errors->has('item.'.$key.''))
                                  <span class="help-block">
                                    <strong>{{ $errors->first('item.'.$key.'') }}</strong>
                                  </span>
                                @endif
                            </td>
                            <td><input type="text" name="quantity[{{$key}}]" class="form-control quantity" value="{{ old('quantity.'.$key) }}" /></td>
                            <td><input type="text" name="unit[{{$key}}]" class="form-control unit" value="{{ old('unit.'.$key) }}" /></td>
                            <td><input type="text" name="price[{{$key}}]" class="form-control price" value="{{ old('price.'.$key) }}" /></td>
                            <td><input type="text" name="sub_amount[{{$key}}]" class="form-control sub_amount" value="{{ old('sub_amount.'.$key) }}" readonly /></td>
                            @if($key !=0)
                            <td><button class="btn btn-danger btn-xs btn-remove-item" type="button"><i class="fa fa-trash"></i></button></td>
                            @endif
                          </tr>
                      @endforeach
                    <!-- Build row items from NOT occured item validation error / The page load at very first-->
                    @else
                      <tr id="row_index_0">
                        <td class="{{ $errors->has('item.0') ? ' has-error' : '' }}">
                          <textarea name="item[0]" class="form-control item">{{ old('item.0') }}</textarea>
                           @if ($errors->has('item.0'))
                              <span class="help-block">
                                <strong>{{ $errors->first('item.0') }}</strong>
                              </span>
                            @endif
                        </td>
                        <td><input type="text" name="quantity[0]" class="form-control quantity" value="{{ old('quantity.0') }}" /></td>
                        <td><input type="text" name="unit[0]" class="form-control unit" value="{{ old('unit.0') }}" /></td>
                        <td><input type="text" name="price[0]" class="form-control price" value="{{ old('price.0') }}" /></td>
                        <td><input type="text" name="sub_amount[0]" class="form-control sub_amount" value="{{ old('sub_amount.0') }}" readonly /></td>
                      </tr>
                    @endif
                  </tbody>
                  <tfoot>
                    <tr>
                      <td colspan="4"><strong>Total Sub Amount</strong></td>
                      <td><input type="text" name="total_sub_amount" id="total_sub_amount" class="form-control" value="{{ old('total_sub_amount') }}" readonly></td>
                      <td></td>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
            <div class="col-sm-2">
              <select name="copy_item_from_pr" id="copy_item_from_pr" style="width:100%;">
              </select>
            </div>
          </div>
          <!-- ENDGroup items -->
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
              {!! Form::text('wht',null,['class'=>'form-control', 'placeholder'=>'WHT of the Purchase Request', 'id'=>'wht']) !!}
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
              {!!Form::text('amount',null,['class'=>'form-control', 'placeholder'=>'Amount of the purchase request', 'id'=>'amount', 'readonly'=>true])!!}
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
              {!! Form::textarea('terms',null,['class'=>'form-control', 'placeholder'=>'Terms and Conditions of the purchase request', 'id'=>'terms']) !!}
              @if ($errors->has('terms'))
                <span class="help-block">
                  <strong>{{ $errors->first('terms') }}</strong>
                </span>
              @endif
            </div>
          </div>
          
          <div class="form-group">
              {!! Form::label('', '', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-4">
              <a href="{{ url('purchase-request') }}" class="btn btn-default">
                <i class="fa fa-repeat"></i>&nbsp;Cancel
              </a>&nbsp;
              <button type="submit" class="btn btn-info" id="btn-submit-purchase-request">
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
  

  <!--Modal Create Quotation Vendor-->
  <div class="modal fade" id="modal-create-quotation-vendor" role="dialog" aria-labelledby="modal-create-quotation-vendorLabel">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
      {!! Form::open(['id'=>'form_create_quotation_vendor', 'role'=>'form','class'=>'form-horizontal', 'url'=>'quotation-vendor/saveFromPurchaseRequest', 'method'=>'post']) !!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="modal-create-quotation-vendorLabel">Create Quotation Vendor</h4>
        </div>
        <div class="modal-body">
          <div class="form-group{{ $errors->has('the_vendor_id') ? ' has-error' : '' }}" id="the_vendor_id_group">
            {!! Form::label('the_vendor_id', 'Vendor', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10" id="the_vendor_id_block">
              <select name="the_vendor_id" id="the_vendor_id" class="form-control" style="width:100%;"></select>
              @if ($errors->has('the_vendor_id'))
                <span class="help-block">
                  <strong>{{ $errors->first('the_vendor_id') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <div class="form-group{{ $errors->has('quotation_vendor_code') ? ' has-error' : '' }}" id="quotation_vendor_code_group">
            {!! Form::label('quotation_vendor_code', 'Quotation Number', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10" id="quotation_vendor_code_block">
              {!! Form::text('quotation_vendor_code',null,['class'=>'form-control', 'placeholder'=>'Quotation Number', 'id'=>'quotation_vendor_code']) !!}
              @if ($errors->has('quotation_vendor_code'))
                <span class="help-block">
                  <strong>{{ $errors->first('quotation_vendor_code') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <div class="form-group{{ $errors->has('quotation_vendor_description') ? ' has-error' : '' }}" id="quotation_vendor_description_group">
            {!! Form::label('quotation_vendor_description', 'Description', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10" id="quotation_vendor_description_block">
              {!! Form::textarea('quotation_vendor_description',null,['class'=>'form-control', 'placeholder'=>'Quotation Vendor Description', 'id'=>'quotation_vendor_description']) !!}
              @if ($errors->has('quotation_vendor_description'))
                <span class="help-block">
                  <strong>{{ $errors->first('quotation_vendor_description') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <div class="form-group{{ $errors->has('quotation_vendor_amount') ? ' has-error' : '' }}" id="quotation_vendor_amount_group">
            {!! Form::label('quotation_vendor_amount', 'Amount', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10" id="quotation_vendor_amount_block">
              {!! Form::text('quotation_vendor_amount',null,['class'=>'form-control', 'placeholder'=>'Quotation Vendor amount', 'id'=>'quotation_vendor_amount']) !!}
              @if ($errors->has('quotation_vendor_amount'))
                <span class="help-block">
                  <strong>{{ $errors->first('quotation_vendor_amount') }}</strong>
                </span>
              @endif
            </div>
          </div>
          
          <div class="form-group{{ $errors->has('quotation_vendor_received_date') ? ' has-error' : '' }}" id="quotation_vendor_received_date_group">
            {!! Form::label('quotation_vendor_received_date', 'Received date', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10" id="quotation_vendor_received_date_block">
              {!! Form::text('quotation_vendor_received_date',null,['class'=>'form-control', 'placeholder'=>'Date when quotation is received', 'id'=>'quotation_vendor_received_date']) !!}
              @if ($errors->has('quotation_vendor_received_date'))
                <span class="help-block">
                  <strong>{{ $errors->first('quotation_vendor_received_date') }}</strong>
                </span>
              @endif
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-info">Submit</button>
        </div>
      {!! Form::close() !!}
      </div>
    </div>
  </div>
<!--ENDModal Create Quotation Vendor-->
@endsection

@section('additional_scripts')
  {!! Html::script('js/datepicker/bootstrap-datepicker.js') !!}
  {!! Html::script('js/autoNumeric.js') !!}
  <script type="text/javascript">
    //Block initialize autonumerical inputs
    $('#amount, .quantity, #vat, #wht, .price, .sub_amount, #total_sub_amount, #discount, #discount_value, #after_discount' ).autoNumeric('init',{
        aSep:',',
        aDec:'.'
    });
    
    //ENDBlock autonumeric

    //Block project selection
    $('#project_id').select2({
      placeholder: 'Select Project',
      ajax: {
        url: '{!! url('select2ProjectForPurchaseRequest') !!}',
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
      allowClear:true,
      templateResult : templateResultProject
    });

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
    //ENDBlock project selection

    //Block Quotation Vendor id Selection
    $('#quotation_vendor_id').select2({
      placeholder: 'Quotation Vendor',
      ajax: {
        url: '{!! url('select2QuotationVendorForPurchaseRequest') !!}',
        dataType: 'json',
        delay: 250,
        processResults: function (data) {
          return {
            results:  $.map(data, function (item) {
                  return {
                      text: item.code,
                      id: item.id,
                      description : item.description,
                      amount : item.amount,
                      vendor : item.vendor,
                  }
              })
          };
        },
        cache: true
      },
      allowClear:true,
      templateResult : templateResultQuotationVendor
    }).on('select2:select', function(){
      var description = $('#quotation_vendor_id').find(':selected').data().data.description;
      var amount = $('#quotation_vendor_id').find(':selected').data().data.amount;
      // alert(description);
      $('#description').val(description);
      $('#amount').autoNumeric('set', amount);
      
    });
    //ENDBlock Quotation Vendor id Selection

    function templateResultQuotationVendor(results){
      if(results.loading){
        return "Searching...";
      }
      var markup = '<span>';
          markup+=  results.text;
          markup+=  '<p>';
          markup+=    results.vendor ? results.vendor.name: "";
          markup+=  '</p>';
          markup+= '</span>';
      return $(markup);
    }

    //Block price input
      //sub amount filling per row when price input is on keyupped
      $('.price').on('keyup', function(){
          var this_price = $(this).val().replace(/,/g, "");
          var this_quantity = $(this).parent().parent().find('.quantity').val().replace(/,/g, "");
          $(this).parent().parent().find('.sub_amount').autoNumeric('set',this_price*this_quantity);
          fill_total_sub_amount();
          update_after_discount_value();
          update_amount_value();
      });
    //ENDBLock price input

    //Block sub_amount input
      //sub amount filling per row when quantity input is on keyupped
      $('.quantity').on('keyup', function(){
          var this_quantity = $(this).val().replace(/,/g, "");
          var this_price_per_unit = $(this).parent().parent().find('.price').val().replace(/,/g, "");
          $(this).parent().parent().find('.sub_amount').autoNumeric('set',this_quantity*this_price_per_unit);
          fill_total_sub_amount();
          update_after_discount_value();
          update_amount_value();
      });
    //ENDBLock sub_amount input

    //Block Button add item handling
    var index_initiator = 0;
    $('#btn-add-item').on('click', function(){
      
      index_initiator+=1;
      var row_item = '<tr id="row_index_'+index_initiator+'">'+
                        '<td><textarea name="item['+index_initiator+']" class="form-control item" value=""></textarea></td>'+
                        '<td><input type="text" name="quantity[]" class="form-control quantity" /></td>'+
                        '<td><input type="text" name="unit[]" class="form-control unit" /></td>'+
                        '<td><input type="text" name="price[]" class="form-control price" /></td>'+
                        '<td><input type="text" name="sub_amount[]" class="form-control sub_amount" readonly /></td>'+
                        '<td><button class="btn btn-danger btn-xs btn-remove-item" type="button"><i class="fa fa-trash"></i></button></td>'+
                      '</tr>';
      $('#table-items').find('tbody').append(row_item);
      $('#table-items').find('tr td button.btn-remove-item').on('click', function(){
        remove_row($(this));
      });

      //Prepare all needed inputs that has to be autoNumeric initialized
        // Quantity input
        $('#table-items').find('tr td input.quantity').autoNumeric('init',{
          aSep:',',
          aDec:'.'
        });

        //Sub amount input
        $('#table-items').find('tr td input.sub_amount').autoNumeric('init',{
          aSep:',',
          aDec:'.'
        });

        //Price
        $('#table-items').find('tr td input.price').autoNumeric('init',{
          aSep:',',
          aDec:'.'
        });

      //Register onkeyup event handler to created inputs : quantity and price
        //quantity
        $('#table-items').find('tr td input.quantity').on('keyup', function(){
          var this_quantity = $(this).val().replace(/,/g, "");
          var this_price_per_unit = $(this).parent().parent().find('.price').val().replace(/,/g, "");
          $(this).parent().parent().find('.sub_amount').autoNumeric('set',this_quantity*this_price_per_unit);
          fill_total_sub_amount();
          update_after_discount_value();
          update_amount_value();
        });

        //price
        $('#table-items').find('tr td input.price').on('keyup', function(){
          var this_price_per_unit = $(this).val().replace(/,/g, "");
          var this_quantity = $(this).parent().parent().find('.quantity').val().replace(/,/g, "");
          $(this).parent().parent().find('.sub_amount').autoNumeric('set',this_quantity*this_price_per_unit);
          fill_total_sub_amount();
          update_after_discount_value();
          update_amount_value();
        });

      
    });
    //ENDBlock Button add item handling

    //Block register .btn-remove-item event handler [After validation fails from the server]
    $('#table-items').find('tr td button.btn-remove-item').on('click', function(){
      remove_row($(this));
    });
    //ENDBlock register .btn-remove-item event handler [After validation fails from the server]


    //Block function to remove additional row
    function remove_row(obj){
      $(obj).parent().parent().remove();
      fill_total_sub_amount();
      update_after_discount_value();
      update_amount_value();
    }
    //ENDBlock function to remove additional row
    

    //Block Function to fill total_sub_amount
    function fill_total_sub_amount(){
      
      var sum = 0;
      $(".sub_amount").each(function(){
          sum += +$(this).val().replace(/,/g, '');
      });
      $("#total_sub_amount").val(sum);
      $('#total_sub_amount').autoNumeric('update',{
          aSep:',',
          aDec:'.'
      });
    }
    //ENDBlock Function to fill total_sub_amount

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
      if($('#total_sub_amount').val() == ""){
        result = 0;
      }
      else{
        result = $('#total_sub_amount').val().replace(/,/g, '');
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

    //Submit purchase request event handling;
    $('#form-create-purchase-request').on('submit', function(){
      $('#btn-submit-purchase-request').prop('disabled', true);
    });


    //Quotation Vendor Blocks starts here
    //setup autonumerical inputs
    $('#quotation_vendor_amount' ).autoNumeric('init',{
        aSep:',',
        aDec:'.'
    });
    //setup Quotation Vendor Received Date input
    $('#quotation_vendor_received_date').on('keydown', function(event){
      event.preventDefault();
    });
    $('#quotation_vendor_received_date').datepicker({
      format : 'yyyy-mm-dd'
    });
    //ENDsetup Quotation Vendor Received Date input

    //Show the create quottion vendor modal
    $('#btn-add-quotation-vendor').on('click', function(){
      $('#modal-create-quotation-vendor').modal('show');
    });

    //Block Vendor id Selection
    $('#the_vendor_id').select2({
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

    $('#form_create_quotation_vendor').on('submit', function(event){
      event.preventDefault();
      var saveQuotationFromPurchaseRequestUrl = $(this).attr('action');
      $('#the_vendor_id_block').find('.help-block').remove();
      $('#quotation_vendor_code_block').find('.help-block').remove();
      $('#quotation_vendor_description_block').find('.help-block').remove();
      $('#quotation_vendor_amount_block').find('.help-block').remove();
      $('#quotation_vendor_received_date_block').find('.help-block').remove();
      $.ajax({
        type: 'post',
        url: saveQuotationFromPurchaseRequestUrl,
        data: $(this).serialize(),
        dataType: 'json',
        success: function(data){
          console.log(data.id);
          //$('#quotation_vendor_id').empty().append('<option selected value="'+data.id+'">'+data.code+'</option>');

          /*$('#quotation_vendor_id').select2('data',{
              text: data.code,
              id: data.id,
              description : data.description,
              amount : data.amount,
          });*/
          //$('#quotation_vendor_id').trigger('change');
          $('#quotation_vendor_id').select2('open');

          $('#modal-create-quotation-vendor').modal('hide');
          $("#quotation_vendor_id").select2("trigger", "select", {
              data: { 
                id: data.id,
                text : data.code,
                description : data.description,
                amount : data.amount,
              }
          });
          
        },
        error: function(data){
          var errors = data.responseJSON;
          console.log(errors);
          if(errors.the_vendor_id){
            $('#the_vendor_id_group').addClass('has-error');
            $('#the_vendor_id_block').append('<span class="help-block">'+errors.the_vendor_id[0]+'</span>');
          }
          else{
            $('#the_vendor_id_group').removeClass('has-error');
            $('#the_vendor_id_block').find('.help-block').remove();
          }
          if(errors.quotation_vendor_code){
            $('#quotation_vendor_code_group').addClass('has-error');
            $('#quotation_vendor_code_block').append('<span class="help-block">'+errors.quotation_vendor_code[0]+'</span>');
          }
          else{
            $('#quotation_vendor_code_group').removeClass('has-error');
            $('#quotation_vendor_code_block').find('.help-block').remove();
          }
          if(errors.quotation_vendor_description){
            $('#quotation_vendor_description_group').addClass('has-error');
            $('#quotation_vendor_description_block').append('<span class="help-block">'+errors.quotation_vendor_description[0]+'</span>');
          }
          else{
            $('#quotation_vendor_description_group').removeClass('has-error');
            $('#quotation_vendor_description_block').find('.help-block').remove();
          }
          if(errors.quotation_vendor_amount){
            $('#quotation_vendor_amount_group').addClass('has-error');
            $('#quotation_vendor_amount_block').append('<span class="help-block">'+errors.quotation_vendor_amount[0]+'</span>');
          }
          else{
            $('#quotation_vendor_amount_group').removeClass('has-error');
            $('#quotation_vendor_amount_block').find('.help-block').remove();
          }
          if(errors.quotation_vendor_received_date){
            $('#quotation_vendor_received_date_group').addClass('has-error');
            $('#quotation_vendor_received_date_block').append('<span class="help-block">'+errors.quotation_vendor_received_date[0]+'</span>');
          }
          else{
            $('#quotation_vendor_received_date_group').removeClass('has-error');
            $('#quotation_vendor_received_date_block').find('.help-block').remove();
          }

        }
      });
    });
  

  //Select from pr
  //Block Copy items from purchase request
    $('#copy_item_from_pr').select2({
      placeholder: 'Copy items from Purchase Request',
      ajax: {
        url: '{!! url('select2PurchaseRequestToCopyItems') !!}',
        dataType: 'json',
        delay: 250,
        processResults: function (data) {
          return {
            results:  $.map(data, function (item) {
                  return {
                      text: item.code,
                      id: item.id,
                      the_items : item.the_items
                  }
              })
          };
        },
        cache: true,
      },
      allowClear:true
    }).on('select2:select', function(){
      run_copy_item_from_pr($(this).val());
    });

    function run_copy_item_from_pr(purchase_request_id){
      //$('#table-items').find('tbody').find('tr#row_index_0').remove();
      var purchase_request_id = purchase_request_id;
      $.ajax({
        url : '{!! url('getPurchaseRequestItems') !!}',
        type : 'GET',
        data : 'purchase_request_id='+purchase_request_id,
        beforeSend : function(){},
        success : function(response){
          if(response.length > 0){
            $('#table-items').find('tbody').find('tr#row_index_0').remove();
            $.each(response, function(idx, obj) {
              index_initiator+=1;
              var row_item = '<tr id="row_index_'+index_initiator+'">'+
                                '<td><textarea name="item['+index_initiator+']" class="form-control item">'+obj.item+'</textarea></td>'+
                                '<td><input type="text" name="quantity['+index_initiator+']" class="form-control quantity" value="'+obj.quantity+'"/></td>'+
                                '<td><input type="text" name="unit['+index_initiator+']" class="form-control unit" value="'+obj.unit+'" /></td>'+
                                '<td><input type="text" name="price['+index_initiator+']" class="form-control price" value="'+obj.price+'" /></td>'+
                                '<td><input type="text" name="sub_amount['+index_initiator+']" class="form-control sub_amount" value="'+obj.sub_amount+'" readonly /></td>'+
                                '<td><button class="btn btn-danger btn-xs btn-remove-item" type="button"><i class="fa fa-trash"></i></button></td>'+
                              '</tr>';
              $('#table-items').find('tbody').append(row_item);
              $('#table-items').find('tr td button.btn-remove-item').on('click', function(){
                remove_row($(this));
              });

              //Prepare all needed inputs that has to be autoNumeric initialized
                // Quantity input
                $('#table-items').find('tr td input.quantity').autoNumeric('init',{
                  aSep:',',
                  aDec:'.'
                });

                //Sub amount input
                $('#table-items').find('tr td input.sub_amount').autoNumeric('init',{
                  aSep:',',
                  aDec:'.'
                });

                //Price
                $('#table-items').find('tr td input.price').autoNumeric('init',{
                  aSep:',',
                  aDec:'.'
                });

              //Register onkeyup event handler to created inputs : quantity and price
                //quantity
                $('#table-items').find('tr td input.quantity').on('keyup', function(){
                  var this_quantity = $(this).val().replace(/,/g, "");
                  var this_price_per_unit = $(this).parent().parent().find('.price').val().replace(/,/g, "");
                  $(this).parent().parent().find('.sub_amount').autoNumeric('set',this_quantity*this_price_per_unit);
                  fill_total_sub_amount();
                  update_after_discount_value();
                  update_amount_value();
                });

                //price
                $('#table-items').find('tr td input.price').on('keyup', function(){
                  var this_price_per_unit = $(this).val().replace(/,/g, "");
                  var this_quantity = $(this).parent().parent().find('.quantity').val().replace(/,/g, "");
                  $(this).parent().parent().find('.sub_amount').autoNumeric('set',this_quantity*this_price_per_unit);
                  fill_total_sub_amount();
                  update_after_discount_value();
                  update_amount_value();
                });
            });

            fill_total_sub_amount();
            update_after_discount_value();
            update_amount_value();
          }
         
        }
      });
    }
    //ENDBlock Copy items from purchase request
  </script>
@endsection