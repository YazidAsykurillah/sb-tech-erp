@extends('layouts.app')


@section('page_title')
    Create Quotation Customer
@endsection

@section('additional_styles')
  {!! Html::style('css/datepicker/datepicker3.css') !!}
@endsection

@section('page_header')
  <h1>
    Quotation Customer
    <small>Create Quotation Customer</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('quotation-customer') }}"><i class="fa fa-archive"></i> Quotation Customer</a></li>
    <li class="active"><i></i> Create</li>
  </ol>
@endsection

@section('content')
  <div class="row">
    <div class="col-md-12">
      <!--BOX Basic Informations-->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Form Create Quotation Customer</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          {!! Form::open(['route'=>'quotation-customer.store','role'=>'form','class'=>'form-horizontal','id'=>'form-create-quotation-customer','files'=>true]) !!}
          
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
              @if(\Auth::user()->roles->first()->code == 'SUP' || \Auth::user()->roles->first()->code == 'ADM')
                {{ Form::select('sales_id', $sales_opts, null, ['class'=>'form-control', 'placeholder'=>'--Select Sales--', 'id'=>'sales_id_selector']) }}
              @else
                {!! Form::text('sales_name',\Auth::user()->name,['class'=>'form-control', 'placeholder'=>'Sales Name', 'id'=>'sales_name', 'disabled'=>true]) !!}
                {!! Form::hidden('sales_id',\Auth::user()->id,['class'=>'form-control', 'placeholder'=>'Sales ID', 'id'=>'sales_id']) !!}
              @endif

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
              <a href="{{ url('quotation-customer') }}" class="btn btn-default">
                <i class="fa fa-repeat"></i>&nbsp;Cancel
              </a>&nbsp;
              <button type="submit" class="btn btn-info" id="btn-submit-quotation-customer">
                <i class="fa fa-save"></i>&nbsp;Submit
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
    $('#sales_id_selector').select2({
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
    $('#received_date').on('keydown', function(event){
      event.preventDefault();
    });
    $('#received_date').datepicker({
      format : 'yyyy-mm-dd'
    });
    //ENDBlock Received Date input

    $('#form-create-quotation-customer').on('submit', function(){
      $('#btn-submit-quotation-customer').prop('disabled', true);
    });
</script>
@endsection