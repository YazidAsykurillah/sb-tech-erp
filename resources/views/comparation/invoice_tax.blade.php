@extends('layouts.app')

@section('page_title')
  Invoice Tax Comparation
@endsection

@section('page_header')
  <h1>
    Invoice Tax Comparation
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li class="active"><i></i> Invoice Tax Comparation</li>
  </ol>
@endsection
  
@section('content')
	<div class="row">
	    <div class="col-lg-12">
	        <div class="box box-primary">
	            <div class="box-header with-border">
	              <h3 class="box-title">Invoice Tax Comparation</h3>
	            </div><!-- /.box-header -->
	            <div class="box-body">
  		        	<div class="table-responsive">
                  <table class="table table-bordered" id="table-invoice-tax-comparation">
                   	<thead>
                    		<tr>
                    			<th style="width:5%;">#</th>
                    			<th style="width:15%;">Masa</th>
                    			<th style="width:20%;">Tax IN (from invoice vendor)</th>
                    			<th style="width:20%;">Tax OUT (from invoice customer)</th>
                          <th style="width:20%;">Credit</th>
                    			<th style="width:20%;">Payment</th>
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

  <!--Modal TAX IN Detail-->
  <div class="modal fade" id="modal-tax-in-detail" tabindex="-1" role="dialog" aria-labelledby="modal-tax-in-detailLabel">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="modal-tax-in-detailLabel"></h4>
        </div>
        <div class="modal-body">
          <div class="table-resposive">
            <table class="table table-bordered" id="table-invoice-vendor-tax" style="width:100%;">
              <thead>
                <tr>
                  <th style="width:5%;">#</th>
                  <th style="width:30%;">Tax Number</th>
                  <th style="width:30%;">Tax Date</th>
                  <th style="width:35%;">Amount</th>
                </tr>
              </thead>
              <thead id="searchColumn">
                <tr>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                </tr>
              </thead>
              
              <tbody>

              </tbody>
              <tfoot>
                <tr>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      
      </div>
    </div>
  </div>
<!--ENDModal TAX IN Detail-->


<!--Modal TAX OUT Detail-->
  <div class="modal fade" id="modal-tax-out-detail" tabindex="-1" role="dialog" aria-labelledby="modal-tax-out-detailLabel">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="modal-tax-out-detailLabel"></h4>
        </div>
        <div class="modal-body">
          <div class="table-resposive">
            <table class="table table-bordered" id="table-invoice-customer-tax" style="width:100%;">
              <thead>
                <tr>
                  <th style="width:5%;">#</th>
                  <th style="width:30%;">Tax Number</th>
                  <th style="width:30%;">Tax Date</th>
                  <th style="width:35%;">Amount</th>
                </tr>
              </thead>
              <thead id="searchColumn">
                <tr>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                </tr>
              </thead>
              
              <tbody>

              </tbody>
              <tfoot>
                <tr>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      
      </div>
    </div>
  </div>
<!--ENDModal TAX OUT Detail-->
@endsection

@section('additional_scripts')
   <script type="text/javascript">
   	var tableInvoiceTaxComparation =  $('#table-invoice-tax-comparation').DataTable({
      processing :true,
      serverSide : true,
      ajax : '{!! route('datatables.getInvoiceTaxComparation') !!}',
      columns :[
        {data: 'rownum', name: 'rownum', searchable:false, orderable:false},
        { data: 'tax_month', name: 'tax_month', orderable:false},
        { data: 'tax_in', name: 'tax_in', searchable:false, orderable:false },
        { data: 'tax_out', name: 'tax_out', searchable:false, orderable:false },
        { data: 'credit', name: 'credit', searchable:false, orderable:false },
        { data: 'payment', name: 'payment', searchable:false, orderable:false },
        { data: 'tax_month', visible: false, searchable: false, className: 'never'},
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
      order : [
        [6, 'asc']
      ]

    });

  
  
  var param_yearmonth = "";

  //Tax in detail event handling
  tableInvoiceTaxComparation.on('click', '.btn-tax-in-detail', function(e){
    var yearmonth = $(this).attr('data-yearmonth');
    param_yearmonth = yearmonth;
    $('#modal-tax-in-detailLabel').html("Detail TAX IN Masa "+yearmonth);
    $('#modal-tax-in-detail').modal('show');
    $('#table-invoice-vendor-tax').DataTable().ajax.reload();
  });


  var tableInvoiceCustomerTax =  $('#table-invoice-customer-tax').DataTable({
      processing :true,
      serverSide : true,
      ajax : {
        url : '{!! route('datatables.getInvoiceCustomerTaxesFromTaxComparation') !!}',
        data: function(d){
          d.param_yearmonth = param_yearmonth;
        }
      },
      columns :[
        {data: 'rownum', name: 'rownum', searchable:false},
        { data: 'tax_number', name:'tax_number' },
        { data: 'tax_date', name:'invoice_customer.tax_date' },
        { data: 'amount', name:'amount' },
      ],
      order : [
        [3, 'desc']
      ]

    });

  //Tax out detail event handling
  tableInvoiceTaxComparation.on('click', '.btn-tax-out-detail', function(e){
    var yearmonth = $(this).attr('data-yearmonth');
    param_yearmonth = yearmonth;
    $('#modal-tax-out-detailLabel').html("Detail TAX out Masa "+yearmonth);
    $('#modal-tax-out-detail').modal('show');
    $('#table-invoice-customer-tax').DataTable().ajax.reload();
  });

  var tableInvoiceVendorTax =  $('#table-invoice-vendor-tax').DataTable({
      processing :true,
      serverSide : true,
      ajax : {
        url : '{!! route('datatables.getInvoiceVendorTaxesFromTaxComparation') !!}',
        data: function(d){
          d.param_yearmonth = param_yearmonth;
        }
      },
      columns :[
        {data: 'rownum', name: 'rownum', searchable:false},
        { data: 'tax_number', name:'tax_number' },
        { data: 'tax_date', name:'invoice_customer.tax_date' },
        { data: 'amount', name:'amount' },
      ],
      order : [
        [3, 'desc']
      ]

    });
  </script>
@endsection