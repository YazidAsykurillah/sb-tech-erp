<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Slip Gaji</title>

    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="css/bootstrap/bootstrap.css">

</head>

<body>
	<div>
		<img src="img/bmkn-logo.jpeg" class="img-circle" width="200px;">
	</div>
	<br>
	<center>
		<h5 class="alert alert-info"><strong>Slip Gaji</strong></h5>
	</center>
	<table class="table">
		<tr>
			<td style="width:20%;">Nama Karyaman</td>
			<td>{{ $user->name }}</td>
		</tr>
		<tr>
			<td style="width:20%;">Nomor Karyawan</td>
			<td>{{ $user->nik }}</td>
		</tr>
		<tr>
			<td style="width:20%;">Posisi</td>
			<td>{{ $user->roles->first()->name }}</td>
		</tr>
		<tr>
			<td style="width:20%;">Period</td>
			<td>{{ $period->start_date }} s/d {{ $period->end_date }}</td>
		</tr>
		
	</table>
	<br/>
	<table class="table table-bordered">
		<tr>
			<td style="width:20%;text-align:center;">Basic Salary (Timesheet Manhour)</td>
			<td>
				<table class="table table-bordered">
					<tr>
						<th style="text-align:center;">Normal</th>
						<th colspan="4" style="text-align:center;">Overtime</th>
					</tr>
					<tr>
						<th></th>
						<th style="text-align:center;">I</th>
						<th style="text-align:center;">II</th>
						<th style="text-align:center;">III</th>
						<th style="text-align:center;">IV</th>
					</tr>
					<tbody>
						<tr>
							<td style="text-align:center;">{{ $total_normal_time }}</td>
							<td style="text-align:center;">{{ $total_overtime_one }}</td>
							<td style="text-align:center;">{{ $total_overtime_two }}</td>
							<td style="text-align:center;">{{ $total_overtime_three }}</td>
							<td style="text-align:center;">{{ $total_overtime_four }}</td>
						</tr>
						<tr>
							<td style="text-align:center;">{{ $total_normal_time }}</td>
							<td style="text-align:center;">{{ $total_overtime_one * 1.5 }}</td>
							<td style="text-align:center;">{{ $total_overtime_two * 2 }}</td>
							<td style="text-align:center;">{{ $total_overtime_three * 3 }}</td>
							<td style="text-align:center;">{{ $total_overtime_four * 4 }}</td>
						</tr>
					</tbody>
				</table>
			</td>
			<td style="text-align:center;">
				Total Jam
				<p>
					{{ $total_normal_time + ($total_overtime_one * 1.5 ) + ($total_overtime_two * 2) + ($total_overtime_three * 3) + ($total_overtime_four * 4) }}
				</p>
			</td>
			<td style="text-align:center;">
				Total Basic Salary ( Total Jam x Rate)
				<p>{{ number_format(($total_normal_time + ($total_overtime_one * 1.5 ) + ($total_overtime_two * 2) + ($total_overtime_three * 3) + ($total_overtime_four * 4)) * $user->man_hour_rate) }} </p>
			</td>
		</tr>
		<tr>
			<td style="width:20%;text-align:center;">Manhour Rate</td>
			<td style="width:20%;text-align:center;">{{ number_format($user->man_hour_rate) }}</td>
		</tr>
	</table>
 
</body>

</html>
