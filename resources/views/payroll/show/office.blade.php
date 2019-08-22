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
                  
                </td>
                <td rowspan="1" style="width:10%;">
                  
                </td>
                <td rowspan="1" style="width:30%;">
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
              <!--Group Incentives-->
              <tr>
                <td colspan="5"><strong>Incentives</strong></td>
              </tr>
              <tr>
                  <td colspan="5">
                    <table style="width:100%;">
                      <tr>
                        <td style="text-align:left;width:20%;">
                            <strong>Week Day</strong>
                        </td>
                        <td style="width:5%;text-align:center;">:</td>
                        <td style="width:35%;text-align:right;">

                         <strong>{{number_format($incentive_weekday->amount,2)}}</strong>
                          
                        </td>
                        <td style="text-align:right">
                          <strong>{{$incentive_weekday->multiplier}}</strong>
                        </td>
                        <td style="width:30%;text-align:right;">
                          <strong>
                            <strong>{{number_format($incentive_weekday->total_amount,2)}}</strong>
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
                            <strong>Week End</strong>
                        </td>
                        <td style="width:5%;text-align:center;">:</td>
                        <td style="width:35%;text-align:right;">
                          
                         <strong>{{number_format($incentive_weekend->amount,2)}}</strong>
                          
                        </td>
                        <td style="text-align:right">
                          <strong>{{$incentive_weekend->multiplier}}</strong>
                        </td>
                        <td style="width:30%;text-align:right;">
                          <strong>
                            <strong>{{number_format($incentive_weekend->total_amount,2)}}</strong>
                          </strong>
                        </td>
                      </tr>
                    </table>
                  </td>
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

              <tr>
                <td colspan="5"></td>
              </tr>
              <!--Loop over the Expenses-->
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
            <table class="table" id="table-ets">
              <thead>
                <tr>
                  <td style="width: 5%;">#</td>
                  <td style="width: 10%;">Date</td>
                  <td style="width: 10%;">Start Time</td>
                  <td style="width: 10%;">End Time</td>
                  <td style="width: 15%;">Description</td>
                  <td>Location</td>
                  <td>Project Number</td>
                  <td>Incentive Week Day</td>
                  <td>Incentive Week End</td>
                  <td>Checker Notes</td>
                </tr>  
              </thead>
              <tbody>
                @if($ets_lists->count())
                  <?php $num = 0; ?>
                  @foreach($ets_lists as $ets)
                  <?php $num++;?>
                  <tr class="{{ is_date_weekend($ets->the_date) == TRUE ? 'weekend':'' }}">
                    <td class="">{{ $num }}</td>
                    <td class="">
                      {{ $ets->the_date }}
                      <p>{{ get_day_name($ets->the_date) }}</p>
                    </td>
                    <td class="">{{ $ets->start_time }}</td>
                    <td class="">{{ $ets->end_time }}</td>
                    <td class="">{{ $ets->description }}</td>
                    <td class="">{{ $ets->location }}</td>
                    <td class="">{{ $ets->project_number }}</td>
                    <td class="">
                      <input type="checkbox" class="check_has_incentive_week_day" data-id="{{$ets->id}}" @if($ets->has_incentive_week_day == TRUE) checked @endif disabled/>
                    </td>
                    <td class="">
                      <input type="checkbox" class="check_has_incentive_week_end" data-id="{{$ets->id}}" @if($ets->has_incentive_week_end == TRUE) checked @endif disabled/>
                    </td>
                    <td>
                      {{ $ets->checker_notes }}
                    </td>
                  </tr>
                  @endforeach
                @endif
              </tbody>
           </table>
          </div>
        </div><!-- /.box-body -->
        <div class="box-footer clearfix"></div>
      </div>
    </div>
    <!--ENDColumn ETS-->