@extends('layouts.app')

@section('page_title')
    Category
@endsection

@section('page_header')
  <h1>
    Category
    <small>Daftar Category</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="#"><i class="fa fa-database"></i> Master Data</a></li>
    <li class="active"><i></i> Category</li>
  </ol>
@endsection

@section('content')
  <div class="row">
    <div class="col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Category</h3>
              <a href="{{ URL::to('master-data/category/create')}}" class="btn btn-primary pull-right" title="Create new Category">
                <i class="fa fa-plus"></i>&nbsp;Add New
              </a>
            </div><!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="table-category">
                  <thead>
                    <tr>
                      <th style="width:5%;">#</th>
                      <th style="width:40%;">Name</th>
                      <th>Description</th>
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

  <!--Modal Delete Category-->
  <div class="modal fade" id="modal-delete-category" tabindex="-1" role="dialog" aria-labelledby="modal-delete-categoryLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      {!! Form::open(['url'=>'deleteCategory', 'method'=>'post']) !!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="modal-delete-categoryLabel">Confirmation</h4>
        </div>
        <div class="modal-body">
          You are going to delete <b id="category-name-to-delete"></b>
          <br/>
          <p class="text text-danger">
            <i class="fa fa-info-circle"></i>&nbsp;This process can not be reverted
          </p>
          <input type="text" id="category_id" name="category_id">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-danger">Delete</button>
        </div>
      {!! Form::close() !!}
      </div>
    </div>
  </div>
<!--ENDModal Delete Category-->

  
@endsection

@section('additional_scripts')
  <script type="text/javascript">
    var tableCategory =  $('#table-category').DataTable({
      processing :true,
      serverSide : true,
      ajax : '{!! route('datatables.getCategories') !!}',
      columns :[
        {data: 'rownum', name: 'rownum', searchable:false},
        { data: 'name', name: 'name' },
        { data: 'description', name: 'description' },
        { data: 'actions', name: 'actions', orderable:false, searchable:false, className:'dt-body-center' },
      ],

    });

    // Delete button handler
    tableCategory.on('click', '.btn-delete-category', function(e){
      var id = $(this).attr('data-id');
      var name = $(this).attr('data-text');
      $('#category_id').val(id);
      $('#category-name-to-delete').text(name);
      $('#modal-delete-category').modal('show');
    });

    // Setup - add a text input to each header cell
    $('#searchColumn th').each(function() {
      if ($(this).index() != 0 && $(this).index() != 3) {
        $(this).html('<input class="form-control" type="text" placeholder="Search" data-id="' + $(this).index() + '" />');
      }
          
    });
    //Block search input and select
    $('#searchColumn input').keyup(function() {
      tableCategory.columns($(this).data('id')).search(this.value).draw();
    });
    //ENDBlock search input and select
    
  </script>
@endsection