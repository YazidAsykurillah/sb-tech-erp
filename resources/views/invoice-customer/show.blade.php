@extends('layouts.app')

@section('page_title')
    Invoice Customer
@endsection

@section('page_header')
  <h1>
    Invoice Customer
    <small>Detail Invoice Customer</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('invoice-customer') }}"><i class="fa fa-credit-card"></i> Invoice Customer</a></li>
    <li><i></i> {{ $invoice_customer->code }}</li>
    <li class="active"><i></i> Detail</li>
  </ol>
@endsection
  
@section('content')
  <div class="row">
    <div class="col-md-9">
      <!--BOX Basic Informations-->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-credit-card"></i>&nbsp;Invoice Customer Information</h3>
          <span class="pull-right">
            
            <a href="{{ URL::to('invoice-customer/'.$invoice_customer->id.'/edit')}}" class="btn btn-success btn-xs" title="Edit">
              <i class="fa fa-edit"></i>&nbsp;Edit
            </a>
            
            <a href="{{ URL::to('invoice-customer/'.$invoice_customer->id.'/print_pdf')}}" class="btn btn-default btn-xs" title="Print PDF">
              <i class="fa fa-print"></i>&nbsp;Print
            </a>
          </span>
          
        </div><!-- /.box-header -->
        <div class="box-body">
          <div class="table-responsive">
            <table class="table">

              <tr>
                <td style="width: 20%;">Invoice Customer Number</td>
                <td style="width: 1%;">:</td>
                <td>{{ $invoice_customer->code }}</td>
              </tr>
              <tr>
                <td style="width: 20%;">Customer Name</td>
                <td style="width: 1%;">:</td>
                <td>
                  @if($invoice_customer->project)
                    {{ $invoice_customer->project->purchase_order_customer->customer->name }}
                  @endif
                </td>
              </tr>
              
              <tr>
                <td style="width: 20%;">Item(s)</td>
                <td style="width: 1%;">:</td>
                <td>
                  <table class="table">
                    <thead>
                      <tr>
                        <th>Item</th>
                        <th style="width:15%;">Qty</th>
                        <th style="width:15%;">Unit</th>
                        <th style="width:20%;">Price/Unit</th>
                        <th style="width:20%;">Sub Amount</th>
                      </tr>
                    </thead>
                    <tbody>
                      @if(count($items))
                        @foreach($items as $item)
                        <tr>
                          <td>{{ $item->item }}</td>
                          <td>{{ $item->quantity }}</td>
                          <td>{{ $item->unit }}</td>
                          <td>{{ number_format($item->price, 2) }}</td>
                          <td>{{ number_format($item->sub_amount, 2) }}</td>
                        </tr>
                        @endforeach
                      @else
                        <tr>
                          <td colspan="5">There's no item data</td>
                        </tr>
                      @endif
                    </tbody>
                  </table>
                </td>
              </tr>
              <tr>
                <td style="width: 20%;">Discount</td>
                <td style="width: 1%;">:</td>
                <td>{{ $invoice_customer->discount }} %</td>
              </tr>
              <tr>
                <td style="width: 20%;">After Discount</td>
                <td style="width: 1%;">:</td>
                <td>{{ number_format($invoice_customer->after_discount) }}</td>
              </tr>
              <tr>
                <td style="width: 20%;">
                  [DP/Term/Pelunasan]
                  <p><strong>{{ ucwords($invoice_customer->type) }}</strong></p>
                </td>
                <td style="width: 1%;">:</td>
                <td>{{ $invoice_customer->down_payment }} %</td>
              </tr>
              <tr>
                <td style="width: 20%;">[DP/Term/Pelunasan Value]</td>
                <td style="width: 1%;">:</td>
                <td>{{ number_format($invoice_customer->down_payment_value) }}</td>
              </tr>
              <tr>
                <td style="width: 20%;">VAT</td>
                <td style="width: 1%;">:</td>
                <td>{{ $invoice_customer->vat }} %</td>
              </tr>
              <tr>
                <td style="width: 20%;">VAT Value</td>
                <td style="width: 1%;">:</td>
                <td>{{ number_format($invoice_customer->vat_value) }}</td>
              </tr>
              <tr>
                <td style="width: 20%;">WHT</td>
                <td style="width: 1%;">:</td>
                <td>{{ number_format($invoice_customer->wht,2) }}</td>
              </tr>
              <tr>
                <td style="width: 20%;">Amount</td>
                <td style="width: 1%;">:</td>
                <td>{{ number_format($invoice_customer->amount,2) }}</td>
              </tr>
              <tr>
                <td style="width: 20%;">Submitted Date</td>
                <td style="width: 1%;">:</td>
                <td>{{ $invoice_customer->created_at }}</td>
              </tr>
              <tr>
                <td style="width: 20%;">Date</td>
                <td style="width: 1%;">:</td>
                <td>{{ $invoice_customer->posting_date }}</td>
              </tr>
              <tr>
                <td style="width: 20%;">Tax Number</td>
                <td style="width: 1%;">:</td>
                <td>{{ $invoice_customer->tax_number }}</td>
              </tr>
              <tr>
                <td style="width: 20%;">Tax Date</td>
                <td style="width: 1%;">:</td>
                <td>{{ $invoice_customer->tax_date }}</td>
              </tr>      
              <tr>
                <td style="width: 20%;">Due Date</td>
                <td style="width: 1%;">:</td>
                <td>{{ $invoice_customer->due_date }}</td>
              </tr>
              <tr>
                <td style="width: 20%;">Status</td>
                <td style="width: 1%;">:</td>
                <td>
                  @if($invoice_customer->status != 'paid')
                    Pending
                    <span>
                      <a href="#" id="btn-set-paid" data-id="{{ $invoice_customer->id }}" data-text="{{ $invoice_customer->code }}" class="btn btn-link">
                        <i class="fa fa-check-circle"></i>&nbsp;Mark as Paid
                      </a>
                    </span>
                  @else
                    Paid
                  @endif

                </td>
              </tr>
              <tr>
                <td style="width: 20%;">Description</td>
                <td style="width: 1%;">:</td>
                <td>{!! nl2br($invoice_customer->description) !!}</td>
              </tr>
              <tr>
                <td style="width: 20%;">Prepared By</td>
                <td style="width: 1%;">:</td>
                <td>
                  @if($invoice_customer->preparator)
                    {{ $invoice_customer->preparator->name }}
                  @endif
                </td>
              </tr>
              <tr>
                <td style="width: 20%;">File</td>
                <td style="width: 1%;">:</td>
                <td>
                  @if($invoice_customer->file != NULL)
                    <a href="{{ url('invoice-customer/file/?file_name='.$invoice_customer->file) }}">
                      {{ $invoice_customer->file }}
                    </a>
                  @else
                    -
                  @endif
                </td>
              </tr>

            </table>
          </div>
          
        </div><!-- /.box-body -->
      </div>
      <!--ENDBOX Basic Informations-->
    </div>

    <div class="col-md-3">
      <!--BOX Project Information-->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-legal"></i>&nbsp;Project Information</h3>
          
        </div><!-- /.box-header -->
        <div class="box-body">
          <strong>Project Number</strong>
          <p class="text-muted">
            @if($invoice_customer->project)
            <a href="{{ url('project/'.$invoice_customer->project->id.'') }}" title="Click to view the project detail" >
              {{ $invoice_customer->project->code }}              
            </a>
            @endif
          </p>
          <strong>Project Name</strong>
          <p class="text-muted">
            @if($invoice_customer->project)
              {{ $invoice_customer->project->name }}
            @endif
        </p>
        </div><!-- /.box-body -->
      </div>
      <!--ENDBOX Project Information-->

      <!--BOX PO Customer Information-->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-bookmark-o"></i>&nbsp;PO Customer Information</h3>
          
        </div><!-- /.box-header -->
        <div class="box-body">
          <strong>PO Customer Number</strong>
          <p class="text-muted">
            @if($invoice_customer->project)
            {{ $invoice_customer->project->purchase_order_customer->code }}
            @endif
          </p>
          <strong>Description</strong>
          <p class="text-muted">
            @if($invoice_customer->project)
              {{ nl2br($invoice_customer->project->purchase_order_customer->description) }}
            @endif
          </p>
          <strong>Amount</strong>
          <p class="text-muted">
            @if($invoice_customer->project)
              {{ number_format($invoice_customer->project->purchase_order_customer->amount) }}
            @endif
          </p>
        </div><!-- /.box-body -->
      </div>
      <!--ENDBOX PO Customer Information-->
    </div>
  </div>


  <!--Modal SET PAID Invoice Customer-->
  <div class="modal fade" id="modal-set-paid-invoice-customer" tabindex="-1" role="dialog" aria-labelledby="modal-set-paid-invoice-customerLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      {!! Form::open(['url'=>'setPaidInvoiceCustomer', 'class'=>'form-horizontal', 'role'=>'form', 'method'=>'post', 'id'=>'form-submit-paid-invoice-customer' ]) !!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="modal-set-paid-invoice-customerLabel">Confirmation</h4>
        </div>
        <div class="modal-body">
          Invoice <b id="invoice-customer-code-to-set-paid"></b> is gonna be marked as "PAID"
          <br/>
          <div class="form-group{{ $errors->has('cash_id') ? ' has-error' : '' }}">
            {!! Form::label('cash_id', 'Bank Penerima', ['class'=>'col-sm-4 control-label']) !!}
            <div class="col-sm-8">
              {!! Form::select('cash_id', $cash_opts, null, ['class'=>'form-control', 'placeholder'=>'Select Bank', 'id'=>'cash_id', 'required'=>true]) !!}
              @if ($errors->has('cash_id'))
                <span class="help-block">
                  <strong>{{ $errors->first('cash_id') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <p class="text text-danger">
            <i class="fa fa-info-circle"></i>&nbsp;This process can not be reverted
          </p>
          <input type="hidden" id="invoice_customer_id" name="invoice_customer_id">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" id="btn-submit-paid-invoice-customer" class="btn btn-primary">Set Paid</button>
        </div>
      {!! Form::close() !!}
      </div>
    </div>
  </div>
<!--ENDModal SET PAID Invoice Customer-->
@endsection

@section('additional_scripts')
  <script type="text/javascript">
    $('#btn-set-paid').on('click', function(event){
      event.preventDefault();
      $('#invoice-customer-code-to-set-paid').text($(this).attr('data-text'));
      $('#invoice_customer_id').val($(this).attr('data-id'));
      $('#modal-set-paid-invoice-customer').modal('show');
    });

    //Form submit paid invoice customer event handling
    $('#form-submit-paid-invoice-customer').on('submit', function(){
      $('#btn-submit-paid-invoice-customer').prop('disabled', true);
    });
  </script>
@endsection