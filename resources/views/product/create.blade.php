@extends('layouts.app')

@section('page_title')
    Product
@endsection

@section('page_header')
  <h1>
    Product
    <small>Create Product</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('product') }}"><i class="fa fa-cube"></i> Product</a></li>
    <li class="active"><i></i> Create</li>
  </ol>
@endsection

@section('content')
  <div class="row">
    <div class="col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Product</h3>
            </div><!-- /.box-header -->
            <div class="box-body">
              {!! Form::open(['route'=>'product.store','role'=>'form','class'=>'form-horizontal','id'=>'form-create-product-category','files'=>true]) !!}
              
              <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                {!! Form::label('name', 'Name', ['class'=>'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                  {!! Form::text('name',null,['class'=>'form-control', 'placeholder'=>'Name of the product', 'id'=>'name']) !!}
                  @if ($errors->has('name'))
                    <span class="help-block">
                      <strong>{{ $errors->first('name') }}</strong>
                    </span>
                  @endif
                </div>
              </div>
              <div class="form-group{{ $errors->has('unit') ? ' has-error' : '' }}">
                {!! Form::label('unit', 'Unit', ['class'=>'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                  {!! Form::text('unit',null,['class'=>'form-control', 'placeholder'=>'unit of the product', 'id'=>'unit']) !!}
                  @if ($errors->has('unit'))
                    <span class="help-block">
                      <strong>{{ $errors->first('unit') }}</strong>
                    </span>
                  @endif
                </div>
              </div>
              <div class="form-group{{ $errors->has('initial_stock') ? ' has-error' : '' }}">
                {!! Form::label('initial_stock', 'Initial Stock', ['class'=>'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                  {!! Form::text('initial_stock',null,['class'=>'form-control', 'placeholder'=>'initial_stock of the product', 'id'=>'initial_stock']) !!}
                  @if ($errors->has('initial_stock'))
                    <span class="help-block">
                      <strong>{{ $errors->first('initial_stock') }}</strong>
                    </span>
                  @endif
                </div>
              </div>
              <div class="form-group">
                  {!! Form::label('', '', ['class'=>'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                  <a href="{{ url('product') }}" class="btn btn-default">
                    <i class="fa fa-repeat"></i>&nbsp;Cancel
                  </a>&nbsp;
                  <button type="submit" class="btn btn-info" id="btn-submit-product">
                    <i class="fa fa-save"></i>&nbsp;Submit
                  </button>
                </div>
              </div>
              {!! Form::close() !!}
            </div>
          </div><!-- /.box-body -->
          <div class="box-footer clearfix">
            
          </div>
        </div><!-- /.box -->
    </div>
  </div>

@endsection

@section('additional_scripts')
 
@endsection