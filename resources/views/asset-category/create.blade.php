@extends('layouts.app')

@section('page_title')
    Asset Category
@endsection

@section('page_header')
  <h1>
    Asset Category
    <small>Create Asset Category</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="#"><i class="fa fa-database"></i> Master Data</a></li>
    <li><i></i> Asset Category</li>
    <li class="active"><i></i> Create</li>
  </ol>
@endsection

@section('content')
  <div class="row">
    <div class="col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Asset Category</h3>
            </div><!-- /.box-header -->
            <div class="box-body">
              {!! Form::open(['route'=>'master-data.asset-category.store','role'=>'form','class'=>'form-horizontal','id'=>'form-create-asset-category','files'=>true]) !!}
              <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                {!! Form::label('name', 'Name', ['class'=>'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                  {!! Form::text('name',null,['class'=>'form-control', 'placeholder'=>'Name of the asset-category', 'id'=>'name']) !!}
                  @if ($errors->has('name'))
                    <span class="help-block">
                      <strong>{{ $errors->first('name') }}</strong>
                    </span>
                  @endif
                </div>
              </div>
              <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                {!! Form::label('description', 'Description', ['class'=>'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                  {!! Form::textarea('description',null,['class'=>'form-control', 'placeholder'=>'Description of the asset-category', 'id'=>'description']) !!}
                  @if ($errors->has('description'))
                    <span class="help-block">
                      <strong>{{ $errors->first('description') }}</strong>
                    </span>
                  @endif
                </div>
              </div>
              <div class="form-group">
                  {!! Form::label('', '', ['class'=>'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                  <a href="{{ url('master-data/asset-category') }}" class="btn btn-default">
                    <i class="fa fa-repeat"></i>&nbsp;Cancel
                  </a>&nbsp;
                  <button type="submit" class="btn btn-info" id="btn-submit-asset-category">
                    <i class="fa fa-save"></i>&nbsp;Submit
                  </button>
                </div>
              </div>
              {!! Form::close() !!}
            </div><!-- /.box-body -->
            <div class="box-footer clearfix">
            
          </div>
        </div><!-- /.box -->
    </div>
  </div>

  
  
@endsection

@section('additional_scripts')
  
@endsection