@extends('layouts.app')

@section('page_title')
  ETS Office
@endsection

@section('page_header')
  <h1>
    ETS Office
    <small>Daftar ETS Office</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li class="active"><i></i>ETS Office</li>
  </ol>
@endsection

@section('content')
  <div class="row">
    <div class="col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">ETS Office</h3>
              <a href="javascript::void()" id="btn-import-ets" class="btn btn-primary pull-right" title="Import ETS Office">
                <i class="fa fa-upload"></i>&nbsp;Import
              </a>
            </div><!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="table-ets">
                  <thead>
                    <tr>
                      <th style="width:40%;">Period</th>
                      <th>User</th>
                      <th style="width:10%;text-align:center;">Actions</th>
                    </tr>
                  </thead>
                  <thead id="searchColumn">
                    <tr>
                      <th></th>
                      <th></th>
                      <th></th>
                    </tr>
                  </thead>
                  
                  <tbody>

                  </tbody>
              </table>
            </div>
          </div><!-- /.box-body -->
          <div class="box-footer clearfix">
            
          </div>
        </div><!-- /.box -->
    </div>
  </div> 


  <!--Modal Import ETS-->
  <div class="modal fade" id="modal-import-ets" tabindex="-1" role="dialog" aria-labelledby="modal-import-etsLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      {!! Form::open(['url'=>'ets/office/import', 'role'=>'form', 'class'=>'form-horizontal', 'method'=>'post', 'id'=>'form-import-file', 'files'=>true]) !!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="modal-import-etsLabel">Import ETS Office</h4>
        </div>
        <div class="modal-body">
          <p class="alert alert-info">
            <i class="fa fa-info-circle"></i> Import ETS will replace all the user's records for selected period
          </p>
          <div class="form-group{{ $errors->has('user_id') ? ' has-error' : '' }}">
            {!! Form::label('user_id', 'User', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {!! Form::select('user_id', [], null, ['class'=>'form-control', 'placeholder'=>'Select User', 'id'=>'user_id']) !!}
              @if ($errors->has('user_id'))
                <span class="help-block">
                  <strong>{{ $errors->first('user_id') }}</strong>
                </span>
              @endif
            </div>
          </div>

          <div class="form-group{{ $errors->has('period_id') ? ' has-error' : '' }}">
            {!! Form::label('period_id', 'Period', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {{ Form::select('period_id', [], null, ['class'=>'form-control', 'placeholder'=>'Select Period', 'id'=>'period_id']) }}
              @if ($errors->has('period_id'))
                <span class="help-block">
                  <strong>{{ $errors->first('period_id') }}</strong>
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
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary" id="btn-submit-import-ets">Submit</button>
        </div>
      {!! Form::close() !!}
      </div>
    </div>
  </div>
  <!--ENDModal Import ETS-->
@endsection

@section('additional_scripts')
  <script type="text/javascript">

    //Datatables
    var tableAssetCategory =  $('#table-ets').DataTable({
      processing :true,
      serverSide : true,
      ajax : '{!! url('ets/office/dataTables') !!}',
      columns :[
        { data: 'the_period', name: 'the_period'},
        { data: 'user_name', name: 'user_name' },
        { data: 'actions', name: 'actions', orderable:false, searchable:false, className:'dt-body-center' },
      ],

    });

    // Setup - add a text input to each header cell
    $('#searchColumn th').each(function() {
      if ($(this).index() != 2 ) {
        $(this).html('<input class="form-control" type="text" placeholder="Search" data-id="' + $(this).index() + '" />');
      }
          
    });
    //Block search input and select
    $('#searchColumn input').keyup(function() {
      tableAssetCategory.columns($(this).data('id')).search(this.value).draw();
    });
    //ENDBlock search input and select
    
    //Import ETS Office handling
    $('#btn-import-ets').on('click',function(event){
      event.preventDefault();
      $('#modal-import-ets').modal('show');
    });

    //User selection
    //Block User Selection
    $('#user_id').select2({
      placeholder: 'Select Office Member',
      width:'100%',
      dropdownParent: $('#modal-import-ets'),
      ajax: {
        url: '{!! url('user/select2Office') !!}',
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


    //Period Selection
    $('#period_id').select2({
      placeholder: 'Select Period',
      width:'100%',
      dropdownParent: $('#modal-import-ets'),
      ajax: {
        url: '{!! url('period/select2') !!}',
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
    //ENDPeriod Selection
  </script>
@endsection