@extends('layouts.app')

@section('page_title')
  {{ $cash->name }}
@endsection

@section('additional_styles')
  {!! Html::style('css/datepicker/datepicker3.css') !!}
@endsection

@section('page_header')
  <h1>
    Cash
    <small>Cash Detail</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('cash') }}"><i class="fa fa-cube"></i> Cash</a></li>
    <li class="active"><i></i> {{ $cash->name }}</li>
  </ol>
@endsection
  
@section('content')
  <div class="row">
    <div class="col-md-12">
      <!--BOX Basic Informations-->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-cube"></i>&nbsp;Cash Information</h3>
          <a href="{{ URL::to('cash/'.$cash->id.'/edit')}}" class="btn btn-success btn-xs pull-right" title="Edit">
                <i class="fa fa-edit"></i>&nbsp;Edit
          </a>
        </div><!-- /.box-header -->
        <div class="box-body">
          <div class="table-responsive">
            <table class="table">
               <tr>
                <td style="width: 20%;">Type</td>
                <td style="width: 1%;">:</td>
                <td>{{ $cash->type }}</td>
              </tr>
              <tr>
                <td style="width: 20%;">Name</td>
                <td style="width: 1%;">:</td>
                <td>{{ $cash->name }}</td>
              </tr>
              <tr>
                <td style="width: 20%;">Account Number</td>
                <td style="width: 1%;">:</td>
                <td>{{ $cash->account_number }}</td>
              </tr>
              <tr>
                <td style="width: 20%;">Description</td>
                <td style="width: 1%;">:</td>
                <td>{{ $cash->description }}</td>
              </tr>
              <tr>
                <td style="width: 20%;">Amount</td>
                <td style="width: 1%;">:</td>
                <td>{{ number_format($cash->amount, 2) }}</td>
              </tr>
              <tr>
                <td style="width: 20%;">Enabled</td>
                <td style="width: 1%;">:</td>
                <td>
                  @if($cash->enabled == TRUE)
                    Yes
                  @else
                    No
                  @endif
                </td>
              </tr>
              
            </table>
          </div>
        </div><!-- /.box-body -->
        <div class="box-footer clearfix">
          
        </div>
      </div>
      <!--ENDBOX Basic Informations-->
    </div>

  </div>


  <div class="row">
    <div class="col-md-12">
      <!--BOX Cash Transactions-->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-money"></i>&nbsp;Transaction Information</h3>
          <div class="pull-right">
            <a href="{{ URL::to('transaction/create/?cash_id='.$cash->id)}}" class="btn btn-info btn-xs" title="Create transaction from this cash">
              <i class="fa fa-plus"></i>&nbsp;Create Transaction
            </a>&nbsp;
            <a href="#" id="btn-import-excel" class="btn btn-success btn-xs" title="Import from Excel">
              <i class="fa fa-upload"></i>&nbsp;Import Excel
            </a>&nbsp;
            <!-- <a href="{{ url('transaction/exportExcel/?cash_id='.$cash->id) }}" id="btn-export-excel" class="btn btn-default btn-xs" title="Export to Excel">
              <i class="fa fa-file-excel-o"></i>&nbsp;Export Excel
            </a>&nbsp; -->
            <a href="#" id="btn-exporter" class="btn btn-default btn-xs" title="Click to export to excel file">
              <i class="fa fa-file-excel-o"></i>&nbsp;Export Excel
            </a>&nbsp;
          </div>
        </div><!-- /.box-header -->
        <div class="box-body">
          <div class="table-responsive">
              <form method="POST" id="date-range-search" class="form-inline" role="form">
                <div class="form-group">
                    <label for="date_from">From</label>
                    <input type="text" class="form-control" name="date_from" id="date_from" placeholder="From">
                </div>
                <div class="form-group">
                    <label for="date_to">To</label>
                    <input type="text" class="form-control" name="date_to" id="date_to" placeholder="To">
                </div>
                <button type="submit" class="btn btn-primary">Search</button>
              </form>
            <br/>
            <table id="table-transaction" class="table">
              <thead>
                <tr>
                  <th style="width:5%;">#</th>
                  <th style="width:10%;">Refference</th>
                  <th style="width:10%;">Reff. Number</th>
                  <th>Member Name</th>
                  <th style="width:5%;">Type</th>
                  <th style="text-align: right;width:10%;">Debet</th>
                  <th style="text-align: right;width:10%">Credit</th>
                  <th style="text-align: right;width:10%">Saldo</th>
                  <th>Notes</th>
                  <th>Transaction Date</th>
                  <th style="width:10%;">Created Date</th>
                  <th>Accounting Expense</th>
                  <th style="width:5%;text-align:center;">Actions</th>
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
              
              <tbody>

              </tbody>

              <tfoot>
                <tr>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th style="text-align:right;"></th>
                  <th style="text-align:right;"></th>
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
        <div class="box-footer clearfix"></div>
      </div>
      <!--ENDBOX Cash Transactions-->

      <!--BOX DELETED Transactions-->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-money"></i>&nbsp;Deleted Transaction Information</h3>
          
        </div><!-- /.box-header -->
        <div class="box-body">
          <div class="table-responsive">
            <table id="table-trashed-transaction" class="table">
              <thead>
                <tr>
                  <th style="width:5%;">#</th>
                  <th style="width:10%;">Refference</th>
                  <th style="width:10%;">Reff. Number</th>
                  <th>Member Name</th>
                  <th style="width:5%;">Type</th>
                  <th style="text-align: right;width:10%;">Debet</th>
                  <th style="text-align: right;width:10%">Credit</th>
                  <th style="text-align: right;width:10%">Saldo</th>
                  <th>Notes</th>
                  <th>Transaction Date</th>
                  <th style="width:10%;">Created Date</th>
                  <th style="width:5%;text-align:center;">Actions</th>
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
                  <th style="text-align:right;"></th>
                  <th style="text-align:right;"></th>
                  <th style="text-align:right;"></th>
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
        <div class="box-footer clearfix"></div>
      </div>
      <!--ENDBOX DELETED Transactions-->
    </div>
  </div>


  
