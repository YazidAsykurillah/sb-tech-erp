@extends('layouts.app')

@section('page_title')
    Cash Bond Site
@endsection

@section('page_header')
  <h1>
    Cash Bond Site
    <small></small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('cash-bond-site') }}"><i class="fa fa-money"></i> Cash Bond site</a></li>
    <li class="active"><i></i> Show</li>
  </ol>
@endsection
  
@section('content')
  <div class="row">
    <div class="col-md-12">
      <!--BOX Basic Informations-->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Cashbond Site Detail</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          <div class="table-responsive">
            <table class="table">
              <tr>
                <td style="width: 20%;">Code</td>
                <td style="width: 1%;">:</td>
                <td>{{ $cashbond_site->code }}</td>
              </tr>
              <tr>
                <td style="width: 20%;">Member</td>
                <td style="width: 1%;">:</td>
                <td>{{ $cashbond_site->user->name }}</td>
              </tr>
              <tr>
                <td style="width: 20%;">Amount</td>
                <td style="width: 1%;">:</td>
                <td>{{ number_format($cashbond_site->amount, 2) }}</td>
              </tr>
              <tr>
                <td style="width: 20%;">Description</td>
                <td style="width: 1%;">:</td>
                <td>{{ nl2br($cashbond_site->description) }}</td>
              </tr>
              <tr>
                <td style="width: 20%;">Transaction Date</td>
                <td style="width: 1%;">:</td>
                <td>{{ $cashbond_site->transaction_date }}</td>
              </tr>
              <tr>
                <td style="width: 20%;">Created Date</td>
                <td style="width: 1%;">:</td>
                <td>{{ $cashbond_site->created_at }}</td>
              </tr>
            </table>
          </div>
          
        </div><!-- /.box-body -->
      </div>
      <!--ENDBOX Basic Informations-->
    </div>
  </div>
@endsection

@section('additional_scripts')
  
@endsection