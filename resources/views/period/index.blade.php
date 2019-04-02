@extends('layouts.app')

@section('page_title')
  Period
@endsection

@section('page_header')
  <h1>
    Period
    <small>Daftar Period</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('period') }}"><i class="fa fa-clock-o"></i> Period</a></li>
    <li class="active"><i></i> Index</li>
  </ol>
@endsection

@section('content')
  <div class="row">
    <div class="col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Period</h3>
              <a href="{{ URL::to('period/create')}}" class="btn btn-primary pull-right" title="Create new Period">
                <i class="fa fa-plus"></i>&nbsp;Add New
              </a>
            </div><!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="table-period">
                  <thead>
                    <tr>
                      <th style="width:5%;">#</th>
                      <th style="width:10%;">Code</th>
                      <th style="width:10%;">Year</th>
                      <th style="width:10%;">Month</th>
                      <th>Start Date</th>
                      <th>End Date</th>
                      <th style="width:10%;text-align:center;">Actions</th>
                    </tr>
                  </thead>
                  <thead id="searchColumn">
                    <tr>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
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

  <!--Modal Delete Project-->
  <div class="modal fade" id="modal-delete-period" tabindex="-1" role="dialog" aria-labelledby="modal-delete-periodLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      {!! Form::open(['url'=>'deletePeriod', 'method'=>'post']) !!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="modal-delete-periodLabel">Confirmation</h4>
        </div>
        <div class="modal-body">
          You are going to delete <b id="period-code-to-delete"></b>
          <br/>
          <p class="text text-danger">
            <i class="fa fa-info-circle"></i>&nbsp;This process can not be reverted
          </p>
          <input type="hidden" id="period_id" name="period_id">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-danger">Delete</button>
        </div>
      {!! Form::close() !!}
      </div>
    </div>
  </div>
<!--ENDModal Delete Project-->
@endsection

@section('additional_scripts')
  <script type="text/javascript">
    var tablePeriod =  $('#table-period').DataTable({
      processing :true,
      serverSide : true,
      ajax : '{!! route('datatables.getPeriods') !!}',
      columns :[
        {data: 'rownum', name: 'rownum', searchable:false},
        { data: 'code', name: 'code' },
        { data: 'the_year', name: 'the_year' },
        { data: 'the_month', name: 'the_month' },
        { data: 'start_date', name: 'start_date' },
        { data: 'end_date', name: 'end_date' },
        { data: 'actions', name: 'actions', orderable:false, searchable:false, className:'dt-body-center' },
      ],
      order : [
        [4, 'desc']
      ]

    });

    // Delete button handler
    tablePeriod.on('click', '.btn-delete-period', function(e){
      var id = $(this).attr('data-id');
      var code = $(this).attr('data-text');
      $('#period_id').val(id);
      $('#period-code-to-delete').text(code);
      $('#modal-delete-period').modal('show');
    });

    // Setup - add a text input to each header cell
    $('#searchColumn th').each(function() {
      if ($(this).index() != 0 && $(this).index() != 6) {
        $(this).html('<input class="form-control" type="text" placeholder="Search" data-id="' + $(this).index() + '" />');
      }
          
    });
    //Block search input and select
    $('#searchColumn input').keyup(function() {
      tablePeriod.columns($(this).data('id')).search(this.value).draw();
    });
    //ENDBlock search input and select
    
  </script>
@endsection