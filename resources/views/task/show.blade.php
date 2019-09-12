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
              <td style="width: 50%;">Status</td>
              <td style="width: 5%;">:</td>
              <td style="">{{ $task->status }}</td>
            </tr>
          </table>
        </div>
        <div class="box-footer clearfix"></div>
      </div>
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
          <h3 class="box-title"> <i class="fa fa-user"></i> Creator Information</h3>
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

  
@endsection

@section('additional_scripts')
<script type="text/javascript">
    
</script>
@endsection