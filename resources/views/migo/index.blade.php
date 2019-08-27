@extends('layouts.app')

@section('page_title')
  Migo
@endsection

@section('page_header')
  <h1>
    Migo
    <small>Daftar Migo</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('migo') }}"><i class="fa fa-tag"></i> Migo</a></li>
    <li class="active"><i></i> Index</li>
  </ol>
@endsection

@section('content')
  <div class="row">
    <div class="col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Migo</h3>
              <div class="pull-right"></div>
            </div><!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="table-migo">
                  <thead>
                    <tr>
                      <th style="width:5%;">#</th>
                      <th style="width:10%;">Code</th>
                      <th style="width:20%;">Description</th>
                      <th style="width:10%;">Purchase Request</th>
                      <th style="">Creator</th>
                      <th style="width: 10%;">Created At</th>
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
                    </tr>
                  </tfoot>
              </table>
            </div>
          </div><!-- /.box-body -->
          <div class="box-footer clearfix">
            <div id="button-table-tools" class=""></div>
          </div>
        </div><!-- /.box -->
    </div>
  </div>

  <!--Modal Delete Purchase Order-->
  <div class="modal fade" id="modal-delete-migo" tabindex="-1" role="dialog" aria-labelledby="modal-delete-migoLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      {!! Form::open(['url'=>'deleteMigo', 'method'=>'post']) !!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="modal-delete-migoLabel">Confirmation</h4>
        </div>
        <div class="modal-body">
          You are going to delete <b id="po-customer-code-to-delete"></b>
          <br/>
          <p class="text text-danger">
            <i class="fa fa-info-circle"></i>&nbsp;This process can not be reverted
          </p>
          <input type="hidden" id="migo_id" name="migo_id">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-danger">Delete</button>
        </div>
      {!! Form::close() !!}
      </div>
    </div>
  </div>
<!--ENDModal Delete Purchase Order-->
@endsection

@section('additional_scripts')
  <script type="text/javascript">
    var tableMigo =  $('#table-migo').DataTable({
      lengthMenu: [[10, 25, 100, 500, -1], [10, 25, 100, 500, "All"]],
      processing :true,
      serverSide : true,
      ajax : '{!! url('migo/dataTables') !!}',
      columns :[
        {data: 'rownum', name: 'rownum', searchable:false, orderable:true},
        { data: 'code', name: 'code' },
        { data: 'description', name: 'description' },
        { data: 'purchase_request_code', name: 'purchase_request.code' },
        { data: 'creator_name', name: 'creator.name' },
        { data: 'created_at', name: 'created_at' },
        { data: 'actions', name: 'actions', orderable:false, searchable:false, className:'dt-body-center' },
      ],
      order : [
        [6, 'desc']
      ]

    });

    var buttonTableTools = new $.fn.dataTable.Buttons(tableMigo,{
        buttons: [
          {
            extend: 'excelHtml5',
            exportOptions: {
                columns: [0,1,2,3,4,5,6,7,8,9]
            }
          },
        ],
      }).container().appendTo($('#button-table-tools'));

    // Delete button handler
    tableMigo.on('click', '.btn-delete-migo', function(e){
      var id = $(this).attr('data-id');
      var code = $(this).attr('data-text');
      $('#migo_id').val(id);
      $('#po-customer-code-to-delete').text(code);
      $('#modal-delete-migo').modal('show');
    });

    // Setup - add a text input to each header cell
    $('#searchColumn th').each(function() {
      if ($(this).index() != 0 && $(this).index() != 12) {
        $(this).html('<input class="form-control" type="text" placeholder="Search" data-id="' + $(this).index() + '" />');
      }
          
    });
    //Block search input and select
    $('#searchColumn input').keyup(function() {
      tableMigo.columns($(this).data('id')).search(this.value).draw();
    });
    //ENDBlock search input and select

   
    
  </script>
@endsection