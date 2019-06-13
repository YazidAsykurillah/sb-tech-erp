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

  <!--Modal Delete Payroll-->
  <div class="modal fade" id="modal-delete-payroll" tabindex="-1" role="dialog" aria-labelledby="modal-delete-payrollLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      {!! Form::open(['url'=>'deletePayroll', 'method'=>'post']) !!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="modal-delete-payrollLabel">Confirmation</h4>
        </div>
        <div class="modal-body">
          Click delete to continue
          <br/>
          <p class="text text-danger">
            <i class="fa fa-info-circle"></i>&nbsp;This process can not be reverted
          </p>
          <input type="hidden" id="payroll_id_to_delete" name="payroll_id_to_delete">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-danger">Delete</button>
        </div>
      {!! Form::close() !!}
      </div>
    </div>
  </div>
<!--ENDModal Delete Payroll-->

 
@endsection

@section('additional_scripts')
  <script type="text/javascript">
    var tablePayroll =  $('#table-payroll').DataTable({
      processing :true,
      serverSide : true,
      ajax : '{!! url('payroll/dataTables') !!}',
      columns :[
        {data: 'rownum', name: 'rownum', searchable:false},
        { data: 'period.code', name: 'period.code' },
        { data: 'user.name', name: 'user.name' },
        { data: 'thp_amount', name: 'thp_amount' },
        { data: 'is_printed', name: 'is_printed', searchable:false, orderable:false },
        { data: 'actions', name: 'actions', orderable:false, searchable:false, className:'dt-body-center' },
      ],

    });

    // Delete button handler
    tablePayroll.on('click', '.btn-delete-payroll', function(e){
      var id = $(this).attr('data-id');
      $('#payroll_id_to_delete').val(id);
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