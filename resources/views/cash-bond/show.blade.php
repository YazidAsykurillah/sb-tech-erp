@extends('layouts.app')

@section('page_title')
  {{ $cashbond->code }}
@endsection

@section('additional_styles')
  {!! Html::style('css/datepicker/datepicker3.css') !!}
@endsection

@section('page_header')
  <h1>
    Cash Bond
    <small>Cashbond Detail</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('cash-bond') }}"><i class="fa fa-money"></i> Cash Bond</a></li>
    <li class="active"><i></i> {{ $cashbond->code }}</li>
  </ol>
@endsection
  
@section('content')
 <div class="row">
    <div class="col-md-7">
      <!--BOX Basic Informations-->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-money"></i>&nbsp;Cashbond Information</h3>
          @if($cashbond->status == 'pending' || $cashbond->status == 'rejected')
          <a href="{{ URL::to('cash-bond/'.$cashbond->id.'/edit')}}" class="btn btn-success btn-xs pull-right" title="Edit">
                <i class="fa fa-edit"></i>&nbsp;Edit
          </a>
          @endif
        </div><!-- /.box-header -->
        <div class="box-body">
          <div class="table-responsive">
            <table class="table">
              <tr>
                <td style="width: 20%;">Code</td>
                <td style="width: 1%;">:</td>
                <td>{{ $cashbond->code }}</td>
              </tr>
              <tr>
                <td style="width: 20%;">Amount</td>
                <td style="width: 1%;">:</td>
                <td>{{ number_format($cashbond->amount, 2) }}</td>
              </tr>
              <tr>
                <td style="width: 20%;">Description</td>
                <td style="width: 1%;">:</td>
                <td>{{ nl2br($cashbond->description) }}</td>
              </tr>
              <tr>
                <td style="width: 20%;">Created Date</td>
                <td style="width: 1%;">:</td>
                <td>{{ jakarta_date_time($cashbond->created_at) }}</td>
              </tr>
              <tr>
                <td style="width: 20%;">Status</td>
                <td style="width: 1%;">:</td>
                <td>
                  {{ $cashbond->status }}
                  @if( \Auth::user()->roles->first()->code == 'SUP' || \Auth::user()->roles->first()->code == 'ADM')
                  <span>
                    <a href="#" id="btn-change-status" data-id="{{ $cashbond->id }}" data-text="{{ $cashbond->code }}" class="btn btn-link">
                      <i class="fa fa-cog"></i>&nbsp;Change Status
                    </a>
                  </span>
                  @endif
                </td>
              </tr>
              <tr>
                <td style="width: 20%;">Transaction Date</td>
                <td style="width: 1%;">:</td>
                <td>{{ $cashbond->transaction_date }}</td>
              </tr>
              <tr>
                <td style="width: 20%;">Potong Gaji</td>
                <td style="width: 1%;">:</td>
                <td>
                  {{ $cashbond->cut_from_salary == TRUE ? 'YES' : 'NO' }}
                  @if(\Auth::user()->can('change-cash-bond-status'))
                    <span>
                    <a href="#" id="btn-set-cut-from-salary" data-id="{{ $cashbond->id }}" data-text="{{ $cashbond->code }}" class="btn btn-link">
                      <i class="fa fa-cog"></i>&nbsp;Potong Gaji
                    </a>
                  </span>
                  @endif
                </td>
              </tr>
              <tr>
                <td style="width: 20%;">Term</td>
                <td style="width: 1%;">:</td>
                <td>{{ $cashbond->term }} Bulan</td>
              </tr>
              <tr>
                <td style="width: 20%;">Payment Status</td>
                <td style="width: 1%;">:</td>
                <td>
                  @if($cashbond->payment_status == TRUE)
                    Lunas
                  @else
                    Belum Lunas
                  @endif
                </td>
              </tr>
              
            </table>
          </div>
        </div><!-- /.box-body -->
        <div class="box-footer clearfix">
          
        </div>
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
      <!--BOX User Informations-->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-user"></i>&nbsp;User Information</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          <strong>Name</strong>
          <p class="text-muted">
            @if($cashbond->user)
            {{ $cashbond->user->name }}
            @endif
          </p>
        </div><!-- /.box-body -->
        <div class="box-footer clearfix">
          
        </div>
      </div>
      <!--ENDBOX User Informations-->

      <!--BOX Installments-->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-money"></i>&nbsp;Installments</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Amount</th>
                <th>Schedule</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              @if($cashbond->cashbond_installments->count())
                @foreach($cashbond->cashbond_installments as $cashbond_installment)
                <tr>
                  <td>{{ number_format($cashbond_installment->amount,2) }}</td>
                  <td>
                    {{ $cashbond_installment->installment_schedule }}
                    @if($cashbond_installment->status == 'unpaid')
                      @if(\Auth::user()->can('update-installment-schedule'))
                      <button class="btn btn-default btn-sm btn-change-schedule" data-id="{{ $cashbond_installment->id }}" data-original-schedule="{{ $cashbond_installment->installment_schedule }}">
                        <i class="fa fa-calendar"></i>
                      </button>
                      @endif
                    @endif
                  </td>
                  <td>{{ $cashbond_installment->status }}</td>
                </tr>
                @endforeach
              @endif
            </tbody>
          </table>
        </div><!-- /.box-body -->
        <div class="box-footer clearfix">
          
        </div>
      </div>
      <!--ENDBOX Installments-->
    </div>
  </div>

  <!--Modal CHANGE STATUS-->
  <div class="modal fade" id="modal-change-status" tabindex="-1" role="dialog" aria-labelledby="modal-change-statusLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      {!! Form::open(['url'=>'changeCashbondStatus', 'method'=>'post']) !!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="modal-change-statusLabel">Change Status</h4>
        </div>
        <div class="modal-body">
          <p class="alert alert-info">
            <i class="fa fa-info-circle"></i>&nbsp;Select to change the Cash Bond status
          </p>
          {!! Form::label('status', 'Status', ['class'=>'col-sm-2 control-label']) !!}
          <div class="col-sm-10">
            {{ Form::select('status', $status_opts, $cashbond->status, ['class'=>'form-control', 'id'=>'status']) }}
          </div>
          <br/>
        </div>
        <div class="modal-footer">
          <input type="hidden" id="cashbond_id" name="cashbond_id">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Change</button>
        </div>
      {!! Form::close() !!}
      </div>
    </div>
  </div>
