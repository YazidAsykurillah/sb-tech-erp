@extends('layouts.app')

@section('page_title')
    Quotation Customer
@endsection

@section('page_header')
  <h1>
    Quotation Customer
    <small>Daftar Quotation Customer</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('quotation-customer') }}"><i class="fa fa-archive"></i> Quotation Customer</a></li>
    <li class="active"><i></i> Index</li>
  </ol>
@endsection

@section('content')
  <div class="row">
    <div class="col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Quotation Customer</h3>
              <a href="{{ URL::to('quotation-customer/create')}}" class="btn btn-primary pull-right" title="Create new Quotation">
                <i class="fa fa-plus"></i>&nbsp;Add New
              </a>
            </div><!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="quotation-customer">
                  <thead>
                    <tr>
                      <th style="width:5%;">#</th>
                      <th style="width:15%;">Code</th>
                      <th>Customer</th>
                      <th style="text-align:right;">Amount</th>
                      <th>Description</th>
                      <th>Created Date</th>
                      <th>Status</th>
                      <th>Sales</th>
                      <th style="width:10%;">Submitted Date</th>
                      <th style="width:10%;">PO Customer</th>
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
                    </tr>
                  </thead>
                  
                  <tbody>

                  </tbody>

                  <tfoot>
                    <tr>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th style="text-align:right;"></th>
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

  <!--Modal Delete Quotation-->
  <div class="modal fade" id="modal-delete-quotation-customer" tabindex="-1" role="dialog" aria-labelledby="modal-delete-quotation-customerLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      {!! Form::open(['url'=>'deleteQuotationCustomer', 'method'=>'post']) !!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="modal-delete-quotation-customerLabel">Confirmation</h4>
        </div>
        <div class="modal-body">
          You are going to delete <b id="quotation-code-to-delete"></b>
          <br/>
          <p class="text text-danger">
            <i class="fa fa-info-circle"></i>&nbsp;This process can not be reverted
          </p>
          <input type="hidden" id="quotation_customer_id" name="quotation_customer_id">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-danger">Delete</button>
        </div>
      {!! Form::close() !!}
      </div>
    </div>
  </div>
<!--ENDModal Delete Quotation-->

  
@endsection

@section('additional_scripts')
  <script type="text/javascript">
    var tableQuotationCustomer =  $('#quotation-customer').DataTable({
      processing :true,
      serverSide : true,
      ajax : '{!! url('quotation-customer/dataTables') !!}',
      columns :[
        {data: 'rownum', name: 'rownum', searchable:false},
        { data: 'code', name: 'code' },
        { data: 'customer', name: 'customer.name' },
        { data: 'amount', name: 'amount', className:'dt-body-right', searchable:false },
        { data: 'description', name: 'description' },
        { data: 'created_at', name: 'created_at' },
        { data: 'status', name: 'status' },
        { data: 'sales', name: 'sales.name' },
        { data: 'submitted_date', name: 'submitted_date' },
        { data: 'po_customer_code', name: 'po_customer.code' },
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
        [5, 'desc']
      ]

    });
    
    var buttonTableTools = new $.fn.dataTable.Buttons(tableQuotationCustomer,{
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
    tableQuotationCustomer.on('click', '.btn-delete-quotation-customer', function(e){
      var id = $(this).attr('data-id');
      var code = $(this).attr('data-text');
      $('#quotation_customer_id').val(id);
      $('#quotation-code-to-delete').text(code);
      $('#modal-delete-quotation-customer').modal('show');
    });

    // Setup - add a text input to each header cell
    $('#searchColumn th').each(function() {
      if ($(this).index() != 0 && $(this).index() != 10) {
        $(this).html('<input class="form-control" type="text" placeholder="Search" data-id="' + $(this).index() + '" />');
      }
          
    });
    //Block search input and select
    $('#searchColumn input').keyup(function() {
      tableQuotationCustomer.columns($(this).data('id')).search(this.value).draw();
    });
    //ENDBlock search input and select
    
  </script>
@endsection