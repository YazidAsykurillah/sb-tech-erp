@extends('layouts.app')

@section('page_title')
  Task :: {{ $task->name}}
@endsection

@section('page_header')
  <h1>
    Task
    <small>Task Detail</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('task') }}"><i class="fa fa-cube"></i> Task</a></li>
    <li class="active"><i></i> Show</li>
  </ol>
@endsection

@section('content')
  <div class="row">
    <!--Left Column-->
    <div class="col-md-8">
      <!--Box Task Information-->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"> <i class="fa fa-list"></i> Task Information</h3>
        </div>
        <div class="box-body">
          <table class="table">
            <tr>
              <td style="width: 50%;">Name</td>
              <td style="width: 5%;">:</td>
              <td style="">{{ $task->name }}</td>
            </tr>
            <tr>
              <td style="width: 50%;">Description</td>
              <td style="width: 5%;">:</td>
              <td style="">{{ $task->description }}</td>
            </tr>
            <tr>
              <td style="width: 50%;">Start Date Schedule</td>
              <td style="width: 5%;">:</td>
              <td style="">{{ $task->start_date_schedule }}</td>
            </tr>
            <tr>
              <td style="width: 50%;">Finish Date Schedule</td>
              <td style="width: 5%;">:</td>
              <td style="">{{ $task->finish_date_schedule }}</td>
            </tr>
            <tr>
              <td style="width: 50%;">Status</td>
              <td style="width: 5%;">:</td>
              <td style="">{{ $task->status }}</td>
            </tr>
          </table>
        </div>
        <div class="box-footer clearfix"></div>
      </div>
      <!--ENDBox Task Information-->

      <!--Box Task Assignee-->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"> <i class="fa fa-users"></i> Task Assignee</h3>
          <div class="pull-right">
            <button type="button" class="btn btn-sm btn-default" data-toggle="modal" data-target=".modal-add-task-assignee">
              <i class="fa fa-plus-circle"></i> Add Assignee
            </button>
          </div>
        </div>
        <div class="box-body">
          <table class="table" id="table-task-assignee">
            <thead>
                    <tr>
                      <th style="width:5%;">#</th>
                      <th style="">Name</th>
                      <th style="">Working Hour</th>
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
                  <tfoot>
                    <tr>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                    </tr>
                  </tfoot>
          </table>
        </div>
        <div class="box-footer clearfix"></div>
      </div>
      <!--ENDBox Task Assignee-->
    </div>
    <!--ENDLeft Column-->

    <!--Right Column-->
    <div class="col-md-4">

      <!--Box Project-->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"> <i class="fa fa-legal"></i> Project Information</h3>
        </div>
        <div class="box-body">
          @if($project)
          <table class="table">
            <tr>
              <td style="width: 50%;">Code</td>
              <td style="width: 5%;">:</td>
              <td style="">{{ $project->code }}</td>
            </tr>
            <tr>
              <td style="width: 50%;">Name</td>
              <td style="width: 5%;">:</td>
              <td style="">{{ $project->name }}</td>
            </tr>
            <tr>
              <td style="width: 50%;">Description</td>
              <td style="width: 5%;">:</td>
              <td style="">{{ $project->description }}</td>
            </tr>
          </table>
          @endif
        </div>
        <div class="box-footer clearfix"></div>
      </div>
      <!--ENDBox Project-->

      <!--Box Creator-->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"> <i class="fa fa-user"></i> Creator</h3>
        </div>
        <div class="box-body box-profile">
          @if($creator)
            @if($creator->profile_picture != NULL)
              {!! Html::image('img/user/thumb_'.$creator->profile_picture.'', $creator->profile_picture, ['class'=>'profile-user-img img-responsive img-circle']) !!}
            @else
            @endif
            <h5 class="profile-username text-center">{{ $creator->name }}</h5>
          @endif
        </div>
      </div>
      <!--ENDBox Creator-->

    </div>
    <!--ENDRight Column-->

  </div>

  <!--Modal Add Task Assignee-->
  <div class="modal fade modal-add-task-assignee" tabindex="-1" role="dialog" aria-labelledby="modal-add-task-assigneeLabel">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Cancel"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Add Assignee</h4>
        </div>
        <div class="modal-body">
          <form class="form-horizontal" id="form-submit-task-assignee">
            <div class="form-group">
              <label for="user_id" class="col-sm-2 control-label">User</label>
              <div class="col-sm-10">
                <select class="form-control" id="user_id" style="width: 100%;"></select>
              </div>
            </div>
            <div class="form-group">
              <label for="working_hour" class="col-sm-2 control-label">Working Hour</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="working_hour" placeholder="Working Hour">
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="button" id="btn-submit-task-assignee" class="btn btn-primary">Submit</button>
        </div>
      </div>
    </div>
  </div>
  <!--ENDModal Add Task Assignee-->
