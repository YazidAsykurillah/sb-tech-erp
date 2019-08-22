@extends('layouts.app')

@section('page_title')
  Create Cashbond
@endsection

@section('page_header')
  <h1>
    Cash Bond
    <small>Create Cashbond</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('cash-bond') }}"><i class="fa fa-money"></i> Cash Bond</a></li>
    <li class="active"><i></i> Create</li>
  </ol>
@endsection
  
@section('content')
 <div class="row">
    <div class="col-md-12">
      <!--BOX Basic Informations-->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Form Create Cashbond</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          {!! Form::open(['route'=>'cash-bond.store','role'=>'form','class'=>'form-horizontal','id'=>'form-create-cash-bond','files'=>true]) !!}

          <div class="form-group{{ $errors->has('user_id') ? ' has-error' : '' }}">
            {!! Form::label('user_id', 'User', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              @if(\Auth::user()->roles->first()->code == 'SUP' || \Auth::user()->roles->first()->code == 'ADM' || \Auth::user()->roles->first()->code == 'FIN')
                {{ Form::select('user_id', $user_opts, null, ['class'=>'form-control', 'placeholder'=>'Select User', 'id'=>'user_id']) }}
              @else
                {!! Form::text('requester_name',\Auth::user()->name,['class'=>'form-control', 'placeholder'=>'Requester NAME', 'id'=>'requester_name', 'disabled'=>true]) !!}
                {!! Form::hidden('user_id',\Auth::user()->id,['class'=>'form-control', 'placeholder'=>'Requester ID', 'id'=>'user_id']) !!}
              @endif
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
          <div class="form-group{{ $errors->has('cut_from_salary') ? ' has-error' : '' }}">
            {!! Form::label('cut_from_salary', 'Potong Gaji', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              <div class="checkbox">
                <label>
                  {!! Form:: checkbox('cut_from_salary', null, true) !!} Check if cashbond will be cut from salary
                </label>
              </div>
              @if ($errors->has('cut_from_salary'))
                <span class="help-block">
                  <strong>{{ $errors->first('cut_from_salary') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <div class="form-group{{ $errors->has('term') ? ' has-error' : '' }}">
            {!! Form::label('term', 'Term', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-4">
              {!! Form::number('term',null,['class'=>'form-control', 'placeholder'=>'Term of the cashbond', 'id'=>'term']) !!}
              @if ($errors->has('term'))
                <span class="help-block">
                  <strong>{{ $errors->first('term') }}</strong>
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
    //ENDBlock User Selection

    $('#form-create-cash-bond').on('submit', function(){
      $('#btn-submit-cash-bond').prop('disabled', true);
    });
  </script>
@endsection