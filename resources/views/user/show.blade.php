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
    <li class="active"><i></i> {{ $user->name }}</li>
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
          <p class="text-muted text-center">{{ $user->number_id }}</p>

          <div class="row">
            <div class="col-md-7">
              <div class="panel panel-default">
                <div class="panel-heading">
                  <div class="panel-title">
                    <i class="fa fa-user"></i>&nbsp;General Information
                  </div>
                </div>
                <div class="panel-body">
                  <div class="table-responsive">
                    <table class="table table-striped">
                      <tr>
                        <td style="width:40%;">NIK</td>
                        <td style="width:5%;">:</td>
                        <td>{{ $user->nik }} </td>
                      </tr>
                      <tr>
                        <td style="width:40%;">Role</td>
                        <td style="width:5%;">:</td>
                        <td>{{ $user->roles->first()->name }} </td>
                      </tr>
                      <tr>
                        <td style="width:40%;">Position</td>
                        <td style="width:5%;">:</td>
                        <td>{{ ucwords($user->position) }} </td>
                      </tr>
                      <tr>
                        <td style="width:40%;">Type</td>
                        <td style="width:5%;">:</td>
                        <td>{{ ucwords($user->type) }} </td>
                      </tr>
                      <tr>
                        <td style="width:40%;">Email</td>
                        <td style="width:5%;">:</td>
                        <td>{{ $user->email }} </td>
                      </tr>
                      <tr>
                        <td style="width:40%;">Status</td>
                        <td style="width:5%;">:</td>
                        <td>{{ strtoupper($user->status) }} </td>
                      </tr>
                      <tr>
                        <td style="width:40%;">Work Active Date</td>
                        <td style="width:5%;">:</td>
                        <td>{{ $user->work_activation_date }} </td>
                      </tr>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-5">
              <div class="panel panel-default">
                <div class="panel-heading">
                  <div class="panel-title">
                    <i class="fa fa-thumbs-up"></i>&nbsp;Salary &amp; Allowances
                  </div>
                </div>
                <div class="panel-body">
                  <div class="table-responsive">
                    <table class="table table-striped">
                      <tr>
                        <td style="width:40%;">Basic Salary</td>
                        <td style="width:5%;">:</td>
                        <td>{{ number_format($user->salary, 2) }} </td>
                      </tr>
                      <tr>
                        <td style="width:40%;">Man Hour Rate</td>
                        <td style="width:5%;">:</td>
                        <td>{{ number_format($user->man_hour_rate, 2) }} </td>
                      </tr>
                      <tr>
                        <td style="width:40%;">Eat Allowance</td>
                        <td style="width:5%;">:</td>
                        <td>{{ number_format($user->eat_allowance, 2) }} </td>
                      </tr>
                      <tr>
                        <td style="width:40%;">Transportation Allowance</td>
                        <td style="width:5%;">:</td>
                        <td>{{ number_format($user->transportation_allowance, 2) }} </td>
                      </tr>
                      <tr>
                        <td style="width:40%;">Medical Allowance</td>
                        <td style="width:5%;">:</td>
                        <td>{{ number_format($user->medical_allowance, 2) }} </td>
                      </tr>
                      <tr>
                        <td style="width:40%;">Incentive Week Day</td>
                        <td style="width:5%;">:</td>
                        <td>{{ number_format($user->incentive_week_day, 2) }} </td>
                      </tr>
                      
                      <tr>
                        <td style="width:40%;">Incentive Week End</td>
                        <td style="width:5%;">:</td>
                        <td>{{ number_format($user->incentive_week_end, 2) }} </td>
                      </tr>
                      
                      <tr>
                        <td style="width:40%;">BPJS Kesehatan</td>
                        <td style="width:5%;">:</td>
                        <td>{{ number_format($user->bpjs_ke, 2) }} </td>
                      </tr>
                      <tr>
                        <td style="width:40%;">BPJS Tenaga Kerja</td>
                        <td style="width:5%;">:</td>
                        <td>{{ number_format($user->bpjs_tk, 2) }} </td>
                      </tr>
                      
                    </table>
                  </div>
                </div>
              </div>
            </div>

          </div>
          
          
          <a href="{{ url('user/'.$user->id.'/edit') }}" class="btn btn-success btn-block"><b><i class="fa fa-edit"></i>&nbsp;Edit</b></a>
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

      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-cog"></i>&nbsp;Super Admin Facilities</h3>
        </div>
        <div class="box-body">
          @if(\Auth::user()->can('reset-user-password'))
          <button class="btn btn-danger" id="btn-reset-password">Reset Password</button>
          @endif
        </div>
      </div>
      
    </div>
  </div>

  <div class="row">
    
    <div class="col-md-9">
      <!--Box Time Report Registration-->
      <!--
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-clock-o"></i>&nbsp;Time Report Sheet</h3>
        </div>
        <div class="box-body">
          <div class="table-responsive">
              <table class="table table-bordered" id="table-user-time-period">
                <thead>
                  <tr>
                    <th style="width:5%;">#</th>
                    <th style="width:15%;">Period</th>
                    <th style="width:10%;">Year</th>
                    <th style="width:10%;">Month</th>
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
                  </tr>
                </thead>
                
                <tbody>

                </tbody>
            </table>
          </div>
        </div>
      </div>
    -->
      <!--ENDBox Time Report Registration-->
    </div>
    
  </div>

  <!--Modal Reset Password-->
  <div class="modal fade" id="modal-reset-password" tabindex="-1" role="dialog" aria-labelledby="modal-reset-passwordLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      {!! Form::open(['url'=>'resetPassword', 'method'=>'post']) !!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="modal-reset-passwordLabel">Confirmation</h4>
        </div>
        <div class="modal-body">
          You are going to reset password of this user
          <br/>
          <p class="text text-danger">
            <i class="fa fa-info-circle"></i>&nbsp;This process can not be reverted
          </p>
          <input type="hidden" id="user_id" name="user_id" value="{{ $user->id }}">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-danger">Reset Password</button>
        </div>
      {!! Form::close() !!}
      </div>
    </div>
  </div>
<!--ENDModal Reset Password-->
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

    var tableUserTimePeriod =  $('#table-user-time-period').DataTable({
      processing :true,
      serverSide : true,
      ajax : {
        "url" : '{!! route('datatables.getUserTimePeriods') !!}',
        "data" : {
          "user_id" : '{!! $user->id !!}',
        }

      },
      columns :[
        {data: 'rownum', name: 'rownum', searchable:false},
        { data: 'code', name: 'code' },
        { data: 'the_year', name: 'the_year' },
        { data: 'the_month', name: 'the_month' },
        { data: 'actions', name: 'actions', orderable:false, searchable:false, className:'dt-body-center' },
      ],

    });

    //reset password control
    $('#btn-reset-password').on('click', function(){
      $('#modal-reset-password').modal('show');
    });
  </script>
@endsection