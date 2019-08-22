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
    {!! Html::style('css/bootstrap/bootstrap.css') !!}

</head>

<body>
	<div>
		{!! Html::image('img/bmkn-logo.jpeg', 'Logo', ['class'=>'img-circle', 'width'=>'200']) !!}
	</div>
	<br>
	<center>
		<p class="alert alert-info">INVOICE</p>
	</center>
	<table class="table">
		<tr>
	        <td style="width: 20%;">Invoice Number</td>
	        <td style="width: 1%;">:</td>
	        <td>{{ $invoice_customer->code }}</td>
	    </tr>
	    <tr>
	        <td style="width: 20%;">Customer Name</td>
	        <td style="width: 1%;">:</td>
	        <td>{{ $invoice_customer->project->purchase_order_customer->customer->name }}</td>
	    </tr>
	    <tr>
	        <td style="width: 20%;">Tax Number</td>
	        <td style="width: 1%;">:</td>
	        <td>{{ $invoice_customer->tax_number }}</td>
	    </tr>
	    <tr>
	        <td style="width: 20%;">Amount</td>
	        <td style="width: 1%;">:</td>
	        <td>{{ number_format($invoice_customer->amount,2) }}</td>
	    </tr>
	    <tr>
	        <td style="width: 20%;">Submitted Date</td>
	        <td style="width: 1%;">:</td>
	        <td>{{ $invoice_customer->submitted_date }}</td>
	    </tr>          
	    <tr>
	        <td style="width: 20%;">Due Date</td>
	        <td style="width: 1%;">:</td>
	        <td>{{ $invoice_customer->due_date }}</td>
	    </tr>
	    <tr>
	        <td style="width: 20%;">Description</td>
	        <td style="width: 1%;">:</td>
	        <td>{{ $invoice_customer->description }}</td>
	    </tr>
	</table>
 
</body>

</html>
