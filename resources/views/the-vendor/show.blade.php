@extends('layouts.app')

@section('page_title')
    Vendor | Detail
@endsection

@section('page_header')
  <h1>
    Vendor
    <small>Vendor Detail</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('the-vendor') }}"><i class="fa fa-child"></i> Vendor</a></li>
    <li class="active"><i></i> {{ $vendor->name }}</li>
  </ol>
@endsection

@section('content')
  <div class="row">
    <div class="col-md-12">
      <!--BOX Basic Informations-->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-child"></i>&nbsp;Vendor Detail</h3>
          <a href="{{ URL::to('the-vendor/'.$vendor->id.'/edit')}}" class="btn btn-success btn-xs pull-right" title="Edit">
                <i class="fa fa-edit"></i>&nbsp;Edit
          </a>
        </div><!-- /.box-header -->
        <div class="box-body">
          <div class="table-responsive">
            <table class="table">

              <tr>
                <td style="width: 20%;">Vendor Name</td>
                <td style="width: 1%;">:</td>
                <td>{{ $vendor->name }}</td>
              </tr>
              <tr>
                <td style="width: 20%;">Product Name</td>
                <td style="width: 1%;">:</td>
                <td>{{ $vendor->product_name }}</td>
              </tr>
              <tr>
                <td style="width: 20%;">Bank Account</td>
                <td style="width: 1%;">:</td>
                <td>{{ $vendor->bank_account }}</td>
              </tr>
              
            </table>
          </div>
          
        </div><!-- /.box-body -->
      </div>
      <!--ENDBOX Basic Informations-->
    </div>
    
  </div>
  <div class="row">
    <div class="col-md-12">
      <!--BOX Invoice Vendor Informations-->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-credit-card"></i>&nbsp;Invoice Vendor Information</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="table-invoice-vendor">
              <thead>
                <tr>
                  <th style="width:5%;">#</th>
                  <th style="width:15%;">Invoice Number</th>
                  <th>Tax Number</th>
                  <th>Project Number</th>
                  <th style="text-align:right;">Amount</th>
                  <th>Received Date</th>
                  <th>Due Date</th>
                  <th>Status</th>
                </tr>
              </thead>
              <thead id="searchColumn">
                <tr>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th style="text-align:right;"></th>
                  <th></th>
                  <th></th>
                  <th></th>
                </tr>
              </thead>
              
              <tbody>

             @if(count($vendor->invoice_vendors))
                @foreach($vendor->invoice_vendors as $invoice_vendor)
                <tr>
                  <td></td>
                  <td>{{ $invoice_vendor->code }}</td>
                  <td>{{ $invoice_vendor->tax_number }}</td>
                  <td>{{ $invoice_vendor->project->code }}</td>
                  <td style="text-align:right;">{{ number_format($invoice_vendor->amount, 2) }}</td>
                  <td>{{ $invoice_vendor->received_date }}</td>
                  <td>{{ $invoice_vendor->due_date }}</td>
                  <td>{{ $invoice_vendor->status }}</td>
                </tr>
                @endforeach
                <tr>
                  <td colspan="4">Total Invoice Amount</td>
                  <td style="text-align:right;">{{ number_format($vendor->invoice_vendors->sum('amount'), 2) }}</td>
                </tr>
              @else
                <tr>
                  <td colspan="5">There is no invoice from this vendor</td>
                </tr>
              @endif
              </tbody>
            </table>
          </div>
          
        </div><!-- /.box-body -->
      </div>
      <!--ENDBOX Invoice Vendor Informations-->
    </div>
  </div>
@endsection

@section('additional_scripts')
 
@endsection