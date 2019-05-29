@extends('layouts.app')

@section('page_title')
  ETS
@endsection

@section('page_header')
  <h1>
    ETS
    <small>Daftar ETS</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li class="active"><i></i>ETS</li>
  </ol>
@endsection

@section('content')
  <div class="row">
    <div class="col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">ETS</h3>
              <a href="{{ URL::to('ets/create')}}" class="btn btn-primary pull-right" title="Create new Category">
                <i class="fa fa-plus"></i>&nbsp;Add New
              </a>
            </div><!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="table-ets">
                  <thead>
                    <tr>
                      <th style="width:40%;">Period</th>
                      <th>User</th>
                      <th style="width:10%;text-align:center;">Actions</th>
                    </tr>
                  </thead>
                  <thead id="searchColumn">
                    <tr>
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
    var tableAssetCategory =  $('#table-ets').DataTable({
      processing :true,
      serverSide : true,
      ajax : '{!! url('ets/site/dataTables') !!}',
      columns :[
        { data: 'the_period', name: 'the_period'},
        { data: 'user_name', name: 'user_name' },
        { data: 'actions', name: 'actions', orderable:false, searchable:false, className:'dt-body-center' },
      ],

    });

    

    // Setup - add a text input to each header cell
    $('#searchColumn th').each(function() {
      if ($(this).index() != 2 ) {
        $(this).html('<input class="form-control" type="text" placeholder="Search" data-id="' + $(this).index() + '" />');
      }
          
    });
    //Block search input and select
    $('#searchColumn input').keyup(function() {
      tableAssetCategory.columns($(this).data('id')).search(this.value).draw();
    });
    //ENDBlock search input and select
    
  </script>
@endsection