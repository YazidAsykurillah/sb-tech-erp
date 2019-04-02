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

    <style type="text/css">
    	table{
    		font-size: 12px;
    	}
    </style>

</head>

<body>
	<div>
		<img src="img/bmkn-logo.jpeg" class="img-circle" width="200px;">
	</div>
	<br>
	
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
			<td style="width: 20%;">
				<p><strong>Basic Salary</strong></p>
				<p>(Timesheet Manhour)</p>
			</td>
			<td>
				<table class="table table-bordered" id="table-manhour">
					<thead>
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
					</thead>
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
				<p><strong>Total Jam</strong></p>
				<p>Normal</p>
				<p>{{ $total_normal_time }}</p>
				<p>Overtime</p>
				<p>
					{{($total_overtime_one * 1.5 ) + ($total_overtime_two * 2) + ($total_overtime_three * 3) + ($total_overtime_four * 4) }}
				</p>
			</td>
			<td style="text-align:center;">
				<table id="table-salary">
					<thead>
						<tr>
							<td>Basic Salary :</td>
							<td></td>
						</tr>
						<tr>
							<td></td>
							<td style="text-align:right;">{{ number_format($user->salary, 2) }}</td>
						</tr>
						<tr>
							<td>Overtime (Total Overtime x Rate) :</td>
							<td></td>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td></td>
							<td style="text-align:right;">
								<?php $overtime_one_value = $total_overtime_one*1.5 ;?>
								<?php $overtime_two_value = $total_overtime_two*2 ;?>
								<?php $overtime_three_value = $total_overtime_three*3 ;?>
								<?php $overtime_four_value = $total_overtime_four*4 ;?>
								<?php $overtime_total_values = $overtime_one_value+$overtime_two_value+$overtime_three_value+$overtime_four_value; ?>
								<!-- Count total overtime value * rate -->
								{{ number_format($overtime_total_values*$user->man_hour_rate, 2) }}
							</td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
		<tr>
			<td style="width:20%;text-align:center;">Manhour Rate</td>
			<td style="width:20%;text-align:center;">{{ number_format($user->man_hour_rate) }}</td>
			<td colspan="2"></td>
		</tr>
		<tr>
			<td colspan="2">
				<p>Transportation and Meal</p>
				<table style="width: 100%;">
					<tr>
						<td colspan="3"><strong>Allowance</strong></td>
					</tr>
					<tr>
						<td style="width: 41%;">Uang Makan</td>
						<td style="width: 5%;">:</td>
						<td>{{ number_format($user->eat_allowance, 2) }}</td>
					</tr>
					<tr>
						<td style="width: 41%;">Tranportasi</td>
						<td style="width: 5%;">:</td>
						<td>{{ number_format($user->transportation_allowance, 2) }}</td>
					</tr>
					<tr>
						<td style="width: 41%;">Insentive</td>
						<td style="width: 5%;">:</td>
						<td>{{ number_format($user->incentive, 2) }}</td>
					</tr>
				</table>
			</td>
			<td style="text-align: center;">
				<p>Total Hari</p>
				<table style="width: 100%;text-align: center;">
					<tr>
						<td>---</td>
					</tr>
					<tr>
						<td>{{ $total_allowance }}</td>
					</tr>
					<tr>
						<td>{{ $total_allowance }}</td>
					</tr>
					<tr>
						<td>{{ $total_allowance }}</td>
					</tr>
				</table>
			</td>
			<td style="text-align:right;">
				<p>Total Allowance</p>
				<table style="width: 100%;text-align: right;">
					<tr>
						<td>---</td>
					</tr>
					<tr>
						<td>{{ number_format($user->eat_allowance*$total_allowance, 2) }}</td>
					</tr>
					<tr>
						<td>{{ number_format($user->transportation_allowance*$total_allowance, 2) }}</td>
					</tr>
					<tr>
						<td>{{ number_format($user->incentive*$total_allowance, 2) }}</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td>
				<strong>Project Expenses</strong>
			</td>
			<td colspan="3" style="text-align: right;">?</td>
		</tr>
		<tr>
			<td colspan="2">
				<p>
					<strong>Medical Allowance</strong>
				</p>
				<table style="width: 100%;">
					<tr>
						<td style="width: 41%;">Rate/Bulan</td>
						<td style="width: 5%;">:</td>
						<td>{{ number_format($user->medical_allowance, 2) }}</td>
					</tr>
					<tr>
						<td colspan="3">
							<p> &gt; 2 weeks = Full </p>
							<p> &lt; 2 weeks = Half </p>
						</td>
					</tr>
				</table>
			</td>
			<td style="text-align: center;">
				<p>Total Hari</p>
				<table style="width: 100%;text-align: center;">
					<tr>
						<td>{{ $total_allowance }}</td>
					</tr>
				</table>
			</td>
			<td style="text-align:right;">
				<p>&nbsp;</p>
				<p>
					@if($total_allowance > 14)
						{{ number_format($user->medical_allowance, 2) }}
					@else
						{{ number_format($user->medical_allowance / 2, 2) }}
					@endif
				</p>
			</td>
		</tr>
		<tr>
			<td>
				<strong>Kasbon Berjalan</strong>
			</td>
			<td  colspan="3" style="text-align: right;">?</td>
		</tr>
		<tr>
			<td>
				<strong>Advance ( Cashbond )</strong>
			</td>
			<td  colspan="3" style="text-align: right;">{{ number_format($cashbonds, 2) }}</td>
		</tr>
		<tr>
			<td>
				<strong>BPJS TK (JHTJKJKM)</strong>
			</td>
			<td  colspan="3" style="text-align: right;">{{ number_format($user->bpjs_ke, 2) }}</td>
		</tr>
		<tr>
			<td>
				<strong>BPJS KESEHATAN</strong>
			</td>
			<td  colspan="3" style="text-align: right;">{{ number_format($user->bpjs_tk, 2) }}</td>
		</tr>
	</table>
 
</body>

</html>
