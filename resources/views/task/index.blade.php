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
                @if(\Auth::user()->can('delete-task'))
                <a href="javascript::void()" id="btn-delete" class="btn btn-xs btn-danger" title="Delete selected task">
                  <i class="fa fa-trash"></i>&nbsp;Delete
                </a>
                @endif
                @if(\Auth::user()->can('change-task-status'))
                <a href="javascript::void()" id="btn-change-taks-status" class="btn btn-xs btn-info" title="Change task status">
                  <i class="fa fa-cog"></i>&nbsp;Change Status
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
                      <th style="">Name</th>
                      <th style="width:10%">Description</th>
                      <th style="width:10%">Creator</th>
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

  <!--Modal Delete Task-->
  <div class="modal fade" id="modal-delete-task" tabindex="-1" role="dialog" aria-labelledby="modal-delete-taskLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      {!! Form::open(['url'=>'task/delete', 'role'=>'form', 'id'=>'form-delete-task', 'class'=>'form-horizontal', 'method'=>'post']) !!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="modal-delete-taskLabel">Delete Confirmation</h4>
        </div>
        <div class="modal-body">
          <span class="selected_task_counter"></span> Task(s) will be deleted
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-danger" id="btn-submit-delete">Delete</button>
        </div>
      {!! Form::close() !!}
      </div>
    </div>
  </div>
<!--ENDModal Delete Task-->

<!--Modal Change Task Status-->
  <div class="modal fade" id="modal-change-task-status" tabindex="-1" role="dialog" aria-labelledby="modal-change-task-statusLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      {!! Form::open(['url'=>'task/change-status', 'role'=>'form', 'id'=>'form-change-task-status', 'class'=>'form-horizontal', 'method'=>'post']) !!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="modal-change-task-statusLabel">Change status confirmation</h4>
        </div>
        <div class="modal-body">
          <span class="selected_task_counter"></span> Task(s) selected
          <div class="form-group{{ $errors->has('task_status') ? ' has-error' : '' }}">
            {!! Form::label('task_status', 'Status', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              <select name="task_status" id="task_status" class="form-control" style="width:100%;" required>
                <option value="draft">Draft</option>
                <option value="ongoing">Ongoing</option>
                <option value="completed">Completed</option>
              </select>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-info" id="btn-submit-change-status">Change Status</button>
        </div>
      {!! Form::close() !!}
      </div>
    </div>
  </div>
<!--ENDModal Change Task Status-->
  
@endsection

@section('additional_scripts')
 <script type="text/javascript">
    //Initiate row selection handler
    var selectedTask = [];

    var tableTask =  $('#table-task').DataTable({
      processing :true,
      serverSide : true,
      ajax : '{!! url('task/dataTables') !!}',
      columns :[
        {data: 'rownum', name: 'rownum', searchable:false},
        { data: 'project.name', name: 'project.name' },
        { data: 'name', name: 'name' },
        { data: 'description', name: 'description' },
        { data: 'creator.name', name: 'creator.name' },
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

    //Block event task rows selections
    tableTask.on( 'click', 'tr', function () {
      $(this).toggleClass('selected');
    });
    //ENDBlock event task rows selections

    //Block delete task
    $('#btn-delete').on('click', function(event){
      event.preventDefault();
      selectedTask = [];
      var selected_task_id = tableTask.rows('.selected').data();
      $.each( selected_task_id, function( key, value ) {
        selectedTask.push(selected_task_id[key].id);
      });
      if(selectedTask.length == 0){
        alert('There are no selected row');
      }else{
        $('#form-delete-task').find('.id_to_delete').remove();
        $('.selected_task_counter').html(selectedTask.length);
        $.each( selectedTask, function( key, value ) {
          $('#form-delete-task').append('<input type="hidden" class="id_to_delete" name="id_to_delete[]" value="'+value+'"/>');
        });
        $('#modal-delete-task').modal('show');
      }
    });
    //ENDBlock delete task

    //Block change task status
    $('#btn-change-taks-status').on('click', function(event){
      event.preventDefault();
      selectedTask = [];
      var selected_task_id = tableTask.rows('.selected').data();
      $.each( selected_task_id, function( key, value ) {
        selectedTask.push(selected_task_id[key].id);
      });
      if(selectedTask.length == 0){
        alert('There are no selected row');
      }else{
        $('#form-change-task-status').find('.id_to_change').remove();
        $('.selected_task_counter').html(selectedTask.length);
        $.each( selectedTask, function( key, value ) {
          $('#form-change-task-status').append('<input type="hidden" class="id_to_change" name="id_to_change[]" value="'+value+'"/>');
        });
        $('#modal-change-task-status').modal('show');
      }
    });
    //ENDBlock change task status
    
    

  </script>
@endsection