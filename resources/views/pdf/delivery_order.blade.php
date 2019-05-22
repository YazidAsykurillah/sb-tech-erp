<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Delivery Order</title>

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
			<td style="width:30%; vertical-align: top;">
				<img src="img/bmkn-logo.jpeg" class="img-circle" width="200px;"/>
			</td>
      <td style="width: 40%; vertical-align: top; border-right:1px solid;">
        <h5><strong>PT. Bintang Mas Karya Nusantara</strong></h5>
        <p>Ruko Grand Galaxy City, RSN 3 No. 50</p>
        <p>Jakasetia Bekasi Selatan Kota Bekasi Jawa Barat</p>
        <p>Indonesia 17147</p>
        <p>Phone (021-82732142)</p>
      </td>
			<td style="vertical-align: top;padding-left: 5px;font-weight: bold;">
				<h5><strong>Delivery Order</strong></h5>
				<table style="width:100%;">
					<tr>
						<td style="width:20%;">No. DO</td>
						<td style="width:5%;"> : </td>
						<td>{{ $deliveryOrder->code }}</td>
					</tr>
          <tr>
            <td style="width:20%;">PO</td>
            <td style="width:5%;"> : </td>
            <td>{{ $deliveryOrder->project->purchase_order_customer->code }}</td>
          </tr>
					<tr>
						<td style="width:20%;">PIC</td>
						<td style="width:5%;"> : </td>
						<td>{{ $deliveryOrder->sender->name }}</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
  <hr style="border: 1px double;">
  
  <table id="table-customer" style="width:100%; border:0;">
    <tr>
      <td style="width:40%; vertical-align: top;">
        <p><strong>Kepada Yth,</strong></p>
        <div><strong>{{ $deliveryOrder->project->customer->name}}</strong></div>
        <div>{{$deliveryOrder->project->customer->address}}</div>
      </td>
      <td style="vertical-align: top;">
        <div style="text-align: right; font-weight: bold;">Tanggal Kirim : {{ $deliveryOrder->created_at}}</div>
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

  <div style="font-size: 10px;">
    Mohon Untuk dicek dan diterima.
  </div>
  <br>
  <table id="table-interactor" style="width:100%; border:0;">
    <tr>
      <td style="width:50%; vertical-align: top; text-align: center;">
        <p>Penerima</p>
        <br/>
        <br/>
        <br/>
        <p>(...............................)</p>
      </td>
       <td style="width:50%; vertical-align: top; text-align: center;">
        <p>Hormat Kami,</p>
        <br/>
        <br/>
        <br/>
        <p>(...............................)</p>
      </td>
    </tr>
  </table>

</body>
</html>
