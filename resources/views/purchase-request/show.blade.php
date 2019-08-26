@extends('layouts.app')

@section('page_title')
    Purchase Request
@endsection

@section('page_header')
  <h1>
    Purchase Request
    <small>Purchase Request Detail</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('purchase-request') }}"><i class="fa fa-tag"></i> Purchase Request</a></li>
    <li><i></i> {{ $purchase_request->code }}</li>
    <li class="active"><i></i> Detail</li>
  </ol>
@endsection

@section('content')
  
  <div class="row">
    <div class="col-md-8">
      <!--BOX Basic Informations-->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-tag"></i> Purchase Request Information</h3>
          @if($purchase_request->status == 'pending')
          <a href="{{ URL::to('purchase-request/'.$purchase_request->id.'/edit')}}" class="btn btn-success btn-xs pull-right" title="Edit">
            <i class="fa fa-edit"></i>&nbsp;Edit
          </a>
          @endif
        </div><!-- /.box-header -->
        <div class="box-body">
          <div class="table-responsive">
            <table class="table">

              <tr>
                <td style="width: 20%;">Purchase Request Number</td>
                <td style="width: 1%;">:</td>
                <td>{{ $purchase_request->code }}</td>
              </tr>
             
              <tr>
                <td style="width: 20%;">Project Number</td>
                <td style="width: 1%;">:</td>
                <td>
                  @if($purchase_request->project)
                    {{ $purchase_request->project->code }}
                  @endif
                </td>
              </tr>
              <tr>
                <td style="width: 20%;">Description</td>
                <td style="width: 1%;">:</td>
                <td>{{ $purchase_request->description }}</td>
              </tr>
              <tr>
                <td style="width: 20%;">Item(s)</td>
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
                            <!--Show checkbox if only this purchase request has purchase order vendor related-->
                            @if($purchase_request->purchase_order_vendor)
                            <input type="checkbox" class="is_received_checker" data-id="{{ $item->id }}" {{ $item->is_received == TRUE ? 'checked' : '' }}  />
                            @endif
                          </td>
                        </tr>
                        @endforeach
                      @else
                        <tr>
                          <td colspan="5">There's no item data</td>
                        </tr>
                      @endif
                    </tbody>
                  </table>
                </td>
              </tr>
              <tr>
                <td style="width: 20%;"><strong>Sub Total</strong></td>
                <td style="width: 1%;">:</td>
                <td>{{ number_format($purchase_request->after_discount) }}</td>
              </tr>
              <tr>
                <td style="width: 20%;"><strong>Discount</strong></td>
                <td style="width: 1%;">:</td>
                <td>{{ $purchase_request->discount }} %</td>
              </tr>
              <tr>
                <td style="width: 20%;"><strong>After Discount</strong></td>
                <td style="width: 1%;">:</td>
                <td>{{ number_format($purchase_request->after_discount) }}</td>
              </tr>
              <tr>
                <td style="width: 20%;"><strong>VAT</strong></td>
                <td style="width: 1%;">:</td>
                <td>
                  {{ number_format($purchase_request->vat_value()) }}
                </td>
              </tr>
              <tr>
                <td style="width: 20%;"><strong>WHT</strong></td>
                <td style="width: 1%;">:</td>
                <td>{{ number_format($purchase_request->wht) }}</td>
              </tr>
              <tr>
                <td style="width: 20%;"><strong>Amount</strong></td>
                <td style="width: 1%;">:</td>
                <td>{{ number_format($purchase_request->amount) }}</td>
              </tr>
              <tr>
                <td style="width: 20%;"><strong>Created Date</strong></td>
                <td style="width: 1%;">:</td>
                <td>{{ jakarta_date_time($purchase_request->created_at) }}</td>
              </tr>
              <tr>
                <td style="width: 20%;"><strong>Status</strong></td>
                <td style="width: 1%;">:</td>
                <td>
                  {{ ucwords($purchase_request->status) }}
                  <?php $user_role = \Auth::user()->roles->first()->code; ?>
                  @if($user_role == 'SUP' || $user_role=='ADM' || $user_role == 'FIN' )
                    <a href="#" id="btn-change-status" data-id="{{ $purchase_request->id }}" data-text="{{ $purchase_request->code }}" class="btn btn-link">
                      <i class="fa fa-cog"></i>&nbsp;Change Status
                    </a>
                  @endif
                </td>
              </tr>
              <tr>
                <td style="width: 20%;"><strong>Terms</strong></td>
                <td style="width: 1%;">:</td>
                <td>{!! $purchase_request->terms !!}</td>
              </tr>
              <tr>
                <td style="width: 20%;"><strong>Received Items</strong></td>
                <td style="width: 1%;">:</td>
                <td>{!! $purchase_request->received_item_purchase_request->count() !!}</td>
              </tr>
            </table>
          </div>
          
        </div><!-- /.box-body -->
      </div>
      <!--ENDBOX Basic Informations-->
    </div>

    <div class="col-md-4">
      <!--BOX Quotation Vendor Information-->
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-archive"></i> Quotation Vendor</h3>
          
        </div><!-- /.box-header -->
        <div class="box-body">
          @if($purchase_request->quotation_vendor)
            <p>
              <strong>Code</strong>
            </p>
            <p class="text-muted">
              <a href="{{ url('quotation-vendor/'.$purchase_request->quotation_vendor->id.'') }}">
                {{ $purchase_request->quotation_vendor->code }}
              </a>
            </p>
            <p>
              <strong>Vendor Name</strong>
            </p>
            <p class="text-muted">
              <a href="{{ url('the-vendor/'.$purchase_request->quotation_vendor->vendor->id.'') }}">
                {{ $purchase_request->quotation_vendor->vendor->name }}
              </a>
            </p>         
          @endif
        </div><!-- /.box-body -->
      </div>
      <!--ENDBOX Quotation Vendor Information-->
      <!--BOX Purchase Order Vendor Information-->
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-archive"></i> Purchase Order Vendor</h3>
          
        </div><!-- /.box-header -->
        <div class="box-body">
          @if($purchase_request->purchase_order_vendor)
            <p>
              <strong>Code</strong>
            </p>
            <p class="text-muted">
              <a href="{{ url('purchase-order-vendor/'.$purchase_request->purchase_order_vendor->id.'') }}">
                {{ $purchase_request->purchase_order_vendor->code }}
              </a>
            </p>
            <p>
              <strong>Amount</strong>
            </p>
            <p class="text-muted">
              {{ number_format($purchase_request->purchase_order_vendor->amount) }}
            </p>
          @endif
        </div><!-- /.box-body -->
      </div>
      <!--ENDBOX Purchase Order Vendor Information-->

      <!--BOX Migo-->
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-book"></i> Migo</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          @if($purchase_request->migo)
            <p>Code</p>
            <p class="text-muted">
              {{ $purchase_request->migo->code }}
            </p>
            <p>Description</p>
            <p class="text-muted">
              {{ $purchase_request->migo->description }}
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
    </div>
  </div>

  <!--Modal CHANGE STATUS-->
  <div class="modal fade" id="modal-change-status" tabindex="-1" role="dialog" aria-labelledby="modal-change-statusLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      {!! Form::open(['url'=>'changePurchaseRequestStatus', 'method'=>'post']) !!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="modal-change-statusLabel">Change Status</h4>
        </div>
        <div class="modal-body">
          <p class="alert alert-info">
            <i class="fa fa-info-circle"></i>&nbsp;Select to change Purchase Request Status
          </p>
          {!! Form::label('status', 'Status', ['class'=>'col-sm-2 control-label']) !!}
          <div class="col-sm-10">
            {{ Form::select('status', $status_opts, $purchase_request->status, ['class'=>'form-control', 'id'=>'status']) }}
          </div>
          <br/>
        </div>
        <div class="modal-footer">
          <input type="hidden" id="purchase_request_id" name="purchase_request_id">
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
          <input type="hidden" id="pr_id" name="pr_id" value="{{$purchase_request->id}}"/>
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
      $('#purchase_request_id').val($(this).attr('data-id'));
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