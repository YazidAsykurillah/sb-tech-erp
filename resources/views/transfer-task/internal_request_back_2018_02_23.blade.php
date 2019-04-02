@extends('layouts.app')

@section('page_title')
  Transfer Task
@endsection

@section('page_header')
  <h1>
    Transfer Task
    <small>Task Internal Request</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('#') }}"><i class="fa fa-tag"></i> Transfer Task</a></li>
    <li><a href="{{ URL::to('transfer-task/internal-request') }}"><i class="fa fa-tag"></i> Internal Request</a></li>
  </ol>
@endsection
  
@section('content')
  <div class="row">
    <div class="col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Internal Request</h3>
            </div><!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="table-internal-request">
                  <thead>
                    <tr>
                      <th style="width:5%;">#</th>
                      <th style="width:10%;">IR Number</th>
                      <th>Petty Cash</th>
                      <th>Project</th>
                      <th>Type</th>
                      <th style="width:10%;text-align:right;">Amount</th>
                      <th>Remitter Bank</th>
                      <th>Beneficiary Bank</th>
                      <th>Requester</th>
                      <th>Created Date</th>
                      <th>Accounted Status</th>
                      <th>Accounted Approval Status</th>
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
                      <th style="text-align:right;"></th>
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
  <div class="modal fade" id="modal-transfer-internal-request" tabindex="-1" role="dialog" aria-labelledby="modal-transfer-internal-requestLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      {!! Form::open(['url'=>'transfer-task/internal-request/transfer', 'role'=>'form', 'class'=>'form-horizontal', 'method'=>'post']) !!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="modal-transfer-internal-requestCustomerLabel">Transfer Confirmation</h4>
        </div>
        <div class="modal-body">
          <p>Internal Request <b id="internal_request_code"></b> will be transfered </p>
        </div>
        <div class="modal-footer">
          <input type="hidden" id="internal_request_id_to_transfer" name="internal_request_id_to_transfer" />
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-info">Transfer</button>
        </div>
      {!! Form::close() !!}
      </div>
    </div>
  </div>
