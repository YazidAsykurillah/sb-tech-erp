@extends('layouts.app')

@section('page_title')
  Purchase Order Vendor
@endsection

@section('page_header')
  <h1>
    Purchase Order Vendor
    <small>Purchase Order Vendor Detail</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('purchase-order-vendor') }}"><i class="fa fa-bookmark-o"></i> PO Vendor</a></li>
    <li><i></i> {{ $po_vendor->code }}</li>
    <li class="active"><i></i> Detail</li>
  </ol>
@endsection

@section('content')
  <div class="row">
    <div class="col-md-8">
      <!--BOX Basic Informations-->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-book"></i>&nbsp;Purchase Order Vendor Detail</h3>
          <span class="pull-right">
            @if(\Auth::user()->can('edit-purchase-order-vendor'))
            <a href="{{ URL::to('purchase-order-vendor/'.$po_vendor->id.'/edit')}}" class="btn btn-success btn-xs" title="Edit">
              <i class="fa fa-edit"></i>&nbsp;Edit
            </a>
            @endif
            <a href="{{ URL::to('purchase-order-vendor/'.$po_vendor->id.'/print_pdf')}}" class="btn btn-default btn-xs" title="Print PDF">
              <i class="fa fa-print"></i>&nbsp;Print
            </a>
          </span>
        </div><!-- /.box-header -->
        <div class="box-body">
          <div class="table-responsive">
            <table class="table">

              <tr>
                <td style="width: 20%;"><strong>PO Number</strong></td>
                <td style="width: 1%;">:</td>
                <td>{{ $po_vendor->code }}</td>
              </tr>
              <tr>
                <td style="width: 20%;"><strong>Vendor Name</strong></td>
                <td style="width: 1%;">:</td>
                <td>{{ $po_vendor->vendor ? $po_vendor->vendor->name : "" }}</td>
              </tr>
              <tr>
                <td style="width: 20%;"><strong>Description</strong></td>
                <td style="width: 1%;">:</td>
                <td>{{ $po_vendor->description }}</td>
              </tr>
              <tr>
                <td style="width: 20%;"><strong>Items</strong></td>
                <td style="width: 1%;">:</td>
                <td>
                  <table class="table">
                    <thead>
                      <tr>
                        <th>Item</th>
                        <th style="width:15%;">Qty</th>
                        <th style="width:15%;">Unit</th>
                        <th style="width:20%;">Price/Unit</th>
                        <th style="width:20%;">Sub Amount</th>
                        <th style="width:20%;">Is Received</th>
                      </tr>
                    </thead>
                    <tbody>
                      @if(count($items))
                        @foreach($items as $item)
                        <tr>
                          <td>{{ $item->item }}</td>
                          <td>{{ $item->quantity }}</td>
                          <td>{{ $item->unit }}</td>
                          <td>{{ number_format($item->price, 2) }}</td>
                          <td>{{ number_format($item->sub_amount, 2) }}</td>
                          <td>
                            <input type="checkbox" class="is_received_checker" data-id="{{ $item->id }}" {{ $item->is_received == TRUE ? 'checked' : '' }}  />
                          </td>
                        </tr>
                        @endforeach
                      @else
                        <tr>
                          <td colspan="6">There's no item data</td>
                        </tr>
                      @endif
                    </tbody>
                  </table>
                </td>
              </tr>
              
              @if($po_vendor->purchase_request)
              <tr>
                <td style="width: 20%;"><strong>Discount</strong></td>
                <td style="width: 1%;">:</td>
                <td>{{ $po_vendor->purchase_request->discount }} %</td>
              </tr>
              <tr>
                <td style="width: 20%;"><strong>Sub Total</strong></td>
                <td style="width: 1%;">:</td>
                <td>{{ number_format($po_vendor->purchase_request->after_discount) }}</td>
              </tr> 
              <tr>
                <td style="width: 20%;"><strong>After Discount</strong></td>
                <td style="width: 1%;">:</td>
                <td>{{ number_format($po_vendor->purchase_request->after_discount) }}</td>
              </tr>
              <tr>
                <td style="width: 20%;"><strong>VAT {{ $po_vendor->purchase_request->vat }} %</strong></td>
                <td style="width: 1%;">:</td>
                <td>{{ number_format($po_vendor->purchase_request->vat_value()) }}</td>
              </tr>
              <tr>
                <td style="width: 20%;"><strong>WHT</strong></td>
                <td style="width: 1%;">:</td>
                <td>{{ number_format($po_vendor->purchase_request->wht) }}</td>
              </tr>
              <tr>
                <td style="width: 20%;"><strong>Terms</strong></td>
                <td style="width: 1%;">:</td>
                <td>{!! $po_vendor->purchase_request->terms !!}</td>
              </tr>
              @endif
              <tr>
                <td style="width: 20%;"><strong>Amount</strong></td>
                <td style="width: 1%;">:</td>
                <td>{{ number_format($po_vendor->amount) }}</td>
              </tr>
              <tr>
                <td style="width: 20%;"><strong>Status</strong></td>
                <td style="width: 1%;">:</td>
                <td>
                  {!! ucwords($po_vendor->status) !!}
                  @if(\Auth::user()->can('change-purchase-order-vendor-status'))
                    <a href="#" id="btn-change-status" data-id="{{ $po_vendor->id }}" data-text="{{ $po_vendor->code }}" class="btn btn-link">
                      <i class="fa fa-cog"></i>&nbsp;Change Status
                    </a>
                  @endif
                </td>
              </tr>
            </table>
          </div>
          
        </div><!-- /.box-body -->
      </div>
      <!--ENDBOX Basic Informations-->
      
    </div>

    <div class="col-md-4">
      <!--Box Purchase Request Information-->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-tag"></i>&nbsp;Purchase Request Information</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          @if($po_vendor->purchase_request)
            <strong>Purchase Request Number</strong>
            <p class="text-muted">
              @if($po_vendor->purchase_request)
                <a href="{{ url('purchase-request/'.$po_vendor->purchase_request->id.'') }}">
                  {{ $po_vendor->purchase_request->code }}
                </a>
              @endif
            </p>
            <strong>Amount</strong>
            <p class="text-muted">
              @if($po_vendor->purchase_request)
                {{ number_format($po_vendor->purchase_request->amount, 2) }}
              @endif
            </p>
          @endif
        </div><!-- /.box-body -->

      </div>
      <!--ENDBOX Purchase Request Information-->

      <!--BOX Migo-->
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-book"></i> Migo</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          @if($po_vendor->purchase_request->migo)
            <p>Code</p>
            <p class="text-muted">
              {{ $po_vendor->purchase_request->migo->code }}
            </p>
            <p>Description</p>
            <p class="text-muted">
              {{ $po_vendor->purchase_request->migo->description }}
            </p>
          @else
            <p class="text text-warning"><i class="fa fa-info-circle"></i> Not Registered</p>
            <a href="javascript::void();" id="btn-register-migo" class="btn btn-default btn-sm">
              Register
            </a>
          @endif
        </div><!-- /.box-body -->
      </div>
      <!--ENDBOX Migo-->

      <!--Box Project Information-->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-legal"></i>&nbsp;Project Information</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          <strong>Project Number</strong>
          <p class="text-muted">
            @if($po_vendor->purchase_request)
              <a href="{{ url('project/'.$po_vendor->purchase_request->project->id.'') }}">
                {{ $po_vendor->purchase_request->project->code }}
              </a>
            @endif
          </p>
          <strong>Project Name</strong>
          <p class="text-muted">
            @if($po_vendor->purchase_request)
              {{ $po_vendor->purchase_request->project->name }}
            @endif
          </p>
        </div><!-- /.box-body -->
      </div>
      <!--ENDBox Project Information-->
      <!--BOX Invoice Vendors-->
      <div class="box box-primary">
        <div class="box-header with-border">
          <div class="pull-left">
            <h3 class="box-title"><i class="fa fa-credit-card"></i>&nbsp;Invoice Vendors</h3>
          </div>
          <div class="pull-right">
            <!-- 
            <a href="{{ url('invoice-vendor/create-from-pov/?pov_id='.$po_vendor->id.'') }}" class="btn btn-default btn-xs" title="Click to create invoice vendor from this PO Vendor">
              <i class="fa fa-plus"></i> Add
            </a>
             -->
          </div>
          
        </div><!-- /.box-header -->
        <div class="box-body">
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th style="width:20%;">Invoice Number</th>
                  <th style="width:10%;">Type</th>
                  <th style="width:40%;text-align:right;">Amount</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                @if($po_vendor->invoice_vendor->count())
                  @foreach($po_vendor->invoice_vendor as $invoice_vendor)
                  <tr>
                    <td>
                      <a href="{{ url('invoice-vendor/'.$invoice_vendor->id.'') }}">
                        {{ $invoice_vendor->code }}
                      </a>
                    </td>
                    <td>
                      @if($invoice_vendor->bill_amount !=0)
                        Billing
                      @else
                      {{ $invoice_vendor->type }} ( {{$invoice_vendor->type_percent }} %)
                      @endif
                    </td>
                    <td style="text-align:right;">
                      @if($invoice_vendor->bill_amount == NULL)
                        {{ number_format($invoice_vendor->amount, 2) }}
                      @else
                        {{ number_format($invoice_vendor->bill_amount, 2) }}
                      @endif
                    </td>
                    <td>{{ $invoice_vendor->status }}</td>
                  </tr>
                  @endforeach
                @endif
              </tbody>
              <tfoot>
                <tr>
                  <td colspan="2">
                    <strong>Total Paid</strong>
                  </td>
                  <td style="text-align:right;">
                    <strong>{{ number_format($po_vendor->paid_invoice_vendor(), 2) }}</strong>
                  </td>
                </tr>
                <tr>
                  <td colspan="2">
                    <strong>Total Pending</strong>
                  </td>
                  <td style="text-align:right;">
                    <strong>{{ number_format($po_vendor->pending_invoice_vendor(), 2) }}</strong>
                  </td>
                </tr>
                <tr>
                  <td colspan="2">
                    <strong>Total Uninvoiced Amount</strong>
                  </td>
                  <td style="text-align:right;">
                    <strong>{{ number_format($po_vendor->UnInvoicedAmount, 2) }}</strong>
                  </td>
                </tr>
                <tr>
                  <td colspan="2">
                    <strong>Invoice Vendor Due</strong>
                  </td>
                  <td style="text-align:right;">
                    <strong>{{ number_format($po_vendor->invoice_vendor_due, 2) }}</strong>
                  </td>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
      </div>
      <!--ENDBOX Invoice Vendors-->

    </div>
    

  </div>

  <!--Modal CHANGE STATUS-->
  <div class="modal fade" id="modal-change-status" tabindex="-1" role="dialog" aria-labelledby="modal-change-statusLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      {!! Form::open(['url'=>'purchase-order-vendor/change-status', 'method'=>'post']) !!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="modal-change-statusLabel">Change Status</h4>
        </div>
        <div class="modal-body">
          <p class="alert alert-info">
            <i class="fa fa-info-circle"></i>&nbsp;Select the status
          </p>
          {!! Form::label('status', 'Status', ['class'=>'col-sm-2 control-label']) !!}
          <div class="col-sm-10">
            {{ Form::select('status', ['uncompleted'=>'Uncompleted', 'completed'=>'Completed'], $po_vendor->status, ['class'=>'form-control', 'id'=>'status']) }}
          </div>
          <br/>
        </div>
        <div class="modal-footer">
          <input type="hidden" id="purchase_order_vendor_id" name="purchase_order_vendor_id">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Change</button>
        </div>
      {!! Form::close() !!}
      </div>
    </div>
  </div>
