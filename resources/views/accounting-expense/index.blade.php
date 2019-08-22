@extends('layouts.app')

@section('page_title')
    Accounting Expense
@endsection

@section('page_header')
  <h1>
    Accounting Expense
    <small>Daftar Accounting Expense</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('master-data/accounting-expense') }}"><i class="fa fa-book"></i> Accounting Expense</a></li>
    <li class="active"><i></i> Index</li>
  </ol>
@endsection

@section('content')
  <div class="row">
    <div class="col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Accounting Expense</h3>
              <a href="{{ URL::to('accounting-expense/create')}}" class="btn btn-primary pull-right" title="Create new bank_account">
                <i class="fa fa-plus"></i>&nbsp;Add New
              </a>
            </div><!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="table-accounting-expense">
                  <thead>
                    <tr>
                      <th style="width:5%;">#</th>
                      <th style="width:20%;">Code</th>
                      <th>Name</th>
                      <th style="width:10%;text-align:center;">Actions</th>
                    </tr>
                  </thead>
                  <thead id="searchColumn">
                    <tr>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                    </tr>
                  </thead>
                  
                  <tbody>

                  </tbody>
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
    var tableAccountingExpense =  $('#table-accounting-expense').DataTable({
      processing :true,
      serverSide : true,
      ajax : '{!! route('datatables.getAccountingExpense') !!}',
      columns :[
        {data: 'rownum', name: 'rownum', searchable:false},
        { data: 'code', name: 'code' },
        { data: 'name', name: 'name' },
        { data: 'actions', name: 'actions', orderable:false, searchable:false, className:'dt-body-center' },
      ],

    });

    // Delete button handler
    tableAccountingExpense.on('click', '.btn-delete-accounting-expense', function(e){
      var id = $(this).attr('data-id');
      var name = $(this).attr('data-text');
      $('#accounting_expense_id').val(id);
      $('#accounting-expense-code-to-delete').text(name);
      $('#modal-delete-accounting-expense').modal('show');
    });

    // Setup - add a text input to each header cell
    $('#searchColumn th').each(function() {
      if ($(this).index() != 0 && $(this).index() != 7) {
        $(this).html('<input class="form-control" type="text" placeholder="Search" data-id="' + $(this).index() + '" />');
      }
          
    });
    //Block search input and select
    $('#searchColumn input').keyup(function() {
      tableAccountingExpense.columns($(this).data('id')).search(this.value).draw();
    });
    //ENDBlock search input and select


    //Delete bank_account process
    $('#form-delete-bank_account').on('submit', function(){
      $('#btn-confirm-delete-bank_account').prop('disabled', true);
    });
    
  </script>
@endsection