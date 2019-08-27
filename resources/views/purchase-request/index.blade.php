@extends('layouts.app')

@section('page_title')
    Purchase Request
@endsection

@section('page_header')
  <h1>
    Purchase Request
    <small>Daftar Purchase Request</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('purchase-request') }}"><i class="fa fa-tag"></i> Purchase Request</a></li>
    <li class="active"><i></i> Index</li>
  </ol>
@endsection

@section('content')
  <div class="row">
    <div class="col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Purchase Request</h3>
              
              <div class="pull-right">
                <a href="{{ URL::to('purchase-request/create')}}" class="btn btn-primary btn-xs" title="Create new Purchase Request">
                  <i class="fa fa-plus"></i>&nbsp;Add New
                </a>
                @if(\Auth::user()->can('approve-purchase-request'))
                <button type="button" class="btn btn-success btn-xs" id="btn-approve">
                  <i class="fa fa-check"></i> Approve Multiple
                </button>  
                @endif
              </div>
              
            </div><!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="table-purchase-request">
                  <thead>
                    <tr>
                      <th style="width:5%;">#</th>
                      <th>Member</th>
                      <th style="width:10%;">Code</th>
                      <th style="width:10%;">Project</th>
                      <th>Quotation Vendor</th>
                      <th>Vendor</th>
                      <th>Description</th>
                      <th style="text-align:right;">Amount</th>
                      <th>Created Date</th>
                      <th>Status</th>
                      <th>PO Vendor</th>
                      <th>MIGO</th>
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
  <div class="modal fade" id="modal-delete-purchaseRequest" tabindex="-1" role="dialog" aria-labelledby="modal-delete-purchaseRequestLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      {!! Form::open(['url'=>'deletePurchaseRequest', 'method'=>'post']) !!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="modal-delete-purchaseRequestLabel">Confirmation</h4>
        </div>
        <div class="modal-body">
          You are going to delete <b id="po-customer-code-to-delete"></b>
          <br/>
          <p class="text text-danger">
            <i class="fa fa-info-circle"></i>&nbsp;This process can not be reverted
          </p>
          <input type="hidden" id="purchase_request_id" name="purchase_request_id">
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

<!--Modal Approve Multiple-->
  <div class="modal fade" id="modal-approve" tabindex="-1" role="dialog" aria-labelledby="modal-approveLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      {!! Form::open(['url'=>'purchase-request/approve', 'id'=> 'form-approve', 'method'=>'post']) !!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="modal-approveLabel">Confirmation</h4>
        </div>
        <div class="modal-body">
          <p class="text text-danger">
            <span id="selected_purchase_request_counter"></span> purchase request(s) will be approved
          </p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-info">Approve</button>
        </div>
      {!! Form::close() !!}
      </div>
    </div>
  </div>
<!--ENDModal Approve Multiple-->
@endsection

@section('additional_scripts')
  <script type="text/javascript">
    var tablePurchaseRequest =  $('#table-purchase-request').DataTable({
      lengthMenu: [[10, 25, 100, 500, -1], [10, 25, 100, 500, "All"]],
      processing :true,
      serverSide : true,
      ajax : '{!! url('purchase-request/dataTables') !!}',
      columns :[
        {data: 'rownum', name: 'rownum', searchable:false, orderable:true},
        { data: 'user', name: 'user.name' },
        { data: 'code', name: 'code' },
        { data: 'project_id', name: 'project.code' },
        { data: 'quotation_vendor', name: 'quotation_vendor.code' },
        { data: 'vendor_name', name: 'quotation_vendor.vendor.name' },
        { data: 'description', name: 'description' },
        { data: 'amount', name: 'amount', className:'dt-body-right' },
        { data: 'created_at', name: 'created_at' },
        { data: 'status', name: 'status' },
        { data: 'purchase_order_vendor', name: 'purchase_order_vendor.code' },
        { data: 'migo', name: 'migo.code' },
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
        [8, 'desc']
      ]

    });

    var buttonTableTools = new $.fn.dataTable.Buttons(tablePurchaseRequest,{
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
    tablePurchaseRequest.on('click', '.btn-delete-purchase-request', function(e){
      var id = $(this).attr('data-id');
      var code = $(this).attr('data-text');
      $('#purchase_request_id').val(id);
      $('#po-customer-code-to-delete').text(code);
      $('#modal-delete-purchaseRequest').modal('show');
    });

    // Setup - add a text input to each header cell
    $('#searchColumn th').each(function() {
      if ($(this).index() != 0 && $(this).index() != 12) {
        $(this).html('<input class="form-control" type="text" placeholder="Search" data-id="' + $(this).index() + '" />');
      }
          
    });
    //Block search input and select
    $('#searchColumn input').keyup(function() {
      tablePurchaseRequest.columns($(this).data('id')).search(this.value).draw();
    });
    //ENDBlock search input and select

    //Purchase request row selection handler
    var selectedPurchaseRequest = [];
    tablePurchaseRequest.on( 'click', 'tr', function () {
      $(this).toggleClass('selected');
    });
    //ENDPurchase request row selection handler
    //Approve handler
    $('#btn-approve').on('click', function(event){
      event.preventDefault();
      selectedPurchaseRequest = [];
      var selected_purchase_request_id = tablePurchaseRequest.rows('.selected').data();
      $.each( selected_purchase_request_id, function( key, value ) {
        selectedPurchaseRequest.push(selected_purchase_request_id[key].id);
      });
      if(selectedPurchaseRequest.length == 0){
        alert('There are no selected row');
      }else{
        $('#form-approve').find('.id_to_approve').remove();
        $('#selected_purchase_request_counter').html(selectedPurchaseRequest.length);
        $.each( selectedPurchaseRequest, function( key, value ) {
          $('#form-approve').append('<input type="hidden" class="id_to_approve" name="id_to_approve[]" value="'+value+'"/>');
        });
        $('#modal-approve').modal('show');  
      }
      
    });
    //ENDApprove handler
  </script>
@endsection