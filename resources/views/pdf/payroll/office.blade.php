<div class="row">
  <div class="col-lg-12">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h5 class="panel-title">Slip Gaji</h5>
      </div>
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
      <div class="panel-body">
          <div class="table-responsive">
            <table id="table-salary-description">
              <tr>
                <td colspan="2"><strong>Basic Salary</strong></td>
                <td style="text-align: center;"><strong>:</strong></td>
                <td colspan="2" style="text-align: right;"><strong>{{ number_format($basic_salary,2) }}</strong></td>
              </tr>
              <tr>
                <td colspan="2"><strong>Tunjangan Kompetensi</strong></td>
                <td style="text-align: center;"><strong>:</strong></td>
                <td colspan="2" style="text-align: right;"><strong>{{ number_format($competency_allowance->amount,2) }}</strong></td>
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
    </div>
  </div>
</div>