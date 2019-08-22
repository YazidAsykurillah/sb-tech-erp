@extends('layouts.app')

@section('page_title')
  Transfer Task Invoice Vendor
@endsection

@section('page_header')
  <h1>
    Transfer Task
    <small>Task Invoice Vendor</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('#') }}"><i class="fa fa-tag"></i> Transfer Task</a></li>
    <li><a href="{{ URL::to('transfer-task/invoice-vendor') }}"><i class="fa fa-tag"></i> Invoice Vendor</a></li>
  </ol>
@endsection
  
@section('content')
  <div class="row">
    <div class="col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Invoice Vendor</h3>
              
              <div class="pull-right">
                @if(\Auth::user()->roles->first()->code == 'SUP')
                  <button type="button" class="btn btn-info btn-xs" id="btn-transfer-multiple"><i class="fa fa-money"></i> Transfer Multiple</button>
                  <button type="button" class="btn btn-success btn-xs" id="btn-approve-multiple"><i class="fa fa-check"></i> Approve Multiple</button>
                @endif

                @if(\Auth::user()->roles->first()->code == 'FIN')
                  <button type="button" class="btn btn-info btn-xs" id="btn-transfer-multiple"><i class="fa fa-money"></i> Transfer Multiple</button>
                @endif
              </div>
              
            </div><!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="table-invoice-vendor">
                  <thead>
                    <tr>
                      <th style="width:5%;">#</th>
                      <th style="width:15%;">Invoice Number</th>
                      <th>Project</th>
                      <th>Vendor</th>
                      <th style="width:10%;">PO Vendor</th>
                      <th style="width:10%;text-align:right;">Amount</th>
                      <th style="width:10%;">Due Date</th>
                      <th>Remitter Bank</th>
                      <th>Beneficiary Bank (Vendor's Bank)</th>
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
  <div class="modal fade" id="modal-transfer-invoice-vendor" tabindex="-1" role="dialog" aria-labelledby="modal-transfer-invoice-vendorLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      {!! Form::open(['url'=>'transfer-task/invoice-vendor/transfer', 'role'=>'form', 'class'=>'form-horizontal', 'method'=>'post']) !!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="modal-transfer-invoice-vendorCustomerLabel">Transfer Confirmation</h4>
        </div>
        <div class="modal-body">
          <p>
            Invoice Vendor <b id="invoice_vendor_code"></b> will be transfered from <b id="remitterBank"></b>
          </p>
          <p><b id="beneficiaryBank"></b></p>
          
        </div>
        <div class="modal-footer">
          <input type="hidden" id="invoice_vendor_id_to_transfer" name="invoice_vendor_id_to_transfer" />
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-info">Transfer</button>
        </div>
      {!! Form::close() !!}
      </div>
    </div>
  </div>
<!--ENDModal Transfer-->

<!--Modal Transfer Multiple-->
  <div class="modal fade" id="modal-transfer-invoice-vendor-multiple" tabindex="-1" role="dialog" aria-labelledby="modal-transfer-invoice-vendor-multipleLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      {!! Form::open(['url'=>'transfer-task/invoice-vendor/transferMultiple', 'role'=>'form','id'=>'form-transfer-invoice-vendor-multiple', 'class'=>'form-horizontal', 'method'=>'post']) !!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="modal-transfer-invoice-vendor-multipleLabel">Multiple Transfer Confirmation</h4>
        </div>
        <div class="modal-body">
          <p>
            Selected invoice vendors will be transfered
          </p>
          
        </div>
        <div class="modal-footer">
          
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-info">Transfer</button>
        </div>
      {!! Form::close() !!}
      </div>
    </div>
  </div>
<!--ENDModal Transfer Multiple-->

 <!--Modal Approve Transfer Task Invoice Vendor-->
  <div class="modal fade" id="modal-approve-transfer-invoice-vendor" tabindex="-1" role="dialog" aria-labelledby="modal-approve-transfer-invoice-vendorLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      {!! Form::open(['url'=>'transfer-task/invoice-vendor/approve', 'role'=>'form', 'class'=>'form-horizontal', 'method'=>'post']) !!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="modal-approve-transfer-invoice-vendorCustomerLabel">Confirmation</h4>
        </div>
        <div class="modal-body">
          <p><small>Please select Remitter Bank to approve this Invoice Vendor transfer task</small></p>
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
          <input type="hidden" id="invoice_vendor_id_to_approve" name="invoice_vendor_id_to_approve" />
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-info">Approve</button>
        </div>
      {!! Form::close() !!}
      </div>
    </div>
  </div>
<!--ENDModal Approve Transfer Task Invoice Vendor-->

<!--Modal Approve Transfer Task Invoice Vendor Multiple-->
  <div class="modal fade" id="modal-approve-transfer-invoice-vendor-multiple" tabindex="-1" role="dialog" aria-labelledby="modal-approve-transfer-invoice-vendor-multipleLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      {!! Form::open(['url'=>'transfer-task/invoice-vendor/approveMultiple', 'role'=>'form', 'id'=>'form-approve-invoice-vendor-multiple', 'class'=>'form-horizontal', 'method'=>'post']) !!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="modal-approve-transfer-invoice-vendor-multipleLabel">Confirmation Multiple</h4>
        </div>
        <div class="modal-body">
          <p><small>Please select Remitter Bank to approve this Invoice Vendor transfer task</small></p>
          <!-- Selection Remitter Bank-->
          <div class="form-group{{ $errors->has('remitter_bank_id_multiple') ? ' has-error' : '' }}">
            {!! Form::label('remitter_bank_id_multiple', 'Remitter Bank', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              <select name="remitter_bank_id_multiple" id="remitter_bank_id_multiple" class="form-control" style="width:100%;" required>
                @if(Request::old('remitter_bank_id_multiple') != NULL)
                  <option value="{{Request::old('remitter_bank_id_multiple')}}">
                    {{ \App\Cash::find(Request::old('remitter_bank_id_multiple'))->code }}
                  </option>
                @endif
              </select>
              @if ($errors->has('remitter_bank_id_multiple'))
                <span class="help-block">
                  <strong>{{ $errors->first('remitter_bank_id_multiple') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <!-- ENDSelection Remitter Bank-->
          <div class="form-group{{ $errors->has('force_transfer') ? ' has-error' : '' }}">
            {!! Form::label('force_transfer', 'Force Transfer', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              <input type="checkbox" name="force_transfer">
              <span class="help-block">
                <strong>If checked, the item will be forced to be transfered</strong>
              </span>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-info">Approve</button>
        </div>
      {!! Form::close() !!}
      </div>
    </div>
  </div>
<!--ENDModal Approve Transfer Task Invoice Vendor Multiple-->

@endsection

@section('additional_scripts')
   <script type="text/javascript">
    var tableInvoiceVendor =  $('#table-invoice-vendor').DataTable({
      processing :true,
      serverSide : true,
      //ajax : '{!! route('datatables.getTransferTaskInvoiceVendors') !!}',
      ajax : {
        url : '{!! route('datatables.getTransferTaskInvoiceVendors') !!}',
        data : function(d){
          d.filter = '{!! $filter !!}'
        }
      },
      columns :[
        {data: 'rownum', name: 'rownum', searchable:false},
        { data: 'code', name: 'code' },
        { data: 'project', name: 'project.code' },
        { data: 'vendor', name:'purchase_order_vendor.vendor.name' },
        { data: 'po_vendor_code', name:'purchase_order_vendor.code' },
        { data: 'amount', name: 'amount', className:'dt-body-right' },
        { data: 'due_date', name: 'due_date' },
        { data: 'remitter_bank', name: 'remitter_bank.name' },
        { data: 'beneficiary_bank', name: 'purchase_order_vendor.vendor.bank_account' },
        { data: 'accounted', name: 'accounted' },
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
        //order by the due date, the closest due date from now on
        [6, 'asc']
      ]

    });

    // Setup - add a text input to each header cell
    $('#searchColumn th').each(function() {
      if ($(this).index() != 0 && $(this).index() != 11) {
        $(this).html('<input class="form-control" type="text" placeholder="Search" data-id="' + $(this).index() + '" />');
      }
          
    });
    //Block search input and select
    $('#searchColumn input').keyup(function() {
      tableInvoiceVendor.columns($(this).data('id')).search(this.value).draw();
    });
    //ENDBlock search input and select

    // Approve Transfer Invoice Vendor event handler
    tableInvoiceVendor.on('click', '.btn-approve-transfer-invoice-vendor', function(e){
      var id = $(this).attr('data-id');
      var code = $(this).attr('data-text');
      $('#invoice_vendor_id_to_approve').val(id);
      $('#modal-approve-transfer-invoice-vendor').modal('show');
    });

    // Run Transfer Invoice Vendor event handler
    tableInvoiceVendor.on('click', '.btn-transfer-invoice-vendor', function(e){
      var id = $(this).attr('data-id');
      var code = $(this).attr('data-text');
      var amount = $(this).attr('data-amount');
      var remitterBank = $(this).attr('data-remitterBank');
      var beneficiaryBank = $(this).attr('data-beneficiaryBank');
      $('#invoice_vendor_id_to_transfer').val(id);
      $('#invoice_vendor_code').text(code);
      $('#remitterBank').text(remitterBank);
      $('#beneficiaryBank').text(beneficiaryBank);
      $('#modal-transfer-invoice-vendor').modal('show');
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



    //Block approve multiple invoice vendor

    //Block Remitter Bank Selection for Multiple
    $('#remitter_bank_id_multiple').select2({
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

    var selectedInvoiceVendor = [];
    tableInvoiceVendor.on( 'click', 'tr', function () {
        $(this).toggleClass('selected');

    });
    var selected_invoice_vendor_ids = tableInvoiceVendor.rows('.selected').data();
    $.each( selected_invoice_vendor_ids, function( key, value ) {
      selectedInvoiceVendor.push(selected_invoice_vendor_ids[key].id);
    });

    //Approve Multiple handler
    $('#btn-approve-multiple').on('click', function(event){
      event.preventDefault();
      selectedInvoiceVendor = [];
      var selected_invoice_vendor_ids = tableInvoiceVendor.rows('.selected').data();
      $.each( selected_invoice_vendor_ids, function( key, value ) {
        selectedInvoiceVendor.push(selected_invoice_vendor_ids[key].id);
      });
      console.log(selectedInvoiceVendor);
      if(selectedInvoiceVendor.length == 0){
        alert('There are no selected row');
      }else{
        $('#form-approve-invoice-vendor-multiple').find('.invoice_vendor_multiple').remove();
        $.each( selectedInvoiceVendor, function( key, value ) {
          $('#form-approve-invoice-vendor-multiple').append('<input type="hidden" class="invoice_vendor_multiple" name="invoice_vendor_multiple[]" value="'+value+'"/>');
        });
        $('#modal-approve-transfer-invoice-vendor-multiple').modal('show');  
      }
    });


    //transfer Multiple handler
    $('#btn-transfer-multiple').on('click', function(event){
      event.preventDefault();
      selectedInvoiceVendor = [];
      var selected_invoice_vendor_ids = tableInvoiceVendor.rows('.selected').data();
      $.each( selected_invoice_vendor_ids, function( key, value ) {
        selectedInvoiceVendor.push(selected_invoice_vendor_ids[key].id);
      });
      console.log(selectedInvoiceVendor);
      if(selectedInvoiceVendor.length == 0){
        alert('There are no selected row');
      }else{
        $('#form-transfer-invoice-vendor-multiple').find('.invoice_vendor_multiple').remove();
        $.each( selectedInvoiceVendor, function( key, value ) {
          $('#form-transfer-invoice-vendor-multiple').append('<input type="hidden" class="invoice_vendor_multiple" name="invoice_vendor_multiple[]" value="'+value+'"/>');
        });
        $('#modal-transfer-invoice-vendor-multiple').modal('show');  
      }
    });

  </script>
@endsection