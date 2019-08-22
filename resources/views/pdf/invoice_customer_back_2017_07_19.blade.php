<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Invoice Customer</title>

    <!-- Bootstrap Core CSS -->
    
    <link rel="stylesheet" href="css/bootstrap/bootstrap.css">
    
    <style type="text/css">
    	table{
    		font-size: 14px;
    	}
    </style>
</head>

<body>
	<!-- Head Part -->
	<table class="table" id="table-head-part">
		<tr>
			<td><img src="img/bmkn-logo.jpeg" class="img-circle" width="200px;"/></td>
			<td>
				<p><strong>Invoice</strong></p>
				Date  : {{ $invoice_customer->created_at }}
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<p>PT. Bintang Mas Karya Nusantara</p>
				<p>Jl. Cendana XIX No. 1 RT 004 RW 006, Komp. Jaka Permai</p>
				<p>Jakasampurna - Bekasi Barat, Kota Bekasi</p>
				<p>Phone (021) 889-68062 Fax (021) 889-68062</p>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<p><strong>Invoice To :</strong></p>
				<div>
					<p>{{ $invoice_customer->project->purchase_order_customer->customer->name }}</p>
					{{ nl2br($invoice_customer->project->purchase_order_customer->customer->address) }}
				</div>
			</td>
		</tr>
		<tr>
			<td></td>
			<td>
				<p>Quotation No : {{ $invoice_customer->project->purchase_order_customer->quotation_customer->code }}</p>
				<p>Invoice No : {{ $invoice_customer->code }}</p>
				<p>Due date : {{ $invoice_customer->due_date }}</p>
			</td>
		</tr>
	</table>
	<!-- ENDHead Part -->

	<!--PO Part -->
	<table class="table" id="table-po-part">
		<thead>
			<tr style="background:orange;">
				<td style="border:1px solid;">PO. NUMBER</td>
				<td style="border:1px solid;">Attation</td>
				<td style="border:1px solid;">TERMIN</td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td style="border:1px solid;">{{ $invoice_customer->project->purchase_order_customer->code }}</td>
				<td style="border:1px solid;">Finance Department</td>
				<td style="border:1px solid;">30 Hari</td>
			</tr>
		</tbody>
	</table>

	<!--END PO Part -->
	
	<!--PO Part -->
	<table class="table" id="table-item-part">
		<thead>
			<tr style="background:orange;">
				<td style="text-align:center; border:1px solid; width:10%;">NO</td>
				<td style="text-align:left; border:1px solid;">Description</td>
				<td style="text-align:center; border:1px solid;">Quantity</td>
				<td style="text-align:center; border:1px solid;">Unit</td>
				<td style="text-align:right; border:1px solid;">Unit Price</td>
				<td style="text-align:right; border:1px solid;">Amount</td>
			</tr>
		</thead>
		<tbody>
			@if(count($item_invoice_customer))
				<?php $row_num = 0;?>
				@foreach($item_invoice_customer as $item)
				<?php $row_num++; ?>
				<tr>
					<td style="text-align:center; border:1px solid;">{{ $row_num }}</td>
					<td style="text-align:left; border:1px solid;">{{ $item->item }}</td>
					<td style="text-align:center; border:1px solid;">{{ $item->quantity }}</td>
					<td style="text-align:center; border:1px solid;">{{ $item->unit }}</td>
					<td style="text-align:right; border:1px solid;">{{ number_format($item->price) }}</td>
					<td style="text-align:right; border:1px solid;">{{ number_format($item->sub_amount) }}</td>
				</tr>
				@endforeach
				<tr>
					<td colspan="5" style="text-align:right; border:none;">Sub Total</td>
					<td style="text-align:right; border:1px solid; background:grey;">{{ number_format($invoice_customer->sub_amount,2) }}</td>
				</tr>
				<tr>
					<td colspan="5" style="text-align:right; border:none;">VAT ({{ $invoice_customer->vat }}% x Sub Total)</td>
					<td style="text-align:right; border:1px solid; background:grey;">
						<?php $vat_value = $invoice_customer->vat / 100 * $invoice_customer->sub_amount; ?>
						{{ number_format( $vat_value, 2) }}  
					</td>
				</tr>
				<tr>
					<td colspan="5" style="text-align:right; border:none;">WHT</td>
					<td style="text-align:right; border:1px solid; background:grey;">{{ number_format($invoice_customer->wht,2) }}</td>
				</tr>
				<tr>
					<td colspan="5" style="text-align:right; border:none;"><strong>Total</strong></td>
					<td style="text-align:right; border:1px solid; background:grey;">
						{{ number_format($invoice_customer->sub_amount + $vat_value + $invoice_customer->wht, 2) }}
					</td>
				</tr>
			@endif
		</tbody>
	</table>

	<!--END PO Part -->
	<table class="table">
		<tr>
			<td style="width:15%;">Prepared By</td>
			<td style="width:5%;">:</td>
			<td>
				@if($invoice_customer->preparator)
				<div>
					<p>&nbsp;</p>
					<p>&nbsp;</p>
					<p><strong>{{ $invoice_customer->preparator->name }}</strong></p>
					<p><strong>({{ $invoice_customer->preparator->roles->first()->name }})</strong></p>
				</div>
				@endif
			</td>
		</tr>
		<tr>
			<td style="width:15%;">Please transfer to ur account</td>
			<td style="width:5%;">:</td>
			<td>
				<div>
					<p>Payment term</p>
					<p>Currency: IDR</p>
					<p><strong>Account transfer to: PT. Bintang Mas Karya Nusantara</strong></p>
					<p><strong>Bank Mandiri Cabang Bintara No. Rek: 167-00-0113889-9</strong></p>
				</div>
			</td>
		</tr>
	</table>
	<p></p>
	<center>
		<strong>THANK YOU FOR YOUR BUSINESS</strong>
	</center>
 
</body>

</html>
