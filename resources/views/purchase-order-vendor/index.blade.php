@extends('layouts.app')

@section('page_title')
    Purchase Order Vendor
@endsection

@section('page_header')
  <h1>
    Purchase Order Vendor
    <small>Daftar Purchase Order Vendor</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('purchase-order-vendor') }}"><i class="fa fa-bookmark-o"></i> PO Vendor</a></li>
    <li class="active"><i></i> Index</li>
  </ol>
@endsection

@section('content')
  <div class="row">
    <div class="col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">PO Vendor</h3>
              <a href="{{ URL::to('purchase-order-vendor/create')}}" class="btn btn-primary pull-right" title="Create new PO Vendor">
                <i class="fa fa-plus"></i>&nbsp;Add New
              </a>
            </div><!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="table-purchase-order-vendor">
                  <thead>
                    <tr>
                      <th style="width:5%;">#</th>
                      <th style="width:10%;">PO Number</th>
                      <th style="width:10%;">Project Code</th>
                      <th style="width:10%;">Project Name</th>
                      <th style="width:10%;">Vendor</th>
                      <th>Purchase Request</th>
                      <th>Quotation Vendor</th>
                      <th style="width:10%;">Description</th>
                      <th>Amount</th>
                      <th style="width:15%;">Paid Invoice</th>
                      <th>Status</th>
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
                    </tr>
                  </thead>
                  
                  <tbody>

                  </tbody>
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

  <!--Modal Delete Purchase Order-->
  <div class="modal fade" id="modal-delete-purchaseOrderVendor" tabindex="-1" role="dialog" aria-labelledby="modal-delete-purchaseOrderVendorLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      {!! Form::open(['url'=>'deletePOVendor', 'method'=>'post']) !!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="modal-delete-purchaseOrderVendorLabel">Confirmation</h4>
        </div>
        <div class="modal-body">
          You are going to delete <b id="po-vendor-code-to-delete"></b>
          <br/>
          <p class="text text-danger">
            <i class="fa fa-info-circle"></i>&nbsp;This process can not be reverted
          </p>
          <input type="hidden" id="po_vendor_id" name="po_vendor_id">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-danger">Delete</button>
        </div>
      {!! Form::close() !!}
      </div>
    </div>
  </div>
<!--ENDModal Delete Purchase Order-->
@endsection

@section('additional_scripts')
  <script type="text/javascript">
    var tablePOVendor =  $('#table-purchase-order-vendor').DataTable({
      processing :true,
      serverSide : true,
      ajax : '{!! route('datatables.getPOVendors') !!}',
      columns :[
        {data: 'rownum', name: 'rownum', searchable:false, orderable:true},
        { data: 'code', name: 'code' },
        { data: 'project_code', name: 'purchase_request.project.code' },
        { data: 'project_name', name: 'purchase_request.project.name' },
        { data: 'vendor_id', name: 'vendor.name' },
        { data: 'purchase_request', name: 'purchase_request.code' },
        { data: 'quotation_vendor', name: 'quotation_vendor.code' },
        { data: 'description', name: 'description' },
        { data: 'amount', name: 'amount' },
        { data: 'paid_invoice_vendor', name: 'paid_invoice_vendor', orderable:false, searchable:false },
        { data: 'status', name: 'status'},
        { data: 'actions', name: 'actions', orderable:false, searchable:false, className:'dt-body-center' },
        { data: 'created_at', name: 'created_at', visible:false, sortable:true},
      ],
      order : [
        [12, 'desc']
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

        // Total amount from current page
        total_amount = api
            .column(8)
            .data()
            .reduce( function (a, b) {
                return theFloat(a) + theFloat(b);
            }, 0 );
        
        $( api.column(8).footer() ).html(
            total_amount.toLocaleString()
        );
        // ENDTotal amount from current page

        // Total paid from current page
        total_paid = api
            .column(9)
            .data()
            .reduce( function (a, b) {
                return theFloat(a) + theFloat(b);
            }, 0 );
        
        $( api.column(9).footer() ).html(
            total_paid.toLocaleString()
        );
        // ENDTotal paid from current page
      },

    });
    
    var buttonTableTools = new $.fn.dataTable.Buttons(tablePOVendor,{
        buttons: [
          {
            extend: 'excelHtml5',
            exportOptions: {
                columns: [0,1,2,3,4,5,6,7,8,9]
            }
          },
        ],
      }).container().appendTo($('#button-table-tools'));

    // Delete button handler
    tablePOVendor.on('click', '.btn-delete-purchase-order-vendor', function(e){
      var id = $(this).attr('data-id');
      var code = $(this).attr('data-text');
      $('#po_vendor_id').val(id);
      $('#po-vendor-code-to-delete').text(code);
      $('#modal-delete-purchaseOrderVendor').modal('show');
    });

    // Setup - add a text input to each header cell
    $('#searchColumn th').each(function() {
      if ($(this).index() != 0 && $(this).index() != 11) {
        $(this).html('<input class="form-control" type="text" placeholder="Search" data-id="' + $(this).index() + '" />');
      }
          
    });
    //Block search input and select
    $('#searchColumn input').keyup(function() {
      tablePOVendor.columns($(this).data('id')).search(this.value).draw();
    });
    //ENDBlock search input and select
    
  </script>
@endsection