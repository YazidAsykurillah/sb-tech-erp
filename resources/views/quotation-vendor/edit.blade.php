@extends('layouts.app')


@section('page_title')
  Edit {{ $quotation_vendor->code }}
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
    <li><a href="{{ URL::to('quotation-vendor') }}"><i class="fa fa-archive"></i> Quotation Vendor</a></li>
    <li><a href="{{ URL::to('quotation-vendor/'.$quotation_vendor->id) }}" /> {{ $quotation_vendor->code }} </a></li>
    <li class="active"><i></i> Edit</li>
  </ol>
@endsection

@section('content')
  <div class="row">
    <div class="col-md-12">
      <!--BOX Basic Informations-->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Form Edit Quotation</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          {!! Form::model($quotation_vendor, ['route'=>['quotation-vendor.update', $quotation_vendor->id], 'class'=>'form-horizontal','id'=>'form-edit-quotation-vendor', 'method'=>'put', 'files'=>true]) !!}
          
          <div class="form-group{{ $errors->has('code') ? ' has-error' : '' }}">
            {!! Form::label('code', 'Code', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {!! Form::text('code',null,['class'=>'form-control', 'placeholder'=>'Quotation code', 'id'=>'code']) !!}
              @if ($errors->has('code'))
                <span class="help-block">
                  <strong>{{ $errors->first('code') }}</strong>
                </span>
              @endif
            </div>
          </div>
          
          <div class="form-group{{ $errors->has('vendor_id') ? ' has-error' : '' }}">
            {!! Form::label('vendor_id', 'Vendor', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {{ Form::select('vendor_id', $vendor_opts, null, ['class'=>'form-control', 'placeholder'=>'--Select Vendor--', 'id'=>'vendor_id']) }}
              @if ($errors->has('vendor_id'))
                <span class="help-block">
                  <strong>{{ $errors->first('vendor_id') }}</strong>
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
          <div class="form-group{{ $errors->has('received_date') ? ' has-error' : '' }}">
            {!! Form::label('received_date', 'Received Date', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {!! Form::text('received_date',null,['class'=>'form-control', 'placeholder'=>'Quotation received date', 'id'=>'received_date']) !!}
              @if ($errors->has('received_date'))
                <span class="help-block">
                  <strong>{{ $errors->first('received_date') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <div class="form-group">
              {!! Form::label('', '', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              <a href="{{ url('quotation-vendor/'.$quotation_vendor->id) }}" class="btn btn-default">
                <i class="fa fa-repeat"></i>&nbsp;Cancel
              </a>&nbsp;
              <button type="submit" class="btn btn-info" id="btn-update-quotation-vendor">
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


    //Block Vendor Selection
    $('#vendor_id').select2({
      placeholder: 'Select Vendor',
      ajax: {
        url: '{!! url('select2Vendor') !!}',
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
    //ENDBlock Vendor Selection

    

    //Block Received Date input
    $('#received_date').on('keydown', function(event){
      event.preventDefault();
    });
    $('#received_date').datepicker({
      format : 'yyyy-mm-dd'
    });
    //ENDBlock Received Date input

    $('#form-edit-quotation-vendor').on('submit', function(){
      $('#btn-update-quotation-vendor').prop('disabled', true);
    });
</script>
@endsection