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
              <div class="pull-right">
                <button type="button" class="btn btn-info btn-xs" id="btn-transfer">
                  <i class="fa fa-money"></i> Transfer
                </button>
                
              </div>
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
                  <tfoot>
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
                  </tfoot>
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
      {!! Form::open(['url'=>'transfer-task/payroll/transfer', 'role'=>'form', 'id'=>'form-transfer', 'class'=>'form-horizontal', 'method'=>'post']) !!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="modal-transfer-payrollCustomerLabel">Transfer Confirmation</h4>
        </div>
        <div class="modal-body">
          <span class="selected_payroll_counter"></span> Will be transfered
          <p><small>Please select the Settlement Cash</small></p>
          <!-- Selection Remitter Bank-->
          <div class="form-group{{ $errors->has('remitter_bank_id') ? ' has-error' : '' }}">
            {!! Form::label('remitter_bank_id', 'Settlement Cash', ['class'=>'col-sm-2 control-label']) !!}
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
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-info">Transfer</button>
        </div>
      {!! Form::close() !!}
      </div>
    </div>
  </div>
<!--ENDModal Transfer-->


@endsection

@section('additional_scripts')
   <script type="text/javascript">
    var tablePayroll =  $('#table-payroll').DataTable({
      "lengthMenu": [[10, 25, 100, 500, -1], [10, 25, 100, 500, "All"]],
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
        var json = api.ajax.json();
        var grand_total = json.grand_total;
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
        $( api.column(3).footer() ).html(
            total.toLocaleString()
        );
      },
      order : [
        [1, 'desc']
      ]

    });

    // Setup - add a text input to each header cell
    $('#searchColumn th').each(function() {
      if ($(this).index() != 0 && $(this).index() != 7) {
        $(this).html('<input class="form-control" type="text" placeholder="Search" data-id="' + $(this).index() + '" />');
      }
          
    });
    //Block search input and select
    $('#searchColumn input').keyup(function() {
      tablePayroll.columns($(this).data('id')).search(this.value).draw();
    });
    //ENDBlock search input and select

    //Payroll row selection handler
    var selectedPayroll = [];
    tablePayroll.on( 'click', 'tr', function () {
      $(this).toggleClass('selected');
    });
    //ENDPurchase request row selection handler
    
    //Transfer handler
    $('#btn-transfer').on('click', function(event){
      event.preventDefault();
      selectedPayroll = [];
      var selected_payroll_id = tablePayroll.rows('.selected').data();
      $.each( selected_payroll_id, function( key, value ) {
        selectedPayroll.push(selected_payroll_id[key].id);
      });
      if(selectedPayroll.length == 0){
        alert('There are no selected row');
      }else{
        $('#form-transfer').find('.id_to_transfer').remove();
        $('.selected_payroll_counter').html(selectedPayroll.length);
        $.each( selectedPayroll, function( key, value ) {
          $('#form-transfer').append('<input type="hidden" class="id_to_transfer" name="id_to_transfer[]" value="'+value+'"/>');
        });
        $('#modal-transfer-payroll').modal('show');  
      }
      
    });
    //ENDTransfer handler

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