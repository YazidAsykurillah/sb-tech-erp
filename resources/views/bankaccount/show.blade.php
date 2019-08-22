@extends('layouts.app')

@section('page_title')
    Bank Account | Detail
@endsection

@section('page_header')
  <h1>
    Bank Account
    <small>Bank Account Detail</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('bank-account') }}"><i class="fa fa-building"></i> Bank Account</a></li>
    <li class="active"><i></i> Detail</li>
  </ol>
@endsection

@section('content')
  
  <div class="row">
    <div class="col-md-12">
      <!--BOX Basic Informations-->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Bank Account Detail</h3>
          <a href="{{ URL::to('bank-account/'.$bank_account->id.'/edit')}}" class="btn btn-primary btn-xs pull-right" title="Edit">
                <i class="fa fa-pencil"></i>&nbsp;Edit
          </a>
        </div><!-- /.box-header -->
        <div class="box-body">
          <div class="table-responsive">
            <table class="table">
              <tr>
                <td style="width: 20%;">Owner</td>
                <td style="width: 1%;">:</td>
                <td>{{ $bank_account->owner->name }}</td>
              </tr>
              <tr>
                <td style="width: 20%;">Bank Account Name</td>
                <td style="width: 1%;">:</td>
                <td>{{ $bank_account->name }}</td>
              </tr>
              <tr>
                <td style="width: 20%;">Account Number</td>
                <td style="width: 1%;">:</td>
                <td>{{ $bank_account->account_number }}</td>
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