@extends('layouts.app')

@section('page_title')
    Delivery Order
@endsection

@section('page_header')
  <h1>
    Delivery Order
    <small>Daftar Delivery Order</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('delivery-order') }}"><i class="fa fa-bookmark-o"></i> Delivery Order</a></li>
    <li class="active"><i></i> Index</li>
  </ol>
@endsection

@section('content')
  <div class="row">
    <div class="col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Delivery Order</h3>
              <a href="{{ URL::to('delivery-order/create')}}" class="btn btn-primary pull-right" title="Create new Delivery Order">
                <i class="fa fa-plus"></i>&nbsp;Add New
              </a>
            </div><!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="data-table">
                  <thead>
                    <tr>
                      <th style="width:5%;">#</th>
                      <th style="">DO Number</th>
                      <th style="">PO Vendor Number</th>
                      <th style="">Creator</th>
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

  
@endsection

@section('additional_scripts')
  <script type="text/javascript">
    var dataTable =  $('#data-table').DataTable({
      processing :true,
      serverSide : true,
      ajax : '{!! url('delivery-order/dataTables') !!}',
      columns :[
        {data: 'rownum', name: 'rownum', searchable:false, orderable:true},
        { data: 'code', name: 'code' },
        { data: 'purchase_order_vendor_id', name: 'purchase_order_vendor_id' },
        { data: 'user_id', name: 'user_id' },
        { data: 'actions', name: 'actions', orderable:false, searchable:false },
      ],

    });

    // Delete button handler
    dataTable.on('click', '.btn-delete-delivery-order', function(e){
      var id = $(this).attr('data-id');
      var code = $(this).attr('data-text');
      $('#delivery-order_id').val(id);
      $('#delivery-order-code-to-delete').text(code);
      $('#modal-delete-delivery-order').modal('show');
    });

    // Setup - add a text input to each header cell
    $('#searchColumn th').each(function() {
      if ($(this).index() != 0 && $(this).index() != 4) {
        $(this).html('<input class="form-control" type="text" placeholder="Search" data-id="' + $(this).index() + '" />');
      }
          
    });
    //Block search input and select
    $('#searchColumn input').keyup(function() {
      dataTable.columns($(this).data('id')).search(this.value).draw();
    });
    //ENDBlock search input and select


    //Delete delivery-order process
    $('#form-delete-delivery-order').on('submit', function(){
      $('#btn-confirm-delete-delivery-order').prop('disabled', true);
    });
    
  </script>

@endsection