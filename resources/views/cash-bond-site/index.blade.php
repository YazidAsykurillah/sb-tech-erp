@extends('layouts.app')

@section('page_title')
    Cash Bond Site
@endsection

@section('page_header')
  <h1>
    Cash Bond Site
    <small>Daftar Cash Bond Site</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('cash-bond-site') }}"><i class="fa fa-money"></i> Cash Bond site</a></li>
    <li class="active"><i></i> Index</li>
  </ol>
@endsection
  
@section('content')
  <div class="row">
    <div class="col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Cash Bond Site</h3>
              <a href="{{ URL::to('cash-bond-site/create')}}" class="btn btn-primary pull-right" title="Create new Cash Bond site">
                <i class="fa fa-plus"></i>&nbsp;Add New
              </a>
            </div><!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="table-cash-bond-site">
                  <thead>
                    <tr>
                      <th style="width:5%;">#</th>
                      <th style="width:10%;">Code</th>
                      <th>Member</th>
                      <th>Amount</th>
                      <th>Description</th>
                      <th style="width:10%;">Transaction Date</th>
                      <th style="width:10%;">Accounted</th>
                      <th>Created Date</th>
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

  <!--Modal Delete Invoice Customer-->
  <div class="modal fade" id="modal-delete-cash-bond-site" tabindex="-1" role="dialog" aria-labelledby="modal-delete-cash-bond-siteLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      {!! Form::open(['url'=>'cash-bond-site/delete', 'method'=>'post']) !!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="modal-delete-PettyCashLabel">Confirmation</h4>
        </div>
        <div class="modal-body">
          You are going to delete <b id="cash-bond-site-code-to-delete"></b>
          <br/>
          <p class="text text-danger">
            <i class="fa fa-info-circle"></i>&nbsp;This process can not be reverted
          </p>
          <input type="hidden" id="cashbond_site_id" name="cashbond_site_id">
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
    var tableCashBondSite =  $('#table-cash-bond-site').DataTable({
      processing :true,
      serverSide : true,
      ajax : '{!! route('datatables.getCashbondSites') !!}',
      columns :[
        {data: 'rownum', name: 'rownum', searchable:false},
        { data: 'code', name: 'code' },
        { data: 'user', name: 'user.name' },
        { data: 'amount', name: 'amount', className:'dt-body-right' },
        { data: 'description', name: 'description' },
        { data: 'transaction_date', name: 'transaction_date' },
        { data: 'accounted', name: 'accounted' },
        { data: 'created_at', name: 'created_at' },
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

    });

    // Delete button handler
    tableCashBondSite.on('click', '.btn-delete-cash-bond-site', function(e){
      var id = $(this).attr('data-id');
      var code = $(this).attr('data-text');
      $('#cashbond_site_id').val(id);
      $('#cash-bond-site-code-to-delete').text(code);
      $('#modal-delete-cash-bond-site').modal('show');
    });

    // Setup - add a text input to each header cell
    $('#searchColumn th').each(function() {
      if ($(this).index() != 0 && $(this).index() != 8) {
        $(this).html('<input class="form-control" type="text" placeholder="Search" data-id="' + $(this).index() + '" />');
      }
          
    });
    //Block search input and select
    $('#searchColumn input').keyup(function() {
      tableCashBondSite.columns($(this).data('id')).search(this.value).draw();
    });
    //ENDBlock search input and select
    
  </script>
@endsection