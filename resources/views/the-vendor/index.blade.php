@extends('layouts.app')

@section('page_title')
    Vendor
@endsection

@section('page_header')
  <h1>
    Vendor
    <small>Daftar Vendor</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('the-vendor') }}"><i class="fa fa-child"></i> Vendor</a></li>
    <li class="active"><i></i> Index</li>
  </ol>
@endsection

@section('content')
  <div class="row">
    <div class="col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Vendor</h3>
              <a href="{{ URL::to('the-vendor/create')}}" class="btn btn-primary pull-right" title="Create new vendor">
                <i class="fa fa-plus"></i>&nbsp;Add New
              </a>
            </div><!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="table-vendor">
                  <thead>
                    <tr>
                      <th style="width:5%;">#</th>
                      <th style="width:20%;">Vendor Name</th>
                      <th>Phone</th>
                      <th>Address</th>
                      <th>Product Name</th>
                      <th>Bank Account</th>
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
              </table>
            </div>
          </div><!-- /.box-body -->
          <div class="box-footer clearfix">
            
          </div>
        </div><!-- /.box -->
    
    </div>
  </div>

  <!--Modal Delete Vendor-->
  <div class="modal fade" id="modal-delete-vendor" tabindex="-1" role="dialog" aria-labelledby="modal-delete-vendorLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      {!! Form::open(['url'=>'deleteVendor', 'method'=>'post']) !!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="modal-delete-vendorLabel">Confirmation</h4>
        </div>
        <div class="modal-body">
          You are going to delete <b id="vendor-name-to-delete"></b>
          <br/>
          <p class="text text-danger">
            <i class="fa fa-info-circle"></i>&nbsp;This process can not be reverted
          </p>
          <input type="hidden" id="vendor_id" name="vendor_id">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-danger">Delete</button>
        </div>
      {!! Form::close() !!}
      </div>
    </div>
  </div>
<!--ENDModal Delete Vendor-->
@endsection

@section('additional_scripts')
  <script type="text/javascript">
    var tableVendor =  $('#table-vendor').DataTable({
      processing :true,
      serverSide : true,
      ajax : '{!! url('the-vendor/dataTables') !!}',
      columns :[
        {data: 'rownum', name: 'rownum', searchable:false, orderable:true},
        { data: 'name', name: 'name' },
        { data: 'phone', name: 'phone' },
        { data: 'address', name: 'address' },
        { data: 'product_name', name: 'product_name' },
        { data: 'bank_account', name: 'bank_account', orderable:false},
        { data: 'actions', name: 'actions', orderable:false, searchable:false, className:'dt-body-center' },
      ],

    });

    // Delete button handler
    tableVendor.on('click', '.btn-delete-vendor', function(e){
      var id = $(this).attr('data-id');
      var name = $(this).attr('data-text');
      $('#vendor_id').val(id);
      $('#vendor-name-to-delete').text(name);
      $('#modal-delete-vendor').modal('show');
    });

    // Setup - add a text input to each header cell
    $('#searchColumn th').each(function() {
      if ($(this).index() != 0 && $(this).index() != 6) {
        $(this).html('<input class="form-control" type="text" placeholder="Search" data-id="' + $(this).index() + '" />');
      }
          
    });
    //Block search input and select
    $('#searchColumn input').keyup(function() {
      tableVendor.columns($(this).data('id')).search(this.value).draw();
    });
    //ENDBlock search input and select


    //Delete vendor process
    $('#form-delete-vendor').on('submit', function(){
      $('#btn-confirm-delete-vendor').prop('disabled', true);
    });
    
  </script>
@endsection