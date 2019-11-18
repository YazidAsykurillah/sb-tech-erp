@extends('layouts.app')

@section('page_title')
  Edit Invoice Customer
@endsection

@section('page_header')
  <h1>
    Invoice Customer
    <small>Edit Invoice Customer</small>
  </h1>
@endsection

@section('additional_styles')
  {!! Html::style('css/datepicker/datepicker3.css') !!}
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('invoice-customer') }}"><i class="fa fa-credit-card"></i> Invoice Customer</a></li>
    <li class="active"><i></i> Edit</li>
  </ol>
@endsection
  
@section('content')
  <div class="row">
    <div class="col-md-9">
      <!--BOX Basic Informations-->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Form Edit Invoice Customer</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          
          {!! Form::model($invoice_customer, ['route'=>['invoice-customer.update', $invoice_customer->id], 'class'=>'form-horizontal','id'=>'form-edit-invoice-customer', 'method'=>'put', 'files'=>true]) !!}
          
          <div class="form-group{{ $errors->has('code') ? ' has-error' : '' }}">
            {!! Form::label('code', 'Invoice Number', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {!! Form::text('code',null,['class'=>'form-control', 'placeholder'=>'Invoice Code', 'id'=>'code', 'disabled'=>true]) !!}
              @if ($errors->has('code'))
                <span class="help-block">
                  <strong>{{ $errors->first('code') }}</strong>
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
          
          <!-- Group items -->
            <div class="form-group">
              {!! Form::label('item', 'Invoice Item(s)', ['class'=>'col-sm-2 control-label']) !!}
              <div class="col-sm-10">
                <div class="table-responsive">
                  <table id="table-items" class="table">
                    <thead>
                      <tr>
                        <th>Item</th>
                        <th style="width:15%;">Qty</th>
                        <th style="width:15%;">Unit</th>
                        <th style="width:20%;">Price/Unit</th>
                        <th style="width:20%;">Sub Amount</th>
                        <th style="width:5%"><button id="btn-add-item" class="btn btn-primary btn-xs" type="button">Add Item</button></th>
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
                        @if(count($items))
                          <?php $item_counter = 0; ?>
                          @foreach($items as $item)
                            <?php $item_counter +=1; ?>
                          <tr id="row_index_{{$item_counter}}">
                            <td class="{{ $errors->has('item.'.$item_counter) ? ' has-error' : '' }}">
                              <textarea name="item[{{$item_counter}}]" class="form-control item">{{ $item->item }}</textarea>
                               @if ($errors->has('item.'.$item_counter))
                                  <span class="help-block">
                                    <strong>{{ $errors->first('item.'.$item_counter) }}</strong>
                                  </span>
                                @endif
                            </td>
                            <td><input type="text" name="quantity[{{$item_counter}}]" class="form-control quantity" value="{{ $item->quantity }}" /></td>
                            <td><input type="text" name="unit[{{$item_counter}}]" class="form-control unit" value="{{ $item->unit }}" /></td>
                            <td><input type="text" name="price[{{$item_counter}}]" class="form-control price" value="{{ $item->price }}" /></td>
                            <td><input type="text" name="sub_amount[{{$item_counter}}]" class="form-control sub_amount" value="{{ $item->sub_amount }}" readonly /></td>
                          </tr>
                          @endforeach
                        @else
                        @endif

                      @endif
                    </tbody>
                    <tfoot>
                      <tr>
                        <td colspan="4"><strong>Total Sub Amount</strong></td>
                        <td><input type="text" name="total_sub_amount" id="total_sub_amount" class="form-control" value="{{ $invoice_customer->sub_amount }}" readonly></td>
                        <td></td>
                      </tr>
                    </tfoot>
                  </table>
                </div>
              </div>
            </div>
            <!-- ENDGroup items -->
          

          <div class="form-group{{ $errors->has('discount') ? ' has-error' : '' }}">
            {!! Form::label('discount', 'Discount', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-3">
              <div class="input-group">
                {!! Form::text('discount',null,['class'=>'form-control', 'placeholder'=>'Discount (%)', 'id'=>'discount']) !!}
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
              
                {!! Form::text('after_discount',null,['class'=>'form-control', 'placeholder'=>'After discount', 'id'=>'after_discount', 'readonly'=>true]) !!}
                
                @if ($errors->has('after_discount'))
                  <span class="help-block">
                    <strong>{{ $errors->first('after_discount') }}</strong>
                  </span>
                @endif
            </div>

            <div class="col-sm-4">
                <button type="button" id="btn-round-after-discount-value" class="btn btn-xs btn-info" title="Click to round it up">
                  <i class="fa fa-cog"></i>
                </button>
            </div>
          </div>

          <div class="form-group{{ $errors->has('down_payment') ? ' has-error' : '' }}">
            {!! Form::label('down_payment', 'DP/Term/Pelunasan', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-2">
              <p>{!! Form::radio('type','dp') !!} DP</p>
              <p>{!! Form::radio('type','term') !!} Term</p>
              <p>{!! Form::radio('type','pelunasan') !!} Pelunasan</p>
            </div>
            <div class="col-sm-2">
              <div class="input-group">
                {!! Form::text('down_payment',null,['class'=>'form-control', 'placeholder'=>'DP (%)', 'id'=>'down_payment']) !!}
                <span class="input-group-btn">
                  <button class="btn btn-default" type="button">%</button>
                </span>
                @if ($errors->has('down_payment'))
                  <span class="help-block">
                    <strong>{{ $errors->first('down_payment') }}</strong>
                  </span>
                @endif
              </div>
            </div>
          </div>
          <div class="form-group{{ $errors->has('down_payment_value') ? ' has-error' : '' }}">
            {!! Form::label('down_payment_value', 'DP/Term/Pelunasan Value', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-4">
              
                {!! Form::text('down_payment_value',null,['class'=>'form-control', 'placeholder'=>'Down Payment Value', 'id'=>'down_payment_value', 'readonly'=>true]) !!}
                
                @if ($errors->has('down_payment_value'))
                  <span class="help-block">
                    <strong>{{ $errors->first('down_payment_value') }}</strong>
                  </span>
                @endif
            </div>
          </div>

          <div class="form-group{{ $errors->has('vat') ? ' has-error' : '' }}">
            {!! Form::label('vat', 'VAT', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-2">
              <div class="input-group">
                {!! Form::text('vat',null,['class'=>'form-control', 'placeholder'=>'VAT (%)', 'id'=>'vat']) !!}
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

          <div class="form-group{{ $errors->has('vat_value') ? ' has-error' : '' }}">
            {!! Form::label('vat_value', 'VAT Value', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-4">
              {!! Form::text('vat_value',null,['class'=>'form-control', 'placeholder'=>'VAT value of the Invoice', 'id'=>'vat_value', 'readonly'=>true]) !!}
              @if ($errors->has('vat_value'))
                <span class="help-block">
                  <strong>{{ $errors->first('vat_value') }}</strong>
                </span>
              @endif
            </div>
          </div>

          <div class="form-group{{ $errors->has('wht') ? ' has-error' : '' }}">
            {!! Form::label('wht', 'WHT', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-4">
              {!! Form::text('wht',null,['class'=>'form-control', 'placeholder'=>'WHT of the Invoice', 'id'=>'wht']) !!}
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
              {!! Form::text('amount',null,['class'=>'form-control', 'placeholder'=>'Amount of the Invoice', 'id'=>'amount', 'readonly'=>true]) !!}
              @if ($errors->has('amount'))
                <span class="help-block">
                  <strong>{{ $errors->first('amount') }}</strong>
                </span>
              @endif
            </div>
            
          </div>
          <div class="form-group{{ $errors->has('posting_date') ? ' has-error' : '' }}">
            {!! Form::label('posting_date', 'Date', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {!! Form::text('posting_date',null,['class'=>'form-control', 'id'=>'posting_date', 'placeholder'=>'Posting Date of the Invoice Customer']) !!}
              @if ($errors->has('posting_date'))
                <span class="help-block">
                  <strong>{{ $errors->first('posting_date') }}</strong>
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
          <div class="form-group{{ $errors->has('tax_date') ? ' has-error' : '' }}">
            {!! Form::label('tax_date', 'Tax Date', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {!! Form::text('tax_date',null,['class'=>'form-control', 'id'=>'tax_date', 'placeholder'=>'Tax Date of the Invoice Customer']) !!}
              @if ($errors->has('tax_date'))
                <span class="help-block">
                  <strong>{{ $errors->first('tax_date') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <div class="form-group{{ $errors->has('due_date') ? ' has-error' : '' }}">
            {!! Form::label('due_date', 'Due Date', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-4">
              {!! Form::text('due_date',null,['class'=>'form-control', 'placeholder'=>'due_date of the Invoice', 'id'=>'due_date']) !!}
              @if ($errors->has('due_date'))
                <span class="help-block">
                  <strong>{{ $errors->first('due_date') }}</strong>
                </span>
              @endif
            </div>
          </div>

          <div class="form-group{{ $errors->has('file') ? ' has-error' : '' }}">
            {!! Form::label('file', 'File', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-4">
              {!! Form::file('file') !!}
              @if ($errors->has('file'))
                <span class="help-block">
                  <strong>{{ $errors->first('file') }}</strong>
                </span>
              @endif
            </div>
          </div>

          <div class="form-group">
            {!! Form::label('', '', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              <a href="{{ url('invoice-customer/'.$invoice_customer->id) }}" class="btn btn-default">
                <i class="fa fa-repeat"></i>&nbsp;Cancel
              </a>&nbsp;
              <button type="submit" class="btn btn-info" id="btn-submit-invoice-customer">
                <i class="fa fa-save"></i>&nbsp;Submit
              </button>
              <input type="hidden" id="total_invoice_due" name="total_invoice_due" value="{{ $total_invoice_due }}">
            </div>
          </div>
          {!! Form::close() !!}
          
        </div><!-- /.box-body -->
      </div>
      <!--ENDBOX Basic Informations-->

    </div>

    <div class="col-md-3">
      <!--BOX PO Customer Information-->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-bookmark-o"></i>&nbsp;PO Customer</h3>
          
        </div><!-- /.box-header -->
        <div class="box-body">
          <strong>PO Number</strong>
          <p class="text-muted">{{ $project->purchase_order_customer->code }}</p>
          <strong>Amount</strong>
          <p class="text-muted">{{ number_format($project->purchase_order_customer->amount) }}</p>
          <strong>Description</strong>
          <p class="text-muted">{!! nl2br(e($project->purchase_order_customer->description)) !!}</p>
        </div><!-- /.box-body -->
      </div>
      <!--ENDBOX PO Customer Information-->

      <!--BOX Invoice Customer Information-->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-credit-card"></i>&nbsp;Invoice Customer</h3>
          
        </div><!-- /.box-header -->
        <div class="box-body">
          <p class="alert alert-info">
            <i class="fa fa-info-circle"></i>&nbsp;Invoice customers related to project {{ $project->code }}
          </p>
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th style="width:20%;">Code</th>
                  <th style="text-align:right;">Amount</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
              @if(count($project->invoice_customer))
                @foreach($project->invoice_customer as $invoice_customer)
                <tr>
                  <td>{{ $invoice_customer->code }}</td>
                  <td style="text-align:right;">{{ number_format($invoice_customer->amount, 2) }}</td>
                  <td>{{ $invoice_customer->status }}</td>
                </tr>
                @endforeach
                <tr>
                  <td><strong>Total Paid Invoice<strong></td>
                  <td style="text-align:right;"><strong>{{ number_format($total_paid_invoice,2) }}</strong></td>
                </tr>
              @else
                <tr>
                  <td colspan="3">There is no invoice for this project</td>
                </tr>
              @endif
                <tr>
                  <td><strong>Invoice Due<strong></td>
                  <td style="text-align:right;" class="alert alert-danger"><strong>{{ number_format($total_invoice_due,2) }}</strong></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div><!-- /.box-body -->
      </div>
      <!--ENDBOX Invoice Customer Information-->
    </div>

  </div>
@endsection

@section('additional_scripts')
  {!! Html::script('js/datepicker/bootstrap-datepicker.js') !!}
  {!! Html::script('js/autoNumeric.js') !!}
  <script type="text/javascript">

    //Block purchase order customer selection
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
                      id: item.id
                  }
              })
          };
        },
        cache: true
      }
    });
    //ENDBlock purchase order customer selection
    
    //Block initialize autonumerical inputs
    $('#amount, .quantity, #vat, #wht, .price, .sub_amount, #total_sub_amount, #after_discount, #down_payment_value, #vat_value').autoNumeric('init',{
        aSep:',',
        aDec:'.'
    });

    $('#discount').autoNumeric('init',{
        aSep:',',
        aDec:'.',
        mDec : 20,
        vMax:99
    });

    $('#down_payment').autoNumeric('init',{
        aSep:',',
        aDec:'.',
        mDec : 10,
        vMax:100
    });

    //ENDBLock initialize autonumerical inputs

    //Block price input
      //sub amount filling per row when price input is on keyupped
      $('.price').on('keyup', function(){
          var this_price = $(this).val().replace(/,/g, "");
          var this_quantity = $(this).parent().parent().find('.quantity').val().replace(/,/g, "");
          $(this).parent().parent().find('.sub_amount').autoNumeric('set',this_price*this_quantity);
          fill_total_sub_amount();
          update_after_discount_value();
          update_down_payment_value_value();
          update_vat_value_value();
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
          update_down_payment_value_value();
          update_vat_value_value();
          update_amount_value();
      });
    //ENDBLock sub_amount input

    //Block Button add item handling
    var index_initiator = parseInt('{{ count($items) }}');
    $('#btn-add-item').on('click', function(){
      
      index_initiator+=1;
      var row_item = '<tr id="row_index_'+index_initiator+'">'+
                        '<td><textarea name="item['+index_initiator+']" class="form-control item" value=""></textarea></td>'+
                        '<td><input type="text" name="quantity['+index_initiator+']" class="form-control quantity" /></td>'+
                        '<td><input type="text" name="unit['+index_initiator+']" class="form-control unit" /></td>'+
                        '<td><input type="text" name="price['+index_initiator+']" class="form-control price" /></td>'+
                        '<td><input type="text" name="sub_amount['+index_initiator+']" class="form-control sub_amount" readonly /></td>'+
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
          update_down_payment_value_value();
          update_vat_value_value();
          update_amount_value();
        });

        //price
        $('#table-items').find('tr td input.price').on('keyup', function(){
          var this_price_per_unit = $(this).val().replace(/,/g, "");
          var this_quantity = $(this).parent().parent().find('.quantity').val().replace(/,/g, "");
          $(this).parent().parent().find('.sub_amount').autoNumeric('set',this_quantity*this_price_per_unit);
          fill_total_sub_amount();
          update_after_discount_value();
          update_down_payment_value_value();
          update_vat_value_value();
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

    //Block function update amount input value [THE MAIN FUNCTION to set the amount of the invoice]
    function update_amount_value(){

      var amount = 0;
      //get #after_discount_value
      var after_discount = parseFloat(get_after_discount_value());
      //get #down_payment_value value
      var down_payment_value_value = parseFloat(get_down_payment_value_value());
      //get #vat_value value
      var vat_value_value = parseFloat(get_vat_value_value());
      //get #wht value
      var wht_value = parseFloat(get_wht_value());
      //if down payment value is not=0
      if(down_payment_value_value !=0){
        //get vat value from down payment value_value
        amount = down_payment_value_value+vat_value_value+wht_value;
      }
      else{
        amount = after_discount+vat_value_value+wht_value;  
      }
      
      $('#amount').autoNumeric('set', amount);
    }
    //ENDBlock function update amount input value [THE MAIN FUNCTION to set the amount of the invoice]

    //Block function update after_discount input value
    function update_after_discount_value(){
      
      var after_discount = "";
      var discount = get_discount_value();
      var total_sub_amount = get_total_sub_amount_value();
      if(discount > 0){
        after_discount = total_sub_amount - (discount/100*total_sub_amount);
      }else{
        after_discount = total_sub_amount;
      }
      $('#after_discount').autoNumeric('set', after_discount);
    }
    //ENDBlock function update after_discount input value


    //Block function update down_payment_value input value
    function update_down_payment_value_value(){
      //get the value of #after_discount
      var after_discount = get_after_discount_value();
      //get the value of #down_payment
      var down_payment = get_down_payment_value();
      //count the down_payment_value
      var down_payment_value_value = down_payment/100*after_discount;

      $('#down_payment_value').autoNumeric('set', down_payment_value_value);
      
    }
    //ENDBlock function update down_payment_value input value

    //Block function update vat_value input value
    function update_vat_value_value(){
      //initiate vat_value_value
      var vat_value_value = 0;
      //get the value of #after_discount
      var after_discount = get_after_discount_value();
      //get the value of #vat
      var vat = get_vat_value();

      //get down_payment
      var down_payment = get_down_payment_value();
      //count the vat_value
      //if down_payment_value is not 0, count the value from the #down_payment_value input
      if(down_payment!=0){
        var down_payment_value_value = get_down_payment_value_value();
        vat_value_value = vat/100*down_payment_value_value;
      }else{  //if down payament is 0, then count the value of vat from #after_discount input
        vat_value_value = vat/100*after_discount;
      }

      $('#vat_value').autoNumeric('set', vat_value_value);
      
    }
    //ENDBlock function update vat_value input value

    //Block register onkeyup event handler to #discount input
    $('#discount').on('keyup', function(){
      update_after_discount_value();
      update_down_payment_value_value();
      update_vat_value_value();
      update_amount_value();
    });
    //ENDBlock register onkeyup event handler to #discount input

    //Block register onkeyup event handler to #down_payment input
    $('#down_payment').on('keyup', function(){
      update_down_payment_value_value();
      update_after_discount_value();
      update_vat_value_value();
      update_amount_value();
    });
    //ENDBlock register onkeyup event handler to #down_payment input

    //Block register onkeyup event handler to VAT input
    $('#vat').on('keyup', function(){
      update_vat_value_value();
      update_after_discount_value();
      update_down_payment_value_value();
      update_amount_value();
    });
    //ENDBlock register onkeyup event handler to VAT input

    //Block register onkeyup event handler to WHT input
    $('#wht').on('keyup', function(){
      update_amount_value();
    });
    //ENDBlock register onkeyup event handler to WHT input

    


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

    

    //Block get DISCOUNT value
    function get_discount_value(){
      var result = 0;
      if($('#discount').val() == ""){
        result = 0;
      }
      else{
        result = $('#discount').val().replace(/,/g, '');
      }
      return result;
    }
    //ENDBlock get DISCOUNT

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

    //Block get #down_payment value
    function get_down_payment_value(){
      var result = 0;
      if($('#down_payment').val() == ""){
        result = 0;
      }
      else{
        result = $('#down_payment').val().replace(/,/g, '');
      }
      return result;
    }
    //ENDBlock get #down_payment value

    //Block get #down_payment_value value
    function get_down_payment_value_value(){
      var result = 0;
      if($('#down_payment_value').val() == ""){
        result = 0;
      }
      else{
        result = $('#down_payment_value').val().replace(/,/g, '');
      }
      return result;
    }
    //ENDBlock get #down_payment_value value


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

    //Block get #VAT_VALUE value
    function get_vat_value_value()
    {
      var result = 0;
      if($('#vat_value').val() == ""){
        result = 0;
      }
      else{
        result = $('#vat_value').val().replace(/,/g, '');
      }
      return result;
    }
    //ENDBlock get #VAT_VALUE value

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

    //Block Due Date input
    $('#due_date').on('keydown', function(event){
      event.preventDefault();
    });
    $('#due_date').datepicker({
      format : 'yyyy-mm-dd'
    });
    //ENDBlock Due Date input
    
    //Block Posting Date
    $('#posting_date').on('keydown', function(event){
      event.preventDefault();
    });
    $('#posting_date').datepicker({
      format : 'yyyy-mm-dd'
    });
    //ENDBlock Posting Date

    //Block TAX Date
    $('#tax_date').on('keydown', function(event){
      event.preventDefault();
    });
    $('#tax_date').datepicker({
      format : 'yyyy-mm-dd'
    });
    //ENDBlock TAX Date


    
    //Round amount event
    $('#btn-round-after-discount-value').on('click', function(){
      var after_discount_value = get_after_discount_value();
      var roundresult = Math.ceil(after_discount_value);
      // alert(roundresult);

      $('#after_discount').autoNumeric('set', roundresult);
      update_down_payment_value_value();
      update_vat_value_value();
      update_amount_value();
    });

    //END round amount event 

    $('#form-create-invoice-customer').on('submit', function(){
      $('#btn-submit-invoice-customer').prop('disabled', true);
    });
  </script>
@endsection