@extends('layouts.app')

@section('page_title')
    Member
@endsection

@section('page_header')
  <h1>
    Member
    <small>Daftar Member</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('user') }}"><i class="fa fa-users"></i> Member</a></li>
    <li class="active"><i></i> Index</li>
  </ol>
@endsection

@section('content')
  <div class="row">
    <div class="col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Member</h3>
              <a href="{{ URL::to('user/create')}}" class="btn btn-primary pull-right" title="Create new member">
                <i class="fa fa-plus"></i>&nbsp;Add New
              </a>
            </div><!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="table-user">
                  <thead>
                    <tr>
                      <th style="width:5%;">#</th>
                      <th style="width:10%;">NIK</th>
                      <th>Name</th>
                      <th>Type</th>
                      <th>Role</th>
                      <th>Position</th>
                      <th>Salary</th>
                      <th style="width:10%;text-align:center;">Status</th>
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
              </table>
            </div>
          </div><!-- /.box-body -->
          <div class="box-footer clearfix">
            
          </div>
        </div><!-- /.box -->
    
    </div>
  </div>

  <!--Modal Delete User-->
  <div class="modal fade" id="modal-delete-user" tabindex="-1" role="dialog" aria-labelledby="modal-delete-userLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      {!! Form::open(['url'=>'deleteUser', 'method'=>'post']) !!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="modal-delete-userLabel">Confirmation</h4>
        </div>
        <div class="modal-body">
          You are going to delete <b id="user-name-to-delete"></b>
          <br/>
          <p class="text text-danger">
            <i class="fa fa-info-circle"></i>&nbsp;This process can not be reverted
          </p>
          <input type="hidden" id="user_id" name="user_id">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-danger">Delete</button>
        </div>
      {!! Form::close() !!}
      </div>
    </div>
  </div>
<!--ENDModal Delete User-->
@endsection

@section('additional_scripts')
  <script type="text/javascript">
    var tableUser =  $('#table-user').DataTable({
      processing :true,
      serverSide : true,
      ajax : '{!! route('datatables.getUsers') !!}',
      columns :[
        {data: 'rownum', name: 'rownum', searchable:false},
        { data: 'nik', name: 'nik' },
        { data: 'name', name: 'name' },
        { data: 'type', name: 'type' },
        { data: 'roles', name: 'roles.name'},
        { data: 'position', name: 'position'},
        { data: 'salary', name: 'salary'},
        { data: 'status', name: 'status', className:'dt-body-center'},
        { data: 'actions', name: 'actions', orderable:false, searchable:false, className:'dt-body-center' },
      ],
      order : [
        [1, 'asc']
      ]
    });

    // Delete button handler
    tableUser.on('click', '.btn-delete-user', function(e){
      var id = $(this).attr('data-id');
      var name = $(this).attr('data-text');
      $('#user_id').val(id);
      $('#user-name-to-delete').text(name);
      $('#modal-delete-user').modal('show');
    });

    // Setup - add a text input to each header cell
    $('#searchColumn th').each(function() {
      if($(this).index() != 0 && $(this).index() != 8) {
        $(this).html('<input class="form-control" type="text" placeholder="Search" data-id="' + $(this).index() + '" />');
      }
      if($(this).index() == 6){
        $(this).html('<select class="dt-selection form-control" data-id="' + $(this).index() + '" ><option value="active">Active</option><option value="inactive">Inactive</option></select>');
      }
    });
    //Block search input and select
    $('#searchColumn input').keyup(function() {
      tableUser.columns($(this).data('id')).search(this.value).draw();
    });

    $('#searchColumn .dt-selection').on('change', function(){
      tableUser.columns($(this).data('id')).search(this.value).draw();
    });
    //ENDBlock search input and select

    //Delete user process
    $('#form-delete-user').on('submit', function(){
      $('#btn-confirm-delete-user').prop('disabled', true);
    });
    
  </script>
@endsection