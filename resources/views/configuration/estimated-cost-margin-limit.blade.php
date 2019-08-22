@extends('layouts.app')

@section('page_title')
    Configuration
@endsection

@section('page_header')
  <h1>
    Configuration
    <small>Estimated Configuration Limit</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="#"><i class="fa fa-database"></i> Master Data</a></li>
    <li class="active"><i></i> Configuration</li>
  </ol>
@endsection

@section('content')
  <div class="row">
    <div class="col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Estimated Configuration Limit</h3>
            </div><!-- /.box-header -->
            <div class="box-body">
              {!! Form::open(['url'=>'master-data/estimated-cost-margin-limit', 'method'=>'post', 'class'=>'form-horizontal']) !!}
                <div class="form-group{{ $errors->has('value') ? ' has-error' : '' }}">
                  {!! Form::label('value', 'Value', ['class'=>'col-sm-2 control-label']) !!}
                  <div class="col-sm-10">
                    {!! Form::text('value',$estimated_cost_margin_limit->value,['class'=>'form-control', 'placeholder'=>'value of the category', 'id'=>'value']) !!}
                    @if ($errors->has('value'))
                      <span class="help-block">
                        <strong>{{ $errors->first('value') }}</strong>
                      </span>
                    @endif
                  </div>
                </div>
                <div class="form-group">
                    {!! Form::label('', '', ['class'=>'col-sm-2 control-label']) !!}
                  <div class="col-sm-10">
                    <button type="submit" class="btn btn-info" id="btn-submit-estimated-cost-margin-limit">
                      <i class="fa fa-save"></i>&nbsp;Save
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