<!--Modal Delete Transaction-->
  <div class="modal fade" id="modal-delete-transaction" tabindex="-1" role="dialog" aria-labelledby="modal-delete-transactionLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      {!! Form::open(['url'=>'deleteTransaction', 'method'=>'post']) !!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="modal-delete-transactionLabel">Confirmation</h4>
        </div>
        <div class="modal-body">
          You are going to delete <b id="transaction-refference-number"></b> from transaction list
          <br/>
          <p class="text text-danger">
            <i class="fa fa-info-circle"></i>&nbsp;This process can not be reverted
          </p>
          <input type="hidden" id="transaction_id" name="transaction_id">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-danger">Delete</button>
        </div>
      {!! Form::close() !!}
      </div>
    </div>
  </div>
  <!--ENDModal Delete Transaction-->

  <!--Modal Import Excel-->
  <div class="modal fade" id="modal-import-excel" tabindex="-1" role="dialog" aria-labelledby="modal-import-excelLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      {!! Form::open(['url'=>'transaction/importExcel', 'method'=>'post', 'id'=>'form-import-file', 'files'=>true]) !!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="modal-import-excelLabel">Import Excel File to The Cash</h4>
        </div>
        <div class="modal-body">
          
          <div class="form-group{{ $errors->has('file') ? ' has-error' : '' }}">
            {!! Form::label('file', 'File', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {!! Form::file('file') !!}
              @if ($errors->has('file'))
                <span class="help-block">
                  <strong>{{ $errors->first('file') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <input type="hidden" id="cash_id" name="cash_id" value="{{ $cash->id }}" />
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary" id="btn-import-transaction">Submit</button>
        </div>
      {!! Form::close() !!}
      </div>
    </div>
  </div>
  <!--ENDModal Import Excel-->

  <!--Modal update Transaction Date-->
  <div class="modal fade" id="modal-update-transaction" tabindex="-1" role="dialog" aria-labelledby="modal-update-transactionLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      {!! Form::open(['url'=>'updateTransactionDate', 'method'=>'post', 'role'=>'form', 'class'=>'form-horizontal']) !!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="modal-update-transactionLabel">Update Transaction Date</h4>
        </div>
        <div class="modal-body">
          <div class="form-group{{ $errors->has('transaction_date') ? ' has-error' : '' }}">
            {!! Form::label('transaction_date', 'Transaction Date', ['class'=>'col-sm-4 control-label']) !!}
            <div class="col-sm-8">
              {!!Form::text('transaction_date',null,['class'=>'form-control', 'placeholder'=>'Transaction date of the transaction', 'id'=>'transaction_date'])!!}
              @if ($errors->has('transaction_date'))
                <span class="help-block">
                  <strong>{{ $errors->first('transaction_date') }}</strong>
                </span>
              @endif
            </div>
          </div>

          <input type="hidden" id="transaction_id_to_update" name="transaction_id_to_update">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-info">update</button>
        </div>
      {!! Form::close() !!}
      </div>
    </div>
  </div>
  <!--ENDModal update Transaction Date-->

  <!--Modal Exporter-->
  <div class="modal fade" id="modal-exporter" tabindex="-1" role="dialog" aria-labelledby="modal-exporterLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      {!! Form::open(['url'=>'exporter/cash_transaction', 'class'=>'form-horizontal', 'role'=>'form', 'method'=>'post', 'id'=>'form-exporter']) !!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="modal-exporterLabel">Exporter</h4>
        </div>
        <div class="modal-body">
          <div class="form-group{{ $errors->has('exporter_type') ? ' has-error' : '' }}">
            {!! Form::label('exporter_type', 'Export Type', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {{ Form::select('exporter_type', ['monthly'=>'Monthly (Bulanan)', 'annual'=>'Annual (Tahunan)', 'full'=>'Full (Komplit)'], null, ['class'=>'form-control', 'placeholder'=>'Select Export Type', 'id'=>'exporter_type', 'required'=>false]) }}
              @if ($errors->has('exporter_type'))
                <span class="help-block">
                  <strong>{{ $errors->first('exporter_type') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <div class="form-group{{ $errors->has('year') ? ' has-error' : '' }}">
            {!! Form::label('year', 'Year', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {{ Form::select('year', $year_opts, null, ['class'=>'form-control', 'placeholder'=>'Select year', 'id'=>'year']) }}
              @if ($errors->has('year'))
                <span class="help-block">
                  <strong>{{ $errors->first('year') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <div class="form-group{{ $errors->has('month') ? ' has-error' : '' }}">
            {!! Form::label('month', 'Month', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {{ Form::select('month', $month_opts, null, ['class'=>'form-control', 'placeholder'=>'Select month', 'id'=>'month']) }}
              @if ($errors->has('month'))
                <span class="help-block">
                  <strong>{{ $errors->first('month') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <input type="hidden" id="cash_id_to_export" name="cash_id_to_export" value="{{ $cash->id }}" />
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary" id="btn-import-transaction">Submit</button>
        </div>
      {!! Form::close() !!}
      </div>
    </div>
  </div>
  <!--ENDModal Exporter-->

  <!--Modal create site settlement-->
  <div class="modal fade" id="modal-create-site-settlement" tabindex="-1" role="dialog" aria-labelledby="modal-create-site-settlementLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      {!! Form::open(['url'=>'transaction/storeSiteSettelement', 'method'=>'post', 'role'=>'form', 'class'=>'form-horizontal', 'id'=>'form-create-site-settlement']) !!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="modal-create-site-settlementLabel">Create site settlement</h4>
        </div>
        <div class="modal-body">

          <div class="form-group{{ $errors->has('site_ir_reference') ? ' has-error' : '' }}">
            {!! Form::label('site_ir_reference', 'Site IR Reference', ['class'=>'col-sm-4 control-label']) !!}
            <div class="col-sm-8">
              {!! Form::text('site_ir_reference',null,['class'=>'form-control', 'placeholder'=>'site_ir_reference of the site settelement', 'id'=>'site_ir_reference', 'readonly'=>true]) !!}
              @if ($errors->has('site_ir_reference'))
                <span class="help-block">
                  <strong>{{ $errors->first('site_ir_reference') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <div class="form-group{{ $errors->has('site_ir_amount') ? ' has-error' : '' }}">
            {!! Form::label('site_ir_amount', 'Site IR Amount', ['class'=>'col-sm-4 control-label']) !!}
            <div class="col-sm-8">
              {!! Form::text('site_ir_amount',null,['class'=>'form-control', 'placeholder'=>'site_ir_amount of the site settelement', 'id'=>'site_ir_amount', 'readonly'=>true]) !!}
              @if ($errors->has('site_ir_amount'))
                <span class="help-block">
                  <strong>{{ $errors->first('site_ir_amount') }}</strong>
                </span>
              @endif
            </div>
          </div>

          <div class="form-group{{ $errors->has('transaction_date_site_settlement') ? ' has-error' : '' }}">
            {!! Form::label('transaction_date_site_settlement', 'Transaction Date', ['class'=>'col-sm-4 control-label']) !!}
            <div class="col-sm-8">
              {!!Form::text('transaction_date_site_settlement',null,['class'=>'form-control', 'placeholder'=>'Transaction date of the transaction', 'id'=>'transaction_date_site_settlement', 'required'=>true])!!}
              @if ($errors->has('transaction_date_site_settlement'))
                <span class="help-block">
                  <strong>{{ $errors->first('transaction_date_site_settlement') }}</strong>
                </span>
              @endif
            </div>
          </div>

          <div class="form-group{{ $errors->has('site_settlement_amount') ? ' has-error' : '' }}">
            {!! Form::label('site_settlement_amount', 'Amount', ['class'=>'col-sm-4 control-label']) !!}
            <div class="col-sm-8">
              {!! Form::text('site_settlement_amount',null,['class'=>'form-control', 'placeholder'=>'site_settlement_amount of the site settelement', 'id'=>'site_settlement_amount', 'required'=>true]) !!}
              @if ($errors->has('site_settlement_amount'))
                <span class="help-block">
                  <strong>{{ $errors->first('site_settlement_amount') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <div class="form-group{{ $errors->has('site_settlement_notes') ? ' has-error' : '' }}">
            {!! Form::label('site_settlement_notes', 'Notes', ['class'=>'col-sm-4 control-label']) !!}
            <div class="col-sm-8">
              {!! Form::textarea('site_settlement_notes',null,['class'=>'form-control', 'placeholder'=>'Notes of the site settlement', 'id'=>'site_settlement_notes', 'required'=>true]) !!}
              @if ($errors->has('site_settlement_notes'))
                <span class="help-block">
                  <strong>{{ $errors->first('site_settlement_notes') }}</strong>
                </span>
              @endif
            </div>
          </div>

          <input type="hidden" id="transaction_id_to_settled" name="transaction_id_to_settled">
        </div>
        <div class="modal-footer">

          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-info" id="btn-submit-site-settlement">Submit</button>
        </div>
      {!! Form::close() !!}
      </div>
    </div>
  </div>
  <!--ENDModal create site settlement-->


  <!--Modal register accounting expense-->
  <div class="modal fade" id="modal-register-accounting-expense" tabindex="-1" role="dialog" aria-labelledby="modal-register-accounting-expenseLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      {!! Form::open(['url'=>'transaction/registerAccountingExpense', 'method'=>'post', 'role'=>'form', 'class'=>'form-horizontal', 'id'=>'form-register-accounting-expense']) !!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="modal-register-accounting-expenseLabel">Register Accounting Expense</h4>
        </div>
        <div class="modal-body">

          {{ Form::select('accounting_expense_id', $accountingExpenseOpts, null, ['class'=>'form-control', 'placeholder'=>'Select Accounting Expense', 'id'=>'accounting_expense_id' , 'required'=>true]) }}
          
          <input type="hidden" id="transaction_id_to_register_accounting_expense" name="transaction_id_to_register_accounting_expense">
        </div>
        <div class="modal-footer">

          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-info" id="btn-submit-site-settlement">Submit</button>
        </div>
      {!! Form::close() !!}
      </div>
    </div>
  </div>
  <!--ENDModal register accounting expense-->


@endsection

@section('additional_scripts')
  {!! Html::script('js/datepicker/bootstrap-datepicker.js') !!}
  {!! Html::script('js/autoNumeric.js') !!}

  <script type="text/javascript">
    var tableTransaction =  $('#table-transaction').DataTable({
      "lengthMenu": [[10, 25, 100, 500, -1], [10, 25, 100, 500, "All"]],
      processing :true,
      serverSide : true,
      ajax : {
        url : '{!! route('datatables.getTransactions') !!}',
        data: function(d){
          d.cash_id = '{!! $cash->id !!}';
          d.date_from = $('input[name=date_from]').val();
          d.date_to = $('input[name=date_to]').val();
        }
      },

      columns :[
        {data: 'rownum', name: 'rownum', searchable:false},
        { data: 'refference', name: 'refference' },
        { data: 'refference_number', name: 'refference_number' },
        { data: 'member_name', name:'member_name'},
        { data: 'type', name: 'type' },
        { data: 'debit_amount', name: 'amount', className:'dt-body-right' },
        { data: 'credit_amount', name: 'amount', className:'dt-body-right' },
        { data: 'reference_amount', name: 'reference_amount', className:'dt-body-right' },
        { data: 'notes', name: 'notes' },
        { data: 'transaction_date', name: 'transaction_date' },
        { data: 'created_at', name: 'created_at' },
        { data: 'accounting_expense', name: 'accounting_expense.name' },
        { data: 'actions', name: 'actions', orderable:false, searchable:false, className:'dt-body-center' }
      ],
      footerCallback: function( tfoot, data, start, end, display ) {
        var api = this.api();
        var json = api.ajax.json();
        var total_debet = json.total_debet;
        var total_credit = json.total_credit;
        // Remove the formatting to get float data for summation
        var theFloat = function ( i ) {
            return typeof i === 'string' ?
                parseFloat(i.replace(/[\$,]/g, '')) :
                typeof i === 'number' ?
                    i : 0;
        };
        // Total_debet_current current page
        total_debet_current = api
            .column(5, { page:'current'})
            .data()
            .reduce( function (a, b) {
                return theFloat(a) + theFloat(b);
            }, 0 );

        // Update footer from of debet sum
        $( api.column(5).footer() ).html(
            total_debet_current.toLocaleString() + '<br/> of Total : <br/>('+theFloat(total_debet).toLocaleString()+')'
        );

        // Total_credit_current current page
        total_credit_current = api
            .column(6, { page:'current' })
            .data()
            .reduce( function (a, b) {
                return theFloat(a) + theFloat(b);
            }, 0 );
        // Update footer from of credit sum
        $( api.column(6).footer() ).html(
            total_credit_current.toLocaleString() + '<br/> of Total : <br/>('+theFloat(total_credit).toLocaleString()+')'
        );
        
        //total balance from current page
        var total_balance_current = total_credit_current - total_debet_current;

        //total balnce from all page
        var total_balance = total_credit - total_debet;
        $(api.column(7).footer()).html(
          total_balance_current.toLocaleString() + '<br/> of Total : <br/>('+theFloat(total_balance).toLocaleString()+')'
        );
      }

    });

    // Delete button handler
    tableTransaction.on('click', '.btn-delete-transaction', function(e){
      var id = $(this).attr('data-id');
      var refference_number = $(this).attr('data-text');
      $('#transaction_id').val(id);
      $('#transaction-refference-number').text(refference_number);
      $('#modal-delete-transaction').modal('show');
    });

    // Setup - add a text input to each header cell
    
    // Update button handler
    tableTransaction.on('click', '.btn-update-transaction', function(e){
      var id = $(this).attr('data-id');
      var transaction_date = $(this).attr('data-transactionDate');

      $('#transaction_id_to_update').val(id);
      $('#transaction_date').val(transaction_date);
      $('#modal-update-transaction').modal('show');
    });

    //date range handling form
      //Block Date From input
      $('#date_from').on('keydown', function(event){
        event.preventDefault();
      });
      $('#date_from').datepicker({
        format : 'yyyy-mm-dd'
      });
      //ENDBlock Date From input
      //Block Date to Date input
      $('#date_to').on('keydown', function(event){
        event.preventDefault();
      });
      $('#date_to').datepicker({
        format : 'yyyy-mm-dd'
      });
      //ENDBlock Date to Date input
    $('#date-range-search').on('submit', function(e) {
      tableTransaction.draw();
      e.preventDefault();
    });
    // Setup - add a text input to each header cell

    $('#searchColumn th').each(function() {
      if ($(this).index() != 0 && $(this).index() != 12) {
        $(this).html('<input class="form-control" type="text" placeholder="Search" data-id="' + $(this).index() + '" />');
      }
      if ($(this).index() == 9) {
        $(this).html('<input class="form-control" type="text" placeholder="YYYY-MM-DD" id="transaction_date_search_column" data-id="' + $(this).index() + '" />');
      }
      
    });
    //Block search input and select
    $('#searchColumn input').keyup(function() {
      tableTransaction.columns($(this).data('id')).search(this.value).draw();
    });
    //ENDBlock search input and select


    $('#btn-import-excel').on('click', function(event){
      event.preventDefault();
      //$('#modal-import-excel').modal('show');
      $('#modal-import-excel').modal({
        backdrop : 'static',
        keyboard : false
      });

    });


    $('#form-import-file').on('submit', function(event){

      $('#btn-import-transaction').prop('disabled', true);
    });

    //Block Transaction Date input
    $('#transaction_date').on('keydown', function(event){
      event.preventDefault();
    });
    $('#transaction_date').datepicker({
      format : 'yyyy-mm-dd'
    });
    //ENDBlock Transaction Date input


    $('#btn-exporter').on('click', function(event){
      event.preventDefault();
      $('#modal-exporter').modal('show');
    });

    $('#exporter_type').on('change', function(){
      var exporter_type = $(this).val();
      if(exporter_type == 'annual'){
        $('#year').prop('required', true);
        $('#month').prop('required', false);
      }
      else if(exporter_type == 'monthly'){
        $('#year').prop('required', true);
        $('#month').prop('required', true);
      }
      else{
        $('#year').prop('required', false);
        $('#month').prop('required', false);
      }
    });

    
    //Block SITE SETTLEMENT
      //Block Transaction Date input
      $('#transaction_date_site_settlement').on('keydown', function(event){
        event.preventDefault();
      });
      $('#transaction_date_site_settlement').datepicker({
        format : 'yyyy-mm-dd'
      });
      //ENDBlock Transaction Date input

      //set up autonumerical inputs
      $('#site_ir_amount, #site_settlement_amount').autoNumeric('init',{
          aSep:',',
          aDec:'.'
      });

      //site settlement create handling
      tableTransaction.on('click', '.btn-create-sitesettlement', function(e){
        var id = $(this).attr('data-id');
        var site_ir_reference = $(this).attr('data-text');
        var site_ir_amount = $(this).attr('data-site_ir_amount');

        $('#transaction_id_to_settled').val(id);
        $('#site_ir_reference').val(site_ir_reference);
        $('#site_ir_amount').autoNumeric('set', site_ir_amount);
        $('#site_settlement_amount').autoNumeric('set', site_ir_amount);
        $('#modal-create-site-settlement').modal('show');
      });


      $('#form-create-site-settlement').on('submit', function(){
        $('#btn-submit-site-settlement').prop('disabled', true);
      });
    //ENDBlock SITE SETTLEMENT

    //Register accounting expense handlling
    tableTransaction.on('click', '.btn-register-accounting-expense', function(e){
      $('#transaction_id_to_register_accounting_expense').val($(this).attr('data-id'));
      $('#modal-register-accounting-expense').modal('show');
    });
  </script>
@endsection