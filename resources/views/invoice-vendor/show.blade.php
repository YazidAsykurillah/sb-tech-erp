@extends('layouts.app')

@section('page_title')
    Invoice Vendor
@endsection

@section('page_header')
  <h1>
    Invoice Vendor
    <small>Detail Invoice Vendor</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('invoice-vendor') }}"><i class="fa fa-credit-card"></i> Invoice Vendor</a></li>
    <li><i></i> {{ $invoice_vendor->code }}</li>
    <li class="active"><i></i> Detail</li>
  </ol>
@endsection
  
@section('content')
  <div class="row">
    <div class="col-md-8">
      <!--BOX Basic Informations-->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-credit-card"></i>&nbsp;Invoice Vendor Information</h3>
          @if($invoice_vendor->status != 'paid')
          <a href="{{ URL::to('invoice-vendor/'.$invoice_vendor->id.'/edit')}}" class="btn btn-success btn-xs pull-right" title="Edit">
                <i class="fa fa-edit"></i>&nbsp;Edit
          </a>
          @endif
        </div><!-- /.box-header -->
        <div class="box-body">
          <div class="table-responsive">
            <table class="table">
              
              <tr>
                <td style="width: 20%;">Invoice Vendor Number</td>
                <td style="width: 1%;">:</td>
                <td>{{ $invoice_vendor->code }}</td>
              </tr>
              <tr>
                <td style="width: 20%;">Type</td>
                <td style="width: 1%;">:</td>
                <td>
                  @if($invoice_vendor->type == 'billing')
                    {{ $invoice_vendor->type }} &nbsp; ( {{ number_format($invoice_vendor->bill_amount) }} )
                  @else
                    {{ $invoice_vendor->type }} &nbsp; ( {{$invoice_vendor->type_percent}} %)
                  @endif
                  
                </td>
              </tr>
              <tr>
                <td style="width: 20%;">Tax Number</td>
                <td style="width: 1%;">:</td>
                <td>{{ $invoice_vendor->tax_number }}</td>
              </tr>
              <tr>
                <td style="width: 20%;">Tax Date</td>
                <td style="width: 1%;">:</td>
                <td>{{ $invoice_vendor->tax_date }}</td>
              </tr>
              <tr>
                <td style="width: 20%;">Sub Total</td>
                <td style="width: 1%;">:</td>
                <td>{{ number_format($invoice_vendor->sub_total, 2) }}</td>
              </tr>
              <tr>
                <td style="width: 20%;">Discount</td>
                <td style="width: 1%;">:</td>
                <td>{{ $invoice_vendor->discount }} %</td>
              </tr>
              <tr>
                <td style="width: 20%;">After Discount</td>
                <td style="width: 1%;">:</td>
                <td>{{ number_format($invoice_vendor->after_discount, 2) }}</td>
              </tr>
              <tr>
                <td style="width: 20%;">VAT</td>
                <td style="width: 1%;">:</td>
                <td>{{ $invoice_vendor->vat }} %</td>
              </tr>
              <tr>
                <td style="width: 20%;">VAT Amount</td>
                <td style="width: 1%;">:</td>
                <td>{{ number_format($invoice_vendor->vat_amount, 2) }}</td>
              </tr>
              <tr>
                <td style="width: 20%;">WHT Amount</td>
                <td style="width: 1%;">:</td>
                <td>{{ number_format($invoice_vendor->wht_amount, 2) }}</td>
              </tr>
              <tr>
                <td style="width: 20%;">Amount</td>
                <td style="width: 1%;">:</td>
                <td>
                  @if($invoice_vendor->bill_amount == NULL)
                    {{ number_format($invoice_vendor->amount, 2) }}
                  @else
                    {{ number_format($invoice_vendor->bill_amount, 2) }}
                  @endif
                </td>
              </tr>
              <tr>
                <td style="width: 20%;">Received Date</td>
                <td style="width: 1%;">:</td>
                <td>{{ $invoice_vendor->received_date }}</td>
              </tr>
              <tr>
                <td style="width: 20%;">Due Date</td>
                <td style="width: 1%;">:</td>
                <td>{{ $invoice_vendor->due_date }}</td>
              </tr>
              <tr>
                <td style="width: 20%;">Status</td>
                <td style="width: 1%;">:</td>
                <td>
                  {{ $invoice_vendor->status }}
                </td>
              </tr>
              <tr>
                <td style="width: 20%;">Paid From</td>
                <td style="width: 1%;">:</td>
                <td>
                  {{ $invoice_vendor->remitter_bank ? $invoice_vendor->remitter_bank->name : NULL  }}
                </td>
              </tr>
            </table>
          </div>
          
        </div><!-- /.box-body -->
      </div>
      <!--ENDBOX Basic Informations-->
      <!--BOX Logs Information-->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-list-alt"></i>&nbsp;Logs</h3>
        </div>
        <div class="box-body">
          @if($the_logs->count() > 0)
            <table class="table table-striped">
            <thead>
                <tr>
                  <th style="width:20%;">Datetime</th>
                  <th style="width:20%;">User</th>
                  <th>Mode</th>
                  <th>Description</th>
                </tr>
              </thead>
            @foreach($the_logs as $the_log)
              <tr>
                <td>{{ jakarta_date_time($the_log->created_at) }}</td>
                <td>{{ $the_log->user->name }}</td>
                <td>{{ $the_log->mode }}</td>
                <td>{{ $the_log->description }}</td>
              </tr>
            @endforeach
            </table>
          @endif
        </div>
      </div>
      <!--ENDBOX Logs Information-->
    </div>

    <div class="col-md-4">

      <!--Box Vendor Information-->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-child"></i>&nbsp;Vendor Information</h3>
        </div>
        <div class="box-body">
          <strong>Vendor Name</strong>
          <p class="text-muted">
            @if($invoice_vendor->purchase_order_vendor)
              @if($invoice_vendor->purchase_order_vendor->vendor)
                {{ $invoice_vendor->purchase_order_vendor->vendor->name }}
              @endif
            @endif
          </p>
        </div>
      </div>
      <!--ENDBOX Vendor Information-->

      <!--Box Purchase Order Vendor Information-->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-bookmark-o"></i>&nbsp;Purchase Order Vendor Information</h3>
        </div>
        <div class="box-body">
          <strong>PO Vendor Code</strong>
          <p class="text-muted">
            @if($invoice_vendor->purchase_order_vendor)
              <a href="{{ url('purchase-order-vendor/'.$invoice_vendor->purchase_order_vendor->id.'') }}">
                {{ $invoice_vendor->purchase_order_vendor->code }}
              </a>
            @endif
          </p>
          <strong>Description</strong>
          <p class="text-muted">
            @if($invoice_vendor->purchase_order_vendor)
              {{ $invoice_vendor->purchase_order_vendor->description }}
            @endif
          </p>
          <strong>Amount</strong>
          <p class="text-muted">
            @if($invoice_vendor->purchase_order_vendor)
              {{ number_format($invoice_vendor->purchase_order_vendor->amount) }}
            @endif
          </p>
        </div>
      </div>
      <!--ENDBOX Purchase Order Vendor Information-->

      <!--Box Purchase Request Information-->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-bookmark-o"></i>&nbsp;Purchase Request Information</h3>
        </div>
        <div class="box-body">
          @if($purchase_request)
            <strong>Purchase Request Code</strong>
            <p class="text-muted">
              <a href="{{ url('purchase-request/'.$purchase_request->id.'') }}">
                  {{ $purchase_request->code }}
              </a>
            </p>
            <strong>Amount</strong>
            <p class="text-muted">
              {{ number_format($purchase_request->amount) }}
            </p>
            <strong>Migo</strong>
            <p class="text-muted">
              {{ $purchase_request->migo ? $purchase_request->migo->code : NULL}}
            </p>
          @endif
        </div>
      </div>
      <!--ENDBOX Purchase Request Information-->

      
      <!--Box Project Information-->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-legal"></i>&nbsp;Project Information</h3>
        </div>
        <div class="box-body">
          <strong>Project Code</strong>
          <p class="text-muted">
            @if($invoice_vendor->project)
              <a href="{{ url('project/'.$invoice_vendor->project->id.'') }}">
                {{ $invoice_vendor->project->code }}
              </a>
            @endif
          </p>
          <strong>Project Name</strong>
          <p class="text-muted">
            @if($invoice_vendor->project)
              {{ $invoice_vendor->project->name }}
            @endif
          </p>
          <strong>Purchase Order Customer</strong>
          <p class="text-muted">
            @if($invoice_vendor->project)
              {{ $invoice_vendor->project->purchase_order_customer ? $invoice_vendor->project->purchase_order_customer->code : "" }}
            @endif
          </p>
        </div>
      </div>
      <!--ENDBOX Project Information-->

      
    </div>
  </div>

@endsection

@section('additional_scripts')
  
@endsection