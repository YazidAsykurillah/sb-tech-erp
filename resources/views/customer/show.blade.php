@extends('layouts.app')

@section('page_title')
    Customer
@endsection

@section('page_header')
  <h1>
    Customer
    <small>Customer Detail</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('customer') }}"><i class="fa fa-briefcase"></i> Customer</a></li>
    <li class="active"><i></i> {{ $customer->name }}</li>
  </ol>
@endsection

@section('content')
  <div class="row">
    <div class="col-md-12">
      <!--BOX Basic Informations-->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Customer Detail</h3>
          <a href="{{ URL::to('customer/'.$customer->id.'/edit')}}" class="btn btn-success btn-xs pull-right" title="Edit">
                <i class="fa fa-edit"></i>&nbsp;Edit
          </a>
        </div><!-- /.box-header -->
        <div class="box-body">
          <div class="table-responsive">
            <table class="table">

              <tr>
                <td style="width: 20%;">Customer Name</td>
                <td style="width: 1%;">:</td>
                <td>{{ $customer->name }}</td>
              </tr>
              <tr>
                <td style="width: 20%;">Contact Number</td>
                <td style="width: 1%;">:</td>
                <td>{{ $customer->contact_number }}</td>
              </tr>
              <tr>
                <td style="width: 20%;">Address</td>
                <td style="width: 1%;">:</td>
                <td>{{ $customer->address }}</td>
              </tr>
              
            </table>
          </div>
          
        </div><!-- /.box-body -->
      </div>
      <!--ENDBOX Basic Informations-->
    </div>
  </div>

  <div class="row">
    <div class="col-lg-12">
        <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Invoice Customer</h3>
              <!-- temporary hide link to create invoice from here-->
              <!-- <a href="{{ URL::to('invoice-customer/create')}}" class="btn btn-primary pull-right" title="Create new Invoice Customer">
                <i class="fa fa-plus"></i>&nbsp;Add New
              </a> -->
            </div><!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="table-invoice-customer">
                  <thead>
                    <tr>
                      <th style="width:5%;">#</th>
                      <th style="width:15%;">Invoice Number</th>
                      <th>Tax Number</th>
                      <th>Project Number</th>
                      <th>PO Number</th>
                      <th>Amount</th>
                      <th>Submitted Date</th>
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
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                    </tr>
                  </thead>
                  
                  <tbody>
                  @if(count($invoice_customers))
                    @foreach($invoice_customers as $invoice_customer)
                    <tr>
                      <td></td>
                      <td>{{ $invoice_customer->code }}</td>
                      <td>{{ $invoice_customer->tax_number }}</td>
                      <td>{{ $invoice_customer->project->code }}</td>
                      <td>{{ $invoice_customer->project->purchase_order_customer->code }}</td>
                      <td>{{ number_format($invoice_customer->amount, 2) }}</td>
                      <td>{{ $invoice_customer->submitted_date }}</td>
                      <td>{{ $invoice_customer->due_date }}</td>
                      <td>{{ $invoice_customer->status }}</td>
                    </tr>
                    @endforeach
                    <tr>
                      <td colspan="5">Total</td>
                      <td>{{ number_format($invoice_customer->sum('amount'), 2) }}</td>
                    </tr>
                  @else
                    <tr>
                      <td colspan="8">No data available</td>
                    </tr>
                  @endif
                  </tbody>
              </table>
            </div>
          </div><!-- /.box-body -->
          <div class="box-footer clearfix">
            
          </div>
        </div><!-- /.box -->
    </div>
  </div>
@endsection

@section('additional_scripts')
  
@endsection