<!--ENDModal CHANGE STATUS-->

<!--Modal cut-from-salary-->
  <div class="modal fade" id="modal-cut-from-salary" tabindex="-1" role="dialog" aria-labelledby="modal-cut-from-salaryLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      {!! Form::open(['url'=>'cash-bond/cut-from-salary', 'method'=>'post']) !!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="modal-cut-from-salaryLabel">Change Status</h4>
        </div>
        <div class="modal-body">
          <p class="alert alert-info">
            <i class="fa fa-info-circle"></i>&nbsp;
          </p>
          {!! Form::label('cut_from_salary', 'Potong Gaji', ['class'=>'col-sm-4 control-label']) !!}
          <div class="col-sm-8">
            {{ Form::select('cut_from_salary', [TRUE=>'Yes', FALSE=>'NO'], $cashbond->cut_from_salary, ['class'=>'form-control', 'id'=>'cut_from_salary']) }}
          </div>
          <br/>
        </div>
        <div class="modal-footer">
          <input type="hidden" id="cashbond_id_to_cut_from_salary" name="cashbond_id_to_cut_from_salary">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">SET</button>
        </div>
      {!! Form::close() !!}
      </div>
    </div>
  </div>
<!--ENDModal cut-from-salary-->


<!--Modal change installment schedule-->
  <div class="modal fade" id="modalChangeInstallmentSchedule" tabindex="-1" role="dialog" aria-labelledby="modalChangeInstallmentScheduleLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      {!! Form::open(['url'=>'cashbond-installment/changeSchedule', 'method'=>'post']) !!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="modalChangeInstallmentScheduleLabel">Change Installment schedule</h4>
        </div>
        <div class="modal-body">
          <div class="form-group{{ $errors->has('installment_schedule') ? ' has-error' : '' }}">
            {!! Form::label('installment_schedule', 'Schedule', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-4">
              {!! Form::text('installment_schedule',null,['class'=>'form-control', 'placeholder'=>'Installment schedule', 'id'=>'installment_schedule']) !!}
              @if ($errors->has('installment_schedule'))
                <span class="help-block">
                  <strong>{{ $errors->first('installment_schedule') }}</strong>
                </span>
              @endif
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <input type="hidden" id="installment_id" name="installment_id">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Update</button>
        </div>
      {!! Form::close() !!}
      </div>
    </div>
  </div>
<!--ENDModal change installment schedule-->

@endsection

@section('additional_scripts')
  {!! Html::script('js/datepicker/bootstrap-datepicker.js') !!}
  <script type="text/javascript">
    //Block Change Status
    $('#btn-change-status').on('click', function(event){
      event.preventDefault();
      $('#cashbond_id').val($(this).attr('data-id'));
      $('#modal-change-status').modal('show');
    });
    //ENDBlock Change Status

    //Block Cut From Salary
    $('#btn-set-cut-from-salary').on('click', function(event){
      event.preventDefault();
      $('#cashbond_id_to_cut_from_salary').val($(this).attr('data-id'));
      $('#modal-cut-from-salary').modal('show');
    });
    //ENDBlock Cut From Salary

    //Block Installment schedule
    $('#installment_schedule').on('keydown', function(event){
      event.preventDefault();
    });
    $('#installment_schedule').datepicker({
      format : 'yyyy-mm-dd'
    });
    //ENDBlock Installment schedule
    //Block change cashbond installment schedule
    $('.btn-change-schedule').on('click', function(event){
      event.preventDefault();
      var installment_id = $(this).attr('data-id');
      var original_schedule = $(this).attr('data-original-schedule');
      $('#installment_id').val(installment_id);
      $('#installment_schedule').val(original_schedule);
      $('#modalChangeInstallmentSchedule').modal('show');
    });
    //ENDBlock change cashbond installment schedule
  </script>
@endsection