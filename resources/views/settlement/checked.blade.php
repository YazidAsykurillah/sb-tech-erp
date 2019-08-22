@extends('layouts.app')

@section('page_title')
  Checked Settlement
@endsection

@section('page_header')
  <h1>
    Settlement
    <small>Daftar Settlement [Checked]</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('settlement') }}"><i class="fa fa-retweet"></i>Settlement</a></li>
    <li class="active"><i></i> Checked</li>
  </ol>
@endsection
  
@section('content')
  <div class="row">
    <div class="col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Settlement</h3>
              <!-- <a href="{{ URL::to('settlement/create')}}" class="btn btn-primary pull-right" title="Create new Settlement">
                <i class="fa fa-plus"></i>&nbsp;Add New
              </a> -->
            </div><!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="table-settlement">
                  <thead>
                    <tr>
                      <th style="width:5%;">#</th>
                      <th style="width:15%;">Code</th>
                      <th>IR Code</th>
                      <th>Transaction Date</th>
                      <th style="text-align:right;">Amount</th>
                      <th>Category</th>
                      <th>Sub Category</th>
                      <th>Result</th>
                      <th>Status</th>
                      <th>Balance</th>
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

  <!--Modal Delete Settlement-->
  <div class="modal fade" id="modal-delete-settlement" tabindex="-1" role="dialog" aria-labelledby="modal-delete-settlementLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      {!! Form::open(['url'=>'deleteSettlement', 'method'=>'post']) !!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="modal-delete-settlementLabel">Confirmation</h4>
        </div>
        <div class="modal-body">
          You are going to delete <b id="settlement-code-to-delete"></b>
          <br/>
          <p class="text text-danger">
            <i class="fa fa-info-circle"></i>&nbsp;This process can not be reverted
          </p>
          <input type="hidden" id="settlement_id" name="settlement_id">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-danger">Delete</button>
        </div>
      {!! Form::close() !!}
      </div>
    </div>
  </div>
  <!--ENDModal Delete Settlement-->

@endsection

@section('additional_scripts')
   <script type="text/javascript">
    var tableSettlement =  $('#table-settlement').DataTable({
      processing :true,
      serverSide : true,
      ajax : '{!! route('datatables.getCheckedSettlements') !!}',
      columns :[
        {data: 'rownum', name: 'rownum', searchable:false},
        { data: 'code', name: 'code' },
        { data: 'internal_request', name: 'internal_request.code' },
        { data: 'transaction_date', name: 'transaction_date' },
        { data: 'amount', name: 'amount', className:'dt-body-right' },
        { data: 'category', name: 'category.name' },
        { data: 'sub_category', name: 'sub_category.name' },
        { data: 'result', name: 'result' },
        { data: 'status', name: 'status' },
        { data: 'balance', name: 'balance', searchable:false, orderable:false },
        { data: 'accounted', name: 'accounted'},
        { data: 'actions', name: 'actions', orderable:false, searchable:false, className:'dt-body-center' },
      ],

    });

    // Delete button handler
    tableSettlement.on('click', '.btn-delete-settlement', function(e){
      var id = $(this).attr('data-id');
      var code = $(this).attr('data-text');
      $('#settlement_id').val(id);
      $('#settlement-code-to-delete').text(code);
      $('#modal-delete-settlement').modal('show');
    });

    // Setup - add a text input to each header cell
    $('#searchColumn th').each(function() {
      if ($(this).index() != 0 && $(this).index() != 11) {
        $(this).html('<input class="form-control" type="text" placeholder="Search" data-id="' + $(this).index() + '" />');
      }
          
    });
    //Block search input and select
    $('#searchColumn input').keyup(function() {
      tableSettlement.columns($(this).data('id')).search(this.value).draw();
    });
    //ENDBlock search input and select
    
  </script>
@endsection