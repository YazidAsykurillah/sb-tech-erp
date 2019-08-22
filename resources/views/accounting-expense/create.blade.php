@extends('layouts.app')

@section('page_title')
    Accounting Expense
@endsection

@section('page_header')
  <h1>
    Accounting Expense
    <small>Daftar Accounting Expense</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('master-data/accounting-expense') }}"><i class="fa fa-book"></i> Accounting Expense</a></li>
    <li class="active"><i></i> Create</li>
  </ol>
@endsection

@section('content')
  <div class="row">
    <div class="col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Accounting Expense</h3>
              <a href="{{ URL::to('accounting-expense/create')}}" class="btn btn-primary pull-right" title="Create new bank_account">
                <i class="fa fa-plus"></i>&nbsp;Add New
              </a>
            </div><!-- /.box-header -->
            <div class="box-body">
              {!! Form::open(['route'=>'accounting-expense.store','role'=>'form','class'=>'form-horizontal','id'=>'form-create-accounting-expense','files'=>true]) !!}
          
                <div class="form-group{{ $errors->has('code') ? ' has-error' : '' }}">
                  {!! Form::label('code', 'Code', ['class'=>'col-sm-2 control-label']) !!}
                  <div class="col-sm-10">
                    {!! Form::text('code',null,['class'=>'form-control', 'placeholder'=>'Code of expense', 'id'=>'code']) !!}
                    @if ($errors->has('code'))
                      <span class="help-block">
                        <strong>{{ $errors->first('code') }}</strong>
                      </span>
                    @endif
                  </div>
                </div>
                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                  {!! Form::label('name', 'Name', ['class'=>'col-sm-2 control-label']) !!}
                  <div class="col-sm-10">
                    {!! Form::text('name',null,['class'=>'form-control', 'placeholder'=>'Name of expense', 'id'=>'name']) !!}
                    @if ($errors->has('name'))
                      <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong>
                      </span>
                    @endif
                  </div>
                </div>
                <div class="form-group">
                    {!! Form::label('', '', ['class'=>'col-sm-2 control-label']) !!}
                  <div class="col-sm-10">
                    <a href="{{ url('accounting-expense') }}" class="btn btn-default">
                      <i class="fa fa-repeat"></i>&nbsp;Cancel
                    </a>&nbsp;
                    <button type="submit" class="btn btn-info" id="btn-submit-accounting-expense">
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