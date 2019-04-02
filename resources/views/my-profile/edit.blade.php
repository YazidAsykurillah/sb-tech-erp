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
  {!! Form::model($user, ['route'=>['my-profile.update', $user->id], 'class'=>'form-horizontal','id'=>'form-edit-user', 'method'=>'put', 'files'=>true]) !!}
  <div class="row">
    <div class="col-md-8">
      <!--BOX Basic Informations-->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Basic Information</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            {!! Form::label('name', 'Member Name', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {!! Form::text('name',null,['class'=>'form-control', 'placeholder'=>'Name of the member', 'id'=>'name']) !!}
              @if ($errors->has('name'))
                <span class="help-block">
                  <strong>{{ $errors->first('name') }}</strong>
                </span>
              @endif
            </div>
          </div>

          <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            {!! Form::label('email', 'Email', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {!! Form::text('email',null,['class'=>'form-control', 'placeholder'=>'Email of the member', 'id'=>'email']) !!}
              @if ($errors->has('email'))
                <span class="help-block">
                  <strong>{{ $errors->first('email') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <div class="form-group{{ $errors->has('number_id') ? ' has-error' : '' }}">
            {!! Form::label('number_id', 'NIK', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {!!Form::text('number_id',$user->nik,['class'=>'form-control', 'placeholder'=>'NIK of the member', 'id'=>'number_id', 'disabled'=>true])!!}
              @if ($errors->has('number_id'))
                <span class="help-block">
                  <strong>{{ $errors->first('number_id') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <div class="form-group{{ $errors->has('salary') ? ' has-error' : '' }}">
            {!! Form::label('salary', 'Salary', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {!!Form::text('salary',null,['class'=>'form-control', 'placeholder'=>'Salary of the member', 'id'=>'salary', 'disabled'=>true])!!}
              @if ($errors->has('salary'))
                <span class="help-block">
                  <strong>{{ $errors->first('salary') }}</strong>
                </span>
              @endif
            </div>
          </div>
          
        </div><!-- /.box-body -->
      </div>
      <!--ENDBOX Basic Informations-->
    </div>

    <div class="col-md-4">
      <!--BOX Image-->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Profile Picture</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
            {!! Form::label('image', 'Profile Picture', ['class'=>'col-sm-4 control-label']) !!}
            <div class="col-sm-8">
              @if($user->profile_picture != NULL)
                <div class="thumbnail" style="width:171px;">
                  {!! Html::image('img/user/thumb_'.$user->profile_picture.'', $user->profile_picture) !!}
                </div>
              @endif
              {{ Form::file('image', ['class']) }}
              @if ($errors->has('image'))
                <span class="help-block">
                  <strong>{{ $errors->first('image') }}</strong>
                </span>
              @endif
            </div>
          </div>
        </div><!-- /.box-body -->
      </div>
      <!--ENDBOX Image-->
    </div>
  </div>

  <div class="row">
    <div class="col-md-8">
      <div class="box">
        <div class="box-body">
          <div class="form-group">
              {!! Form::label('', '', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              <a href="{{ url('my-profile') }}" class="btn btn-default">
                <i class="fa fa-repeat"></i>&nbsp;Cancel
              </a>&nbsp;
              <button type="submit" class="btn btn-info" id="btn-submit-user">
                <i class="fa fa-save"></i>&nbsp;Update
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  {!! Form::close() !!}
@endsection

@section('additional_scripts')

  {!! Html::script('js/autoNumeric.js') !!}
  <script type="text/javascript">
    $('#salary').autoNumeric('init',{
        aSep:',',
        aDec:'.'
    });

    $('#form-edit-user').on('submit', function(){
      $('#btn-submit-user').prop('disabled', true);
    });
  </script>
@endsection