@extends('layouts.app')

@section('page_title')
  {{ $internal_request->code }}
@endsection

@section('page_header')
  <h1>
    Internal Request
    <small>Internal Request Detail</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('internal-request') }}"><i class="fa fa-tag"></i> Internal Request</a></li>
    <li class="active"><i></i> {{ $internal_request->code }}</li>
  </ol>
@endsection
  
@section('content')
  <div class="row">
    
    <div class="col-md-7">
      <!--BOX Basic Informations-->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-tag"></i>&nbsp;Internal Request Detail</h3>
          @if($internal_request->status == 'pending' || $internal_request->status == 'rejected')
            <a href="{{ URL::to('internal-request/'.$internal_request->id.'/edit')}}" class="btn btn-success btn-xs pull-right" title="Edit"><i class="fa fa-edit"></i>&nbsp;Edit
            </a>
          @endif
        </div><!-- /.box-header -->
        <div class="box-body">
          <div class="table-responsive">
            <table class="table">
              <tr>
                <td style="width: 30%;">Internal Request Number</td>
                <td style="width: 1%;">:</td>
                <td>{{ $internal_request->code }}</td>
              </tr>
              <tr>
                <td style="width: 30%;">Type</td>
                <td style="width: 1%;">:</td>
                <td>{{ $internal_request->type }}</td>
              </tr>
              <tr>
                <td style="width: 30%;">Amount</td>
                <td style="width: 1%;">:</td>
                <td>{{ number_format($internal_request->amount, 2) }}</td>
              </tr>
              <tr>
                <td style="width: 30%;">Description</td>
                <td style="width: 1%;">:</td>
                <td>{!! nl2br($internal_request->description) !!}</td>
              </tr>
              <tr>
                <td style="width: 30%;">Petty Cash</td>
                <td style="width: 1%;">:</td>
                <td>
                  @if($internal_request->is_petty_cash == TRUE)
                    <i class="fa fa-check"></i>
                  @else
                    <i class="fa fa-times"></i>
                  @endif
                </td>
              </tr>
              <tr>
                <td style="width: 30%;">Remitter Bank</td>
                <td style="width: 1%;">:</td>
                <td>
                  @if($internal_request->remitter_bank)
                    {{ $internal_request->remitter_bank->name }}
                  @endif
                </td>
              </tr>
              <tr>
                <td style="width: 30%;">Beneficiary Bank</td>
                <td style="width: 1%;">:</td>
                <td>
                  @if($internal_request->beneficiary_bank)
                    {{ $internal_request->beneficiary_bank->name }}
                  @endif
                </td>
              </tr>
              <tr>
                <td style="width: 20%;">Created Date</td>
                <td style="width: 1%;">:</td>
                <td>{{ jakarta_date_time($internal_request->created_at) }}</td>
              </tr>
              <tr>
                <td style="width: 20%;">Transaction Date</td>
                <td style="width: 1%;">:</td>
                <td>{{ $internal_request->transaction_date }}</td>
              </tr>
              @if(\Auth::user()->roles->first()->code == 'SUP' || \Auth::user()->roles->first()->code == 'ADM')
              <tr>
                <td style="width: 20%;">Accounted</td>
                <td style="width: 1%;">:</td>
                <td>
                  @if($internal_request->accounted == TRUE)
                    <i class="fa fa-check"></i>
                  @else
                    <i class="fa fa-hourglass"></i>
                  @endif
                </td>
              </tr>
              @endif
              <tr>
                <td style="width: 30%;">Status</td>
                <td style="width: 1%;">:</td>
                <td>
                  @if($internal_request->status == 'pending')
                    Pending
                  @elseif($internal_request->status == 'checked')
                    Checked
                  @elseif($internal_request->status == 'approved')
                    Approved
                  @elseif($internal_request->status == 'transacted')
                    Transacted
                  @elseif($internal_request->status == 'rejected')
                    Rejected
                  @else
                    Undefined Status
                  @endif

                  <span>
                      <!-- if user can change status and accounted status of this internal request is NOT TRUE-->
                      @if(\Auth::user()->can('change-status-internal-request') && $internal_request->accounted == FALSE )
                      <a href="#" id="btn-change-status" data-id="{{ $internal_request->id }}" data-text="{{ $internal_request->code }}" class="btn btn-link">
                        <i class="fa fa-cog"></i>&nbsp;Change Status
                      </a>
                      @endif
                  </span>
                  <p>{{ jakarta_date_time($internal_request->updated_at) }}</p>
                  
                </td>
              </tr>
              
            </table>
          </div>
          
        </div><!-- /.box-body -->
        
      </div>
      <!--ENDBOX Basic Informations-->

      <!--BOX Logs Information-->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-list-alt"></i>&nbsp;Logs</h3>
        </div>
        <div class="box-body">
          @if($the_logs->count() > 0)
            <table class="table table-striped">
            <thead>
                <tr>
                  <th style="width:20%;">Datetime</th>
                  <th style="width:20%;">User</th>
                  <th>Mode</th>
                  <th>Description</th>
                </tr>
              </thead>
            @foreach($the_logs as $the_log)
              <tr>
                <td>{{ jakarta_date_time($the_log->created_at) }}</td>
                <td>{{ $the_log->user->name }}</td>
                <td>{{ $the_log->mode }}</td>
                <td>{{ $the_log->description }}</td>
              </tr>
            @endforeach
            </table>
          @endif
        </div>
      </div>
      <!--ENDBOX Logs Information-->
    </div>
    <div class="col-md-5">

      <!--BOX Requester Information-->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-user"></i>&nbsp;Requester</h3>
        </div>
        <div class="box-body">
          <strong>Requester Name</strong>
          <p class="text-muted">{{ $internal_request->requester->name }}</p>
        </div>
      </div>
      <!--ENDBOX Requester Information-->

      <!--BOX Project Information-->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-legal"></i>&nbsp;Project</h3>
        </div>
        <div class="box-body">
          <strong>Project Number</strong>
          <p class="text-muted">
            @if($internal_request->project)
              {{ $internal_request->project->code }}
            @endif
          </p>
          <strong>Project Name</strong>
          <p class="text-muted">
            @if($internal_request->project)
              {{ $internal_request->project->name }}
            @endif
          </p>
        </div>
      </div>
      <!--ENDBOX Project Information-->

      <!--BOX Settlement Information-->
      @if($internal_request->type != "pindah_buku")
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-retweet"></i>&nbsp;Settlement</h3>
        </div>
        <div class="box-body">
          @if($internal_request->settlement)
          <strong>Code</strong>
          <p>
            <a href="{{ url('settlement/'.$internal_request->settlement->id) }}" title="Click to view the settlement detail"> 
              {{ $internal_request->settlement->code }}
            </a>
          </p>
          <strong>Amount</strong>
          <p>{{ number_format($internal_request->settlement->amount, 2) }}</p>
          <strong>Status</strong>
          <p>{{ $internal_request->settlement->status }}</p>
          @else
          <p class="alert alert-info">
            Doesn't have settlement data
          </p>
          @endif
        </div>
        <div class="box-footer clearfix">
          @if( $internal_request->status == 'approved')
            @if($internal_request->settlement == 0)
              <a href="{{ URL::to('settlement/create/?internal_request_id='.$internal_request->id.'')}}" class="btn btn-default btn-xs" title="Register a Settlement for this Internal Request">
                <i class="fa fa-plus"></i>&nbsp;Register Settlement
              </a>
            @endif
          @else
            
          @endif
        </div>
      </div>
      <!--ENDBOX Settlement Information-->
      @endif
    </div>

  </div>

  <!--Modal CHANGE STATUS-->
  <div class="modal fade" id="modal-change-status" tabindex="-1" role="dialog" aria-labelledby="modal-change-statusLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      {!! Form::open(['url'=>'changeInternalRequestStatus', 'method'=>'post']) !!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="modal-change-statusLabel">Change Status</h4>
        </div>
        <div class="modal-body">
          <p class="alert alert-info">
            <i class="fa fa-info-circle"></i>&nbsp;Select to change the internal request status
          </p>
          {!! Form::label('status', 'Status', ['class'=>'col-sm-2 control-label']) !!}
          <div class="col-sm-10">
            {{ Form::select('status', $status_opts, $internal_request->status, ['class'=>'form-control', 'id'=>'status']) }}
          </div>
          <br/>
        </div>
        <div class="modal-footer">
          <input type="hidden" id="internal_request_id" name="internal_request_id">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Change</button>
        </div>
      {!! Form::close() !!}
      </div>
    </div>
  </div>
<!--ENDModal CHANGE STATUS-->


 
@endsection

@section('additional_scripts')
   <script type="text/javascript">
    //Block Change Status
    $('#btn-change-status').on('click', function(event){
      event.preventDefault();
      $('#internal_request_id').val($(this).attr('data-id'));
      $('#modal-change-status').modal('show');
    });
    //ENDBlock Change Status
  </script>
@endsection