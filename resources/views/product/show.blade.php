@extends('layouts.app')

@section('page_title')
    Product
@endsection

@section('page_header')
  <h1>
    Product
    <small>Product Detail</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('product') }}"><i class="fa fa-cube"></i> Product</a></li>
    <li class="active"><i></i> {{ $product->code }}</li>
  </ol>
@endsection

@section('content')
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Product Detail</h3>
            <div class="pull-right"></div>
          </div><!-- /.box-header -->
          <div class="box-body">
            <div class="table-responsive">
              <table class="table">
                <tr>
                  <td style="width: 20%;">Code</td>
                  <td style="width: 1%;">:</td>
                  <td>{{ $product->code }}</td>
                </tr>
                <tr>
                  <td style="width: 20%;">Name</td>
                  <td style="width: 1%;">:</td>
                  <td>{{ $product->name }}</td>
                </tr>
                <tr>
                  <td style="width: 20%;">Unit</td>
                  <td style="width: 1%;">:</td>
                  <td>{{ $product->unit }}</td>
                </tr>
                <tr>
                  <td style="width: 20%;">Price</td>
                  <td style="width: 1%;">:</td>
                  <td>{{ number_format($product->price) }}</td>
                </tr>
                <tr>
                  <td style="width: 20%;">Initial Stock</td>
                  <td style="width: 1%;">:</td>
                  <td>{{ $product->initial_stock }}</td>
                </tr>
                <tr>
                  <td style="width: 20%;">Stock</td>
                  <td style="width: 1%;">:</td>
                  <td>{{ $product->stock }}</td>
                </tr>
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