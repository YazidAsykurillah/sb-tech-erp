@extends('layouts.app')

@section('page_title')
  Cash Flow
@endsection

@section('page_header')
  <h1>
    Cash Flow
    <small></small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('cash-flow') }}"><i class="fa fa-line-chart"></i> Cash Flow</a></li>
    <li class="active"><i></i> Index</li>
  </ol>
@endsection

@section('content')
  <div class="row">
      <div class="col-lg-12">
          <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title">Cash Flow</h3>
              </div><!-- /.box-header -->
              <div class="box-body">
              <div class="table-responsive">
                    <table class="table table-bordered" id="table-cash-flow">
                      <thead>
                          <tr>
                            <th style="width:5%;">#</th>
                            <th style="width:20%;">Year-Month</th>
                            <th>Invoice Customer(IN)</th>
                            <th>Invoice Vendor (OUT)</th>
                            <th style="width:20%;">Diff</th>
                            <th style="">CASH</th>
                            <th style="">PREV CASH</th>
                            <th style="width:20%;">Estimation</th>
                          </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                        </tfoot>
                    </table>
                 </div>
            </div>
          </div>
      </div>
  </div>
@endsection

@section('additional_scripts')
  
  <script type="text/javascript">
    var init = 0;
    var tableCashFlow =  $('#table-cash-flow').DataTable({
      lengthMenu: [[-1], ["All"]],
      processing :true,
      serverSide : true,
      ajax : '{!! route('datatables.getCashFlow') !!}',
      columns :[
        { data: 'rownum', name: 'rownum', searchable:false, orderable:false},
        { data: 'year_month', name: 'year_month' },
        { data: 'tot_invoice_customer', name: 'tot_invoice_customer' },
        { data: 'tot_invoice_vendor', name: 'tot_invoice_vendor' },
        { data: 'difference', name: 'difference' },
        {
          data: 'cash_amount', name: 'cash_amount',
            render:function(data, type, row, meta){
             
              //return row.difference;
              return data;
          }
        },
        { data: 'previous_cash', name: 'previous_cash' },
        { data: 'estimation', name: 'estimation' },
      ],
      footerCallback: function( tfoot, data, start, end, display ) {
        var api = this.api();
        // Remove the formatting to get float data for summation
        var theFloat = function ( i ) {
            return typeof i === 'string' ?
                parseFloat(i.replace(/[\$,]/g, '')) :
                typeof i === 'number' ?
                    i : 0;
        };

        // Total over all pages
        total = api
            .column(3)
            .data()
            .reduce( function (a, b) {
                return theFloat(a) + theFloat(b);
            }, 0 );
        // Update footer
        $( api.column(3).footer() ).html(
            total.toLocaleString()
        );
      },
      
    });
  </script>

@endsection