@extends('layouts.app')

@section('page_title')
    Internal Request
@endsection

@section('page_header')
  <h1>
    Internal Request
    <small>Edit Internal Request</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('internal-request') }}"><i class="fa fa-tag"></i> Internal Request</a></li>
    <li><a href="{{ URL::to('internal-request/'.$internal_request->id) }}"><i class="fa fa-tag"></i> {{ $internal_request->code }}</a></li>
    <li class="active"><i></i> Edit </li>
  </ol>
@endsection
  
@section('content')
  <div class="row">
    <div class="col-md-12">
      <!--BOX Basic Informations-->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Form Edit Internal Request</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          {!! Form::model($internal_request, ['route'=>['internal-request.update', $internal_request->id], 'class'=>'form-horizontal','id'=>'form-edit-internal-request', 'method'=>'put', 'files'=>true]) !!}
          <div class="form-group{{ $errors->has('code') ? ' has-error' : '' }}">
            {!! Form::label('code', 'IR Number', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {!!Form::text('code',null,['class'=>'form-control', 'placeholder'=>'Internal Request number', 'id'=>'code', 'disabled'=>true])!!}
              @if ($errors->has('code'))
                <span class="help-block">
                  <strong>{{ $errors->first('code') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <div class="form-group{{ $errors->has('requester_id') ? ' has-error' : '' }}">
            {!! Form::label('requester_id', 'Requester', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              @if(\Auth::user()->can('create-internal-request-to-other'))
                {{ Form::select('requester_id', $requester_opts, null, ['class'=>'form-control', 'placeholder'=>'Select Requester', 'id'=>'requester_id']) }}
              @else
                {!! Form::text('requester_name',\Auth::user()->name,['class'=>'form-control', 'placeholder'=>'Requester NAME', 'id'=>'requester_name', 'disabled'=>true]) !!}
                {!! Form::hidden('requester_id',\Auth::user()->id,['class'=>'form-control', 'placeholder'=>'Requester ID', 'id'=>'requester_id']) !!}
              @endif
              @if ($errors->has('requester_id'))
                <span class="help-block">
                  <strong>{{ $errors->first('requester_id') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <div class="form-group{{ $errors->has('project_id') ? ' has-error' : '' }}">
            {!! Form::label('project_id', 'Project', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {{ Form::select('project_id', $project_opts, null, ['class'=>'form-control', 'placeholder'=>'Select Project', 'id'=>'project_id']) }}
              @if ($errors->has('project_id'))
                <span class="help-block">
                  <strong>{{ $errors->first('project_id') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <!-- Selection Vendor-->
          <div class="form-group{{ $errors->has('vendor_id') ? ' has-error' : '' }}">
            {!! Form::label('vendor_id', 'Vendor', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              <select name="vendor_id" id="vendor_id" class="form-control" style="width:100%;">
                @if($internal_request->vendor)
                  <option value="{{ $internal_request->vendor_id }}">{{ $internal_request->vendor->name }}</option>
                @endif
                @if(Request::old('vendor_id') != NULL)
                  <option value="{{Request::old('vendor_id')}}">
                    {{ \App\Vendor::find(Request::old('vendor_id'))->name }}
                  </option>
                @endif
              </select>
              @if ($errors->has('vendor_id'))
                <span class="help-block">
                  <strong>{{ $errors->first('vendor_id') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <!-- ENDSelection Vendor-->
          <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
            {!! Form::label('type', 'Type', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {{ Form::select('type', $type_opts, null, ['class'=>'form-control', 'placeholder'=>'Select Type', 'id'=>'type']) }}
              @if ($errors->has('type'))
                <span class="help-block">
                  <strong>{{ $errors->first('type') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
            {!! Form::label('amount', 'Amount', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {!! Form::text('amount',null,['class'=>'form-control', 'placeholder'=>'Amount of the Internal Request', 'id'=>'amount']) !!}
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
              {!! Form::textarea('description',null,['class'=>'form-control', 'placeholder'=>'Description of the Internal Request', 'id'=>'description']) !!}
              @if ($errors->has('description'))
                <span class="help-block">
                  <strong>{{ $errors->first('description') }}</strong>
                </span>
              @endif
            </div>
          </div>
          
          <div class="form-group{{ $errors->has('is_petty_cash') ? ' has-error' : '' }}">
            {!! Form::label('is_petty_cash', 'Petty Cash', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {!! Form:: checkbox('is_petty_cash', null) !!} Check if this IR is petty cash
              @if ($errors->has('is_petty_cash'))
                <span class="help-block">
                  <strong>{{ $errors->first('is_petty_cash') }}</strong>
                </span>
              @endif
            </div>
          </div>
          
          
          <div class="form-group">
              {!! Form::label('', '', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              <a href="{{ url('internal-request/'.$internal_request->id) }}" class="btn btn-default">
                <i class="fa fa-repeat"></i>&nbsp;Cancel
              </a>&nbsp;
              <button type="submit" class="btn btn-info" id="btn-submit-internal-request">
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
  {!! Html::script('js/autoNumeric.js') !!}
  <script type="text/javascript">
    $('#amount').autoNumeric('init',{
        aSep:',',
        aDec:'.'
    });

    //Block Project Selection
    $('#project_id').select2({
      placeholder: 'Select Project',
      ajax: {
        url: '{!! url('select2Project') !!}',
        dataType: 'json',
        delay: 250,
        processResults: function (data) {
          return {
            results:  $.map(data, function (item) {
                  return {
                      text: item.code,
                      id: item.id
                  }
              })
          };
        },
        cache: true
      }
    });
    //ENDBlock Project Selection
    //Block Vendor id Selection
    $('#vendor_id').select2({
      placeholder: 'Vendor',
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
    //ENDBlock Vendor id Selection
    //Block Requester Selection
    $('#requester_id').select2({
      placeholder: 'Select Member',
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
      },
      allowClear:true,
    }).on('select2:select', function(){
      $('#beneficiary_bank_id').val('').trigger("change");
    }).on('select2:unselect', function(){
      $('#beneficiary_bank_id').val('').trigger("change");
    });
    //ENDBlock Requester Selection

    
    
    $('#form-edit-internal-request').on('submit', function(){
      $('#btn-submit-internal-request').prop('disabled', true);
    });
  </script>
@endsection