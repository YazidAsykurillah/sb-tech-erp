@extends('layouts.app')


@section('page_title')
  Edit {{ $quotation_customer->code }}
@endsection

@section('additional_styles')
  {!! Html::style('css/datepicker/datepicker3.css') !!}
@endsection

@section('page_header')
  <h1>
    Quotation
    <small>Edit Quotation</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('quotation-customer') }}"><i class="fa fa-archive"></i> Quotation Customer</a></li>
    <li><a href="{{ URL::to('quotation-customer/'.$quotation_customer->id) }}" /> {{ $quotation_customer->code }} </a></li>
    <li class="active"><i></i> Edit</li>
  </ol>
@endsection

@section('content')
  <div class="row">
    <div class="col-md-12">
      <!--BOX Basic Informations-->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Form Edit Quotation Customer</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          {!! Form::model($quotation_customer, ['route'=>['quotation-customer.update', $quotation_customer->id], 'class'=>'form-horizontal','id'=>'form-edit-quotation-customer', 'method'=>'put', 'files'=>true]) !!}
          
          <div class="form-group{{ $errors->has('code') ? ' has-error' : '' }}">
            {!! Form::label('code', 'Code', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {!! Form::text('code',null,['class'=>'form-control', 'placeholder'=>'Quotation code', 'id'=>'code', 'readonly'=>true]) !!}
              @if ($errors->has('code'))
                <span class="help-block">
                  <strong>{{ $errors->first('code') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <div class="form-group{{ $errors->has('customer_id') ? ' has-error' : '' }}">
            {!! Form::label('customer_id', 'Customer', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {{ Form::select('customer_id', $customer_opts, null, ['class'=>'form-control', 'placeholder'=>'--Select Customer--', 'id'=>'customer_id']) }}
              @if ($errors->has('customer_id'))
                <span class="help-block">
                  <strong>{{ $errors->first('customer_id') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <div class="form-group{{ $errors->has('sales_id') ? ' has-error' : '' }}">
            {!! Form::label('sales_id', 'Sales', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {{ Form::select('sales_id', $sales_opts, null, ['class'=>'form-control', 'placeholder'=>'--Select Sales--', 'id'=>'sales_id']) }}
              @if ($errors->has('sales_id'))
                <span class="help-block">
                  <strong>{{ $errors->first('sales_id') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
            {!! Form::label('amount', 'Amount', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {!! Form::text('amount',null,['class'=>'form-control', 'placeholder'=>'Quotation amount', 'id'=>'amount']) !!}
              @if ($errors->has('amount'))
                <span class="help-block">
                  <strong>{{ $errors->first('amount') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
            {!! Form::label('description', 'Description', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {!! Form::textarea('description',null,['class'=>'form-control', 'placeholder'=>'Quotation description', 'id'=>'description']) !!}
              @if ($errors->has('description'))
                <span class="help-block">
                  <strong>{{ $errors->first('description') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <div class="form-group{{ $errors->has('file') ? ' has-error' : '' }}">
            {!! Form::label('file', 'File', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              <p>
                @if($quotation_customer->file != NULL)
                    <a href="{{ url('quotation-customer/file/?file_name='.$quotation_customer->file) }}">
                      {{ $quotation_customer->file }}
                    </a>
                @endif
              </p>
              {!! Form::file('file') !!}
              @if ($errors->has('file'))
                <span class="help-block">
                  <strong>{{ $errors->first('file') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <div class="form-group">
              {!! Form::label('', '', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              <a href="{{ url('quotation-customer/'.$quotation_customer->id) }}" class="btn btn-default">
                <i class="fa fa-repeat"></i>&nbsp;Cancel
              </a>&nbsp;
              <button type="submit" class="btn btn-info" id="btn-update-quotation-customer">
                <i class="fa fa-save"></i>&nbsp;Update
              </button>
            </div>
          </div>
          {!! Form::close() !!}
          
        </div><!-- /.box-body -->
      </div>
      <!--ENDBOX Basic Informations-->
    </div>
  </div>
@endsection

@section('additional_scripts')

  {!! Html::script('js/datepicker/bootstrap-datepicker.js') !!}
  {!! Html::script('js/autoNumeric.js') !!}
  <script type="text/javascript">
    $('#amount').autoNumeric('init',{
        aSep:',',
        aDec:'.'
    });


    //Block Customer Selection
    $('#customer_id').select2({
      placeholder: 'Select Customer',
      ajax: {
        url: '{!! url('select2Customer') !!}',
        dataType: 'json',
        delay: 250,
        processResults: function (data) {
          return {
            results:  $.map(data, function (item) {
                  return {
                      text: item.name,
                      id: item.id
                  }
              })
          };
        },
        cache: true
      }
    });
    //ENDBlock Customer Selection

    //Block Sales Selection
    $('#sales_id').select2({
      placeholder: 'Select Sales',
      ajax: {
        url: '{!! url('select2User') !!}',
        dataType: 'json',
        delay: 250,
        processResults: function (data) {
          return {
            results:  $.map(data, function (item) {
                  return {
                      text: item.name,
                      id: item.id
                  }
              })
          };
        },
        cache: true
      }
    });
    //ENDBlock Sales Selection

    //Block Received Date input
    $('#submitted_date').on('keydown', function(event){
      event.preventDefault();
    });
    $('#submitted_date').datepicker({
      format : 'yyyy-mm-dd'
    });
    //ENDBlock Received Date input

    $('#form-edit-quotation-customer').on('submit', function(){
      $('#btn-update-quotation-customer').prop('disabled', true);
    });
</script>
@endsection