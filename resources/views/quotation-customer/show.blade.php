@extends('layouts.app')

@section('page_title')
  {{ $quotation_customer->code }}
@endsection

@section('page_header')
  <h1>
    Quotation Customer Detail
    <small>Detail of {{ $quotation_customer->code }}</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('quotation-customer') }}"><i class="fa fa-legal"></i> Quotation Customer</a></li>
    <li class="active"><i></i> {{ $quotation_customer->code }}</li>
  </ol>
@endsection

@section('content')
  <div class="row">
    <div class="col-lg-7">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-archive"></i>&nbsp;Quotation Customer</h3>
          <a href="{{ URL::to('quotation-customer/'.$quotation_customer->id.'/edit')}}" class="btn btn-xs btn-success pull-right" title="Edit Quotation">
            <i class="fa fa-edit"></i>&nbsp;Edit
          </a>
        </div><!-- /.box-header -->
        <div class="box-body">
          <div class="table-responsive">
            <table class="table">
              <tr>
                <td style="width: 20%;">Quotation Code</td>
                <td style="width: 1%;">:</td>
                <td>{{ $quotation_customer->code }}</td>
              </tr>
              <tr>
                <td style="width: 20%;">Customer</td>
                <td style="width: 1%;">:</td>
                <td>{{ $quotation_customer->customer->name }}</td>
              </tr>
              <tr>
                <td style="width: 20%;">Sales</td>
                <td style="width: 1%;">:</td>
                <td>{{ $quotation_customer->sales->name }}</td>
              </tr>
              <tr>
                <td style="width: 20%;">Amount</td>
                <td style="width: 1%;">:</td>
                <td>{{ number_format($quotation_customer->amount, 2) }}</td>
              </tr>
              <tr>
                <td style="width: 20%;">Description</td>
                <td style="width: 1%;">:</td>
                <td>{!! nl2br($quotation_customer->description) !!}</td>
              </tr>
              <tr>
                <td style="width: 20%;">Created Date</td>
                <td style="width: 1%;">:</td>
                <td>{{ jakarta_date_time($quotation_customer->created_at) }}</td>
              </tr>
              <tr>
                <td style="width: 20%;">Status</td>
                <td style="width: 1%;">:</td>
                <td>
                  @if($quotation_customer->status == 'pending')
                    Pending
                    <span>
                      <a href="#" id="btn-set-submitted" data-id="{{ $quotation_customer->id }}" data-text="{{ $quotation_customer->code }}" class="btn btn-link">
                        <i class="fa fa-check-circle"></i>&nbsp;Mark as Submitted
                      </a>
                    </span>
                  @else
                    {{ $quotation_customer->status }}
                  @endif
                </td>
              </tr>
              <tr>
                <td style="width: 20%;">Submitted Date</td>
                <td style="width: 1%;">:</td>
                <td>{{ $quotation_customer->submitted_date }}</td>
              </tr>
            </table>
          </div>
        </div><!-- /.box-body -->
        <div class="box-footer clearfix">
          
        </div>
      </div><!-- /.box -->
    </div>


    <div class="col-md-5">
      <!--BOX File Information-->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-file"></i>&nbsp;File</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          @if($quotation_customer->file != NULL)
          <table class="table table-resposinve">
            <tr>
              <td style="width: 90%;">
                <a href="{{ url('quotation-customer/file/?file_name='.$quotation_customer->file) }}">
                  {{ $quotation_customer->file }}
                </a>
              </td>
              <td>
                <a href="{{ url('quotation-customer/file/delete/?id='.$quotation_customer->id.'') }}" class="btn btn-xs btn-danger">
                  <i class="fa fa-trash"></i>
                </a>
              </td>            
            </tr>
          </table>
          @else
            {!! Form::open(['url'=>'quotation-customer/file/upload','role'=>'form','class'=>'form-horizontal','id'=>'form-upload-quotation-customer-file','files'=>true]) !!}
              <div class="form-group{{ $errors->has('file') ? ' has-error' : '' }}">
                <div class="col-sm-10">
                  {!! Form::file('file') !!}
                  @if ($errors->has('file'))
                    <span class="help-block">
                      <strong>{{ $errors->first('file') }}</strong>
                    </span>
                  @endif
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-10">
                  {!! Form::hidden('id', $quotation_customer->id) !!}
                  <button type="submit" class="btn btn-info" id="btn-submit-quotation-customer-file">
                    <i class="fa fa-upload"></i>&nbsp;Upload
                  </button>
                </div>
              </div>
            {!! Form::close() !!}
          @endif
        </div><!-- /.box-body -->
        <div class="box-footer clearfix">
          
        </div>
      </div><!-- /.box -->
      <!--ENDBOX File Information-->

      <!--BOX PO Customer Information-->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-bookmark-o"></i>&nbsp;Purchase Order Customer</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          @if($quotation_customer->po_customer)
          <table class="table table-resposinve">          
            <tr>
              <td style="width: 80%;">
                PO Number
              </td>
              <td>
                <a href="{{ url('purchase-order-customer/'.$quotation_customer->po_customer->id) }}" class="btn btn-xs btn-link">
                  {{ $quotation_customer->po_customer->code }}
                </a>
              </td>            
            </tr>
            <tr>
              <td style="width: 80%;">
                PO Amount
              </td>
              <td>
                {{ number_format($quotation_customer->po_customer->amount) }}
              </td>            
            </tr>
          </table>
          @else
            <p class="alert alert-info"><i class="fa fa-info-circle"></i>&nbsp;This quotation doesn't related to any Purchase Order Customer</p>
          @endif
        </div>
      </div>
      <!--ENDBOX PO Customer Information-->

      <!--BOX Project Information-->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-legal"></i>&nbsp;Project</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          @if($quotation_customer->po_customer)
            @if($quotation_customer->po_customer->project)
              <table class="table table-resposinve">          
                <tr>
                  <td style="width: 80%;">
                    Project Number
                  </td>
                  <td>
                    <a href="{{ url('project/'.$quotation_customer->po_customer->project->id) }}" class="btn btn-xs btn-link">
                      {{ $quotation_customer->po_customer->project->code }}
                    </a>
                  </td>            
                </tr>
              </table>
            @else
              <p class="alert alert-info"><i class="fa fa-info-circle"></i>&nbsp;This quotation doesn't related to any project</p>
            @endif
          @else
            <p class="alert alert-info"><i class="fa fa-info-circle"></i>&nbsp;This quotation doesn't related to any project</p>
          @endif
          
        </div>
      </div>
      <!--ENDBOX Project Information-->
    </div>
  </div>


  <!--Modal SET SUBMITTED Quotation Customer-->
  <div class="modal fade" id="modal-set-submitted-quotation-customer" tabindex="-1" role="dialog" aria-labelledby="modal-set-submitted-quotation-customerLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      {!! Form::open(['url'=>'setSubmittedQuotationCustomer', 'method'=>'post']) !!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="modal-set-submitted-quotation-customerLabel">Confirmation</h4>
        </div>
        <div class="modal-body">
          Quotation Customer <b id="quotation-customer-code-to-set-submitted"></b> is gonna be marked as "submitted"
          <br/>
          <p class="text text-danger">
            <i class="fa fa-info-circle"></i>&nbsp;This process can not be reverted
          </p>
          <input type="hidden" id="quotation_customer_id" name="quotation_customer_id">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      {!! Form::close() !!}
      </div>
    </div>
  </div>
<!--ENDModal SET SUBMITTED Quotation Customer-->

  
@endsection

@section('additional_scripts')
  <script type="text/javascript">
    $('#btn-set-submitted').on('click', function(event){
      event.preventDefault();
      $('#quotation-customer-code-to-set-submitted').text($(this).attr('data-text'));
      $('#quotation_customer_id').val($(this).attr('data-id'));
      $('#modal-set-submitted-quotation-customer').modal('show');
    });
  </script>
@endsection