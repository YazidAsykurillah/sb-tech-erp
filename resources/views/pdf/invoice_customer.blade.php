<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>INVOICE</title>

    <!-- Bootstrap Core CSS -->
    
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
</head>

<body>
	<table style="width:100%;border:0;">
		<tr>
			<td style="width:75%;">
				<img src="img/bmkn-logo.jpeg" class="img-circle" width="200px;"/>
				<p>{{ config('app.company_name') }}</p>
				<p>Ruko Grand Galaxy City, RSN 3 No. 50</p>
				<p>Kecamatan Bekasi Selatan</p>
				<p>Kelurahan Jaka Setia</p>
				<p>Phone (021-82732142)</p>
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
			<td style="width:20%;text-align:left;">
				Prepared By
				@if($invoice_customer->preparator)
				<p>&nbsp;</p>
				<p>&nbsp;</p>
				<p><strong>{{ $invoice_customer->preparator->name }}</strong></p>
				<p><strong>({{ $invoice_customer->preparator->position }})</strong></p>
				@endif
			</td>
		</tr>
		<tr>
			<td>
				<p>Please transfer to our account:</p>
				<p>Payment term</p>
				<p>Currency: IDR</p>
				<p>Account transfer to: PT. Bintang Mas Karya Nusantara</p>
				<p>Bank Mandiri Cabang Bintara No. Rek: 167-00-0113889-9</p>
				<p>THANK YOU FOR YOUR BUSINESS</p>
			</td>
		</tr>
	</table>
</body>

</html>
