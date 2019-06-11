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
    <div class="col-md-6">
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
                <td style="width:40%;">NIK</td>
                <td style="width:5%;">:</td>
                <td>{{ $payroll->user->nik }} </td>
              </tr>
              <tr>
                <td style="width:40%;">Name</td>
                <td style="width:5%;">:</td>
                <td>{{ $payroll->user->name }} </td>
              </tr>
              <tr>
                <td style="width:40%;">Position</td>
                <td style="width:5%;">:</td>
                <td>{{ $payroll->user->position }} </td>
              </tr>
              <tr>
                <td style="width:40%;">Type</td>
                <td style="width:5%;">:</td>
                <td>{{ $payroll->user->type }} </td>
              </tr>
              <tr>
                <td style="width:40%;">Period</td>
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
                  <p><strong>Basic Salary</strong></p>
                  <p style="text-align:right;">
                    <strong>{{ number_format($total_basic_salary,2) }}</strong>
                  </p>
                  <p>(Manhour Timesheet)</p>
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
                  <p>Total Basic Salary</p>
                  <p style="text-align:right;">
                    <strong></strong>
                  </p>
                  <p>(Total Jam x Rate)</p>
                  <p style="text-align:right;">
                    <strong>{{ number_format($total_man_hour_salary,2) }}</strong>
                  </p>
                  
                </td>
              </tr>
              <tr>
                <td>Manhour Rate</td>
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
              
              @endif
              <!--ENDLoop over the allowances exclude medical-->
              
              <!--Block Medical Allowance-->
              <tr>
                <td colspan="5">
                  <table style="width:100%;">
                    <tr>
                      <td style="width:20%;">Name</td>
                      <td style="width:5%;text-align:center;">:</td>
                      <td colspan="3"><strong>Medical Allowance</strong></td>
                    </tr>
                    <tr>
                      <td>
                        <p>Rate / Month</p>
                        
                      </td>
                      <td style="text-align:center;">:</td>
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

              <tr>
                <td colspan="5"></td>
              </tr>
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

              <tr>
                <td colspan="3" style="text-align:right;">Take Home Pay</td>
                <td style="text-align:center;">:</td>
                <td style="text-align:right;"><strong id="thp_amount">{{ number_format($payroll->thp_amount,2) }}</strong></td>
              </tr>
              
            </table>
          </div>
        </div>
        <!--ENDBody employee salary info-->
      </div>
    </div>
    <!--Endcolumn Slip Gaji-->

    <!--Column ETS-->
    <div class="col-md-6">
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-clock-o"></i>&nbsp;ETS</h3>
          <div class="pull-right">
            <button type="button" id="btn-import-ets" class="btn btn-xs btn-info">
              <i class="fa fa-upload"></i> Import
            </button>
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
                  <tr>
                    <td class="centered-bordered">{{ $num }}</td>
                    <td class="centered-bordered">{{ $ets->the_date }}</td>
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