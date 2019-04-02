@extends('layouts.app')

@section('page_title')
  My Profile
@endsection

@section('page_header')
  <h1>
    My Profile
    <small></small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('my-profile') }}"><i class="fa fa-users"></i> My Profile</a></li>
    <li class="active"><i></i> Detail</li>
  </ol>
@endsection

@section('content')
  <div class="row">
    <div class="col-md-7">
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
              <b>Man Hour Rate</b> <a class="pull-right">{{ number_format($user->man_hour_rate) }}</a>
            </li>
            <li class="list-group-item">
              <b>Status</b> <a class="pull-right">{{ strtoupper($user->status) }}</a>
            </li>
          </ul>
          
          <a href="{{ url('my-profile/edit') }}" class="btn btn-primary btn-block"><b>Edit</b></a>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>

    <div class="col-md-5">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-cog"></i>&nbsp;Change Password</h3>
        </div>
        <div class="box-body">
          {!! Form::open(['url'=>'my-profile/updatePassword', 'class'=>'form form-horizontal', 'role'=>'form', 'method'=>'post', 'name'=>'form_update_password']) !!}
            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
              {!! Form::label('password', 'Password', ['class'=>'col-sm-2 control-label']) !!}
              <div class="col-sm-10">
                {!! Form::password('password',['class'=>'form-control', 'placeholder'=>'Your new password', 'id'=>'password']) !!}
                @if ($errors->has('password'))
                  <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                  </span>
                @endif
              </div>
            </div>
            <div class="form-group{{ $errors->has('password_conf') ? ' has-error' : '' }}">
              {!! Form::label('password_conf', 'Password Confirmation', ['class'=>'col-sm-2 control-label']) !!}
              <div class="col-sm-10">
                {!! Form::password('password_conf',['class'=>'form-control', 'placeholder'=>'Your new password_confirmation', 'id'=>'password_conf']) !!}
                @if ($errors->has('password_conf'))
                  <span class="help-block">
                    <strong>{{ $errors->first('password_conf') }}</strong>
                  </span>
                @endif
              </div>
            </div>
            <div class="form-group">
                <div class="col-md-6">
                  <button type="submit" class="btn btn-primary">
                      <i class="fa fa-save"></i> Save
                  </button>
                </div>
            </div>
          {!! Form::close() !!}
      </div>
    </div>

    
  </div>

  
@endsection

@section('additional_scripts')
  
@endsection