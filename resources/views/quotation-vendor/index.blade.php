@extends('layouts.app')

@section('page_title')
    Quotation
@endsection

@section('page_header')
  <h1>
    Quotation
    <small>Daftar Quotation Vendor</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('quotation-vendor') }}"><i class="fa fa-archive"></i> Quotation Vendor</a></li>
    <li class="active"><i></i> Index</li>
  </ol>
@endsection

@section('content')
  <div class="row">
    <div class="col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Quotation</h3>
              <a href="{{ URL::to('quotation-vendor/create')}}" class="btn btn-primary pull-right" title="Create new Quotation">
                <i class="fa fa-plus"></i>&nbsp;Add New
              </a>
            </div><!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="quotation-vendor">
                  <thead>
                    <tr>
                      <th style="width:5%;">#</th>
                      <th style="width:15%;">Code</th>
                      <th style="width:15%;">Vendor</th>
                      <th style="text-align:right;">Amount</th>
                      <th>Description</th>
                      <th>Status</th>
                      <th>Creator</th>
                      <th style="width:10%;">Received Date</th>
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
  <div class="modal fade" id="modal-delete-quotation-vendor" tabindex="-1" role="dialog" aria-labelledby="modal-delete-quotation-vendorLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      {!! Form::open(['url'=>'deleteQuotationVendor', 'method'=>'post']) !!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="modal-delete-quotation-vendorLabel">Confirmation</h4>
        </div>
        <div class="modal-body">
          You are going to delete <b id="quotation-code-to-delete"></b>
          <br/>
          <p class="text text-danger">
            <i class="fa fa-info-circle"></i>&nbsp;This process can not be reverted
          </p>
          <input type="hidden" id="quotation_vendor_id" name="quotation_vendor_id">
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
    var tableQuotationVendor =  $('#quotation-vendor').DataTable({
      processing :true,
      serverSide : true,
      ajax : '{!! route('datatables.getQuotationVendors') !!}',
      columns :[
        {data: 'rownum', name: 'rownum', searchable:false},
        { data: 'code', name: 'code' },
        { data: 'vendor', name: 'vendor.name' },
        { data: 'amount', name: 'amount', className:'dt-body-right', searchable:false },
        { data: 'description', name: 'description' },
        { data: 'status', name: 'status' },
        { data: 'user', name: 'user.name' },
        { data: 'received_date', name: 'received_date' },
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
        [7, 'desc']
      ]

    });

    var buttonTableTools = new $.fn.dataTable.Buttons(tableQuotationVendor,{
        buttons: [
          {
            extend: 'excelHtml5',
            exportOptions: {
                columns: [0,1,2,3,4,5,6]
            }
          },
        ],
      }).container().appendTo($('#button-table-tools'));

    // Delete button handler
    tableQuotationVendor.on('click', '.btn-delete-quotation-vendor', function(e){
      var id = $(this).attr('data-id');
      var code = $(this).attr('data-text');
      $('#quotation_vendor_id').val(id);
      $('#quotation-code-to-delete').text(code);
      $('#modal-delete-quotation-vendor').modal('show');
    });

    // Setup - add a text input to each header cell
    $('#searchColumn th').each(function() {
      if ($(this).index() != 0 && $(this).index() != 8) {
        $(this).html('<input class="form-control" type="text" placeholder="Search" data-id="' + $(this).index() + '" />');
      }
          
    });
    //Block search input and select
    $('#searchColumn input').keyup(function() {
      tableQuotationVendor.columns($(this).data('id')).search(this.value).draw();
    });
    //ENDBlock search input and select
    
  </script>
@endsection