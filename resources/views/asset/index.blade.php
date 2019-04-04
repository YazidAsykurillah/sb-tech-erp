@extends('layouts.app')

@section('page_title')
    Asset
@endsection

@section('page_header')
  <h1>
    Asset
    <small>Daftar Asset</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="#"><i class="fa fa-database"></i> Master Data</a></li>
    <li class="active"><i></i> Asset</li>
  </ol>
@endsection

@section('content')
  <div class="row">
    <div class="col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Asset</h3>
              <a href="{{ URL::to('master-data/asset/create')}}" class="btn btn-primary pull-right" title="Create new Category">
                <i class="fa fa-plus"></i>&nbsp;Add New
              </a>
            </div><!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="table-asset">
                  <thead>
                    <tr>
                      <th style="width:5%;">#</th>
                      <th style="width:15%;">Code</th>
                      <th style="width:15%;">Asset Category</th>
                      <th style="width:15%;">Asset Type</th>
                      <th style="width:15%;">Name</th>
                      <th style="width:15%;">Price</th>
                      <th style="width:10%;">Description</th>
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

  <!--Modal Delete Asset-->
  <div class="modal fade" id="modal-delete-asset" tabindex="-1" role="dialog" aria-labelledby="modal-delete-assetLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      {!! Form::open(['url'=>'deleteAsset', 'method'=>'post']) !!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="modal-delete-assetLabel">Confirmation</h4>
        </div>
        <div class="modal-body">
          You are going to delete <b id="asset-name-to-delete"></b>
          <br/>
          <p class="text text-danger">
            <i class="fa fa-info-circle"></i>&nbsp;This process can not be reverted
          </p>
          <input type="text" id="asset_id" name="asset_id">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-danger">Delete</button>
        </div>
      {!! Form::close() !!}
      </div>
    </div>
  </div>
<!--ENDModal Delete Asset-->

  
@endsection

@section('additional_scripts')
  <script type="text/javascript">
    var tableAsset =  $('#table-asset').DataTable({
      processing :true,
      serverSide : true,
      ajax : '{!! route('datatables.getAssets') !!}',
      columns :[
        {data: 'rownum', name: 'rownum', searchable:false},
        { data: 'code', name: 'code' },
        { data: 'asset_category', name: 'asset_category.name' },
        { data: 'type', name: 'type' },
        { data: 'name', name: 'name' },
        { data: 'price', name: 'price' },
        { data: 'description', name: 'description' },
        { data: 'actions', name: 'actions', orderable:false, searchable:false, className:'dt-body-center' },
      ],

    });

    // Delete button handler
    tableAsset.on('click', '.btn-delete-asset', function(e){
      var id = $(this).attr('data-id');
      var name = $(this).attr('data-text');
      $('#asset_id').val(id);
      $('#asset-name-to-delete').text(name);
      $('#modal-delete-asset').modal('show');
    });

    // Setup - add a text input to each header cell
    $('#searchColumn th').each(function() {
      if ($(this).index() != 0 && $(this).index() != 5) {
        $(this).html('<input class="form-control" type="text" placeholder="Search" data-id="' + $(this).index() + '" />');
      }
          
    });
    //Block search input and select
    $('#searchColumn input').keyup(function() {
      tableAsset.columns($(this).data('id')).search(this.value).draw();
    });
    //ENDBlock search input and select
    
  </script>
@endsection