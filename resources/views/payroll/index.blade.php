@extends('layouts.app')

@section('page_title')
  Payroll
@endsection

@section('page_header')
  <h1>
    Payroll
    <small>Daftar Payroll</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('payroll') }}"><i class="fa fa-clock-o"></i> Payroll</a></li>
    <li class="active"><i></i> Index</li>
  </ol>
@endsection

@section('content')
  <div class="row">
    <div class="col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Payroll</h3>
              @if(\Auth::user()->can('create-payroll'))
              <a href="{{ URL::to('payroll/create')}}" class="btn btn-primary pull-right" title="Create new Payroll">
                <i class="fa fa-plus"></i>&nbsp;Add New
              </a>
              @endif
            </div><!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="table-payroll">
                  <thead>
                    <tr>
                      <th style="width:5%;">#</th>
                      <th style="width:10%;">Period</th>
                      <th style="width:20%;">Member</th>
                      <th>THP Amount</th>
                      <th>Is Printed</th>
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
                    </tr>
                  </thead>
                  
                  <tbody></tbody>
              </table>
            </div>
          </div><!-- /.box-body -->
          <div class="box-footer clearfix">
            
          </div>
        </div><!-- /.box -->
    </div>
  </div>

 
@endsection

@section('additional_scripts')
  <script type="text/javascript">
    var tablePayroll =  $('#table-payroll').DataTable({
      processing :true,
      serverSide : true,
      ajax : '{!! route('datatables.getPayrolls') !!}',
      columns :[
        {data: 'rownum', name: 'rownum', searchable:false},
        { data: 'period_id', name: 'period_id' },
        { data: 'user_id', name: 'user_id' },
        { data: 'thp_amount', name: 'thp_amount' },
        { data: 'is_printed', name: 'is_printed', searchable:false, orderable:false },
        { data: 'actions', name: 'actions', orderable:false, searchable:false, className:'dt-body-center' },
      ],

    });

    // Delete button handler
    tablePayroll.on('click', '.btn-delete-payroll', function(e){
      var id = $(this).attr('data-id');
      $('#payroll_id').val(id);
      $('#modal-delete-payroll').modal('show');
    });

    // Setup - add a text input to each header cell
    $('#searchColumn th').each(function() {
      if ($(this).index() != 0 && $(this).index() != 5) {
        $(this).html('<input class="form-control" type="text" placeholder="Search" data-id="' + $(this).index() + '" />');
      }
          
    });
    //Block search input and select
    $('#searchColumn input').keyup(function() {
      tablePayroll.columns($(this).data('id')).search(this.value).draw();
    });
    //ENDBlock search input and select
    
  </script>
@endsection