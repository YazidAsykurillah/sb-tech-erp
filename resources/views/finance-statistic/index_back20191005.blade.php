@extends('layouts.app')

@section('page_title')
  Statistik Keuangan
@endsection

@section('page_header')
  <h1>
    Statistik Keuangan
    <small></small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('finance-statistic') }}"><i class="fa fa-line-chart"></i> Statistik Keuangan</a></li>
    <li class="active"><i></i> Index</li>
  </ol>
@endsection

@section('content')
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary box-solid">
        <div class="box-header with-border">
          <h3 class="box-title">Data Sources</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
            </button>
          </div>
          <!-- /.box-tools -->
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <!--List Group Project-->
          <ul class="list-group">
            <li class="list-group-item">
              <strong>A. Project</strong>
            </li>
            <li class="list-group-item">
              <span class="badge bg-green">{{ number_format($tot_not_invoiced_from_pro, 2) }}</span>
              Not Invoiced <small><i>(Total NOT Invoiced amount from projects)</i></small>
            </li>
            
          </ul>
          <!--ENDList Group Project-->

          <!--List Group Invoice Customer-->
          <ul class="list-group">
            <li class="list-group-item">
              <strong>B. Invoice Customer</strong>
            </li>
            <li class="list-group-item">
              <span class="badge bg-green">{{ number_format($tot_pending_invoice_customer, 2) }}</span>
              Total amount of Invoice Customers that the status is pending
            </li>
          </ul>
          <!--ENDList Group Invoice Customer-->

          <!--List Group Invoice Vendor-->
          <ul class="list-group">
            <li class="list-group-item">
              <strong>C. Invoice Vendor</strong>
            </li>
            <li class="list-group-item">
              <span class="badge bg-green">{{ number_format($tot_pending_invoice_vendor, 2) }}</span>
              Total amount of Invoice Vendors that the status is pending
            </li>
          </ul>
          <!--ENDList Group Invoice Vendor-->

          <!--List Group Purchase Order Vendor-->
          <ul class="list-group">
            <li class="list-group-item">
              <strong>D. Purchase Order Vendor</strong>
            </li>
            <li class="list-group-item">
              <span class="badge bg-green">{{ number_format($tot_purchase_order_vendor_amount, 2) }}</span>
              Total Amount Purchase Order Vendor
            </li>
            <li class="list-group-item">
              <span class="badge bg-green">{{ number_format($tot_invoice_vendor_amount, 2) }}</span>
              Total Amount Invoice Vendor
            </li>
            <li class="list-group-item">
              <span class="badge bg-green">{{ number_format($tot_purchase_order_vendor_amount - $tot_invoice_vendor_amount, 2) }}</span>
              Total amount of Purchase Order Vendor that are NOT invoiced
            </li>
          </ul>
          <!--ENDList Group Purchase Order Vendor-->

          <!--List Group Cash-->
          <ul class="list-group">
            <li class="list-group-item">
              <strong>E. Cash</strong>
            </li>
            <li class="list-group-item">
              <span class="badge bg-green">{{ number_format($tot_cash_amounts, 2) }}</span>
              All cash amount
            </li>
          </ul>
          <!--ENDList Group Cash-->

          <!--List Group TAXES-->
          <ul class="list-group">
            <li class="list-group-item">
              <strong>F. TAXES</strong>
            </li>
            <li class="list-group-item">
              <span class="badge bg-green">{{ number_format($tot_invoice_customer_tax_amount, 2) }}</span>
              Invoice Customer Taxes Amount
            </li>
            <li class="list-group-item">
              <span class="badge bg-green">{{ number_format($tot_invoice_vendor_tax_amount, 2) }}</span>
              Invoice Vendor Taxes Amount
            </li>
            <li class="list-group-item">
              <span class="badge bg-green">{{ number_format($tax_balance, 2) }}</span>
              Tax Balance
            </li>
          </ul>
          <!--ENDList Group TAXES-->
          <hr>

          <ul class="list-group">
            <li class="list-group-item">
              <span class="badge bg-blue">
                {{ number_format($balance, 2) }}
              </span>
              <strong>Balance</strong>
            </li>
          </ul>

        </div>
        <!-- /.box-body -->
      </div> 
    </div>
  </div>
@endsection

@section('additional_scripts')

@endsection