<!--ENDModal CHANGE STATUS-->

<!--Modal register migo-->
  <div class="modal fade" id="modal-register-migo" tabindex="-1" role="dialog" aria-labelledby="modal-register-migoLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      {!! Form::open(['route'=>'migo.store','role'=>'form','class'=>'form-horizontal','id'=>'form-create-migo','files'=>true]) !!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="modal-register-migoLabel">Register Migo</h4>
        </div>
        <div class="modal-body">
          <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
            {!! Form::label('description', 'Description', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {!! Form::textarea('description',null,['class'=>'form-control', 'placeholder'=>'Migo description', 'id'=>'description']) !!}
              @if ($errors->has('description'))
                <span class="help-block">
                  <strong>{{ $errors->first('description') }}</strong>
                </span>
              @endif
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <input type="hidden" id="pr_id" name="pr_id" value="{{$po_vendor->purchase_request->id}}"/>
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary" id="btn-submit-register-migo">Register</button>
        </div>
      {!! Form::close() !!}
      </div>
    </div>
  </div>
  <!--ENDModal register migo-->
@endsection

@section('additional_scripts')
  <script type="text/javascript">
    //Block Change Status
    $('#btn-change-status').on('click', function(event){
      event.preventDefault();
      $('#purchase_order_vendor_id').val($(this).attr('data-id'));
      $('#modal-change-status').modal('show');
    });
    //ENDBlock Change Status

    //Is received checker handling
    $('.is_received_checker').on('click', function(){
      var ipr_id = $(this).attr('data-id');
      var mode = "";
      var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
      console.log(CSRF_TOKEN);
      if($(this).is(":checked")){
        mode = "checked";
      }
      else if($(this).is(":not(:checked)")){
        mode = "unchecked";
      }
      $.ajax({
        url : '{!! url('updateItemPurchaseRequestIsReceived') !!}',
        type : 'POST',
        data : 'ipr_id='+ipr_id+'&mode='+mode+'&_token='+CSRF_TOKEN,
        beforeSend : function(){},
        success : function(response){
          console.log(response);
        }
      });
    });

    //Block Register migo handling
    $('#btn-register-migo').on('click', function(event){
      event.preventDefault();
      $('#modal-register-migo').modal('show');
    });
    //EndBlock Register migo handling

  </script>
@endsection