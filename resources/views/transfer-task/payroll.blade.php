@extends('layouts.app')

@section('page_title')
  Transfer Task payroll
@endsection

@section('page_header')
  <h1>
    Transfer Task
    <small>Task payroll</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('#') }}"><i class="fa fa-tag"></i> Transfer Task</a></li>
    <li><a href="{{ URL::to('transfer-task/payroll') }}"><i class="fa fa-tag"></i> payroll</a></li>
  </ol>
@endsection
  
@section('content')
  <div class="row">
    <div class="col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Payroll</h3>
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
                      <th>Status</th>
                      <th>Accounted</th>
                      <th>Remitter Bank</th>
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

  <!--Modal Transfer-->
  <div class="modal fade" id="modal-transfer-payroll" tabindex="-1" role="dialog" aria-labelledby="modal-transfer-payrollLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      {!! Form::open(['url'=>'transfer-task/payroll/transfer', 'role'=>'form', 'class'=>'form-horizontal', 'method'=>'post']) !!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="modal-transfer-payrollCustomerLabel">Transfer Confirmation</h4>
        </div>
        <div class="modal-body">
          <p>
            payroll <b id="payroll_code_to_transfer"></b> will be transfered from <b id="remitterBank"></b>
          </p>
          
        </div>
        <div class="modal-footer">
          <input type="hidden" id="payroll_id_to_transfer" name="payroll_id_to_transfer" />
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-info">Transfer</button>
        </div>
      {!! Form::close() !!}
      </div>
    </div>
  </div>
<!--ENDModal Transfer-->

 <!--Modal Approve Transfer Task payroll-->
  <div class="modal fade" id="modal-approve-transfer-payroll" tabindex="-1" role="dialog" aria-labelledby="modal-approve-transfer-payrollLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      {!! Form::open(['url'=>'transfer-task/payroll/approve', 'role'=>'form', 'class'=>'form-horizontal', 'method'=>'post']) !!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="modal-approve-transfer-payrollCustomerLabel">Confirmation</h4>
        </div>
        <div class="modal-body">
          <p><small>Please select Remitter Bank to approve this payroll transfer task</small></p>
          <!-- Selection Remitter Bank-->
          <div class="form-group{{ $errors->has('remitter_bank_id') ? ' has-error' : '' }}">
            {!! Form::label('remitter_bank_id', 'Remitter Bank', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              <select name="remitter_bank_id" id="remitter_bank_id" class="form-control" style="width:100%;" required>
                @if(Request::old('remitter_bank_id') != NULL)
                  <option value="{{Request::old('remitter_bank_id')}}">
                    {{ \App\Cash::find(Request::old('remitter_bank_id'))->code }}
                  </option>
                @endif
              </select>
              @if ($errors->has('remitter_bank_id'))
                <span class="help-block">
                  <strong>{{ $errors->first('remitter_bank_id') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <!-- ENDSelection Remitter Bank-->
        </div>
        <div class="modal-footer">
          <input type="hidden" id="payroll_id_to_approve" name="payroll_id_to_approve" />
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-info">Approve</button>
        </div>
      {!! Form::close() !!}
      </div>
    </div>
  </div>
<!--ENDModal Approve Transfer Task payroll-->

@endsection

@section('additional_scripts')
   <script type="text/javascript">
    var tablePayroll =  $('#table-payroll').DataTable({
      processing :true,
      serverSide : true,
      ajax : '{!! route('datatables.getTransferTaskPayroll') !!}',
      columns :[
        {data: 'rownum', name: 'rownum', searchable:false},
        { data: 'period.code', name: 'period.code' },
        { data: 'user.name', name: 'user.name' },
        { data: 'thp_amount', name: 'thp_amount' },
        { data: 'status', name: 'status' },
        { data: 'accounted', name: 'accounted' },
        { data: 'remitter_bank_id', name: 'remitter_bank_id'},
        { data: 'actions', name: 'actions', orderable:false, searchable:false, className:'dt-body-center' },
      ],
      footerCallback: function( tfoot, data, start, end, display ) {
        var api = this.api();
        // Remove the formatting to get float data for summation
        var theFloat = function ( i ) {
            return typeof i === 'string' ?
                parseFloat(i.replace(/[\$,]/g, '')) :
                typeof i === 'number' ?
                    i : 0;
        };

        // Total over all pages
        total = api
            .column(3)
            .data()
            .reduce( function (a, b) {
                return theFloat(a) + theFloat(b);
            }, 0 );
        // Update footer
        $( api.column(5).footer() ).html(
            total.toLocaleString()
        );
      },
      order : [
        [1, 'desc']
      ]

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

    // Approve Transfer payroll event handler
    tablePayroll.on('click', '.btn-approve-transfer-payroll', function(e){
      var id = $(this).attr('data-id');
      var code = $(this).attr('data-text');
      $('#payroll_id_to_approve').val(id);
      $('#modal-approve-transfer-payroll').modal('show');
    });

    // Run Transfer payroll event handler
    tablePayroll.on('click', '.btn-transfer-payroll', function(e){
      var id = $(this).attr('data-id');
      var amount = $(this).attr('data-amount');
      var remitterBank = $(this).attr('data-remitterBank');
      var beneficiaryBank = $(this).attr('data-beneficiaryBank');
      $('#payroll_id_to_transfer').val(id);
      $('#remitterBank').text(remitterBank);
      $('#beneficiaryBank').text(beneficiaryBank);
      $('#modal-transfer-payroll').modal('show');
    });

    //Block Remitter Bank Selection
    $('#remitter_bank_id').select2({
      placeholder: 'Bank Pengirim',
      ajax: {
        url: '{!! url('select2Cash') !!}',
        dataType: 'json',
        delay: 250,
        processResults: function (data) {
          return {
            results:  $.map(data, function (item) {
                  return {
                      text: item.name,
                      id: item.id,
                  }
              })
          };
        },
        cache: true
      },
      allowClear : true,
    });
  </script>
@endsection