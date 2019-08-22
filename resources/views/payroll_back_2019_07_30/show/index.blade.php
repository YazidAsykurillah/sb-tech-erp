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
    @if($user->type == 'outsource')
      @include('payroll.show.outsource')
    @else
      @include('payroll.show.office')
    @endif
    
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