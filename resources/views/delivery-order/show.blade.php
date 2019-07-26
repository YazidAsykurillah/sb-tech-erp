@extends('layouts.app')

@section('page_title')
    Delivery Order
@endsection

@section('page_header')
  <h1>
    Delivery Order
    <small>Daftar Delivery Order</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('delivery-order') }}"><i class="fa fa-bookmark-o"></i> Delivery Order</a></li>
    <li class="active"><i></i> Detail</li>
  </ol>
@endsection

@section('content')
  <div class="row">
    <div class="col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Delivery Order</h3>
              <a href="{{ URL::to('delivery-order/'.$deliveryOrder->id.'/print_pdf')}}" class="btn btn-primary pull-right btn-xs" title="Print">
                <i class="fa fa-print"></i>&nbsp;Print
              </a>
            </div><!-- /.box-header -->
            <div class="box-body">
              <table class="table table-responsive">
                <tr>
                  <td style="width: 25%;">Code</td>
                  <td style="width: 5%;">:</td>
                  <td style="">{{$deliveryOrder->code}}</td>
                </tr>
                <tr>
                  <td style="width: 25%;">Project</td>
                  <td style="width: 5%;">:</td>
                  <td style="">({{$deliveryOrder->project->code}}) {{$deliveryOrder->project->name}}</td>
                </tr>
                <tr>
                  <td style="width: 25%;">PIC</td>
                  <td style="width: 5%;">:</td>
                  <td style="">{{$deliveryOrder->sender ? ->$deliveryOrder->sender->name : ""}}</td>
                </tr>
              </table>
            </div>
            <div class="box-body">
              <table class="table table-responsive">
                <thead>
                  <tr>
                    <th style="width: 10%;">No</th>
                    <th style="width: 80%;">Item</th>
                    <th>Quantity</th>
                  </tr>
                </thead>
                <tbody>
                @if(count($deliveryOrderItems))
                  <?php $rowNumber=0;?>
                  @foreach($deliveryOrderItems as $item)
                  <?php $rowNumber++;?>
                  <tr>
                    <td>{{$rowNumber}}</td>
                    <td>
                      {{\DB::table('item_purchase_request')->where('id','=',$item->item_purchase_request_id)->first()->item}}
                    </td>
                    <td>{{round($item->quantity)}}</td>
                  </tr>
                  @endforeach
                @endif
                </tbody>
              </table>
            </div>
          </div><!-- /.box-body -->
          <div class="box-footer clearfix">
            <div id="button-table-tools" class=""></div>
          </div>
        </div><!-- /.box -->
    </div>
  </div>

  
@endsection

@section('additional_scripts')
  
@endsection