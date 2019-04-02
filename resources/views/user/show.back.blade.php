@extends('layouts.app')

@section('page_title')
  Member Detail
@endsection

@section('page_header')
  <h1>
    Member
    <small>Member Detail</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('user') }}"><i class="fa fa-users"></i> Member</a></li>
    <li class="active"><i></i> Detail</li>
  </ol>
@endsection

@section('content')
  <div class="row">
    <div class="col-md-9">
      <!-- Profile Image -->
      <div class="box box-primary">
        <div class="box-body box-profile">
          @if($user->profile_picture != NULL)
            {!! Html::image('img/user/thumb_'.$user->profile_picture.'', $user->profile_picture, ['class'=>'profile-user-img img-responsive img-circle']) !!}
          @else
          @endif
          <h3 class="profile-username text-center">{{ $user->name }}</h3>

          <p class="text-muted text-center">{{ $user->roles->first()->name }}</p>
          <p class="text-muted text-center">{{ ucwords($user->type) }}</p>
          <p class="text-muted text-center">{{ $user->number_id }}</p>

          <ul class="list-group list-group-unbordered">
            <li class="list-group-item">
              <b>Email</b> <a class="pull-right">{{ $user->email }}</a>
            </li>
            <li class="list-group-item">
              <b>NIK</b> <a class="pull-right">{{ $user->nik }}</a>
            </li>
            <li class="list-group-item">
              <b>Salary</b> <a class="pull-right">{{ number_format($user->salary) }}</a>
            </li>
            <li class="list-group-item">
              <b>Status</b> <a class="pull-right">{{ strtoupper($user->status) }}</a>
            </li>
          </ul>
          
          <a href="{{ url('user/'.$user->id.'/edit') }}" class="btn btn-primary btn-block"><b>Edit</b></a>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>

    <div class="col-md-3">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-lock"></i>&nbsp;Locking Facility Statuses</h3>
        </div>
        <div class="box-body">
          <strong>Create Internal Request</strong>
          <p class="text text-muted">
            @if($lock_create_internal_request > 0 )
              <input type="checkbox" name="lock_create_internal_request" id="lock_create_internal_request" />
            @else
              <input type="checkbox" name="lock_create_internal_request" id="lock_create_internal_request" checked="checked" />
            @endif
          </p>
        </div>
      </div>
      
    </div>
  </div>

  <div class="row">
    @if($user->type == 'outsource')
    <div class="col-md-9">
      <!--Box Time Report Registration-->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-clock-o"></i>&nbsp;Time Report Sheet</h3>
        </div>
        <div class="box-body">
          <strong>Input Time Report Sheet</strong>
          <p class="text text-muted">
            <a href="{{ url('user/time-report/create/?user_id='.$user->id) }}">Go</a>
          </p>
        </div>
      </div>
      <!--ENDBox Time Report Registration-->
    </div>
    @endif
  </div>
@endsection

@section('additional_scripts')
  <script type="text/javascript">
    $('#lock_create_internal_request').on('click', function(){
      var user_id = '{!! $user->id !!}';
      var lock_create_internal_request = $(this).is(':checked');
      var token = $('meta[name="csrf-token"]').attr('content');
      if(lock_create_internal_request == true){
        $.ajax({
          url : '{!! url('user/unlock_create_internal_request') !!}',
          type : 'POST',
          data : 'user_id='+user_id+'&_token='+token,
          beforeSend : function(){},
          success : function(response){
            console.log(response);
          }
        });
      }
    });
  </script>
@endsection