<!--ENDModal Transfer-->

 <!--Modal Approve Transfer Task IR-->
  <div class="modal fade" id="modal-approve-transfer-internal-request" tabindex="-1" role="dialog" aria-labelledby="modal-approve-transfer-internal-requestLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      {!! Form::open(['url'=>'transfer-task/internal-request/approve', 'role'=>'form', 'class'=>'form-horizontal', 'method'=>'post']) !!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="modal-approve-transfer-internal-requestCustomerLabel">Confirmation</h4>
        </div>
        <div class="modal-body">
          <p><small>Please select Remitter Bank and Beneficiary Bank to approve this internal request transfer task</small></p>
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
          <!-- Selection Beneficiary Bank-->
          <div class="form-group{{ $errors->has('beneficiary_bank_id') ? ' has-error' : '' }}">
            {!! Form::label('beneficiary_bank_id', 'Beneficiary Bank', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              <select name="beneficiary_bank_id" id="beneficiary_bank_id" class="form-control" style="width:100%;">
                @if(Request::old('beneficiary_bank_id') != NULL)
                  <option value="{{Request::old('beneficiary_bank_id')}}">
                    {{ \App\Cash::find(Request::old('beneficiary_bank_id'))->code }}
                  </option>
                @endif
              </select>
              @if ($errors->has('beneficiary_bank_id'))
                <span class="help-block">
                  <strong>{{ $errors->first('beneficiary_bank_id') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <!-- ENDSelection Beneficiary Bank-->
        </div>
        <div class="modal-footer">
          <input type="hidden" id="internal_request_id_to_approve" name="internal_request_id_to_approve" />
          <input type="hidden" id="requester_id" name="requester_id" />
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-info">Approve</button>
        </div>
      {!! Form::close() !!}
      </div>
    </div>
  </div>
<!--ENDModal Approve Transfer Task IR-->


<!--Modal Approve Transfer Task IR PINDAH BUKU-->
  <div class="modal fade" id="modal-approve-pindah-buku" tabindex="-1" role="dialog" aria-labelledby="modal-approve-pindah-bukuLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      {!! Form::open(['url'=>'transfer-task/internal-request/approvePindahBuku', 'role'=>'form', 'class'=>'form-horizontal', 'method'=>'post']) !!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="modal-approve-pindah-bukuCustomerLabel">Confirmation</h4>
        </div>
        <div class="modal-body">
          <p><small>Please select Source Bank and Target Bank to approve this internal request transfer task</small></p>
          <!-- Selection Source Bank-->
          <div class="form-group{{ $errors->has('bank_source_id') ? ' has-error' : '' }}">
            {!! Form::label('bank_source_id', 'Source Bank', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              <select name="bank_source_id" id="bank_source_id" class="form-control" style="width:100%;" required>
                @if(Request::old('bank_source_id') != NULL)
                  <option value="{{Request::old('bank_source_id')}}">
                    {{ \App\Cash::find(Request::old('bank_source_id'))->code }}
                  </option>
                @endif
              </select>
              @if ($errors->has('bank_source_id'))
                <span class="help-block">
                  <strong>{{ $errors->first('bank_source_id') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <!-- ENDSelection Source Bank-->
          <!-- Selection Target Bank-->
          <div class="form-group{{ $errors->has('bank_target_id') ? ' has-error' : '' }}">
            {!! Form::label('bank_target_id', 'Target Bank', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              <select name="bank_target_id" id="bank_target_id" class="form-control" style="width:100%;" required>
                @if(Request::old('bank_target_id') != NULL)
                  <option value="{{Request::old('bank_target_id')}}">
                    {{ \App\Cash::find(Request::old('bank_target_id'))->code }}
                  </option>
                @endif
              </select>
              @if ($errors->has('bank_target_id'))
                <span class="help-block">
                  <strong>{{ $errors->first('bank_target_id') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <!-- ENDSelection Target Bank-->
        </div>
        <div class="modal-footer">
          <input type="hidden" id="internal_request_pindah_buku_id_to_approve" name="internal_request_pindah_buku_id_to_approve" />
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-info">Approve</button>
        </div>
      {!! Form::close() !!}
      </div>
    </div>
  </div>
<!--ENDModal Approve Transfer Task IR PINDAH BUKU-->
@endsection

@section('additional_scripts')
   <script type="text/javascript">
    var tableInternalRequest =  $('#table-internal-request').DataTable({
      processing :true,
      serverSide : true,
      ajax : '{!! route('datatables.getTransferTaskInternalRequests') !!}',
      columns :[
        {data: 'rownum', name: 'rownum', searchable:false},
        { data: 'code', name: 'code' },
        { data: 'is_petty_cash', name: 'is_petty_cash' },
        { data: 'project', name: 'project.code' },
        { data: 'type', name: 'type' },
        { data: 'amount', name: 'amount', className:'dt-body-right' },
        { data: 'remitter_bank', name: 'remitter_bank.name' },
        { data: 'beneficiary_bank', name: 'beneficiary_bank.name'},
        { data: 'requester', name: 'requester.name' },
        { data: 'created_at', name: 'created_at' },
        { data: 'transfered', name: 'accounted' },
        { data: 'accounted_approval', name: 'accounted_approval' },
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
            .column(5)
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
        [9, 'desc']
      ]

    });

    // Transfer event handler
    tableInternalRequest.on('click', '.btn-transfer-internal-request', function(e){
      var id = $(this).attr('data-id');
      var code = $(this).attr('data-text');
      var remitter_bank = $(this).attr('data-remitterBank');
      var beneficiary_bank = $(this).attr('data-beneficiaryBank');
      $('#internal_request_id_to_transfer').val(id);
      $('#internal_request_code').html(code);
      $('#remitter_bank').html(remitter_bank);
      $('#beneficiary_bank').html(beneficiary_bank);
      $('#modal-transfer-internal-request').modal('show');
    });

    // Approve Transfer Internal Request event handler
    tableInternalRequest.on('click', '.btn-approve-transfer-internal-request', function(e){
      var id = $(this).attr('data-id');
      var code = $(this).attr('data-text');
      var requester_id = $(this).attr('data-requester-id');
      $('#internal_request_id_to_approve').val(id);
      $('#requester_id').val(requester_id);
      $('#modal-approve-transfer-internal-request').modal('show');
    });

    // Approve Transfer Internal Request Pindah Buku event handler
    tableInternalRequest.on('click', '.btn-approve-transfer-internal-request-pindah-buku', function(e){
      var id = $(this).attr('data-id');
      var code = $(this).attr('data-text');
      $('#internal_request_pindah_buku_id_to_approve').val(id);
      $('#modal-approve-pindah-buku').modal('show');
    });

    // Setup - add a text input to each header cell
    $('#searchColumn th').each(function() {
      if ($(this).index() != 0 && $(this).index() != 12) {
        $(this).html('<input class="form-control" type="text" placeholder="Search" data-id="' + $(this).index() + '" />');
      }
          
    });
    //Block search input and select
    $('#searchColumn input').keyup(function() {
      tableInternalRequest.columns($(this).data('id')).search(this.value).draw();
    });
    //ENDBlock search input and select
    
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


    $('#beneficiary_bank_id').select2({
      placeholder: 'Bank Penerima',
      allowClear : true,
      ajax: {
        url: '/select2BankAccount',
        dataType: 'json',
        delay: 250,
        data: function (params) {
          var requester_id = $('#requester_id').val();
           return {
                q: params.term,
                user_id: requester_id,
                page: params.page
           };
       },
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
      },
      dropdownAutoWidth : true,
      width: '100%'
    });



    //Block Source Bank Selection
    $('#bank_source_id').select2({
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

    //Block Source Bank Selection
    $('#bank_target_id').select2({
      placeholder: 'Bank Penerima',
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