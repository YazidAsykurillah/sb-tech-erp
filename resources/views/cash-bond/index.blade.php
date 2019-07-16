@extends('layouts.app')

@section('page_title')
    Cash Bond
@endsection

@section('page_header')
  <h1>
    Cash Bond
    <small>Daftar Cash Bond</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('cash-bond') }}"><i class="fa fa-money"></i> Cash Bond</a></li>
    <li class="active"><i></i> Index</li>
  </ol>
@endsection
  
@section('content')
  <div class="row">
    <div class="col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Cash Bond</h3>
              <div class="pull-right">
                <a href="{{ URL::to('cash-bond/create')}}" class="btn btn-primary btn-xs" title="Create new Cash Bond">
                  <i class="fa fa-plus"></i>&nbsp;Add New
                </a>
                @if(\Auth::user()->can('approve-cashbond'))
                <button type="button" class="btn btn-warning btn-xs" id="btn-approve">
                  <i class="fa fa-check-circle"></i> Approve
                </button>  
                @endif
                @if(\Auth::user()->can('set-cashbond-payment-status-to-paid'))
                <button type="button" class="btn btn-success btn-xs" id="btn-set-cashbond-payment-status-to-paid">
                  <i class="fa fa-check"></i> Set as Paid
                </button>  
                @endif
                
              </div>
              
            </div><!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="table-cash-bond">
                  <thead>
                    <tr>
                      <th style="width:5%;">#</th>
                      <th style="width:20%;">Code</th>
                      <th>Member</th>
                      <th>Amount</th>
                      <th>Description</th>
                      <th>Created Date</th>
                      <th>Status</th>
                      <th>Transaction Date</th>
                      <th>Accounted</th>
                      <th>Potong Gaji</th>
                      <th>Term (Bulan)</th>
                      <th>Payment Status</th>
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
                      <th style="text-align:right;"></th>
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
                  </tfoot>
              </table>
            </div>
          </div><!-- /.box-body -->
          <div class="box-footer clearfix">
            
          </div>
        </div><!-- /.box -->
    </div>
  </div>

  <!--Modal Delete Invoice Customer-->
  <div class="modal fade" id="modal-delete-cash-bond" tabindex="-1" role="dialog" aria-labelledby="modal-delete-cash-bondLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      {!! Form::open(['url'=>'deleteCashbond', 'method'=>'post']) !!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="modal-delete-PettyCashLabel">Confirmation</h4>
        </div>
        <div class="modal-body">
          You are going to delete <b id="cash-bond-code-to-delete"></b>
          <br/>
          <p class="text text-danger">
            <i class="fa fa-info-circle"></i>&nbsp;This process can not be reverted
          </p>
          <input type="hidden" id="cashbond_id" name="cashbond_id">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-danger">Delete</button>
        </div>
      {!! Form::close() !!}
      </div>
    </div>
  </div>
<!--ENDModal Delete Invoice Customer-->

<!--Modal Set Cashbond Payment status to paid-->
  <div class="modal fade" id="modal-set-cashbond-payment-status-to-paid" tabindex="-1" role="dialog" aria-labelledby="modal-set-cashbond-payment-status-to-paidLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      {!! Form::open(['url'=>'cashbond/setPaymentStatusPaid', 'id'=> 'form-set-paid', 'method'=>'post']) !!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="modal-set-cashbond-payment-status-to-paidLabel">Confirmation</h4>
        </div>
        <div class="modal-body">
          <p class="text text-danger">
            <span id="selected_cashbond_counter"></span> Cashbond(s) will be paid
          </p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-info">Submit</button>
        </div>
      {!! Form::close() !!}
      </div>
    </div>
  </div>
<!--ENDModal Set Cashbond Payment status to paid-->

<!--Modal Approve Cashbond-->
  <div class="modal fade" id="modal-approve-cashbond" tabindex="-1" role="dialog" aria-labelledby="modal-approve-cashbondLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      {!! Form::open(['url'=>'cashbond/approve', 'id'=> 'form-approve-cashbond', 'method'=>'post']) !!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="modal-approve-cashbondLabel">Confirmation</h4>
        </div>
        <div class="modal-body">
          <p class="text text-danger">
            <span id="approve_cashbond_counter"></span> Cashbond(s) will be approved
          </p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-info">Submit</button>
        </div>
      {!! Form::close() !!}
      </div>
    </div>
  </div>
<!--ENDModal Approve Cashbond-->
@endsection

