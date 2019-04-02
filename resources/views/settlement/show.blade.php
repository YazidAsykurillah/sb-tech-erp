@extends('layouts.app')

@section('page_title')
    {{ $settlement->code }}
@endsection

@section('page_header')
  <h1>
    Settlement
    <small>Detail of Settlement</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('settlement') }}"><i class="fa fa-retweet"></i>Settlement</a></li>
    <li class="active"><i></i> {{ $settlement->code }}</li>
  </ol>
@endsection
  
@section('content')
  <div class="row">
    <div class="col-md-7">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-retweet"></i>&nbsp;Settlement</h3>
          @if($settlement->status == 'pending' || $settlement->status == 'rejected')
          <a href="{{ URL::to('settlement/'.$settlement->id.'/edit')}}" class="btn btn-xs btn-success pull-right" title="Edit settlement">
            <i class="fa fa-edit"></i>&nbsp;Edit
          </a>
          @endif
        </div><!-- /.box-header -->
        <div class="box-body">
          <div class="table-responsive">
            <table class="table">
              <tr>
                <td style="width: 20%;">Settlement Code</td>
                <td style="width: 1%;">:</td>
                <td>{{ $settlement->code }}</td>
              </tr>
              <tr>
                <td style="width: 20%;">Transaction Date</td>
                <td style="width: 1%;">:</td>
                <td>{{ $settlement->transaction_date }}</td>
              </tr>
              <tr>
                <td style="width: 20%;">Amount</td>
                <td style="width: 1%;">:</td>
                <td>{{ number_format($settlement->amount, 2) }}</td>
              </tr>
              <tr>
                <td style="width: 20%;">Description</td>
                <td style="width: 1%;">:</td>
                <td>{!! nl2br($settlement->description) !!}</td>
              </tr>
              <tr>
                <td style="width: 20%;">Result</td>
                <td style="width: 1%;">:</td>
                <td>{{ $settlement->result }}</td>
              </tr>
              <tr>
                <td style="width: 20%;">Created Date</td>
                <td style="width: 1%;">:</td>
                <td>{{ jakarta_date_time($settlement->created_at) }}</td>
              </tr>
              <tr>
                <td style="width: 20%;">Status</td>
                <td style="width: 1%;">:</td>
                <td>
                  {{ ucwords($settlement->status) }}
                  @if(\Auth::user()->roles->first()->code == 'SUP' || \Auth::user()->roles->first()->code == 'ADM' || \Auth::user()->roles->first()->code == 'FIN' )
                  <span>
                      <a href="#" id="btn-change-status" data-id="{{ $settlement->id }}" data-text="{{ $settlement->code }}" class="btn btn-link">
                        <i class="fa fa-cog"></i>&nbsp;Change Status
                      </a>
                  </span>
                  @endif
                </td>
              </tr>
              <tr>
                <td style="width: 20%;">Last Updater</td>
                <td style="width: 1%;">:</td>
                <td>{{ $settlement->last_updater->name }}</td>
              </tr>
              
            </table>
          </div>
        </div><!-- /.box-body -->
        <div class="box-footer clearfix">
          
        </div>
      </div><!-- /.box -->

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
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-tag"></i>&nbsp;Internal Request</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          <div class="table-responsive">
            @if($settlement->internal_request)
            <table class="table">
              <tr>
                <td style="width: 25%;">IR Code</td>
                <td style="width: 1%;">:</td>
                <td>
                  <a href="{{ url('internal-request/'.$settlement->internal_request->id) }}">
                    {{ $settlement->internal_request->code }}
                  </a>
                </td>
              </tr>
              <tr>
                <td style="width: 25%;">Amount</td>
                <td style="width: 1%;">:</td>
                <td>{{ number_format($settlement->internal_request->amount, 2) }}</td>
              </tr>
              <tr>
                <td style="width: 25%;">Descrption</td>
                <td style="width: 1%;">:</td>
                <td>{!! nl2br($settlement->internal_request->description) !!}</td>
              </tr>
              <tr>
                <td style="width: 25%;">Remitter Bank</td>
                <td style="width: 1%;">:</td>
                <td>
                  @if($settlement->internal_request->remitter_bank)
                    {{ $settlement->internal_request->remitter_bank->name }}
                  @endif
                </td>
              </tr>
              <tr>
                <td style="width: 25%;">Beneficiary Bank</td>
                <td style="width: 1%;">:</td>
                <td>
                    @if($settlement->internal_request->beneficiary_bank)
                      {{ $settlement->internal_request->beneficiary_bank->name }}
                    @endif
                </td>
              </tr>
              <tr>
                <td style="width: 25%;">Balance</td>
                <td style="width: 1%;">:</td>
                <td>{{ $settlement->internal_request->amount - $settlement->amount }}</td>
              </tr>

            </table>
            @endif
          </div>
        </div><!-- /.box-body -->
        <div class="box-footer clearfix">
          
        </div>
      </div><!-- /.box -->


      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-legal"></i>&nbsp;Project</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          <div class="table-responsive">
            @if($settlement->internal_request)
            <table class="table">
              <tr>
                <td style="width: 25%;">Code</td>
                <td style="width: 1%;">:</td>
                <td>
                  <a href="{{ url('project/'.$settlement->internal_request->project->id.'') }}">
                    {{ $settlement->internal_request->project->code }}
                  </a>
                </td>
              </tr>
              <tr>
                <td style="width: 25%;">Name</td>
                <td style="width: 1%;">:</td>
                <td>
                  {{ $settlement->internal_request->project->name }}
                </td>
              </tr>
            </table>
            @endif
          </div>
        </div><!-- /.box-body -->
        <div class="box-footer clearfix">
          
        </div>
      </div><!-- /.box -->

    </div>

  </div>

  <!--Modal CHANGE STATUS-->
  <div class="modal fade" id="modal-change-status" tabindex="-1" role="dialog" aria-labelledby="modal-change-statusLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      {!! Form::open(['url'=>'changeSettlementStatus', 'method'=>'post']) !!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="modal-change-statusLabel">Change Status</h4>
        </div>
        <div class="modal-body">
          <p class="alert alert-info">
            <i class="fa fa-info-circle"></i>&nbsp;Select to change the settlement status
          </p>
          {!! Form::label('status', 'Status', ['class'=>'col-sm-2 control-label']) !!}
          <div class="col-sm-10">
            {{ Form::select('status', $status_opts, $settlement->status, ['class'=>'form-control', 'id'=>'status']) }}
          </div>
          <br/>
        </div>
        <div class="modal-footer">
          <input type="hidden" id="settlement_id" name="settlement_id">
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
      $('#settlement_id').val($(this).attr('data-id'));
      $('#modal-change-status').modal('show');
    });
    //ENDBlock Change Status
  </script>
@endsection