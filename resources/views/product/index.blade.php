@extends('layouts.app')

@section('page_title')
    Product
@endsection

@section('page_header')
  <h1>
    Product
    <small>Daftar Product</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('product') }}"><i class="fa fa-cube"></i> Product</a></li>
    <li class="active"><i></i> Index</li>
  </ol>
@endsection

@section('content')
  <div class="row">
    <div class="col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Daftar Product</h3>
              <div class="pull-right">
                <a href="javascript::void()" class="btn btn-xs btn-success" title="Import" id="btn-import-excel">
                  <i class="fa fa-upload"></i>&nbsp;Import
                </a>
                <a href="{{ URL::to('product/create')}}" class="btn btn-xs btn-primary" title="Create new Product">
                  <i class="fa fa-plus"></i>&nbsp;Add New
                </a>

              </div>
              
            </div><!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table class="table" id="table-product">
                  <thead>
                    <tr>
                      <th style="width:5%;">#</th>
                      <th style="width:10%;">Code</th>
                      <th style="width:10%">Product Category</th>
                      <th style="">Name</th>
                      <th style="width:10%">Unit</th>
                      <th style="width:10%">Price</th>
                      <th style="width:10%">Part Number</th>
                      <th style="width:10%">Brand</th>
                      <th style="width:5%">Stock</th>
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
                    </tr>
              </table>
            </div>
          </div><!-- /.box-body -->
          <div class="box-footer clearfix">
            
          </div>
        </div><!-- /.box -->
    </div>
  </div>

  <!--Modal Import Excel-->
  <div class="modal fade" id="modal-import-excel" tabindex="-1" role="dialog" aria-labelledby="modal-import-excelLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      {!! Form::open(['url'=>'product/import-excel', 'method'=>'post', 'id'=>'form-import-file', 'files'=>true]) !!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="modal-import-excelLabel">Import product from excel file</h4>
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
@endsection

@section('additional_scripts')
 <script type="text/javascript">
    var tableProduct =  $('#table-product').DataTable({
      processing :true,
      serverSide : true,
      ajax : '{!! url('product/dataTables') !!}',
      columns :[
        {data: 'rownum', name: 'rownum', searchable:false},
        { data: 'code', name: 'code' },
        { data: 'product_category', name: 'product_category.name'},
        { data: 'name', name: 'name' },
        { data: 'unit', name: 'unit' },
        { data: 'price', name: 'price' },
        { data: 'part_number', name: 'part_number' },
        { data: 'brand', name: 'brand' },
        { data: 'stock', name: 'stock' },
        { data: 'actions', name: 'actions', orderable:false, searchable:false, className:'dt-body-center' },
      ],

    });

    // Delete button handler
    tableProduct.on('click', '.btn-delete-product', function(e){
      var id = $(this).attr('data-id');
      var name = $(this).attr('data-text');
      $('#product_id').val(id);
      $('#product-name-to-delete').text(name);
      $('#modal-delete-product').modal('show');
    });

    // Setup - add a text input to each header cell
    $('#searchColumn th').each(function() {
      if ($(this).index() != 0 && $(this).index() != 9) {
        $(this).html('<input class="form-control" type="text" placeholder="Search" data-id="' + $(this).index() + '" />');
      }
          
    });
    //Block search input and select
    $('#searchColumn input').keyup(function() {
      tableProduct.columns($(this).data('id')).search(this.value).draw();
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
  </script>
@endsection