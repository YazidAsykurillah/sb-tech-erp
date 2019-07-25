@extends('layouts.app')

@section('page_title')
  Payroll
@endsection

@section('additional_styles')
  {!! Html::style('vendor/bootstrap3-editable/css/bootstrap-editable.css') !!}
  <style type="text/css">
    table#table-salary-description{
      width: 100%;
    }
    table#table-salary-description td{
      padding: 4px;
      vertical-align: top;
      border: 1px solid;
    }

    table#table-manhour-summary td{
      text-align: center;
      border:1px solid;
    }
    td.centered-bordered{
      text-align: center;
    }
    tr.weekend{
      color: red;
    }
    td.weekend{
      color: red;
    }

    table#extra_payment_table_adder td{
      vertical-align: center;
      border:none;
    }
    table#extra_payment_table_substractor td{
      vertical-align: center;
      border:none;
    }
  </style>
@endsection

@section('page_header')
  <h1>
    Payroll
    <small>Detail</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('payroll') }}"><i class="fa fa-clock-o"></i> Payroll</a></li>
    <li class="active"><i></i> Show</li>
  </ol>
@endsection

@section('content')
  <div class="row">
    <!--Column Slip Gaji-->
    <div class="col-md-12">
      <div class="panel panel-primary">
        <div class="panel-heading">
          <div class="panel-title">
            <i class="fa fa-credit-card"></i>&nbsp;Slip Gaji
          </div>
        </div>
        <!--Body employee info-->
        <div class="panel-body">
          <div class="table-responsive">
            <table class="table table-striped">
              <tr>
                <td style="width:20%;">Name</td>
                <td style="width:5%;">:</td>
                <td>{{ $payroll->user->name }} </td>
              </tr>
              <tr>
                <td style="width:20%;">NIK</td>
                <td style="width:5%;">:</td>
                <td>{{ $payroll->user->nik }} </td>
              </tr>
              <tr>
                <td style="width:20%;">Position</td>
                <td style="width:5%;">:</td>
                <td>{{ $payroll->user->position }} </td>
              </tr>
              <tr>
                <td style="width:20%;">Type</td>
                <td style="width:5%;">:</td>
                <td>{{ $payroll->user->type }} </td>
              </tr>
              <tr>
                <td style="width:20%;">Period</td>
                <td style="width:5%;">:</td>
                <td>{{ $payroll->period->code }} </td>
              </tr>
            </table>
          </div>
        </div>
        <!--ENDBody employee info-->
        <!--Body employee salary info-->
        <div class="panel-body">
          <div class="table-responsive">
            <table id="table-salary-description">
              <tr>
                <td style="width:20%;">
                  <p><strong>Manhour Timesheet</strong></p>
                </td>
                <td style="width:5%;text-align:center;">:</td>
                <td style="width:35%;">
                  <table id="table-manhour-summary" style="width:100%;">
                    <tr>
                      <td rowspan="2" style="width:20%;">Normal</td>
                      <td colspan="4" style="width:80%;">Overtime</td>
                    </tr>
                    <tr>
                      <td style="width:20%;">I</td>
                      <td style="width:20%;">II</td>
                      <td style="width:20%;">III</td>
                      <td style="width:20%;">IV</td>
                    </tr>
                    <tr>
                      <td>{{ $normal_count }}</td>
                      <td>{{ $I_count }}</td>
                      <td>{{ $II_count }} </td>
                      <td>{{ $III_count }}</td>
                      <td>{{ $IV_count }}</td>
                    </tr>
                    <tr>
                      <td>{{ $normal_total }}</td>
                      <td>{{ $I_total }}</td>
                      <td>{{ $II_total }} </td>
                      <td>{{ $III_total }}</td>
                      <td>{{ $IV_total }}</td>
                    </tr>
                  </table>
                </td>
                <td rowspan="2" style="width:10%;">
                  <p>Total Jam</p>
                  <p style="text-align:right;"><strong>{{ $man_hour_total }}</strong></p>
                </td>
                <td rowspan="2" style="width:30%;">
                  <p>Basic Salary</p>
                  <p style="text-align:right;">
                    <strong>{{ number_format($basic_salary,2) }}</strong>
                  </p>
                  <p>Tunjangan Kompetensi</p>
                  <p style="text-align:right;">
                    <strong>{{ number_format($competency_allowance->amount,2) }}</strong>
                  </p>
                  <p>(Total Jam x Rate)</p>
                  <p style="text-align:right;">
                    <strong>{{ number_format($total_man_hour_salary,2) }}</strong>
                  </p>
                  
                </td>
              </tr>
              <tr>
                <td><strong>Manhour Rate</strong></td>
                <td style="width:5%;text-align:center;">:</td>
                <td><strong>{{ number_format($payroll->user->man_hour_rate,2) }}</strong></td>
              </tr>
              <tr>
                <td colspan="5"></td>
              </tr>
              <tr>
                <td colspan="5"></td>
              </tr>

              <!--Group Allowance-->
              <tr>
                <td colspan="5"><strong>Allowances</strong></td>
              </tr>
              <!--Loop over the allowances exclude medical-->
              @if(count($allowances))
                @foreach($allowances as $allowance)
                <?php $obj_allowance = \App\Allowance::find($allowance->id);?>
                <tr>
                  <td colspan="5">
                    <table style="width:100%;">
                      <tr>
                        <td colspan="5">
                          <strong>{{ $allowance->name }}</strong>
                        </td>
                      </tr>
                      @if($obj_allowance)
                        @foreach($obj_allowance->allowance_items as $allowance_item)
                        <tr>
                          <td style="text-align:left;width:20%;">
                            {{ $allowance_item->type }}
                          </td>
                          <td style="width:5%;text-align:center;">:</td>
                          <td style="width:35%;text-align:right;">
                            <a href="#" class="allowance_item_amount" data-type="text" data-pk="{{ $allowance_item->id }}"  data-title="Amount">{{ number_format($allowance_item->amount,2) }}</a>
                          </td>
                          <td style="text-align:right">
                            <a href="#" class="allowance_item_multiplier" data-type="text" data-pk="{{ $allowance_item->id }}"  data-title="Multiplier">{{ $allowance_item->multiplier }}</a>
                          </td>
                          <td style="width:30%;text-align:right;">
                            <strong>
                              <text id="total_amount_{{$allowance_item->id}}">{{ number_format($allowance_item->total_amount,2) }}</text>
                            </strong>
                            
                          </td>
                        </tr>
                        @endforeach
                      @endif
                    </table>
                  </td>
                </tr>
                @endforeach

                <!--Block Workshop allowance-->
                <tr>
                  <td colspan="5">
                    <table style="width:100%;">
                      <tr>
                        <td style="width: 20%;" colspan="5">
                          <strong>Workshop Allowance</strong>
                        </td>
                      </tr>
                      <tr>
                        <td style="width: 20%;">
                          <p>Rate</p>
                        </td>
                        <td style="text-align:center;width: 5%;">:</td>
                        <td style="width:35%;text-align:right;">
                          @if($payroll->workshop_allowance)
                            <a href="#" id="workshop_allowance_amount" data-type="text" data-pk="{{ $payroll->workshop_allowance->id }}"  data-title="Workshop allowance amount">
                              {{ number_format($payroll->workshop_allowance->amount,2) }}
                            </a>
                          @endif
                        </td>
                        <td style="text-align:right">
                          @if($payroll->workshop_allowance)
                            <a href="#" id="workshop_allowance_multiplier" data-type="text" data-pk="{{ $payroll->workshop_allowance->id }}"  data-title="Workshop allowance multiplier">
                              {{$payroll->workshop_allowance->multiplier}}
                            </a>
                          @endif
                        </td>
                        <td style="width:30%;text-align:right;">
                          @if($payroll->workshop_allowance)
                            <p>
                              <strong id="total_workshop_allowance_amount">
                                {{ number_format($payroll->workshop_allowance->total_amount,2) }}
                              </strong>
                            </p>
                          @else
                            <p><strong id="total_workshop_allowance_amount">0</strong></p>
                          @endif
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <!--ENDBlock Workshop allowance-->
              
              @endif
              <!--ENDLoop over the allowances exclude medical-->
              
              <!--Block Medical Allowance-->
              <tr>
                <td colspan="5">
                  <table style="width:100%;">
                    <tr>
                      <td style="width: 20%;" colspan="5">
                        <strong>Medical Allowance</strong>
                      </td>
                    </tr>
                    <tr>
                      <td style="width: 20%;">
                        <p>Rate / Month</p>
                      </td>
                      <td style="text-align:center;width: 5%;">:</td>
                      <td style="width:35%;text-align:right;">
                        <p>
                          <a href="#" id="medical_allowance_amount" data-type="text" data-pk="{{ $medical_allowance->first()->id }}"  data-title="Medical Alloawance Amount">
                            {{ number_format($medical_allowance->first()->amount,2) }}
                          </a>
                        </p>
                        <div class="text text-info">
                          <p> > 2 weeks = Full</p>
                          <p> < 2 weeks = Half </p>
                        </div>
                      </td>
                      <td style="text-align:right">
                        <p><strong>Total Hari</strong></p>
                        <p>
                          <a href="#" id="medical_allowance_multiplier" data-type="text" data-pk="{{ $medical_allowance->first()->id }}"  data-title="Multiplier">
                            {{ $medical_allowance->first()->multiplier }}
                          </a>
                        </p>
                      </td>
                      <td style="width:30%;text-align:right;">
                        <strong id="total_medical_allowance_amount">{{ number_format($medical_allowance->first()->total_amount, 2) }}</strong>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
              <!--ENDBlock Medical Allowance-->
              <!--ENDGroup Allowance-->
              <!--Group BPJSn-->
              <tr>
                <td colspan="5"><strong>BPJS</strong></td>
              </tr>
              <tr>
                <td colspan="5">
                  <table style="width:100%;">
                    <tr>
                      <td style="text-align:left;width:20%;">
                          <strong>Kesehatan</strong>
                      </td>
                      <td style="width:5%;text-align:center;">:</td>
                      <td style="text-align:right;">
                        <strong>
                          <strong>{{number_format($bpjs_kesehatan->amount,2)}}</strong>
                        </strong>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
              <tr>
                <td colspan="5">
                  <table style="width:100%;">
                    <tr>
                      <td style="text-align:left;width:20%;">
                          <strong>Ketenagakerjaan</strong>
                      </td>
                      <td style="width:5%;text-align:center;">:</td>
                      <td style="text-align:right;">
                        <strong>
                          <strong>{{number_format($bpjs_ketenagakerjaan->amount,2)}}</strong>
                        </strong>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
              <!--/Group BPJSn-->
              
              <!--Loop cashbonds-->
              <tr>
                <td colspan="5">
                  <table style="width:100%;">
                    <tr>
                      <td style="width:20%;"><strong>Cash Advance (Kasbon)</strong></td>
                      <td style="width:5%;text-align:center;">:</td>
                      <td colspan="3" style="text-align:right;">
                        @if(count($cash_advances))
                          @foreach($cash_advances as $cash_advance)
                            <p><strong>{{ number_format($cash_advance->amount,2) }}</strong></p>
                          @endforeach
                        @endif
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
              <!--ENDLoop cashbonds-->

              
              <!--Loop Extra Payroll Payment-->
              <tr>
                <td colspan="5"><strong>Extra Payroll Payment</strong></td>
              </tr>
              <tr>
                <td colspan="5">
                  <table style="width:100%;">
                    <tr>
                      <td style="width:20%;">
                        <strong>Penambahan</strong>
                        <div class="pull-right">
                          <button class="btn btn-xs btn-default btn-create-extra-payroll-payment" data-type="adder">
                            <i class="fa fa-plus-circle"></i>
                          </button>
                        </div>
                      </td>
                      <td style="width:5%;text-align:center;">:</td>
                      <td colspan="3" style="">
                        <table class="extra_payment_table" id="extra_payment_table_adder" style="width: 100%;">
                          <tbody>
                            @if($extra_payroll_payments_adder->count())
                              @foreach($extra_payroll_payments_adder as $epp_adder)
                              <tr id="row_{{$epp_adder->id}}">
                                <td style="width: 5%;">
                                  <a href="javascript::void()" class="btn btn-xs btn-delete-extra-payment" data-id="{{$epp_adder->id}}">
                                    <i class="fa fa-trash"></i>
                                  </a>
                                </td>
                                <td>{{ $epp_adder->description }}</td>
                                <td style="text-align: right;">
                                  <strong>{{ number_format($epp_adder->amount,2) }}</strong>
                                </td>
                              </tr>
                              @endforeach
                            @endif
                          </tbody>
                          
                        </table>
                      </td>
                    </tr>
                    <!--Substractor Block-->
                    <tr>
                      <td style="width:20%;">
                        <strong>Pengurangan</strong>
                        <div class="pull-right">
                          <button class="btn btn-xs btn-default btn-create-extra-payroll-payment" data-type="substractor">
                            <i class="fa fa-plus-circle"></i>
                          </button>
                        </div>
                      </td>
                      <td style="width:5%;text-align:center;">:</td>
                      <td colspan="3" style="">
                        <table class="extra_payment_table" id="extra_payment_table_substractor" style="width: 100%;">
                          <tbody>
                            @if($extra_payroll_payments_substractor->count())
                              @foreach($extra_payroll_payments_substractor as $epp_substractor)
                              <tr id="row_{{$epp_substractor->id}}">
                                <td style="width: 5%;">
                                  <a href="javascript::void()" class="btn btn-xs btn-delete-extra-payment" data-id="{{$epp_substractor->id}}">
                                    <i class="fa fa-trash"></i>
                                  </a>
                                </td>
                                <td>{{ $epp_substractor->description }}</td>
                                <td style="text-align: right;">
                                  <strong>{{ number_format($epp_substractor->amount,2) }}</strong>
                                </td>
                              </tr>
                              @endforeach
                            @endif
                          </tbody>
                          
                        </table>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
              <!--ENDLoop Extra Payroll Payment-->
              <tr>
                <td colspan="3" style="text-align:right;">Gross Amount</td>
                <td style="text-align:center;">:</td>
                <td style="text-align:right;"><strong id="gross_amount">{{ number_format($payroll->gross_amount,2) }}</strong></td>
              </tr>
              <!--Loop Settlement-->
              <tr>
                <td colspan="5">
                  <table style="width:100%;">
                    <tr>
                      <td style="width:20%;"><strong>Settlement Payroll</strong></td>
                      <td style="width:5%;text-align:center;">:</td>
                      <td colspan="3" style="">
                      @if($payroll->settlement_payroll->count())
                        <table style="width:100%;" id="table-settlement-list">
                        @foreach($payroll->settlement_payroll as $settlement_payroll)
                          <?php $settlement_balance = $settlement_payroll->settlement->internal_request->amount - $settlement_payroll->settlement->amount;?>
                          <tr>
                            <td style="width: 20%;">
                              <a href="{{url('settlement/'.$settlement_payroll->settlement->id)}}" target="">
                                {{ $settlement_payroll->settlement->code}}
                              </a>
                            </td>
                            <td style="text-align: right;">
                              @if($settlement_balance > 0)
                                <strong>
                                  - {{ number_format(abs($settlement_balance), 2) }}
                                </strong>
                              @else
                                <strong>
                                  + {{ number_format(abs($settlement_balance), 2) }}
                                </strong>
                              @endif
                            </td>
                          </tr>
                        @endforeach
                        </table>
                      @endif
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
              <!--ENDLoop Settlement-->

              <tr>
                <td colspan="3" style="text-align:right;">Take Home Pay</td>
                <td style="text-align:center;">:</td>
                <td style="text-align:right;"><strong id="thp_amount">{{ number_format($payroll->thp_amount,2) }}</strong></td>
              </tr>
              
            </table>
          </div>
        </div>
        <!--ENDBody employee salary info-->

        <!--Table action to payroll-->
        <div class="panel-body">
          <div class="table-responsive">
            <table class="table">
              <tr>
                <td style="width: 20%;">Status</td>
                <td style="width: 5%;">:</td>
                <td style="text-align: right;">
                  {{ucwords($payroll->status)}} 
                  @if($payroll->status == 'draft' || $payroll->status == NULL)
                    &nbsp;<a href="#" id="btn-check-payroll" class="btn btn-default btn-xs">
                      <i class="fa fa-check-circle"></i> Check
                    </a>
                  @elseif($payroll->status == 'checked')
                    &nbsp;<a href="#" id="btn-approve-payroll" class="btn btn-default btn-xs">
                      <i class="fa fa-check-circle"></i> Approve
                    </a>
                  @else
                   
                  @endif
                </td>
              </tr>      
            </table>
          </div>
        </div>
        <!--ENDTable action to payroll-->

      </div>
    </div>
    <!--Endcolumn Slip Gaji-->

    <!--Column ETS-->
    <div class="col-md-12">
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-clock-o"></i>&nbsp;ETS</h3>
          <div class="pull-right">
            <!--
            <button type="button" id="btn-import-ets" class="btn btn-xs btn-info">
              <i class="fa fa-upload"></i> Import
            </button>
          -->
          </div>
        </div><!-- /.box-header -->
        <div class="box-body">
          <div class="table-responsive">
            <table id="table-ets" class="table">
              <thead>
                <tr>
                  <th rowspan="3" style="text-align:center;border:1px solid;">#</th>
                  <th rowspan="3" style="text-align:center;border:1px solid;">Date</th>
                  <th colspan="5" style="text-align:center;border:1px solid;">Manhour</th>
                  
                  <th rowspan="3" style="text-align:center;border:1px solid;">Project Number</th>
                  <th rowspan="3" style="text-align:center;border:1px solid;">Location</th>
                  
                </tr>
                <tr>
                  <th rowspan="2" style="text-align:center;border:1px solid;">Normal</th>
                  <th colspan="4" style="text-align:center;border:1px solid;">Overtime</th>
                  
                </tr>
                <tr>
                  <th style="text-align:center;border:1px solid;">I</th>
                  <th style="text-align:center;border:1px solid;">II</th>
                  <th style="text-align:center;border:1px solid;">III</th>
                  <th style="text-align:center;border:1px solid;">IV</th>
                </tr>
              </thead>
              <tbody>
                @if($ets_lists->count())
                  <?php $num = 0; ?>
                  @foreach($ets_lists as $ets)
                  <?php $num++;?>
                  <tr class="{{ is_date_weekend($ets->the_date) == TRUE ? 'weekend':'' }}">
                    <td class="centered-bordered">{{ $num }}</td>
                    <td class="centered-bordered">
                      {{ $ets->the_date }}
                      <p>{{ get_day_name($ets->the_date) }}</p>
                    </td>
                    <td class="centered-bordered">{{ $ets->normal }}</td>
                    <td class="centered-bordered">{{ $ets->I }}</td>
                    <td class="centered-bordered">{{ $ets->II }}</td>
                    <td class="centered-bordered">{{ $ets->III }}</td>
                    <td class="centered-bordered">{{ $ets->IV }}</td>
                    <td class="centered-bordered">{{ $ets->project_number }}</td>
                    <td class="centered-bordered">{{ $ets->location }}</td>
                  </tr>
                  @endforeach
                @endif
              </tbody>
              <tfoot>
                <tr>
                  <td style="text-align: center;">Total</td>
                  <td style="text-align:center;"></td>
                  <td style="text-align:center;">{{$normal_count}}</td>
                  <td style="text-align:center;">{{abs($I_count)}}</td>
                  <td style="text-align:center;">{{abs($II_count)}}</td>
                  <td style="text-align:center;">{{abs($III_count)}}</td>
                  <td style="text-align:center;">{{abs($IV_count)}}</td>
                </tr>
              </tfoot>
            </table>
          </div>
        </div><!-- /.box-body -->
        <div class="box-footer clearfix"></div>
      </div>
    </div>
    <!--ENDColumn ETS-->
    
  </div>

  <div class="row">
    
  </div>


  <!--Modal Import ETS-->
  <div class="modal fade" id="modal-import-ets" tabindex="-1" role="dialog" aria-labelledby="modal-import-etsLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      {!! Form::open(['url'=>'ets/importFromPayroll', 'method'=>'post', 'id'=>'form-import-file', 'files'=>true]) !!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="modal-import-etsLabel">Import ETS</h4>
        </div>
        <div class="modal-body">
          <p class="alert alert-info">
            <i class="fa fa-info-circle"></i> Import ETS will replace all the user's records for this period
          </p>
          <div class="form-group{{ $errors->has('file') ? ' has-error' : '' }}">
            {!! Form::label('file', 'File', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {!! Form::file('file') !!}
              @if ($errors->has('file'))
                <span class="help-block">
                  <strong>{{ $errors->first('file') }}</strong>
                </span>
              @endif
            </div>
          </div>
          
        </div>
        <div class="modal-footer">
          <input type="hidden" id="period_id" name="period_id" value="{{ $payroll->period->id }}" />
          <input type="hidden" id="user_id" name="user_id" value="{{ $payroll->user->id }}" />
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary" id="btn-submit-import-ets">Submit</button>
        </div>
      {!! Form::close() !!}
      </div>
    </div>
  </div>
  <!--ENDModal Import ETS-->

  <!--Modal Create Extra Payroll Payment-->
  <div class="modal fade" id="modal-create-extra-payroll-payment" tabindex="-1" role="dialog" aria-labelledby="modal-create-extra-payroll-paymentLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      {!! Form::open(['url'=>'extra-payroll-payment/save', 'class'=>'form form-horizontal', 'method'=>'post', 'id'=>'form-create-extra-payroll-payment', 'files'=>true]) !!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="modal-create-extra-payroll-paymentLabel">Create Extra Payroll Payment</h4>
        </div>
        <div class="modal-body">
          
          <div class="form-group{{ $errors->has('epp_description') ? ' has-error' : '' }}">
            {!! Form::label('epp_description', 'Description', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {!! Form::text('epp_description',null,['class'=>'form-control', 'placeholder'=>'Description', 'id'=>'epp_description']) !!}
              @if ($errors->has('epp_description'))
                <span class="help-block">
                  <strong>{{ $errors->first('epp_description') }}</strong>
                </span>
              @endif
            </div>
          </div>

          <div class="form-group{{ $errors->has('epp_amount') ? ' has-error' : '' }}">
            {!! Form::label('epp_amount', 'Amount', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {!! Form::text('epp_amount',null,['class'=>'form-control', 'placeholder'=>'Amount', 'id'=>'epp_amount']) !!}
              @if ($errors->has('epp_amount'))
                <span class="help-block">
                  <strong>{{ $errors->first('epp_amount') }}</strong>
                </span>
              @endif
            </div>
          </div>
          
        </div>
        <div class="modal-footer">
          <input type="hidden" id="payroll_id" name="payroll_id" value="{{ $payroll->id }}" />
          <input type="hidden" id="epp_type" name="epp_type" value="" />
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary" id="btn-submit-extra-payroll-payment">Submit</button>
        </div>
      {!! Form::close() !!}
      </div>
    </div>
  </div>
  <!--ENDModal Create Extra Payroll Payment-->

  <!--Modal Change Payroll Status-->
  <div class="modal fade" id="modal-change-payroll-status" tabindex="-1" role="dialog" aria-labelledby="modal-change-payroll-statusLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      {!! Form::open(['url'=>'payroll/change-status', 'class'=>'form form-horizontal', 'method'=>'post', 'id'=>'form-change-payroll-status']) !!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="modal-change-payroll-statusLabel">
            Confirmation
          </h4>
        </div>
        <div class="modal-body">
          
          Payroll status will be changed to <span id="new_payroll_status_description"></span>
      
        </div>
        <div class="modal-footer">
          <input type="hidden" id="payroll_id_to_change" name="payroll_id_to_change" value="{{ $payroll->id }}" />
          <input type="hidden" id="new_payroll_status" name="new_payroll_status" value="" />
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary" id="btn-submit-payroll-status">Submit</button>
        </div>
      {!! Form::close() !!}
      </div>
    </div>
  </div>
  <!--ENDModal Change Payroll Status-->
 
@endsection

@section('additional_scripts')
  {!! Html::script('vendor/bootstrap3-editable/js/bootstrap-editable.js') !!}
  {!! Html::script('js/autoNumeric.js') !!}
  <script type="text/javascript">
    
    var _token = $('meta[name="csrf-token"]').attr('content');

    $('#btn-import-ets').on('click', function(event){
      event.preventDefault();
      //$('#modal-import-ets').modal('show');
      $('#modal-import-ets').modal({
        backdrop : 'static',
        keyboard : false
      });
    });
    $('#form-import-file').on('submit', function(){
      $('#btn-submit-import-ets').prop('disabled', true);
    });

    
    //Allowance item amount
    $('.allowance_item_amount').editable({
      mode : 'inline',
      type: 'number',
      pk: $(this).attr('data-pk'),
      url: '{!! url('allowance-item/update-amount') !!}',
      title: 'Enter Amount',
      params : {_token : _token},
      success: function(response, newValue) {
        $('#total_amount_'+response.id).text(response.total_amount);
        update_thp_amount();
      }
    }).on('shown', function(e, editable) {
        editable.input.$input.autoNumeric('init',{
            aSep:',',
            aDec:'.'
        });
    });

     //Allowance item multiplier
    $('.allowance_item_multiplier').editable({
      mode : 'inline',
      type: 'number',
      pk: $(this).attr('data-pk'),
      url: '{!! url('allowance-item/update-multiplier') !!}',
      title: 'Enter Multiplier',
      params : {_token : _token},
      success: function(response, newValue){
        $('#total_amount_'+response.id).text(response.total_amount);
        update_thp_amount();
        
      }
    }).on('shown', function(e, editable) {
        editable.input.$input.autoNumeric('init',{
            mDec:'0',
            vMin:'0',
            vMax:'1000',
        });
    });


    //Medical Allowance Amount
    $('#medical_allowance_amount').editable({
      mode : 'inline',
      type: 'number',
      pk: $(this).attr('data-pk'),
      url: '{!! url('medical-allowance/update-amount') !!}',
      title: 'Enter Multiplier',
      params : {_token : _token},
      success: function(response, newValue){
        $('#total_medical_allowance_amount').text(response.total_medical_allowance_amount);
        update_thp_amount();
        
      }
    }).on('shown', function(e, editable) {
        editable.input.$input.autoNumeric('init',{
            aSep:',',
            aDec:'.'
        });
    });

    //Medical Allowance Multiplier
    $('#medical_allowance_multiplier').editable({
      mode : 'inline',
      type: 'number',
      pk: $(this).attr('data-pk'),
      url: '{!! url('medical-allowance/update-multiplier') !!}',
      title: 'Enter Multiplier',
      params : {_token : _token},
      success: function(response, newValue){
        $('#total_medical_allowance_amount').text(response.total_medical_allowance_amount);
        update_thp_amount();
        
      }
    }).on('shown', function(e, editable) {
        editable.input.$input.autoNumeric('init',{
            mDec:'0',
            vMin:'0',
            vMax:'1000',
        });
    });


    //Editable Workshop Allowance Amount
    $('#workshop_allowance_amount').editable({
      mode : 'inline',
      type: 'number',
      pk: $(this).attr('data-pk'),
      url: '{!! url('workshop-allowance/update-amount') !!}',
      title: 'Enter amount',
      params : {_token : _token},
      success: function(response, newValue){
        $('#total_workshop_allowance_amount').text(response.total_workshop_allowance_amount);
        update_thp_amount();
        
      }
    }).on('shown', function(e, editable) {
        editable.input.$input.autoNumeric('init',{
            aSep:',',
            aDec:'.'
        });
    });

    //Editable Workshop Allowance multiplier
    $('#workshop_allowance_multiplier').editable({
      mode : 'inline',
      type: 'number',
      pk: $(this).attr('data-pk'),
      url: '{!! url('workshop-allowance/update-multiplier') !!}',
      title: 'Enter multiplier',
      params : {_token : _token},
      success: function(response, newValue){
        $('#total_workshop_allowance_amount').text(response.total_workshop_allowance_amount);
        update_thp_amount();
        
      }
    }).on('shown', function(e, editable) {
        editable.input.$input.autoNumeric('init',{
            aSep:',',
            aDec:'.'
        });
    });


    //Create Extra Payroll Payment Handler
    $('#epp_amount').autoNumeric('init',{
      aSep:',',
      aDec:'.'
    });
    $('.btn-create-extra-payroll-payment').on('click', function(event){
      event.preventDefault();
      let type = $(this).attr('data-type');
      
      $('#epp_type').val(type);
      $('#modal-create-extra-payroll-payment').modal('show');
    });

    //Form create extra payroll payment submission handling
    $('#form-create-extra-payroll-payment').on('submit',function(event){
      event.preventDefault();
      $.ajax({
        type: 'post',
        url: $(this).attr('action'),
        data: $(this).serialize(),
        dataType: 'json',
        success: function(data){
          let new_row ='<tr>';
              new_row+= '<td style="width: 5%;">';
              new_row+=   '<a href="#" class="btn btn-xs btn-delete-extra-payment" data-id="'+data.id+'">';
              new_row+=     '<i class="fa fa-trash"></i>';
              new_row+=   '</a>';
              new_row+= '</td>';
              new_row+= '<td>';
              new_row+=   data.description;
              new_row+= '</td>';
              new_row+= '<td style="text-align:right;">';
              new_row+=   '<strong>'+data.amount+'</strong>';
              new_row+= '</td>';
              new_row+= '</tr>';
          console.log(data);
          if(data.type == 'adder'){
            $('#modal-create-extra-payroll-payment').modal('hide');
            $('#extra_payment_table_adder').find('tbody').append(new_row);
            update_thp_amount();
          }else{
            $('#modal-create-extra-payroll-payment').modal('hide');
            $('#extra_payment_table_substractor').find('tbody').append(new_row);
            update_thp_amount();
          }
        },
        error: function(data){
          var errors = data.responseJSON;
          console.log(errors);
        }
      });
    });


    //Delete extra payroll payment handling
    $('.btn-delete-extra-payment').on('click', function(event){
      let id = $(this).attr('data-id');
      event.preventDefault();
      console.log("id to delete: "+id);
      $.ajax({
        type: 'post',
        url: '/extra-payroll-payment/delete',
        data: 'id='+id+'&_token='+_token,
        success:function(response){
          console.log(response);
          $('#row_'+id).remove();
          update_thp_amount();
        }
      });
    });


    //Check payroll handling
    $('#btn-check-payroll').on('click', function(event){
      event.preventDefault();
      $('#new_payroll_status_description').html('Checked');
      $('#new_payroll_status').val('checked');
      $('#modal-change-payroll-status').modal('show');
    });

    //Update payroll handling
    $('#btn-approve-payroll').on('click', function(event){
      event.preventDefault();
      $('#new_payroll_status_description').html('Approved');
      $('#new_payroll_status').val('approved');
      $('#modal-change-payroll-status').modal('show');
    });


    update_thp_amount();

    function update_thp_amount(){
      var payroll_id = "{{ $payroll->id }}";
      $.ajax({
        url : '{!! url('payroll/update_thp_amount') !!}',
        type : 'POST',
        data : 'payroll_id='+payroll_id+'&_token='+_token+'&total_man_hour_salary='+{{$total_man_hour_salary}},
        beforeSend : function(){},
        success : function(response){
          $('#thp_amount').text(response.thp_amount);
        }
      });
    }
    
  </script>
@endsection