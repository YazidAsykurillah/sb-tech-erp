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
              <div class="pull-right">
                <a href="#" class="btn btn-default btn-xs" id="btn-set-check" title="Mark payroll status to be checked">
                  <i class="fa fa-check"></i>&nbsp;Check
                </a>
                <a href="#" class="btn btn-default btn-xs" id="btn-set-approve" title="Mark payroll status to be approved">
                  <i class="fa fa-check-circle"></i>&nbsp;Approve
                </a>
                @if(\Auth::user()->can('create-payroll'))
                <a href="{{ URL::to('payroll/create')}}" class="btn btn-primary btn-xs" title="Create new Payroll">
                  <i class="fa fa-plus"></i>&nbsp;Add New
                </a>
                @endif
                
              </div>
              
            </div><!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <form method="POST" id="form-filter" class="form-inline" role="form">
                  <div class="form-group">
                    <label class="" for="filter_period">Period</label>
                    <select name="filter_period" id="filter_period" class="form-control" style="width: 200px;"></select>
                  </div>
                  <div class="form-group">
                    <label class="" for="filter_user_type">User Type</label>
                    <select name="filter_user_type" id="filter_user_type" class="form-control" style="width: 200px;">
                      <option value="">All</option>
                      <option value="office">Office</option>
                      <option value="outsource">Outsource</option>
                    </select>
                  </div>

                  <button type="submit" class="btn btn-primary">Filter</button>
                </form>
                <br/>
                <table class="table table-bordered" id="table-payroll">
                  <thead>
                    <tr>
                      <th style="width:5%;">#</th>
                      <th style="width:10%;">Period</th>
                      <th style="width:20%;">NIK</th>
                      <th style="width:20%;">Member Name</th>
                      <th>THP Amount</th>
                      <th>Status</th>
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

 <!--Modal Check-->
  <div class="modal fade" id="modal-check" tabindex="-1" role="dialog" aria-labelledby="modal-checkLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      {!! Form::open(['url'=>'payroll/setStatusCheck', 'id'=> 'form-check', 'method'=>'post']) !!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="modal-checkLabel">Confirmation</h4>
        </div>
        <div class="modal-body">
          <p class="text text-danger">
            <span class="selected_payroll_counter"></span> payroll(s) will be checkd
          </p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-info">check</button>
        </div>
      {!! Form::close() !!}
      </div>
    </div>
  </div>
<!--ENDModal Check-->

<!--Modal Approve Payroll-->
  <div class="modal fade" id="modal-approve" tabindex="-1" role="dialog" aria-labelledby="modal-approveLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      {!! Form::open(['url'=>'payroll/setStatusApprove', 'id'=> 'form-approve', 'method'=>'post']) !!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="modal-approveLabel">Approve Payroll Confirmation</h4>
        </div>
        <div class="modal-body">
          <p class="text text-danger">
            <span class="selected_payroll_counter"></span> payroll(s) will be approved
          </p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-info">approve</button>
        </div>
      {!! Form::close() !!}
      </div>
    </div>
  </div>
<!--ENDModal Approve Payroll-->
@endsection

@section('additional_scripts')
  <script type="text/javascript">
    //Block Period selection
    $('#filter_period').select2({
      placeholder: 'Select Period',
      ajax: {
        url: '{!! url('period/select2') !!}',
        width:'100%',
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
      },
      allowClear:true
    });
    //ENDBlock Period selection

    //Block filter user type selection
    $('#filter_user_type').select2({});
    //ENDBlock filter user type selection

    var tablePayroll =  $('#table-payroll').DataTable({
      processing :true,
      serverSide : true,
      ajax : {
        url : '{!! url('payroll/dataTables') !!}',
        data: function(d){
          d.filter_period = $('select[name=filter_period]').val();
          d.filter_user_type = $('select[name=filter_user_type]').val();
        }
      },
      columns :[
        {data: 'rownum', name: 'rownum', searchable:false},
        { data: 'period.code', name: 'period.code' },
        { data: 'user.nik', name: 'user.nik' },
        { data: 'user.name', name: 'user.name' },
        { data: 'thp_amount', name: 'thp_amount' },
        { data: 'status', name: 'status' },
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
      if ($(this).index() != 0 && $(this).index() != 6) {
        $(this).html('<input class="form-control" type="text" placeholder="Search" data-id="' + $(this).index() + '" />');
      }
          
    });
    //Block search input and select
    $('#searchColumn input').keyup(function() {
      tablePayroll.columns($(this).data('id')).search(this.value).draw();
    });
    //ENDBlock search input and select

    //Filter handling
    $('#form-filter').on('submit', function(e) {
      tablePayroll.draw();
      e.preventDefault();
    });

    //Payroll row selection handler
    var selectedPayroll = [];
    tablePayroll.on( 'click', 'tr', function () {
      $(this).toggleClass('selected');
    });
    //ENDPurchase request row selection handler

    //Set Check handler
    $('#btn-set-check').on('click', function(event){
      event.preventDefault();
      selectedPayroll = [];
      var selected_payroll_id = tablePayroll.rows('.selected').data();
      $.each( selected_payroll_id, function( key, value ) {
        selectedPayroll.push(selected_payroll_id[key].id);
      });
      if(selectedPayroll.length == 0){
        alert('There are no selected row');
      }else{
        $('#form-check').find('.id_to_check').remove();
        $('#selected_purchase_request_counter').html(selectedPayroll.length);
        $.each( selectedPayroll, function( key, value ) {
          $('#form-check').append('<input type="hidden" class="id_to_check" name="id_to_check[]" value="'+value+'"/>');
        });
        $('#modal-check').modal('show');  
      }
      
    });
    //ENDSet Check handler

    //Set Approve handler
    $('#btn-set-approve').on('click', function(event){
      event.preventDefault();
      selectedPayroll = [];
      var selected_payroll_id = tablePayroll.rows('.selected').data();
      $.each( selected_payroll_id, function( key, value ) {
        selectedPayroll.push(selected_payroll_id[key].id);
      });
      if(selectedPayroll.length == 0){
        alert('There are no selected row');
      }else{
        $('#form-approve').find('.id_to_approve').remove();
        $('#selected_purchase_request_counter').html(selectedPayroll.length);
        $.each( selectedPayroll, function( key, value ) {
          $('#form-approve').append('<input type="hidden" class="id_to_approve" name="id_to_approve[]" value="'+value+'"/>');
        });
        $('#modal-approve').modal('show');  
      }
      
    });
    //ENDSet Approve handler
  </script>
@endsection