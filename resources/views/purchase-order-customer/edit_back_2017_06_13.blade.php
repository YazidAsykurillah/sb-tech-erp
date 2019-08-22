@extends('layouts.app')

@section('page_title')
    Purchase Order Customer
@endsection

@section('page_header')
  <h1>
    Purchase Order Customer
    <small>Edit Purchase Order Customer</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('purchase-order-customer') }}"><i class="fa fa-bookmark-o"></i> PO Customer</a></li>
    <li><i></i><a href="{{ URL::to('purchase-order-customer/'.$po_customer->id.'') }}">{{ $po_customer->code }}</a></li>
    <li class="active"><i></i> Edit</li>
  </ol>
@endsection

@section('content')
  <div class="row">
    <div class="col-md-12">
      <!--BOX Basic Informations-->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Form Edit Purchase Order Customer</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          {!! Form::model($po_customer, ['route'=>['purchase-order-customer.update', $po_customer->id], 'class'=>'form-horizontal','id'=>'form-edit-purchase-order-customer', 'method'=>'put', 'files'=>true]) !!}
          
          <div class="form-group{{ $errors->has('code') ? ' has-error' : '' }}">
            {!! Form::label('code', 'Purchase Order Number', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {!! Form::text('code',null,['class'=>'form-control', 'placeholder'=>'Purchase order number', 'id'=>'code']) !!}
              @if ($errors->has('code'))
                <span class="help-block">
                  <strong>{{ $errors->first('code') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <div class="form-group{{ $errors->has('quotation_customer_id') ? ' has-error' : '' }}">
            {!! Form::label('quotation_customer_id', 'Quotation Customer', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              <select name="quotation_customer_id" id="quotation_customer_id" class="form-control">
                @if(Request::old('quotation_customer_id') != NULL)
                  <option value="{{Request::old('quotation_customer_id')}}">
                    {{ \App\QuotationCustomer::find(Request::old('quotation_customer_id'))->code }}
                  </option>
                @endif
              </select>
              @if ($errors->has('quotation_customer_id'))
                <span class="help-block">
                  <strong>{{ $errors->first('quotation_customer_id') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <div class="form-group{{ $errors->has('customer_id') ? ' has-error' : '' }}">
            {!! Form::label('customer_id', 'Customer', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {!! Form::text('customer_name',$po_customer->quotation_customer->customer->name,['class'=>'form-control', 'placeholder'=>'Select from Quotation', 'id'=>'customer_name', 'readonly'=>true]) !!}
              {!! Form::hidden('customer_id',null,['class'=>'form-control', 'placeholder'=>'Customer ID', 'id'=>'customer_id']) !!}
              @if ($errors->has('customer_id'))
                <span class="help-block">
                  <strong>{{ $errors->first('customer_id') }}</strong>
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
              <a href="{{ url('purchase-order-customer') }}" class="btn btn-default">
                <i class="fa fa-repeat"></i>&nbsp;Cancel
              </a>&nbsp;
              <button type="submit" class="btn btn-info" id="btn-submit-customer">
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
    var current_quotation_customer_id = '{!! $po_customer->quotation_customer->id !!}';
    //alert(current_quotation_customer_id);

    $('#amount').autoNumeric('init',{
        aSep:',',
        aDec:'.'
    });

    //Block Quotation Customer Selection

    $('#quotation_customer_id').select2({
      placeholder: 'Quotation Customer',
      ajax: {
        url: '{!! url('select2QuotationCustomerForPOCustomer') !!}',
        dataType: 'json',
        delay: 250,
        data: function (params) {
           return {
                q: params.term,
                current_quotation_customer_id: current_quotation_customer_id,
                page: params.page
           };
        },
        processResults: function (data) {
          return {
            results:  $.map(data, function (item) {
                  return {
                      text: item.code,
                      id: item.id,
                      amount : item.amount,
                      description : item.description,
                      customer_id : item.customer.id,
                      customer_name : item.customer.name,
                  }
              })
          };
        },
        cache: true
      },
      allowClear : true,
      templateResult : templateResultQuotationCustomer,
    }).on('select2:select', function(){
      var selected = $('#quotation_customer_id').select2('data')[0];
      //$('#amount').val(selected.amount);
      $('#description').val(selected.description);
      $('#amount').autoNumeric('set', selected.amount);
      $('#customer_name').val(selected.customer_name);
      $('#customer_id').val(selected.customer_id);
    });

    function templateResultQuotationCustomer(results){

      if(results.loading){
        return "Searching...";
      }
      var markup = '<span>';
          markup+=  results.text;
          markup+=  '<br/>'+results.customer_name;
          markup+= '</span>';
      return $(markup);
    }

    //Set initial selected quotation_customer_id
    /*$("#quotation_customer_id").select2("trigger", "select", {
        data: {
          id:current_quotation_customer_id,
          text: "{{ $po_customer->quotation_customer->code }}",
          customer_id : "{{ $po_customer->quotation_customer->customer->id }}",
          customer_name : "{{ $po_customer->quotation_customer->customer->name }}",
          description : "{!! e($po_customer->description) !!}",
          amount : "{{ $po_customer->amount }}"
        }
    });*/

    //ENDBlock Quotation Customer Selection

    $('#form-create-purchase-order-customer').on('submit', function(){
      $('#btn-submit-customer').prop('disabled', true);
    });
  </script>
@endsection