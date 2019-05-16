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
				<p>PT. Bintang Mas Karya Nusantara</p>
				<p>Ruko Grand Galaxy City, RSN 3 No. 50</p>
				<p>Kecamatan Bekasi Selatan</p>
				<p>Kelurahan Jaka Setia</p>
				<p>Phone (021-82732142)</p>
			</td>
			<td>
				<strong>Delivery Order</strong>
				<table style="width:100%;">
					<tr>
						<td style="width:40%;">DO Number</td>
						<td style="width:1%;"> : </td>
						<td>{{ $deliveryOrder->code }}</td>
					</tr>
					<tr>
						<td style="width:40%;">PIC</td>
						<td style="width:1%;"> : </td>
						<td>{{ $deliveryOrder->sender->name }}</td>
					</tr>
				</table>
			</td>
		</tr>
		
	</table>
	
	<table class="table" id="table-items">
		<thead>
          <tr>
            <th style="width: 10%;">No</th>
            <th style="width: 80%;">Item</th>
            <th>Quantity</th>
          </tr>
        </thead>
        <tbody>
        @if(count($deliveryOrderItems))
          <?php $rowNumber=0;?>
          @foreach($deliveryOrderItems as $item)
          <?php $rowNumber++;?>
          <tr>
            <td>{{$rowNumber}}</td>
            <td>
              {{\DB::table('item_purchase_request')->where('id','=',$item->item_purchase_request_id)->first()->item}}
            </td>
            <td>{{round($item->quantity)}}</td>
          </tr>
          @endforeach
        @endif
        </tbody>
	</table>
		
</body>

</html>
