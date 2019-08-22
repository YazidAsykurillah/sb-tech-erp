@extends('layouts.app')

@section('page_title')
    Invoice Vendor TAX
@endsection

@section('page_header')
  <h1>
    Invoice Vendor TAX
    <small>Daftar Invoice Vendor TAX</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('invoice-vendor-tax') }}"><i class="fa fa-credit-card"></i> Invoice Vendor Tax</a></li>
    <li class="active"><i></i> Index</li>
  </ol>
@endsection
  
@section('content')
  <div class="row">
    <div class="col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Invoice Vendor Tax</h3>
              
            </div><!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="table-invoice-vendor-tax">
                  <thead>
                    <tr>
                      <th style="width:5%;">#</th>
                      <th style="width:10%;">Tax Number</th>
                      <th>Tax Date</th>
                      <th style="width:10%;">Refference Number</th>
                      <th>Source</th>
                      <th>Percentage</th>
                      <th>Amount</th>
                      <th>Created At</th>
                      <th>Status</th>
                      <th>Bank</th>
                      <th>Approval</th>
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

  <!--Modal Paid Tax-->
  <div class="modal fade" id="modal-pay-tax" tabindex="-1" role="dialog" aria-labelledby="modal-pay-taxLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      {!! Form::open(['url'=>'payInvoiceVendorTax', 'method'=>'post']) !!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="modal-pay-taxLabel">Confirmation</h4>
        </div>
        <div class="modal-body">
          
          <!-- Selection Bank-->
          <div class="form-group{{ $errors->has('cash_id') ? ' has-error' : '' }}">
            {!! Form::label('cash_id', 'Bank', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              <select name="cash_id" id="cash_id" class="form-control" style="width:100%;" required>
                @if(Request::old('cash_id') != NULL)
                  <option value="{{Request::old('cash_id')}}">
                    {{ \App\Cash::find(Request::old('cash_id'))->code }}
                  </option>
                @endif
              </select>
              @if ($errors->has('cash_id'))
                <span class="help-block">
                  <strong>{{ $errors->first('cash_id') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <!-- ENDSelection Bank-->
          
          <input type="hidden" id="invoice_vendor_tax_id" name="invoice_vendor_tax_id">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-info">Submit</button>
        </div>
      {!! Form::close() !!}
      </div>
    </div>
  </div>
<!--ENDModal Paid Tax-->

<!--Modal Pay Tax Approval-->
  <div class="modal fade" id="modal-pay-tax-approval" tabindex="-1" role="dialog" aria-labelledby="modal-pay-tax-approvalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      {!! Form::open(['url'=>'payInvoiceVendorTaxApproval', 'method'=>'post']) !!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="modal-pay-tax-approvalLabel">Confirmation</h4>
        </div>
        <div class="modal-body">
          
          You are going to approve <b id="tax-description-to-approve"></b>
          <br/>
          <p class="text text-danger">
            <i class="fa fa-info-circle"></i>&nbsp;This process can not be reverted
          </p>
          <input type="hidden" id="invoice_vendor_tax_id_to_approve" name="invoice_vendor_tax_id_to_approve">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-info">Submit</button>
        </div>
      {!! Form::close() !!}
      </div>
    </div>
  </div>
<!--ENDModal Pay Tax Approval-->
@endsection

@section('additional_scripts')
   <script type="text/javascript">
    var tableInvoiceVendorTax =  $('#table-invoice-vendor-tax').DataTable({
      processing :true,
      serverSide : true,
      ajax : '{!! route('datatables.getInvoiceVendorTaxes') !!}',
      columns :[
        {data: 'rownum', name: 'rownum', searchable:false},
        { data: 'tax_number', name:'tax_number' },
        { data: 'tax_date', name:'invoice_vendor.tax_date' },
        { data: 'invoice_vendor_id', name:'invoice_vendor.code' },
        { data: 'source', name:'source' },
        { data: 'percentage', name:'percentage' },
        { data: 'amount', name:'amount' },
        { data: 'created_at', name:'created_at' },
        { data: 'status', name:'status' },
        { data: 'cash_id', name:'cash_id' },
        { data: 'approval', name:'approval' },
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
            .column(6)
            .data()
            .reduce( function (a, b) {
                return theFloat(a) + theFloat(b);
            }, 0 );
        // Update footer
        $( api.column(6).footer() ).html(
            total.toLocaleString()
        );
      },
      order : [
        [7, 'desc']
      ]

    });

    //Pay Tax event handler
    tableInvoiceVendorTax.on('click', '.btn-paid-tax', function(e){
      var id = $(this).attr('data-id');
      var description = $(this).attr('data-description');
      $('#invoice_vendor_tax_id').val(id);
      $('#tax-description').text(description);
      $('#modal-pay-tax').modal('show');
    });

    //Approve Tax PAID event handler
    tableInvoiceVendorTax.on('click', '.btn-approve-paid-tax', function(e){
      var id = $(this).attr('data-id');
      var description = $(this).attr('data-description');
      $('#invoice_vendor_tax_id_to_approve').val(id);
      $('#tax-description-to-approve').text(description);
      $('#modal-pay-tax-approval').modal('show');
    });

    // Setup - add a text input to each header cell
    $('#searchColumn th').each(function() {
      if ($(this).index() != 0 && $(this).index() != 10) {
        $(this).html('<input class="form-control" type="text" placeholder="Search" data-id="' + $(this).index() + '" />');
      }
          
    });
    //Block search input and select
    $('#searchColumn input').keyup(function() {
      tableInvoiceVendorTax.columns($(this).data('id')).search(this.value).draw();
    });
    //ENDBlock search input and select
    

    //Block Remitter Bank Selection
    $('#cash_id').select2({
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