@extends('layouts.app')

@section('page_title')
    Purchase Order Customer
@endsection

@section('page_header')
  <h1>
    Purchase Order Customer
    <small>Purchase Order Customer Detail</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('purchase-order-customer') }}"><i class="fa fa-bookmark-o"></i> PO Customer</a></li>
    <li class="active"><i></i> {{ $po_customer->code }}</li>
  </ol>
@endsection

@section('content')

  <div class="row">
    <div class="col-md-8">
      <!--BOX Basic Informations-->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-bookmark-o"></i>&nbsp;Purchase Order Customer Information</h3>
          <a href="{{ URL::to('purchase-order-customer/'.$po_customer->id.'/edit')}}" class="btn btn-success btn-xs pull-right" title="Edit">
            <i class="fa fa-edit"></i>&nbsp;Edit
          </a>
        </div><!-- /.box-header -->
        <div class="box-body">
          <div class="table-responsive">
            <table class="table">

              <tr>
                <td style="width: 20%;">PO Number</td>
                <td style="width: 1%;">:</td>
                <td>{{ $po_customer->code }}</td>
              </tr>
              <tr>
                <td style="width: 20%;">Description</td>
                <td style="width: 1%;">:</td>
                <td>{!! nl2br($po_customer->description) !!}</td>
              </tr>
              <tr>
                <td style="width: 20%;">Amount</td>
                <td style="width: 1%;">:</td>
                <td>{{ number_format($po_customer->amount) }}</td>
              </tr>
              <tr>
                <td style="width: 20%;">File</td>
                <td style="width: 1%;">:</td>
                <td>
                  @if($po_customer->file != NULL)
                    <a href="{{ url('purchase-order-customer/file/?file_name='.$po_customer->file) }}">
                      {{ $po_customer->file }}
                    </a>
                  @else
                    -
                  @endif
                </td>
              </tr>
              <tr>
                <td style="width: 20%;">Status</td>
                <td style="width: 1%;">:</td>
                <td>{{ $po_customer->status }}</td>
              </tr>
              <tr>
                <td style="width: 20%;">Received Date</td>
                <td style="width: 1%;">:</td>
                <td>{{ $po_customer->received_date }}</td>
              </tr>
            </table>
          </div>
          
        </div><!-- /.box-body -->
      </div>
      <!--ENDBOX Basic Informations-->
    </div>

    <div class="col-md-4">
      <!--Box Quotation Information-->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-archive"></i>&nbsp;Quotation Customer Information</h3>
        </div>
        <div class="box-body">
        @if($po_customer->quotation_customer)
          <strong>Code</strong>
          <p class="text-muted">
            <a href="{{ url('quotation-customer/'.$po_customer->quotation_customer->id) }}">
              {{ $po_customer->quotation_customer->code }}
            </a>
          </p>
          <strong>Sales</strong>
          <p class="text-muted">{{ $po_customer->quotation_customer->sales->name }}</p>
          <strong>Amount</strong>
          <p class="text-muted">{{ number_format($po_customer->quotation_customer->amount, 2) }}</p>
          <strong>Submitted Date</strong>
          <p class="text-muted">{{ $po_customer->quotation_customer->submitted_date }}</p>
        @else
          <p class="alert alert-info"><i class="fa fa-info-circle"></i>&nbsp;This PO Customer doesn't have Quotation</p>
        @endif
        </div>
      </div>
      <!--ENDBOX Quotation Information-->

      <!--Box Project Information-->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-legal"></i>&nbsp;Project Information</h3>
        </div>
        <div class="box-body">
        @if($po_customer->project)
          <strong>Code</strong>
          <p class="text-muted">
            <a href="{{ url('project/'.$po_customer->project->id) }}">{{ $po_customer->project->code }}</a>
          </p>
          <strong>Name</strong>
          <p class="text-muted">
            {{ $po_customer->project->name }}
          </p>
        @else
          <p class="alert alert-info"><i class="fa fa-info-circle"></i>&nbsp;This PO Customer doesn't related to any project</p>
        @endif
        </div>
      </div>
      <!--ENDBOX Project Information-->

      <!--Box Customer Information-->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-briefcase"></i>&nbsp;Customer Information</h3>
        </div>
        <div class="box-body">
          <strong>Name</strong>
          <p class="text-muted">{{ $po_customer->customer->name }}</p>
          <strong>Contact Number</strong>
          <p class="text-muted">{{ $po_customer->customer->contact_number }}</p>
          <strong>Address</strong>
          <p class="text-muted">{{ $po_customer->customer->address }}</p>
        </div>
      </div>
      <!--ENDBOX Customer Information-->
    </div>
  </div>
@endsection

@section('additional_scripts')
  
@endsection