@section('additional_scripts')
   <script type="text/javascript">
    var tableCashBond =  $('#table-cash-bond').DataTable({
      processing :true,
      serverSide : true,
      ajax : '{!! url('cash-bond/dataTables') !!}',
      columns :[
        {data: 'rownum', name: 'rownum', searchable:false},
        { data: 'code', name: 'code' },
        { data: 'user', name: 'user.name' },
        { data: 'amount', name: 'amount', className:'dt-body-right' },
        { data: 'description', name: 'description' },
        { data: 'created_at', name: 'created_at' },
        { data: 'status', name: 'status' },
        { data: 'transaction_date', name: 'transaction_date' },
        { data: 'accounted', name: 'accounted' },
        { data: 'cut_from_salary', name: 'cut_from_salary' },
        { data: 'term', name: 'term' },
        { data: 'payment_status', name: 'payment_status' },
        { data: 'actions', name: 'actions', orderable:false, searchable:false, className:'dt-body-center' },
      ],
      footerCallback: function( tfoot, data, start, end, display ) {
        var api = this.api();
        // Remove the formatting to get float data for summation
        var theFloat = function ( i ) {
            return typeof i === 'string' ?
                parseFloat(i.replace(/[\$,]/g, '')) :
                typeof i === 'number' ?
                    i : 0;
        };

        // Total over all pages
        total = api
            .column(3)
            .data()
            .reduce( function (a, b) {
                return theFloat(a) + theFloat(b);
            }, 0 );
        // Update footer
        $( api.column(3).footer() ).html(
            total.toLocaleString()
        );
      },
      order : [
        [1, 'desc']
      ]

    });

    // Delete button handler
    tableCashBond.on('click', '.btn-delete-cash-bond', function(e){
      var id = $(this).attr('data-id');
      var code = $(this).attr('data-text');
      $('#cashbond_id').val(id);
      $('#cash-bond-code-to-delete').text(code);
      $('#modal-delete-cash-bond').modal('show');
    });

    // Setup - add a text input to each header cell
    $('#searchColumn th').each(function() {
      if ($(this).index() != 0 && $(this).index() != 12) {
        $(this).html('<input class="form-control" type="text" placeholder="Search" data-id="' + $(this).index() + '" />');
      }
          
    });
    //Block search input and select
    $('#searchColumn input').keyup(function() {
      tableCashBond.columns($(this).data('id')).search(this.value).draw();
    });
    //ENDBlock search input and select
    
    //Cashbond row selection handler
    var selectedCashbond = [];
    tableCashBond.on( 'click', 'tr', function () {
      $(this).toggleClass('selected');
    });
    //ENDPurchase request row selection handler
    //BlockSet Payment Status Handler
    $('#btn-set-cashbond-payment-status-to-paid').on('click', function(event){
      event.preventDefault();
      selectedCashbond = [];
      var selected_cashbond_id = tableCashBond.rows('.selected').data();
      $.each( selected_cashbond_id, function( key, value ) {
        selectedCashbond.push(selected_cashbond_id[key].id);
      });
      if(selectedCashbond.length == 0){
        alert('There are no selected row');
      }else{
        $('#form-set-paid').find('.id_to_set_paid').remove();
        $('#selected_cashbond_counter').html(selectedCashbond.length);
        $.each( selectedCashbond, function( key, value ) {
          $('#form-set-paid').append('<input type="hidden" class="id_to_set_paid" name="id_to_set_paid[]" value="'+value+'"/>');
        });
        $('#modal-set-cashbond-payment-status-to-paid').modal('show');  
      }
      
    });
    //ENDBlock Set Payment Status Handler

    //Block Approve Cashbond
    $('#btn-approve').on('click', function(event){
      event.preventDefault();
      selectedCashbond = [];
      var selected_cashbond_id = tableCashBond.rows('.selected').data();
      $.each( selected_cashbond_id, function( key, value ) {
        selectedCashbond.push(selected_cashbond_id[key].id);
      });
      if(selectedCashbond.length == 0){
        alert('There are no selected row');
      }else{
        $('#form-approve-cashbond').find('.id_to_approve').remove();
        $('#selected_cashbond_counter').html(selectedCashbond.length);
        $.each( selectedCashbond, function( key, value ) {
          $('#form-approve-cashbond').append('<input type="hidden" class="id_to_approve" name="id_to_approve[]" value="'+value+'"/>');
        });
        $('#modal-approve-cashbond').modal('show');  
      }
      
    });
    //ENDBlock Approve Cashbond
  </script>
@endsection