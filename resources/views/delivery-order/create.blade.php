@extends('layouts.app')

@section('page_title')
    Delivery Order
@endsection

@section('page_header')
  <h1>
    Delivery Order
    <small>Create Delivery Order</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('delivery-order') }}"><i class="fa fa-truck"></i> Delivery Order</a></li>
    <li class="active"><i></i> Create</li>
  </ol>
@endsection

@section('content')
  <div class="row">
    {!! Form::open(['route'=>'delivery-order.store','role'=>'form','class'=>'form-horizontal','id'=>'form-create-delivery-order','files'=>true]) !!}
    <div class="col-md-4">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Purchase Order Vendor</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          <div class="form-group{{ $errors->has('purchase_order_vendor_id') ? ' has-error' : '' }}">
            {!! Form::label('purchase_order_vendor_id', 'PO Vendor', ['class'=>'col-sm-4 control-label']) !!}
            <div class="col-sm-8">
              {{ Form::select('purchase_order_vendor_id', [], null, ['class'=>'form-control', 'placeholder'=>'--Select PO Vendor--', 'id'=>'purchase_order_vendor_id']) }}
              @if ($errors->has('purchase_order_vendor_id'))
                <span class="help-block">
                  <strong>{{ $errors->first('purchase_order_vendor_id') }}</strong>
                </span>
              @endif
            </div>
          </div>
          
        </div>
      </div><!-- /.box-body -->
    </div>
    <div class="col-md-8">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Items</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          <table class="table" id="table-item">
            <thead>
              <tr>
                <th>Item Name</th>
                <th>Quantity</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td colspan="2">There is no item, please selet the Purchase order vendor first or select another one</td>
              </tr>
            </tbody>
          </table>
          <br>
          <div class="form-group">
            
            <div class="col-sm-10">
              <a href="{{ url('delivery-order') }}" class="btn btn-default">
                <i class="fa fa-repeat"></i>&nbsp;Cancel
              </a>&nbsp;
              <button type="submit" class="btn btn-info" id="btn-submit-delivery-order">
                <i class="fa fa-save"></i>&nbsp;Submit
              </button>
            </div>
          </div>
        </div>
      </div><!-- /.box-body -->
    </div>
    {!! Form::close() !!}
  </div>

  
@endsection

@section('additional_scripts')
  
<script type="text/javascript">
  //Block purchase order vendor selection
    $('#purchase_order_vendor_id').select2({
      placeholder: 'Select PO Vendor',
      ajax: {
        url: '{!! url('select2PurchaseOrderVendor') !!}',
        dataType: 'json',
        delay: 250,
        processResults: function (data) {
          return {
            results:  $.map(data, function (item) {
                  return {
                      text: item.code,
                      id: item.id,
                  }
              })
          };
        },
        cache: true
      },
      templateResult : templateResultPurchaseOrderVendor,
    });

    function templateResultPurchaseOrderVendor(results){
      if(results.loading){
        return "Searching...";
      }
      var markup = '<span>';
          markup+=  results.text;
          markup+= '</span>';
      return $(markup);
    }

    $('#purchase_order_vendor_id').on('select2:select', function(){
      var purchase_order_vendor_id = $(this).val();
      var token = $('meta[name="csrf-token"]').attr('content');
      $.ajax({
        url : '/purchase-order-vendor/getItems',
        type : 'POST',
        data : 'purchase_order_vendor_id='+purchase_order_vendor_id+'&_token='+token,
        beforeSend : function(){},
        success:function(response){
          obj = $.parseJSON(response);
          console.log(obj);

        }
      });
    });

    //ENDBlock purchase order vendor selection

</script>
@endsection