@extends('layouts.app')

@section('page_title')
    Overdue Invoice Customer Over Last Week
@endsection

@section('page_header')
  <h1>
    Overdue Invoice Customer
    <small>Overdue Invoice Customer Over the Last Week</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('invoice-customer') }}"><i class="fa fa-credit-card"></i> Invoice Customer</a></li>
    <li class="active"><i></i> Overdue Over the Last Week</li>
  </ol>
@endsection
  
@section('content')
  <div class="row">
    <div class="col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Overdue Invoice Customer</h3>
            </div><!-- /.box-header -->
            <div class="box-body">
              <p class="alert alert-info">
                <i class="fa fa-info-circle"></i>&nbsp;Below are the invoice customers that will be overdued Over the Last Week ({{ $last_week}} )
              </p>
              <div class="table-responsive">
                <table class="table table-bordered" id="table-invoice-customer">
                  <thead>
                    <tr>
                      <th style="width:5%;">#</th>
                      <th style="width:15%;">Invoice Number</th>
                      <th>Customer</th>
                      <th>Tax Number</th>
                      <th>Project Number</th>
                      <th>PO Number</th>
                      <th>Amount</th>
                      <th>Due Date</th>
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
                    </tr>
                  </thead>
                  
                  <tbody>

                  </tbody>
              </table>
            </div>
          </div><!-- /.box-body -->
          <div class="box-footer clearfix">
            
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
    var tableInvoiceCustomerOverLastWeekOverDue =  $('#table-invoice-customer').DataTable({
      processing :true,
      serverSide : true,
      ajax : '{!! route('datatables.getInvoiceCustomersOverLastWeekOverDue') !!}',
      columns :[
        {data: 'rownum', name: 'rownum', searchable:false},
        { data: 'code', name: 'code' },
        { data: 'customer_name', name: 'project.purchase_order_customer.customer.name' },
        { data: 'tax_number', name: 'tax_number' },
        { data: 'project_id', name: 'project.code' },
        { data: 'po_customer', name: 'project.purchase_order_customer.code' },
        { data: 'amount', name:'amount' },
        { data: 'due_date', name:'due_date' },
        { data: 'status', name:'status' },
        { data: 'actions', name: 'actions', orderable:false, searchable:false, className:'dt-body-center' },
      ],

    });

    // Delete button handler
    tableInvoiceCustomerOverLastWeekOverDue.on('click', '.btn-delete-invoice-customer', function(e){
      var id = $(this).attr('data-id');
      var code = $(this).attr('data-text');
      $('#invoice_customer_id').val(id);
      $('#invoice-customer-code-to-delete').text(code);
      $('#modal-delete-invoice-customer').modal('show');
    });

    // Setup - add a text input to each header cell
    $('#searchColumn th').each(function() {
      if ($(this).index() != 0 && $(this).index() != 9) {
        $(this).html('<input class="form-control" type="text" placeholder="Search" data-id="' + $(this).index() + '" />');
      }
          
    });
    //Block search input and select
    $('#searchColumn input').keyup(function() {
      tableInvoiceCustomerOverLastWeekOverDue.columns($(this).data('id')).search(this.value).draw();
    });
    //ENDBlock search input and select
    
  </script>
@endsection