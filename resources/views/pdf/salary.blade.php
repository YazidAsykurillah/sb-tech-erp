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
    		font-size: 10px;
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
			<td style="width:20%;">Nomor Karyawan</td>
			<td>{{ $employee_nik }}</td>
		</tr>
		<tr>
			<td style="width:20%;">Nama Karyaman</td>
			<td>{{ $employee_name }}</td>
		</tr>
		<tr>
			<td style="width:20%;">Posisi</td>
			<td>{{ $employee_role }}</td>
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
							<td style="text-align:center;">{{ $value_total_overtime_one }}</td>
							<td style="text-align:center;">{{ $value_total_overtime_two }}</td>
							<td style="text-align:center;">{{ $value_total_overtime_three }}</td>
							<td style="text-align:center;">{{ $value_total_overtime_four }}</td>
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
					{{ $value_total_over_time }}
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
							<td style="text-align:right;">{{ number_format($employee_salary, 2) }}</td>
						</tr>
						<tr>
							<td>Overtime Salary(Total Overtime x Rate) :</td>
							<td></td>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td></td>
							<td style="text-align:right;">
								{{ number_format($overtime_salary, 2) }}
							</td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
		<tr>
			<td style="width:20%;text-align:center;">Manhour Rate</td>
			<td style="width:20%;text-align:center;">{{ number_format($employee_man_hour_rate) }}</td>
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
						<td>{{ number_format($employee_eat_allowance, 2) }}</td>
					</tr>
					<tr>
						<td style="width: 41%;">Tranportasi</td>
						<td style="width: 5%;">:</td>
						<td>{{ number_format($employee_transportation_allowance, 2) }}</td>
					</tr>
					<tr>
						<td style="width: 41%;">Insentive Week Day</td>
						<td style="width: 5%;">:</td>
						<td>{{ number_format($employee_incentive_week_day, 2) }}</td>
					</tr>
					<tr>
						<td style="width: 41%;">Insentive Week End</td>
						<td style="width: 5%;">:</td>
						<td>{{ number_format($employee_incentive_week_end, 2) }}</td>
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
						<td>{{ $total_incentive_week_day }}</td>
					</tr>
					<tr>
						<td>{{ $total_incentive_week_end }}</td>
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
						<td>{{ number_format($eat_allowance_salary, 2) }}</td>
					</tr>
					<tr>
						<td>{{ number_format($transportation_allowance_salary, 2) }}</td>
					</tr>
					<tr>
						<td>{{ number_format($incentive_week_day_salary, 2) }}</td>
					</tr>
					<tr>
						<td>{{ number_format($incentive_week_end_salary, 2) }}</td>
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
						<td>{{ number_format($employee_medical_allowance, 2) }}</td>
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
					{{ number_format($medical_allowance_salary, 2) }}
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
			<td  colspan="3" style="text-align: right;">{{ number_format($cashbond_salary, 2) }}</td>
		</tr>
		<tr>
			<td>
				<strong>BPJS TK (JHTJKJKM)</strong>
			</td>
			<td  colspan="3" style="text-align: right;">{{ number_format($bpjs_ke_salary, 2) }}</td>
		</tr>
		<tr>
			<td>
				<strong>BPJS KESEHATAN</strong>
			</td>
			<td  colspan="3" style="text-align: right;">{{ number_format($bpjs_tk_salary, 2) }}</td>
		</tr>
		<tr>
			<td colspan="3"><strong>Jumlah yang dibayarkan ke Karyawan</strong></td>
			<td style="text-align: right;">
				{{ number_format($total_salary, 2) }}
			</td>
		</tr>
		<tr>
			<td colspan="4">
				@if($user->bank_accounts->count())
					Transfer to Rek {{ $user->name }}, No.Rek {{ $user->bank_accounts()->first()->name }}
				@else
					Transfer to Rek {{ $user->name }}, No.Rek <strong>[<i class="fa fa-warning-sign"></i>&nbsp;Empty Bank Account data]</strong>
				@endif
			</td>
		</tr>
	</table>
</body>

</html>
