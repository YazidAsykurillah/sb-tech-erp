@extends('layouts.app')

@section('page_title')
  {{ $quotation_vendor->code }}
@endsection

@section('page_header')
  <h1>
    Quotation Detail
    <small>Detail of Quotation Vendor</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('quotation-vendor') }}"><i class="fa fa-legal"></i> Quotation Vendor</a></li>
    <li class="active"><i></i> {{ $quotation_vendor->code }}</li>
  </ol>
@endsection

@section('content')
  <div class="row">
    <div class="col-lg-7">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-archive"></i>&nbsp;Quotation Vendor</h3>
          <a href="{{ URL::to('quotation-vendor/'.$quotation_vendor->id.'/edit')}}" class="btn btn-xs btn-success pull-right" title="Edit Quotation">
            <i class="fa fa-edit"></i>&nbsp;Edit
          </a>
        </div><!-- /.box-header -->
        <div class="box-body">
          <div class="table-responsive">
            <table class="table">
              <tr>
                <td style="width: 20%;">Quotation Code</td>
                <td style="width: 1%;">:</td>
                <td>{{ $quotation_vendor->code }}</td>
              </tr>
              <tr>
                <td style="width: 20%;">Amount</td>
                <td style="width: 1%;">:</td>
                <td>{{ number_format($quotation_vendor->amount, 2) }}</td>
              </tr>
              <tr>
                <td style="width: 20%;">Description</td>
                <td style="width: 1%;">:</td>
                <td>{!! nl2br($quotation_vendor->description) !!}</td>
              </tr>
              <tr>
                <td style="width: 20%;">Status</td>
                <td style="width: 1%;">:</td>
                <td>{{ $quotation_vendor->status }}</td>
              </tr>
              <tr>
                <td style="width: 20%;">Received Date</td>
                <td style="width: 1%;">:</td>
                <td>{{ $quotation_vendor->received_date }}</td>
              </tr>
            </table>
          </div>
        </div><!-- /.box-body -->
        <div class="box-footer clearfix">
          
        </div>
      </div><!-- /.box -->
    </div>


    <div class="col-md-5">
      
      <!--BOX Vendor Information-->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-child"></i>&nbsp;Vendor</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          <div class="table-responsive">
            <table class="table">
              <tr>
                <td style="width: 20%;">Name</td>
                <td style="width: 1%;">:</td>
                <td>{{ $quotation_vendor->vendor->name }}</td>
              </tr>
              
            </table>
          </div>
        </div><!-- /.box-body -->
        <div class="box-footer clearfix">
          
        </div>
      </div><!-- /.box -->
      <!--ENDBOX Vendor Information-->
    </div>
  </div>

  
@endsection

@section('additional_scripts')
 
@endsection