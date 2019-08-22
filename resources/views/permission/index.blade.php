@extends('layouts.app')

@section('page_title')
    Pemission
@endsection

@section('page_header')
  <h1>
    Pemission
    <small>Daftar Pemission</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('permission') }}"><i class="fa fa-briefcase"></i> Permission</a></li>
    <li class="active"><i></i> Index</li>
  </ol>
@endsection

@section('content')
  <div class="row">
    <div class="col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Permission</h3>
              <a href="{{ URL::to('permission/create')}}" class="btn btn-primary pull-right" title="Create new Permission">
                <i class="fa fa-plus"></i>&nbsp;Add New
              </a>
            </div><!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="table-permission">
                  <thead>
                    <tr>
                      <th style="width:5%;">#</th>
                      <th style="width:20%;">Slug</th>
                      <th>Description</th>
                      <th style="width:10%;text-align:center;">Actions</th>
                    </tr>
                  </thead>
                  <thead id="searchColumn">
                    <tr>
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

@endsection

@section('additional_scripts')
  <script type="text/javascript">
    var tablePermission =  $('#table-permission').DataTable({
      processing :true,
      serverSide : true,
      ajax : '{!! route('datatables.getPermissions') !!}',
      columns :[
        {data: 'rownum', name: 'rownum', searchable:false, orderable:true},
        { data:'slug', name: 'slug' },
        { data:'description', name: 'description' },
        { data: 'actions', name: 'actions', orderable:false, searchable:false },
      ],

    });

    // Setup - add a text input to each header cell
    $('#searchColumn th').each(function() {
      if ($(this).index() != 0 && $(this).index() != 4) {
        $(this).html('<input class="form-control" type="text" placeholder="Search" data-id="' + $(this).index() + '" />');
      }
          
    });
    //Block search input and select
    $('#searchColumn input').keyup(function() {
      tablePermission.columns($(this).data('id')).search(this.value).draw();
    });
    //ENDBlock search input and select


    //Delete customer process
    $('#form-delete-customer').on('submit', function(){
      $('#btn-confirm-delete-customer').prop('disabled', true);
    });
    
  </script>
@endsection