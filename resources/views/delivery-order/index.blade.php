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
                      <th style="">Project</th>
                      <th style="">Creator</th>
                      <th style="">Sender</th>
                      <th style="">Status</th>
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

  <!--Modal Delete Delivery Order-->
  <div class="modal fade" id="modal-delete-delivery-order" tabindex="-1" role="dialog" aria-labelledby="modal-delete-delivery-orderLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      {!! Form::open(['url'=>'deleteDeliveryOrder', 'id'=>'form-delete-delivery-order' , 'method'=>'post']) !!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="modal-delete-delivery-orderLabel">Confirmation</h4>
        </div>
        <div class="modal-body">
          You are going to delete <b id="delivery-order-code-to-delete"></b>
          <br/>
          <p class="text text-danger">
            <i class="fa fa-info-circle"></i>&nbsp;This process can not be reverted
          </p>
          <input type="hidden" id="delivery_order_id_to_delete" name="delivery_order_id_to_delete">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-danger" id="btn-delete-delivery-order">Delete</button>
        </div>
      {!! Form::close() !!}
      </div>
    </div>
  </div>
<!--ENDModal Delete Delivery Order-->

  
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
        { data: 'project', name: 'project.code' },
        { data: 'user_id', name: 'creator.name' },
        { data: 'sender_id', name: 'sender.name' },
        { data: 'status', name: 'status' },
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
      if ($(this).index() != 0 && $(this).index() != 6) {
        $(this).html('<input class="form-control" type="text" placeholder="Search" data-id="' + $(this).index() + '" />');
      }
          
    });
    //Block search input and select
    $('#searchColumn input').keyup(function() {
      dataTable.columns($(this).data('id')).search(this.value).draw();
    });
    //ENDBlock search input and select


    // Delete button handler
    dataTable.on('click', '.btn-delete-delivery-order', function(e){
      var id = $(this).attr('data-id');
      var code = $(this).attr('data-text');
      $('#delivery_order_id_to_delete').val(id);
      $('#delivery-order-code-to-delete').text(code);
      $('#modal-delete-delivery-order').modal('show');
    });

    //Delete delivery-order process
    $('#form-delete-delivery-order').on('submit', function(){
      $('#btn-confirm-delete-delivery-order').prop('disabled', true);
    });
    
  </script>

@endsection