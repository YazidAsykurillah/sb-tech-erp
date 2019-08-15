@extends('layouts.app')

@section('page_title')
    Task
@endsection

@section('page_header')
  <h1>
    Task
    <small>Daftar Task</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('task') }}"><i class="fa fa-cube"></i> Task</a></li>
    <li class="active"><i></i> Index</li>
  </ol>
@endsection

@section('content')
  <div class="row">
    <div class="col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Daftar Task</h3>
              <div class="pull-right">
                @if(\Auth::user()->can('create-task'))
                <a href="{{ URL::to('task/create')}}" class="btn btn-xs btn-primary" title="Create new Product">
                  <i class="fa fa-plus"></i>&nbsp;Add New
                </a>
                @endif
              </div>
              
            </div><!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table class="table" id="table-task">
                  <thead>
                    <tr>
                      <th style="width:5%;">#</th>
                      <th style="width:10%;">Project</th>
                      <th style="width:10%">PIC</th>
                      <th style="">Name</th>
                      <th style="width:10%">Description</th>
                      <th style="width:10%">Status</th>
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
    var tableTask =  $('#table-task').DataTable({
      processing :true,
      serverSide : true,
      ajax : '{!! url('task/dataTables') !!}',
      columns :[
        {data: 'rownum', name: 'rownum', searchable:false},
        { data: 'project.name', name: 'project.name' },
        { data: 'pic.name', name: 'pic.name' },
        { data: 'name', name: 'name' },
        { data: 'description', name: 'description' },
        { data: 'status', name: 'status' },
        { data: 'actions', name: 'actions', orderable:false, searchable:false, className:'dt-body-center' },
      ],

    });

    // Setup - add a text input to each header cell
    $('#searchColumn th').each(function() {
      if ($(this).index() != 0 && $(this).index() != 9) {
        $(this).html('<input class="form-control" type="text" placeholder="Search" data-id="' + $(this).index() + '" />');
      }
          
    });
    //Block search input and select
    $('#searchColumn input').keyup(function() {
      tableTask.columns($(this).data('id')).search(this.value).draw();
    });
    //ENDBlock search input and select
  </script>
@endsection