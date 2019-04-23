@extends('layouts.app')

@section('page_title')
    Invoice Customer
@endsection

@section('page_header')
  <h1>
    Invoice Customer
    <small>Daftar Invoice Customer</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('invoice-customer') }}"><i class="fa fa-credit-card"></i> Invoice Customer</a></li>
    <li class="active"><i></i> Index</li>
  </ol>
@endsection
  
@section('content')
  <div class="row">
    <div class="col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Invoice Customer</h3>
              <!-- temporary hide link to create invoice from here-->
              <!-- <a href="{{ URL::to('invoice-customer/create')}}" class="btn btn-primary pull-right" title="Create new Invoice Customer">
                <i class="fa fa-plus"></i>&nbsp;Add New
              </a> -->
            </div><!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="table-invoice-customer">
                  <thead>
                    <tr>
                      <th style="width:5%;">#</th>
                      <th style="width:10%;">Invoice Number</th>
                      <th>Customer</th>
                      <th>Project Number</th>
                      <th>PO Number</th>
                      <th>Amount</th>
                      <th>Due Date</th>
                      <th>Tax Number</th>
                      <th>Tax Date</th>
                      <th>Status</th>
                      <th>Accounted</th>
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
                      <th style="text-align:right;"></th>
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
  <div class="modal fade" id="modal-delete-invoice-customer" tabindex="-1" role="dialog" aria-labelledby="modal-delete-invoice-customerLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      {!! Form::open(['url'=>'deleteInvoiceCustomer', 'method'=>'post']) !!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="modal-delete-InvoiceCustomerLabel">Confirmation</h4>
        </div>
        <div class="modal-body">
          You are going to delete <b id="invoice-customer-code-to-delete"></b>
          <br/>
          <p class="text text-danger">
            <i class="fa fa-info-circle"></i>&nbsp;This process can not be reverted
          </p>
          <input type="hidden" id="invoice_customer_id" name="invoice_customer_id">
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
    var tableInvoiceCustomer =  $('#table-invoice-customer').DataTable({
      "lengthMenu": [[10, 25, 100, 500, -1], [10, 25, 100, 500, "All"]],
      processing :true,
      serverSide : true,
      ajax : '{!! url('invoice-customer/dataTables') !!}',
      columns :[
        {data: 'rownum', name: 'rownum', searchable:false},
        { data: 'code', name: 'code' },
        { data: 'customer_name', name: 'project.purchase_order_customer.customer.name' },
        { data: 'project_id', name: 'project.code' },
        { data: 'po_customer', name: 'project.purchase_order_customer.code' },
        { data: 'amount', name:'amount', className:'dt-body-center' },
        { data: 'due_date', name:'due_date' },
        { data: 'tax_number', name: 'tax_number' },
        { data: 'tax_date', name:'tax_date' },
        { data: 'status', name:'status' },
        { data: 'accounted', name:'accounted' },
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
            .column(5)
            .data()
            .reduce( function (a, b) {
                return theFloat(a) + theFloat(b);
            }, 0 );
        // Update footer
        $( api.column(5).footer() ).html(
            total.toLocaleString()
        );
      },
      order : [
        [1, 'desc']
      ]

    });
  
    var buttonTableTools = new $.fn.dataTable.Buttons(tableInvoiceCustomer,{
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
    tableInvoiceCustomer.on('click', '.btn-delete-invoice-customer', function(e){
      var id = $(this).attr('data-id');
      var code = $(this).attr('data-text');
      $('#invoice_customer_id').val(id);
      $('#invoice-customer-code-to-delete').text(code);
      $('#modal-delete-invoice-customer').modal('show');
    });

    // Setup - add a text input to each header cell
    $('#searchColumn th').each(function() {
      if ($(this).index() != 0 && $(this).index() != 11) {
        $(this).html('<input class="form-control" type="text" placeholder="Search" data-id="' + $(this).index() + '" />');
      }
          
    });
    //Block search input and select
    $('#searchColumn input').keyup(function() {
      tableInvoiceCustomer.columns($(this).data('id')).search(this.value).draw();
    });
    //ENDBlock search input and select
    
  </script>
@endsection