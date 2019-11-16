<!DOCTYPE html>
<html><head>
	<title></title>
	<link rel="stylesheet" href="css/bootstrap/bootstrap.css">
	<style type="text/css">
    	table{
    		font-size: 10px;
    	}
    	#table-items{
    		border-top: 1px solid;
    		border-bottom: 1px solid;
    		border-left: 1px solid;
    		border-right: 1px solid;
    		margin-top: 24px;
    	}

    </style>
</head><body>
	<table style="width:100%;border:0;">
		<tr>
			<td style="width:75%;">
				<img src="img/logo-sbt.jpeg" class="img-circle" width="200px;"/>
				<p>{{ config('app.company_name') }}</p>
				<div>
					{!! nl2br($company_office) !!}
				</div>
			</td>
			<td>
				<p><strong>INVOICE</strong></p>
				<table style="width:100%;">
					<tr>
						<td style="width:40%;">Inovice Number</td>
						<td style="width:1%;">:</td>
						<td>{{ $invoice_customer->code }}</td>
					</tr>
					<tr>
						<td style="width:40%;">Date</td>
						<td style="width:1%;">:</td>
						<td>{{ $invoice_customer->posting_date }}</td>
					</tr>
					<tr>
						<td style="width:40%;">Due Date</td>
						<td style="width:1%;">:</td>
						<td>{{ $invoice_customer->due_date }}</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td style="width:75%;">
				<p>&nbsp;</p>
				<p><strong>Invoice For:</strong></p>
				<p>{{ $invoice_customer->project->purchase_order_customer->customer->name }}</p>
				<div>
					{!! nl2br($invoice_customer->project->purchase_order_customer->customer->address) !!}
				</div>
			</td>
			<td>
				<p><strong>Quotation Number : {{ $invoice_customer->project->purchase_order_customer->quotation_customer->code }}</strong></p>
				<p><strong>PO Number : {{ $invoice_customer->project->purchase_order_customer->code }}</strong></p>
				
			</td>
		</tr>
	</table>
	
	<table class="table" id="table-items">
		<thead>
			<tr style="background:orange;">
				<th style="width:5%;text-align:center;">NO</th>
				<th>Description</th>
				<th>Qty</th>
				<th style="text-align:right;">Unit Price</th>
				<th style="text-align:right;">Price</th>
			</tr>
		</thead>
		<tbody>
			@if(count($item_invoice_customer))
				<?php $counter = 0; ?>
				@foreach($item_invoice_customer as $item)
				<?php $counter++; ?>
				<tr>
					<td>{{ $counter }}</td>
					<td>{{ $item->item }}</td>
					<td>{{ $item->quantity }}&nbsp;{{ $item->unit }}</td>
					<td style="text-align:right;">&nbsp;{{ number_format($item->price) }}</td>
					<td style="text-align:right;">&nbsp;{{ number_format($item->sub_amount) }}</td>
				</tr>
				@endforeach
				<tr>
					<td colspan="3" style="text-align:right;border-top:1px solid;">Sub Total</td>
					<td style="width:5%;border-top:1px solid;">&nbsp;:</td>
					<td style="text-align:right;border-top:1px solid;">Rp&nbsp;{{ number_format($invoice_customer->sub_amount) }}</td>
				</tr>
				<tr>
					<td colspan="3" style="text-align:right;border:0;">Discount {{ $invoice_customer->discount}}&nbsp;%</td>
					<td style="width:5%;">&nbsp;:</td>
					<td style="text-align:right;">{{ number_format($invoice_customer->discount_value) }}</td>
				</tr>
				<tr>
					<td colspan="3" style="text-align:right;border:0;">After Discount</td>
					<td style="width:5%;">&nbsp;:</td>
					<td style="text-align:right;">Rp&nbsp;{{ number_format($invoice_customer->after_discount) }}</td>
				</tr>
				<tr>
					<td colspan="3" style="text-align:right;border:0;"> {{ ucwords($invoice_customer->type) }} {{ $invoice_customer->down_payment}}&nbsp;%</td>
					<td style="width:5%;">&nbsp;:</td>
					<td style="text-align:right;">{{ number_format($invoice_customer->down_payment_value) }}</td>
				</tr>
				<tr>
					<td colspan="3" style="text-align:right;border:0;">VAT&nbsp;{{ $invoice_customer->vat }}&nbsp;%</td>
					<td style="width:5%;">&nbsp;:</td>
					<td style="text-align:right;">Rp&nbsp;{{ number_format($invoice_customer->vat_value) }}</td>
				</tr>
				<tr>
					<td colspan="3" style="text-align:right;border:0;">WHT</td>
					<td style="width:5%;">&nbsp;:</td>
					<td style="text-align:right;">Rp&nbsp;{{ number_format($invoice_customer->wht,2) }}</td>
				</tr>
				<tr>
					<td colspan="3" style="text-align:right;border:0;">Total</td>
					<td style="width:5%;">&nbsp;:</td>
					<td style="text-align:right;">Rp&nbsp;{{ number_format($invoice_customer->amount) }}</td>
				</tr>
			@else
			<tr>
				<td colspan="5">There's no data</td>
			</tr>
			@endif
		</tbody>
	</table>

	<table class="table">
		<tr>
			<td>
				<p>Please transfer to our account:</p>
				<div>
					{!! nl2br($company_bank_account) !!}
				</div>
			</td>
		</tr>
	</table>
</body></html>