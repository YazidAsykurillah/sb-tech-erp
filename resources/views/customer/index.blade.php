@extends('layouts.app')

@section('page_title')
    Customer
@endsection

@section('page_header')
  <h1>
    Customer
    <small>Daftar Customer</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('customer') }}"><i class="fa fa-briefcase"></i> Customer</a></li>
    <li class="active"><i></i> Index</li>
  </ol>
@endsection

@section('content')
  <div class="row">
    <div class="col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Customer</h3>
              <a href="{{ URL::to('customer/create')}}" class="btn btn-primary pull-right" title="Create new customer">
                <i class="fa fa-plus"></i>&nbsp;Add New
              </a>
            </div><!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="table-customer">
                  <thead>
                    <tr>
                      <th style="width:5%;">#</th>
                      <th style="width:20%;">Customer Name</th>
                      <th>Contact Number</th>
                      <th>Address</th>
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
              </table>
            </div>
          </div><!-- /.box-body -->
          <div class="box-footer clearfix">
            
          </div>
        </div><!-- /.box -->
    
    </div>
  </div>

  <!--Modal Delete Customer-->
  <div class="modal fade" id="modal-delete-customer" tabindex="-1" role="dialog" aria-labelledby="modal-delete-customerLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      {!! Form::open(['url'=>'deleteCustomer', 'method'=>'post']) !!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="modal-delete-customerLabel">Confirmation</h4>
        </div>
        <div class="modal-body">
          You are going to delete <b id="customer-name-to-delete"></b>
          <br/>
          <p class="text text-danger">
            <i class="fa fa-info-circle"></i>&nbsp;This process can not be reverted
          </p>
          <input type="hidden" id="customer_id" name="customer_id">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-danger">Delete</button>
        </div>
      {!! Form::close() !!}
      </div>
    </div>
  </div>
<!--ENDModal Delete Customer-->
@endsection

@section('additional_scripts')
  <script type="text/javascript">
    var tableCustomer =  $('#table-customer').DataTable({
      processing :true,
      serverSide : true,
      ajax : '{!! route('datatables.getCustomers') !!}',
      columns :[
        {data: 'rownum', name: 'rownum', searchable:false, orderable:true},
        { data: 'name', name: 'name' },
        { data: 'contact_number', name: 'contact_number' },
        { data: 'address', name: 'address' },
        { data: 'actions', name: 'actions', orderable:false, searchable:false },
      ],

    });

    // Delete button handler
    tableCustomer.on('click', '.btn-delete-customer', function(e){
      var id = $(this).attr('data-id');
      var name = $(this).attr('data-text');
      $('#customer_id').val(id);
      $('#customer-name-to-delete').text(name);
      $('#modal-delete-customer').modal('show');
    });

    // Setup - add a text input to each header cell
    $('#searchColumn th').each(function() {
      if ($(this).index() != 0 && $(this).index() != 4) {
        $(this).html('<input class="form-control" type="text" placeholder="Search" data-id="' + $(this).index() + '" />');
      }
          
    });
    //Block search input and select
    $('#searchColumn input').keyup(function() {
      tableCustomer.columns($(this).data('id')).search(this.value).draw();
    });
    //ENDBlock search input and select


    //Delete customer process
    $('#form-delete-customer').on('submit', function(){
      $('#btn-confirm-delete-customer').prop('disabled', true);
    });
    
  </script>
@endsection