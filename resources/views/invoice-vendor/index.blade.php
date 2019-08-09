@extends('layouts.app')

@section('page_title')
    Invoice Vendor
@endsection

@section('additional_styles')

@endsection

@section('page_header')
  <h1>
    Invoice Vendor
    <small>Daftar Invoice Vendor</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('invoice-vendor') }}"><i class="fa fa-credit-card"></i> Invoice Vendor</a></li>
    <li class="active"><i></i> Index</li>
  </ol>
@endsection
  
@section('content')
  <div class="row">
    <div class="col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Invoice Vendor</h3>
              <div class="pull-right">
                
                <a href="{{ URL::to('invoice-vendor/create')}}" class="btn btn-primary" title="Create new Invoice Vendor">
                  <i class="fa fa-plus"></i>&nbsp;Add New
                </a>
                
              </div>
            </div><!-- /.box-header -->
            <div class="box-body">
              
              <div class="table-responsive">
                
                <table class="table table-bordered" id="table-invoice-vendor">
                  <thead>
                    <tr>
                      <th style="width:5%;">#</th>
                      <th style="width:10%;">Invoice Number</th>
                      <th>Type</th>
                      <th>Tax Number</th>
                      <th>Project Number</th>
                      <th>PO Vendor</th>
                      <th>Vendor</th>
                      <th>Amount</th>
                      <th>Received Date</th>
                      <th>Due Date</th>
                      <th>Status</th>
                      <th>Accounted</th>
                      <th>Tax Date</th>
                      <th style="width:10%;text-align:center;">Actions</th>
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
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                    </tr>
                  </thead>
                  
                  <tbody></tbody>
                  <tfoot>
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
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                    </tr>
                  </tfoot>
              </table>
              
            </div>
          </div><!-- /.box-body -->
          <div class="box-footer clearfix">
            <div id="button-table-tools" class=""></div>
          </div>
        </div><!-- /.box -->
    </div>
  </div>

  <!--Modal Delete Invoice Customer-->
  <div class="modal fade" id="modal-delete-invoice-vendor" tabindex="-1" role="dialog" aria-labelledby="modal-delete-invoice-vendorLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      {!! Form::open(['url'=>'deleteInvoiceVendor', 'method'=>'post']) !!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="modal-delete-InvoiceVendorLabel">Confirmation</h4>
        </div>
        <div class="modal-body">
          You are going to delete <b id="invoice-vendor-code-to-delete"></b>
          <br/>
          <p class="text text-danger">
            <i class="fa fa-info-circle"></i>&nbsp;This process can not be reverted
          </p>
          <input type="hidden" id="invoice_vendor_id" name="invoice_vendor_id">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-danger">Delete</button>
        </div>
      {!! Form::close() !!}
      </div>
    </div>
  </div>
<!--ENDModal Delete Invoice Customer-->
@endsection

@section('additional_scripts')
  
  <script type="text/javascript">
    var tableInvoiceVendor =  $('#table-invoice-vendor').DataTable({
      processing :true,
      serverSide : true,
      ajax : '{!! url('invoice-vendor/dataTables') !!}',
      columns :[
        {data: 'rownum', name: 'rownum', searchable:false},
        { data: 'code', name: 'code' },
        { data: 'type', name: 'type' },
        { data: 'tax_number', name: 'tax_number' },
        { data: 'project_id', name: 'project.code' },
        { data: 'purchase_order_vendor_id', name: 'purchase_order_vendor.code' },
        { data: 'vendor', name: 'purchase_order_vendor.vendor.name' },
        { data: 'amount', name: 'amount' },
        { data: 'received_date', name:'received_date'},
        { data: 'due_date', name:'due_date'},
        { data: 'status', name:'status'},
        { data: 'accounted', name:'accounted'},
        { data: 'tax_date', name:'tax_date'},
        { data: 'actions', name: 'actions', orderable:false, searchable:false, className:'dt-body-center' },
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
            .column(7)
            .data()
            .reduce( function (a, b) {
                return theFloat(a) + theFloat(b);
            }, 0 );
        // Update footer
        $( api.column(7).footer() ).html(
            total.toLocaleString()
        );
      },
      order : [
        [7, 'asc']
      ]

    });
    
    var buttonTableTools = new $.fn.dataTable.Buttons(tableInvoiceVendor,{
      buttons: [
        {
          extend: 'excelHtml5',
          exportOptions: {
              columns: [0,1,2,3,4,5,6,7,8,9,10]
          }
        },
      ],
    }).container().appendTo($('#button-table-tools'));
    // Delete button handler
    tableInvoiceVendor.on('click', '.btn-delete-invoice-vendor', function(e){
      var id = $(this).attr('data-id');
      var code = $(this).attr('data-text');
      $('#invoice_vendor_id').val(id);
      $('#invoice-vendor-code-to-delete').text(code);
      $('#modal-delete-invoice-vendor').modal('show');
    });

    // Setup - add a text input to each header cell
    $('#searchColumn th').each(function() {
      if ($(this).index() != 0 && $(this).index() != 13) {
        $(this).html('<input class="form-control" type="text" placeholder="Search" data-id="' + $(this).index() + '" />');
      }
          
    });
    //Block search input and select
    $('#searchColumn input').keyup(function() {
      tableInvoiceVendor.columns($(this).data('id')).search(this.value).draw();
    });
    //ENDBlock search input and select
    
  </script>
@endsection