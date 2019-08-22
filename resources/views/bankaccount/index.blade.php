@extends('layouts.app')

@section('page_title')
    Bank Account
@endsection

@section('page_header')
  <h1>
    Bank Account
    <small>Daftar Bank Account</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('bank-account') }}"><i class="fa fa-building"></i> Bank Account</a></li>
    <li class="active"><i></i> Index</li>
  </ol>
@endsection

@section('content')
  <div class="row">
    <div class="col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Bank Account</h3>
              <a href="{{ URL::to('bank-account/create')}}" class="btn btn-primary pull-right" title="Create new bank_account">
                <i class="fa fa-plus"></i>&nbsp;Add New
              </a>
            </div><!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="table-bank-account">
                  <thead>
                    <tr>
                      <th style="width:5%;">#</th>
                      <th style="width:20%;">Owner</th>
                      <th style="width:20%;">Bank Name</th>
                      <th>Account Number</th>
                      <th style="width:10%;text-align:center;">Actions</th>
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

  <!--Modal Delete Banck Account-->
  <div class="modal fade" id="modal-delete-bank_account" tabindex="-1" role="dialog" aria-labelledby="modal-delete-bank_accountLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      {!! Form::open(['url'=>'deleteBankAccount', 'method'=>'post']) !!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="modal-delete-bank_accountLabel">Confirmation</h4>
        </div>
        <div class="modal-body">
          You are going to delete <b id="bank_account-name-to-delete"></b>
          <br/>
          <p class="text text-danger">
            <i class="fa fa-info-circle"></i>&nbsp;This process can not be reverted
          </p>
          <input type="hidden" id="bank_account_id" name="bank_account_id">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-danger">Delete</button>
        </div>
      {!! Form::close() !!}
      </div>
    </div>
  </div>
<!--ENDModal Delete Banck Account-->
@endsection

@section('additional_scripts')
  <script type="text/javascript">
    var tableBankAccount =  $('#table-bank-account').DataTable({
      processing :true,
      serverSide : true,
      ajax : '{!! route('datatables.getBankAccounts') !!}',
      columns :[
        {data: 'rownum', name: 'rownum', searchable:false},
        { data: 'owner', name: 'owner.name' },
        { data: 'name', name: 'name' },
        { data: 'account_number', name: 'account_number' },
        { data: 'actions', name: 'actions', orderable:false, searchable:false, className:'dt-body-center' },
      ],

    });

    // Delete button handler
    tableBankAccount.on('click', '.btn-delete-bank-account', function(e){
      var id = $(this).attr('data-id');
      var name = $(this).attr('data-text');
      $('#bank_account_id').val(id);
      $('#bank_account-name-to-delete').text(name);
      $('#modal-delete-bank_account').modal('show');
    });

      // Setup - add a text input to each header cell
    $('#searchid th').each(function() {
      if ($(this).index() != 0 && $(this).index() != 5) {
          $(this).html('<input class="form-control" type="text" placeholder="Search" data-id="' + $(this).index() + '" />');
      }
    });
    //Block search input and select
    $('#searchid input').keyup(function() {
      tableBankAccount.columns($(this).data('id')).search(this.value).draw();
    });
    $('#searchid select').change(function () {
      if($(this).val() == ""){
        tableBankAccount.columns($(this).data('id')).search('').draw();
      }
      else{
        tableBankAccount.columns($(this).data('id')).search(this.value).draw();
      }
    });
    //ENDBlock search input and select


    //Delete bank_account process
    $('#form-delete-bank_account').on('submit', function(){
      $('#btn-confirm-delete-bank_account').prop('disabled', true);
    });
    
  </script>
@endsection