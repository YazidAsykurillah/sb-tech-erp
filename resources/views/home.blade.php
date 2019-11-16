@extends('layouts.app')

@section('page_title')
    Dashboard
@endsection

@section('page_header')
  <h1>
    Dashboard
    <small></small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li class="active"><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
  </ol>
@endsection

@section('content')
  
  <!-- DASHBOARD Super admin and Admin -->
  @if(\Auth::user()->roles->first()->code == 'SUP' || \Auth::user()->roles->first()->code == 'ADM')
  <h3><i class="fa fa-credit-card"></i>&nbsp;Invoice Customer</h3>
  <div class="row">
    <div class="col-md-6">
      <!-- small box -->
      <div class="small-box bg-red">
        <div class="inner">
          <h3>{{ count($invoice_customer_over_due_in_week) }}</h3>

          <p>Overdue Invoice Customer within this week</p>
        </div>
        <div class="icon">
          <i class="fa fa-credit-card"></i>
        </div>
        <a href="{{ URL::to('invoice-customer/in_week_overdue') }}" class="small-box-footer">
          More info <i class="fa fa-arrow-circle-right"></i>
        </a>
      </div>
    </div>
    <!-- ./col -->

    <div class="col-md-6">
      <!-- small box -->
      <div class="small-box bg-red">
        <div class="inner">
          <h3>{{ count($invoice_customer_over_due_over_last_week) }}</h3>

          <p>Overdue Invoice Customer over the last week</p>
        </div>
        <div class="icon">
          <i class="fa fa-credit-card"></i>
        </div>
        <a href="{{ URL::to('invoice-customer/over_last_week_overdue') }}" class="small-box-footer">
          More info <i class="fa fa-arrow-circle-right"></i>
        </a>
      </div>
    </div>
    <!-- ./col -->
  </div>

  <h3><i class="fa fa-credit-card"></i>&nbsp;Invoice Vendor</h3>
  <div class="row">
    <!-- col -->
    <div class="col-md-6">
      <div class="small-box bg-red">
        <div class="inner">
          <h3>{{ count($invoice_vendor_over_due_in_week) }}</h3>
          <p>Overdue Invoice Vendor within this week</p>
        </div>
        <div class="icon">
          <i class="fa fa-credit-card"></i>
        </div>
        <a href="{{ URL::to('transfer-task/invoice-vendor') }}" class="small-box-footer">
          More info <i class="fa fa-arrow-circle-right"></i>
        </a>
      </div>
    </div>
    <!-- ./col -->
     <!-- col -->
    <div class="col-md-6">
      <div class="small-box bg-red">
        <div class="inner">
          <h3>{{ count($invoice_vendor_over_due_over_last_week) }}</h3>

          <p>Overdue Invoice Vendor over the last week</p>
        </div>
        <div class="icon">
          <i class="fa fa-credit-card"></i>
        </div>
        <a href="{{ URL::to('transfer-task/invoice-vendor?type=over_last_week_overdue') }}" class="small-box-footer">
          More info <i class="fa fa-arrow-circle-right"></i>
        </a>
      </div>
    </div>
    <!-- ./col -->
  </div>

  <h3><i class="fa fa-tag"></i>&nbsp;Internal Request</h3>
  <div class="row">
    <div class="col-md-4">
      <!-- small box -->
      <div class="small-box bg-green">
        <div class="inner">
          <h3>{{ count($pending_internal_requests) }}</h3>
          <p>Pending</p>
        </div>
        <div class="icon">
          <i class="fa fa-hourglass-3"></i>
        </div>
        <a href="{{ URL::to('internal-request/pending') }}" class="small-box-footer">
          More info <i class="fa fa-arrow-circle-right"></i>
        </a>
      </div>
    </div>
    <div class="col-md-4">
      <!-- small box -->
      <div class="small-box bg-green">
        <div class="inner">
          <h3>{{ count($checked_internal_requests) }}</h3>
          <p>Checked</p>
        </div>
        <div class="icon">
          <i class="fa fa-list-alt"></i>
        </div>
        <a href="{{ URL::to('internal-request/checked') }}" class="small-box-footer">
          More info <i class="fa fa-arrow-circle-right"></i>
        </a>
      </div>
    </div>
    <div class="col-md-4">
      <!-- small box -->
      <div class="small-box bg-green">
        <div class="inner">
          <h3>{{ count($approved_internal_requests) }}</h3>

          <p>Approved</p>
        </div>
        <div class="icon">
          <i class="fa fa-thumbs-o-up"></i>
        </div>
        <a href="{{ URL::to('internal-request/approved') }}" class="small-box-footer">
          More info <i class="fa fa-arrow-circle-right"></i>
        </a>
      </div>
    </div>
  </div>

  <h3><i class="fa fa-retweet"></i>&nbsp;Settlement</h3>
  <div class="row">
    <div class="col-md-4">
      <div class="small-box bg-blue">
        <div class="inner">
          <h3>{{ count($pending_settlements) }}</h3>

          <p>Pending</p>
        </div>
        <div class="icon">
          <i class="fa fa-hourglass-3"></i>
        </div>
        <a href="{{ URL::to('settlement/pending') }}" class="small-box-footer">
          More info <i class="fa fa-arrow-circle-right"></i>
        </a>
      </div>
    </div>

    <div class="col-md-4">
      <div class="small-box bg-blue">
        <div class="inner">
          <h3>{{ count($checked_settlements) }}</h3>
          <p>Checked</p>
        </div>
        <div class="icon">
          <i class="fa fa-list-alt"></i>
        </div>
        <a href="{{ URL::to('settlement/checked') }}" class="small-box-footer">
          More info <i class="fa fa-arrow-circle-right"></i>
        </a>
      </div>
    </div>

    <div class="col-md-4">
      <div class="small-box bg-blue">
        <div class="inner">
          <h3>{{ count($approved_settlements) }}</h3>
          <p>Approved</p>
        </div>
        <div class="icon">
          <i class="fa fa-thumbs-o-up"></i>
        </div>
        <a href="{{ URL::to('settlement/approved') }}" class="small-box-footer">
          More info <i class="fa fa-arrow-circle-right"></i>
        </a>
      </div>
    </div>

  </div>
  <!-- END DASHBOARD Super admin and Admin -->

  <!-- DASHBOARD Other roles  -->
  @else
  <div class="row">
    <div class="col-md-6">
      <!-- small box -->
      <div class="small-box bg-red">
        <div class="inner">
          <h3>Internal Request</h3>

          <p>Internal Request</p>
        </div>
        <div class="icon">
          <i class="fa fa-credit-card"></i>
        </div>
        <a href="{{ URL::to('internal-request') }}" class="small-box-footer">
          More info <i class="fa fa-arrow-circle-right"></i>
        </a>
      </div>
    </div>
    <!-- ./col -->
  </div>
  @endif

@endsection
