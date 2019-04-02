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
    <div class="col-md-9">
      <!--BOX Basic Informations-->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-book"></i>&nbsp;Purchase Order Vendor Detail</h3>
          <span class="pull-right">
            <a href="{{ URL::to('purchase-order-vendor/'.$po_vendor->id.'/edit')}}" class="btn btn-success btn-xs" title="Edit">
              <i class="fa fa-edit"></i>&nbsp;Edit
            </a>
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
                <td>{{ $po_vendor->vendor->name }}</td>
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
                <td>{{ number_format($po_vendor->sub_amount) }}</td>
              </tr>
              <tr>
                <td style="width: 20%;"><strong>Discount</strong></td>
                <td style="width: 1%;">:</td>
                <td>{{ $po_vendor->discount }} %</td>
              </tr>
              <tr>
                <td style="width: 20%;"><strong>After Discount</strong></td>
                <td style="width: 1%;">:</td>
                <td>{{ number_format($po_vendor->after_discount) }}</td>
              </tr>
              <tr>
                <td style="width: 20%;"><strong>VAT</strong></td>
                <td style="width: 1%;">:</td>
                <td>{{ number_format($po_vendor->vat / 100 * $po_vendor->sub_amount) }}</td>
              </tr>
              <tr>
                <td style="width: 20%;"><strong>Amount</strong></td>
                <td style="width: 1%;">:</td>
                <td>{{ number_format($po_vendor->amount) }}</td>
              </tr>
              <tr>
                <td style="width: 20%;"><strong>Terms</strong></td>
                <td style="width: 1%;">:</td>
                <td>{!! $po_vendor->terms !!}</td>
              </tr>
            </table>
          </div>
          
        </div><!-- /.box-body -->
      </div>
      <!--ENDBOX Basic Informations-->
    </div>

   
    <div class="col-md-3">
      <!--Box Purchase Request Information-->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-tag"></i>&nbsp;Purchase Request Information</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          <strong>Purchase Request Number</strong>
          <p class="text-muted">
            @if($po_vendor->purchase_request)
              {{ $po_vendor->purchase_request->code }}
            @endif
          </p>
          <strong>Description</strong>
          <p class="text-muted">
            @if($po_vendor->purchase_request)
              {{ $po_vendor->purchase_request->description }}
            @endif
          </p>
          <strong>Amount</strong>
          <p class="text-muted">
            @if($po_vendor->purchase_request)
              {{ $po_vendor->purchase_request->amount }}
            @endif
          </p>
        </div><!-- /.box-body -->
      </div>
      <!--ENDBOX Purchase Request Information-->

      <!--Box Project Information-->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-legal"></i>&nbsp;Project Information</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          <strong>Project Number</strong>
          <p class="text-muted">
            @if($po_vendor->purchase_request)
              {{ $po_vendor->purchase_request->project->code }}
            @endif
          </p>
          <strong>Project Name</strong>
          <p class="text-muted">
            @if($po_vendor->purchase_request)
              {{ $po_vendor->purchase_request->project->name }}
            @endif
          </p>
          <strong>Sales Name</strong>
          <p class="text-muted">
            @if($po_vendor->purchase_request)
              {{ $po_vendor->purchase_request->project->sales->name }}
            @endif
          </p>
          
        </div><!-- /.box-body -->
      </div>
      <!--ENDBox Project Information-->
      
    </div>
    

  </div>
@endsection

@section('additional_scripts')
 
@endsection