@endsection

@section('additional_scripts')
<script type="text/javascript">
  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
 //Initiate row selection handler
    var selectedTaskAssignee = [];

    var tableTaskAssignee =  $('#table-task-assignee').DataTable({
      processing :true,
      serverSide : true,
      ajax : {
        url : '{!! url('task-assignee/getDataPerTask') !!}',
        data: function(d){
          d.task_id = '{!! $task->id !!}';
        }
      },
      columns :[
        {data: 'rownum', name: 'rownum', searchable:false},
        { data: 'user_name', name: 'user.name' },
        { data: 'working_hour', name: 'working_hour' },
        { data: 'actions', name: 'actions', orderable:false, searchable:false, className:'dt-body-center' },
      ],

    });

    // Setup - add a text input to each header cell
    $('#searchColumn th').each(function() {
      if ($(this).index() != 0 && $(this).index() != 3) {
        $(this).html('<input class="form-control" type="text" placeholder="Search" data-id="' + $(this).index() + '" />');
      }
          
    });
    //Block search input and select
    $('#searchColumn input').keyup(function() {
      tableTaskAssignee.columns($(this).data('id')).search(this.value).draw();
    });
    //ENDBlock search input and select

    //Block event task rows selections
    tableTaskAssignee.on( 'click', 'tr', function () {
      $(this).toggleClass('selected');
    });
    //ENDBlock event task rows selections

    //Block delete task
    $('#btn-delete').on('click', function(event){
      event.preventDefault();
      selectedTaskAssignee = [];
      var selected_task_id = tableTaskAssignee.rows('.selected').data();
      $.each( selected_task_id, function( key, value ) {
        selectedTaskAssignee.push(selected_task_id[key].id);
      });
      if(selectedTaskAssignee.length == 0){
        alert('There are no selected row');
      }else{
        $('#form-delete-task-assignee').find('.id_to_delete').remove();
        $('.selected_task_counter').html(selectedTaskAssignee.length);
        $.each( selectedTaskAssignee, function( key, value ) {
          $('#form-delete-task-assignee').append('<input type="hidden" class="id_to_delete" name="id_to_delete[]" value="'+value+'"/>');
        });
        $('#modal-delete-task-assignee').modal('show');
      }
    });
    //ENDBlock delete task

    //Block User Selection
    $('#user_id').select2({
      placeholder: 'Select Member',
      ajax: {
        url: '{!! url('task-assignee/select2User') !!}',
        dataType: 'json',
        delay: 250,
        processResults: function (data) {
          return {
            results:  $.map(data, function (item) {
                  return {
                      text: item.name,
                      id: item.id
                  }
              })
          };
        },
        cache: true
      }
    });
    //ENDBlock User Selection

    //Block submit task assignee
    $("#btn-submit-task-assignee").click(function(){
        $.ajax({
            url: '/task-assignee',
            type: 'POST',
            data: {_token: CSRF_TOKEN, user_id:$('#user_id').val(), working_hour:$('#working_hour').val(), task_id:'{!! $task->id !!}'},
            dataType: 'JSON',
            success: function (data) { 
              console.log(data);
              if(data.success == true){
                $('.modal-add-task-assignee').modal('toggle');
                $('#user_id').val(null).trigger('change');
                document.getElementById('form-submit-task-assignee').reset();
                tableTaskAssignee.ajax.reload();
              }else{
                alert('not success');
              }
            }
        }); 
    });
    //ENDBlock submit task assignee
</script>
@endsection