@extends('layouts.app')

@section('page_title')
  Transfer Task Settlement
@endsection

@section('page_header')
  <h1>
    Transfer Task
    <small>Task Settlement</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('#') }}"><i class="fa fa-tag"></i> Transfer Task</a></li>
    <li><a href="{{ URL::to('transfer-task/settlement') }}"><i class="fa fa-tag"></i> Settlement</a></li>
  </ol>
@endsection
  
@section('content')
  <div class="row">
    <div class="col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Settlement</h3>
            </div><!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="table-settlement">
                  <thead>
                    <tr>
                      <th style="width:5%;">#</th>
                      <th style="width:10%;">Code</th>
                      <th>IR Code</th>
                      <th>Member</th>
                      <th style="text-align:right;">Amount</th>
                      <th>Result</th>
                      <th>Status</th>
                      <th>Balance</th>
                      <th>Transaction Date</th>
                      <th>Accounted Approval</th>
                      <th>Accounted</th>
                      <th>IR Cash</th>
                      <th>Settlement Cash</th>
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
  <div class="modal fade" id="modal-transfer-settlement" tabindex="-1" role="dialog" aria-labelledby="modal-transfer-settlementLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      {!! Form::open(['url'=>'transfer-task/settlement/transfer', 'role'=>'form', 'class'=>'form-horizontal', 'method'=>'post']) !!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="modal-transfer-settlementCustomerLabel">Transfer Confirmation</h4>
        </div>
        <div class="modal-body">
          <p>
            Settlement <b id="settlement_code_to_transfer"></b> will be transfered from <b id="remitterBank"></b>
          </p>
          
        </div>
        <div class="modal-footer">
          <input type="hidden" id="settlement_id_to_transfer" name="settlement_id_to_transfer" />
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-info">Transfer</button>
        </div>
      {!! Form::close() !!}
      </div>
    </div>
  </div>
<!--ENDModal Transfer-->

 <!--Modal Approve Transfer Task Settlement-->
  <div class="modal fade" id="modal-approve-transfer-settlement" tabindex="-1" role="dialog" aria-labelledby="modal-approve-transfer-settlementLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      {!! Form::open(['url'=>'transfer-task/settlement/approve', 'role'=>'form', 'class'=>'form-horizontal', 'method'=>'post']) !!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="modal-approve-transfer-settlementCustomerLabel">Confirmation</h4>
        </div>
        <div class="modal-body">
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
          <input type="hidden" id="settlement_id_to_approve" name="settlement_id_to_approve" />
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-info">Approve</button>
        </div>
      {!! Form::close() !!}
      </div>
    </div>
  </div>
<!--ENDModal Approve Transfer Task Settlement-->

@endsection

@section('additional_scripts')
   <script type="text/javascript">
    var tableSettlement =  $('#table-settlement').DataTable({
      processing :true,
      serverSide : true,
      ajax : '{!! route('datatables.getTransferTaskSettlement') !!}',
      columns :[
        {data: 'rownum', name: 'rownum', searchable:false},
        { data: 'code', name: 'code' },
        { data: 'ir_code', name: 'internal_request.code' },
        { data: 'member_name', name: 'internal_request.requester.name'},
        { data: 'amount', name: 'amount', className:'dt-body-right' },
        { data: 'result', name: 'result' },
        { data: 'status', name: 'status' },
        { data: 'balance', name: 'balance', searchable:false, orderable:false },
        { data: 'transaction_date', name: 'transaction_date' },
        { data: 'accounted_approval', name: 'settlements.accounted_approval', className:'dt-body-center'},
        { data: 'accounted', name: 'settlements.accounted', className:'dt-body-center'},
        { data: 'ir_cash', name: 'internal_request.remitter_bank.name' },
        { data: 'remitter_bank_id', name: 'remitter_bank.name'},
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
            .column(7)
            .data()
            .reduce( function (a, b) {
                return theFloat(a) + theFloat(b);
            }, 0 );
        // Update footer
        $( api.column(7).footer() ).html(
            total.toLocaleString()
        );
      },
      order : [
        [8, 'desc']
      ]

    });

    // Setup - add a text input to each header cell
    $('#searchColumn th').each(function() {
      if ($(this).index() != 0 && $(this).index() != 12) {
        $(this).html('<input class="form-control" type="text" placeholder="Search" data-id="' + $(this).index() + '" />');
      }
          
    });
    //Block search input and select
    $('#searchColumn input').keyup(function() {
      tableSettlement.columns($(this).data('id')).search(this.value).draw();
    });
    //ENDBlock search input and select

    // Approve Transfer Settlement event handler
    tableSettlement.on('click', '.btn-approve-transfer-settlement', function(e){
      var id = $(this).attr('data-id');
      var code = $(this).attr('data-text');
      $('#settlement_id_to_approve').val(id);
      $('#modal-approve-transfer-settlement').modal('show');
    });

    // Run Transfer Settlement event handler
    tableSettlement.on('click', '.btn-transfer-settlement', function(e){
      var id = $(this).attr('data-id');
      var code = $(this).attr('data-text');
      var amount = $(this).attr('data-amount');
      var remitterBank = $(this).attr('data-remitterBank');
      var beneficiaryBank = $(this).attr('data-beneficiaryBank');
      $('#settlement_id_to_transfer').val(id);
      $('#settlement_code_to_transfer').text(code);
      $('#remitterBank').text(remitterBank);
      $('#beneficiaryBank').text(beneficiaryBank);
      $('#modal-transfer-settlement').modal('show');
    });

    //Block Remitter Bank Selection
    $('#remitter_bank_id').select2({
      placeholder: 'Select Settlement Cash',
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