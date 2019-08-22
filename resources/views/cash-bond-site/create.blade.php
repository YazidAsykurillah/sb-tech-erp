@extends('layouts.app')

@section('page_title')
    Cash Bond Site
@endsection

@section('additional_styles')
  {!! Html::style('css/datepicker/datepicker3.css') !!}
@endsection

@section('page_header')
  <h1>
    Cash Bond Site
    <small>Daftar Cash Bond Site</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('cash-bond-site') }}"><i class="fa fa-money"></i> Cash Bond site</a></li>
    <li class="active"><i></i> Index</li>
  </ol>
@endsection
  
@section('content')
  <div class="row">
    <div class="col-md-12">
      <!--BOX Basic Informations-->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Form Create Cashbond Site</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          {!! Form::open(['route'=>'cash-bond-site.store','role'=>'form','class'=>'form-horizontal','id'=>'form-create-cash-bond-site','files'=>true]) !!}

          <div class="form-group{{ $errors->has('user_id') ? ' has-error' : '' }}">
            {!! Form::label('user_id', 'User', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {{ Form::select('user_id', [], null, ['class'=>'form-control', 'placeholder'=>'Select User', 'id'=>'user_id']) }}
              @if ($errors->has('user_id'))
                <span class="help-block">
                  <strong>{{ $errors->first('user_id') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
            {!! Form::label('amount', 'Amount', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {!! Form::text('amount',null,['class'=>'form-control', 'placeholder'=>'Amount of the cashbond', 'id'=>'amount']) !!}
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
              {!! Form::textarea('description',null,['class'=>'form-control', 'placeholder'=>'Description of the cashbond', 'id'=>'description']) !!}
              @if ($errors->has('description'))
                <span class="help-block">
                  <strong>{{ $errors->first('description') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <div class="form-group{{ $errors->has('transaction_date') ? ' has-error' : '' }}">
            {!! Form::label('transaction_date', 'Transaction Date', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {!! Form::text('transaction_date',null,['class'=>'form-control', 'placeholder'=>'transaction_date of the cashbond', 'id'=>'transaction_date']) !!}
              @if ($errors->has('transaction_date'))
                <span class="help-block">
                  <strong>{{ $errors->first('transaction_date') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <div class="form-group{{ $errors->has('cash_id') ? ' has-error' : '' }}">
            {!! Form::label('cash_id', 'Cash', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              <select name="cash_id" id="cash_id" class="form-control">
                @if(Request::old('cash_id') != NULL)
                  <option value="{{Request::old('cash_id')}}">
                    {{ \App\Cash::find(Request::old('cash_id'))->name }}
                  </option>
                @endif
              </select>
              @if ($errors->has('cash_id'))
                <span class="help-block">
                  <strong>{{ $errors->first('cash_id') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <div class="form-group">
            {!! Form::label('', '', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              <a href="{{ url('cash-bond') }}" class="btn btn-default">
                <i class="fa fa-repeat"></i>&nbsp;Cancel
              </a>&nbsp;
              <button type="submit" class="btn btn-info" id="btn-submit-cash-bond">
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

    //Block User Selection
    $('#user_id').select2({
      placeholder: 'Select Member',
      ajax: {
        url: '{!! url('select2UserForCashbondSite') !!}',
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
    //ENDBlock User Selection

    //Block Transaction Date
    $('#transaction_date').on('keydown', function(event){
      event.preventDefault();
    });
    $('#transaction_date').datepicker({
      format : 'yyyy-mm-dd'
    });
    //ENDBlock Transaction Date

    //Block Cash Selection
    $('#cash_id').select2({
      placeholder: 'Select Cash',
      ajax: {
        url: '{!! url('select2Cash') !!}',
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
    //ENDBlock Cash Selection

    $('#form-create-cash-bond-site').on('submit', function(){
      $('#btn-submit-cash-bond').prop('disabled', true);
    });
  </script>
@endsection