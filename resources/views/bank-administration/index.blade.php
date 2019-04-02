@extends('layouts.app')

@section('page_title')
    Bank Administration
@endsection

@section('page_header')
  <h1>
    Bank Administration
    <small>Daftar Bank Administration</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('bank-administration') }}"><i class="fa fa-book"></i> Bank Administration</a></li>
    <li class="active"><i></i> Index</li>
  </ol>
@endsection

@section('content')
  <div class="row">
    <div class="col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Bank Administration</h3>
              <a href="{{ URL::to('bank-administration/create')}}" class="btn btn-primary pull-right" title="Create new bank_account">
                <i class="fa fa-plus"></i>&nbsp;Add New
              </a>
            </div><!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="table-bank-administration">
                  <thead>
                    <tr>
                      <th style="width:5%;">#</th>
                      <th style="width:20%;">Code</th>
                      <th>Cash</th>
                      <th style="width:20%;">Refference Number</th>
                      <th>Description</th>
                      <th>Amount</th>
                      <th>Accounted</th>
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
  <div class="modal fade" id="modal-delete-bank-administration" tabindex="-1" role="dialog" aria-labelledby="modal-delete-bank-administrationLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      {!! Form::open(['url'=>'deleteBankAdministration', 'method'=>'post']) !!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="modal-delete-bank-administrationLabel">Confirmation</h4>
        </div>
        <div class="modal-body">
          You are going to delete <b id="bank-administration-code-to-delete"></b>
          <br/>
          <p class="text text-danger">
            <i class="fa fa-info-circle"></i>&nbsp;This process can not be reverted
          </p>
          <input type="hidden" id="bank_administration_id" name="bank_administration_id">
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
    var tableBankAdministration =  $('#table-bank-administration').DataTable({
      processing :true,
      serverSide : true,
      ajax : '{!! route('datatables.getBankAdministrations') !!}',
      columns :[
        {data: 'rownum', name: 'rownum', searchable:false},
        { data: 'code', name: 'code' },
        { data: 'cash', name: 'cash.name' },
        { data: 'refference_number', name: 'refference_number' },
        { data: 'description', name: 'description' },
        { data: 'amount', name: 'amount', className:'dt-body-right'},
        { data: 'accounted', name: 'accounted' },
        { data: 'actions', name: 'actions', orderable:false, searchable:false, className:'dt-body-center' },
      ],

    });

    // Delete button handler
    tableBankAdministration.on('click', '.btn-delete-bank-administration', function(e){
      var id = $(this).attr('data-id');
      var name = $(this).attr('data-text');
      $('#bank_administration_id').val(id);
      $('#bank-administration-code-to-delete').text(name);
      $('#modal-delete-bank-administration').modal('show');
    });

    // Setup - add a text input to each header cell
    $('#searchColumn th').each(function() {
      if ($(this).index() != 0 && $(this).index() != 7) {
        $(this).html('<input class="form-control" type="text" placeholder="Search" data-id="' + $(this).index() + '" />');
      }
          
    });
    //Block search input and select
    $('#searchColumn input').keyup(function() {
      tableBankAdministration.columns($(this).data('id')).search(this.value).draw();
    });
    //ENDBlock search input and select


    //Delete bank_account process
    $('#form-delete-bank_account').on('submit', function(){
      $('#btn-confirm-delete-bank_account').prop('disabled', true);
    });
    
  </script>
@endsection