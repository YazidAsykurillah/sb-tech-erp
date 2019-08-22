@extends('layouts.app')

@section('page_title')
  Approved Cash Bond
@endsection

@section('page_header')
  <h1>
    Approved Cash Bond
    <small>Daftar Approved Cash Bond</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('cash-bond') }}"><i class="fa fa-money"></i> Cash Bond</a></li>
    <li class="active"><i></i> Approved</li>
  </ol>
@endsection
  
@section('content')
  <div class="row">
    <div class="col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Cash Bond</h3>
            </div><!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="table-cash-bond">
                  <thead>
                    <tr>
                      <th style="width:5%;">#</th>
                      <th style="width:20%;">Code</th>
                      <th>User</th>
                      <th>Amount</th>
                      <th>Description</th>
                      <th>Status</th>
                      <th>Transaction Date</th>
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
            
          </div>
        </div><!-- /.box -->
    </div>
  </div>

@endsection

@section('additional_scripts')
   <script type="text/javascript">
    var tableCashBond =  $('#table-cash-bond').DataTable({
      processing :true,
      serverSide : true,
      ajax : '{!! route('datatables.getApprovedCashbonds') !!}',
      columns :[
        {data: 'rownum', name: 'rownum', searchable:false},
        { data: 'code', name: 'code' },
        { data: 'user', name: 'user.name' },
        { data: 'amount', name: 'amount', className:'dt-body-right' },
        { data: 'description', name: 'description' },
        { data: 'status', name: 'status' },
        { data: 'transaction_date', name: 'transaction_date' },
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
        [1, 'desc']
      ]

    });

    // Delete button handler
    tableCashBond.on('click', '.btn-delete-cash-bond', function(e){
      var id = $(this).attr('data-id');
      var code = $(this).attr('data-text');
      $('#cashbond_id').val(id);
      $('#cash-bond-code-to-delete').text(code);
      $('#modal-delete-cash-bond').modal('show');
    });

    // Setup - add a text input to each header cell
    $('#searchColumn th').each(function() {
      if ($(this).index() != 0 && $(this).index() != 8) {
        $(this).html('<input class="form-control" type="text" placeholder="Search" data-id="' + $(this).index() + '" />');
      }
          
    });
    //Block search input and select
    $('#searchColumn input').keyup(function() {
      tableCashBond.columns($(this).data('id')).search(this.value).draw();
    });
    //ENDBlock search input and select
    
  </script>
@endsection