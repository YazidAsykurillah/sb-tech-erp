@extends('layouts.app')

@section('page_title')
    Vendor | Create
@endsection

@section('page_header')
  <h1>
    Vendor
    <small>Create Vendor</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('the-vendor') }}"><i class="fa fa-child"></i> Vendor</a></li>
    <li class="active"><i></i> Create</li>
  </ol>
@endsection

@section('content')
  <div class="row">
    <div class="col-md-12">
      <!--BOX Basic Informations-->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Form Create Vendor</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          {!! Form::open(['route'=>'the-vendor.store','role'=>'form','class'=>'form-horizontal','id'=>'form-create-vendor','files'=>true]) !!}
          <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            {!! Form::label('name', 'Vendor Name', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {!! Form::text('name',null,['class'=>'form-control', 'placeholder'=>'Name of the vendor', 'id'=>'name']) !!}
              @if ($errors->has('name'))
                <span class="help-block">
                  <strong>{{ $errors->first('name') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <div class="form-group{{ $errors->has('product_name') ? ' has-error' : '' }}">
            {!! Form::label('product_name', 'Product Name', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {!! Form::text('product_name',null,['class'=>'form-control', 'placeholder'=>'Product of the vendor', 'id'=>'product_name']) !!}
              @if ($errors->has('product_name'))
                <span class="help-block">
                  <strong>{{ $errors->first('product_name') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <div class="form-group{{ $errors->has('bank_account') ? ' has-error' : '' }}">
            {!! Form::label('bank_account', 'Bank Account', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {!! Form::text('bank_account',null,['class'=>'form-control', 'placeholder'=>'Bank Account of the vendor', 'id'=>'bank_account']) !!}
              @if ($errors->has('bank_account'))
                <span class="help-block">
                  <strong>{{ $errors->first('bank_account') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <div class="form-group">
              {!! Form::label('', '', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              <a href="{{ url('vendor') }}" class="btn btn-default">
                <i class="fa fa-repeat"></i>&nbsp;Cancel
              </a>&nbsp;
              <button type="submit" class="btn btn-info" id="btn-submit-vendor">
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
  <script type="text/javascript">
    $('#form-create-vendor').on('submit', function(){
      $('#btn-submit-vendor').prop('disabled', true);
    });
  </script>
@endsection