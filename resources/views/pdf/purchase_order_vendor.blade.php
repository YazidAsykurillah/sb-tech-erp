<!DOCTYPE html>
<html lang="en"><head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Purchase Order Vendor</title>

    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="css/bootstrap/bootstrap.css">
    
    <style type="text/css">
    	body{
    		font-size: 9.5px;
    	}
    	.table-borderless > tbody > tr > td,
		.table-borderless > tbody > tr > th,
		.table-borderless > tfoot > tr > td,
		.table-borderless > tfoot > tr > th,
		.table-borderless > thead > tr > td,
		.table-borderless > thead > tr > th {
		    border: none;
		    padding: 0;
		}
    </style>
</head><body>
	<table class="table table-borderless">
		<tbody>
			<tr>
				<td style="width:60%;">
					<img src="img/logo-sbt.jpeg" class="img-circle" width="200px;"/>
					<p>{{ config('app.company_name') }}</p>
					<div>
						{!! nl2br($company_office) !!}
					</div>
				</td>
				<td>
					<table class="table table-borderless">
						<tbody>
							<tr>
								<td colspan="3">
									<h4>Purchase Order</h4>
								</td>
							</tr>
							<tr>
								<td style="width:40%;">Date</td>
								<td style="width:1%;">:</td>
								<td>{{ $purchase_order_vendor->date }}</td>
							</tr>
							<tr>
								<td style="width:40%;">P.O Number</td>
								<td style="width:1%;">:</td>
								<td>{{ $purchase_order_vendor->code }}</td>
							</tr>
							<tr>
								<td style="width:40%;">Quotation Number</td>
								<td style="width:1%;">:</td>
								<td>{{ $purchase_order_vendor->quotation_vendor->code }}</td>
							</tr>
							<tr>
								<td style="width:40%;">Term</td>
								<td style="width:1%;">:</td>
								<td>{!! $purchase_order_vendor->purchase_request->terms !!}</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
		</tbody>
	</table>

	<!--Table Vendor information-->
	<table class="table table-borderless">
		<tbody>
			<tr>
				<td>
					<p><strong>Vendor</strong></p>
					<p>{{ $purchase_order_vendor->vendor->name }}</p>
					<p>{{ $purchase_order_vendor->vendor->phone }}</p>
					<p>{!! nl2br($purchase_order_vendor->vendor->address) !!}</p>
				</td>
			</tr>
		</tbody>
	</table>
	<!--ENDTable Vendor information-->

	<table class="table" id="table-items">
		<thead style="background:grey;">
			<tr>
				<th style="width:5%;text-align:center;">#</th>
				<th>Description</th>
				<th>Qty</th>
				<th style="text-align:right;">Unit Price</th>
				<th style="text-align:right;">Price</th>
			</tr>
		</thead>
		<tbody>
			@if(count($item_purchase_order_vendor))
				<?php $counter = 0; ?>
				@foreach($item_purchase_order_vendor as $item)
				<?php $counter++; ?>
				<tr>
					<td style="text-align: center;">{{ $counter }}</td>
					<td>{{ $item->item }}</td>
					<td>{{ $item->quantity }}&nbsp;{{ $item->unit }}</td>
					<td style="text-align:right;">Rp&nbsp;{{ number_format($item->price) }}</td>
					<td style="text-align:right;">Rp&nbsp;{{ number_format($item->sub_amount) }}</td>
				</tr>
				@endforeach
				
				<tr>
					<td colspan="4" style="text-align:right;border:0;">Sub Total</td>
					<td style="text-align:right;background:grey;">Rp&nbsp;{{ number_format($purchase_order_vendor->purchase_request->sub_amount) }}</td>
				</tr>
				<tr>
					<td colspan="4" style="text-align:right;border:0;">Discount {{ $purchase_order_vendor->purchase_request->discount}}&nbsp;%</td>
					<?php $discount_value = $purchase_order_vendor->purchase_request->discount / 100 * $purchase_order_vendor->purchase_request->sub_amount; ?>
					<td style="text-align:right;">{{ number_format($discount_value) }}</td>
				</tr>
				<tr>
					<td colspan="4" style="text-align:right;border:0;">After Discount</td>
					<td style="text-align:right;background:grey;">Rp&nbsp;{{ number_format($purchase_order_vendor->purchase_request->after_discount) }}</td>
				</tr>
				<tr>
					<td colspan="4" style="text-align:right;border:0;">VAT {{ $purchase_order_vendor->purchase_request->vat}}&nbsp;%</td>
					<td style="text-align:right;">Rp&nbsp;{{ number_format($purchase_order_vendor->purchase_request->vat_value()) }}</td>
				</tr>
				<tr>
					<td colspan="4" style="text-align:right;border:0;">Total</td>
					<td style="text-align:right;background:grey;">Rp&nbsp;{{ number_format($purchase_order_vendor->purchase_request->amount) }}</td>
				</tr>
			@else
			<tr>
				<td colspan="5">There's no data</td>
			</tr>
			@endif
		</tbody>
	</table>
</body></html>
