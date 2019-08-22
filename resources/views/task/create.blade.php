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
    <li class="active"><i></i> Create</li>
  </ol>
@endsection

@section('content')
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Create Task</h3>
        </div><!-- /.box-header -->
        <div class="box-body">

        </div><!-- /.box-body -->
        <div class="box-footer clearfix">
          {!! Form::open(['route'=>'task.store','role'=>'form','class'=>'form-horizontal','id'=>'form-save','files'=>true]) !!}
            <div class="form-group{{ $errors->has('project_id') ? ' has-error' : '' }}">
              {!! Form::label('project_id', 'Project', ['class'=>'col-sm-2 control-label']) !!}
              <div class="col-sm-10">
                <select name="project_id" id="project_id" class="form-control">
                  @if(Request::old('project_id') != NULL)
                    <option value="{{Request::old('project_id')}}">
                      {!! \App\Project::find(Request::old('project_id'))->code !!}
                    </option>
                  @endif
                </select>
                @if ($errors->has('project_id'))
                  <span class="help-block">
                    <strong>{{ $errors->first('project_id') }}</strong>
                  </span>
                @endif
              </div>
            </div>
            <div class="form-group{{ $errors->has('user_id') ? ' has-error' : '' }}">
              {!! Form::label('user_id', 'PIC ', ['class'=>'col-sm-2 control-label']) !!}
              <div class="col-sm-10">
                <select name="user_id" id="user_id" class="form-control">
                  @if(Request::old('user_id') != NULL)
                    <option value="{{Request::old('user_id')}}">
                      {!! \App\User::find(Request::old('user_id'))->name !!}
                    </option>
                  @endif
                </select>
                @if ($errors->has('user_id'))
                  <span class="help-block">
                    <strong>{{ $errors->first('user_id') }}</strong>
                  </span>
                @endif
              </div>
            </div>
            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
              {!! Form::label('name', 'Name', ['class'=>'col-sm-2 control-label']) !!}
              <div class="col-sm-10">
                {!! Form::text('name',null,['class'=>'form-control', 'placeholder'=>'Name of the task', 'id'=>'name']) !!}
                @if ($errors->has('name'))
                  <span class="help-block">
                    <strong>{{ $errors->first('name') }}</strong>
                  </span>
                @endif
              </div>
            </div>
            <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
              {!! Form::label('description', 'Description', ['class'=>'col-sm-2 control-label']) !!}
              <div class="col-sm-10">
                {!! Form::textarea('description',null,['class'=>'form-control', 'placeholder'=>'Description of the task', 'id'=>'description']) !!}
                @if ($errors->has('description'))
                  <span class="help-block">
                    <strong>{{ $errors->first('description') }}</strong>
                  </span>
                @endif
              </div>
            </div>
            <div class="form-group">
              {!! Form::label('', '', ['class'=>'col-sm-2 control-label']) !!}
              <div class="col-sm-10">
                <a href="{{ url('task') }}" class="btn btn-default">
                  <i class="fa fa-repeat"></i>&nbsp;Cancel
                </a>&nbsp;
                <button type="submit" class="btn btn-info" id="btn-save">
                  <i class="fa fa-save"></i>&nbsp;Save
                </button>
              </div>
            </div>
          {!! Form::close() !!}
        </div>
      </div><!-- /.box -->
    </div>
  </div>

  
@endsection

@section('additional_scripts')
<script type="text/javascript">
  //Block Project Selection
  $('#project_id').select2({
    placeholder: 'Select Project',
    ajax: {
      url: '{!! url('task/select2Project') !!}',
      dataType: 'json',
      delay: 250,
      processResults: function (data) {
        return {
          results:  $.map(data, function (item) {
                return {
                    text: item.code,
                    id: item.id,
                    name:item.name
                }
            })
        };
      },
      cache: true
    },
    allowClear : true,
    templateResult : templateResultProject,
  }).on('select2:select', function(){
    
  });
  function templateResultProject(results){
    if(results.loading){
      return "Searching...";
    }
    var markup = '<span>';
        markup+=  results.text;
        markup+=  '<br/>';
        markup+=  results.name;
        markup+= '</span>';
    return $(markup);
  }
  //ENDBlock Project Selection

  //Block User Selection
  $('#user_id').select2({
    placeholder: 'Select PIC',
    ajax: {
      url: '{!! url('task/select2User') !!}',
      dataType: 'json',
      delay: 250,
      processResults: function (data) {
        return {
          results:  $.map(data, function (item) {
                return {
                    text: item.name,
                    id: item.id,
                }
            })
        };
      },
      cache: true
    },
    allowClear : true,
    templateResult : templateResultUser,
  }).on('select2:select', function(){
    
  });
  function templateResultUser(results){
    if(results.loading){
      return "Searching...";
    }
    var markup = '<span>';
        markup+=  results.text;
        markup+=  '<br/>';
        markup+= '</span>';
    return $(markup);
  }
  //ENDBlock User Selection

  //Form submission handling
  $('#form-save').on('submit',function(){
    $('#btn-save').prop('disabled', true);
  });
  //ENDForm submission handling
</script>
@endsection