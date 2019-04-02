@extends('layouts.app')

@section('page_title')
  Pending Internal Request
@endsection

@section('page_header')
  <h1>
    Internal Request
    <small>Daftar Internal Request</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('internal-request') }}"><i class="fa fa-tag"></i> Internal Request</a></li>
    <li class="active"><i></i> Pending</li>
  </ol>
@endsection
  
@section('content')
  <div class="row">
    <div class="col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Internal Request</h3>
              <a href="{{ URL::to('internal-request/create')}}" class="btn btn-primary pull-right" title="Create new Invoice Customer">
                <i class="fa fa-plus"></i>&nbsp;Add New
              </a>
            </div><!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="table-internal-request">
                  <thead>
                    <tr>
                      <th style="width:5%;">#</th>
                      <th style="width:15%;">IR Number</th>
                      <th>Project</th>
                      <th style="width:15%;">Description</th>
                      <th style="width:10%;text-align:right;">Amount</th>
                      <th style="width:5%;text-align:center;">Petty Cash</th>
                      <th>Remitter Bank</th>
                      <th>Beneficiary Bank</th>
                      <th>Requester</th>
                      <th>Transaction Date</th>
                      <th>Status</th>
                      <th>Settled</th>
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
                      <th style="text-align:right;"></th>
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
            
          </div>
        </div><!-- /.box -->
    </div>
  </div>

  <!--Modal Delete Invoice Customer-->
  <div class="modal fade" id="modal-delete-internal-request" tabindex="-1" role="dialog" aria-labelledby="modal-delete-internal-requestLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      {!! Form::open(['url'=>'deleteInternalRequest', 'method'=>'post']) !!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="modal-delete-InvoiceCustomerLabel">Confirmation</h4>
        </div>
        <div class="modal-body">
          You are going to delete <b id="internal-request-code-to-delete"></b>
          <br/>
          <p class="text text-danger">
            <i class="fa fa-info-circle"></i>&nbsp;This process can not be reverted
          </p>
          <input type="hidden" id="internal_request_id" name="internal_request_id">
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
    var tableInternalRequest =  $('#table-internal-request').DataTable({
      processing :true,
      serverSide : true,
      ajax : '{!! route('datatables.getPendingInternalRequests') !!}',
      columns :[
        {data: 'rownum', name: 'rownum', searchable:false},
        { data: 'code', name: 'code' },
        { data: 'project', name: 'project.code' },
        { data: 'description', name: 'description' },
        { data: 'amount', name: 'amount', className:'dt-body-right' },
        { data: 'is_petty_cash', name: 'is_petty_cash', className:'dt-body-center' },
        { data: 'remitter_bank', name: 'remitter_bank.name' },
        { data: 'beneficiary_bank', name: 'beneficiary_bank.name' },
        { data: 'requester', name: 'requester.name' },
        { data: 'transaction_date', name: 'transaction_date' },
        { data: 'status', name: 'status' },
        { data: 'settled', name: 'settled' },
        { data: 'accounted', name: 'accounted' },
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
            .column(4)
            .data()
            .reduce( function (a, b) {
                return theFloat(a) + theFloat(b);
            }, 0 );
        // Update footer
        $( api.column(4).footer() ).html(
            total.toLocaleString()
        );
      }

    });

    // Delete button handler
    tableInternalRequest.on('click', '.btn-delete-internal-request', function(e){
      var id = $(this).attr('data-id');
      var code = $(this).attr('data-text');
      $('#internal_request_id').val(id);
      $('#internal-request-code-to-delete').text(code);
      $('#modal-delete-internal-request').modal('show');
    });

    // Setup - add a text input to each header cell
    $('#searchColumn th').each(function() {
      if ($(this).index() != 0 && $(this).index() != 13) {
        $(this).html('<input class="form-control" type="text" placeholder="Search" data-id="' + $(this).index() + '" />');
      }
          
    });
    //Block search input and select
    $('#searchColumn input').keyup(function() {
      tableInternalRequest.columns($(this).data('id')).search(this.value).draw();
    });
    //ENDBlock search input and select
    
  </script>
@endsection