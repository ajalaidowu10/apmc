	<!DOCTYPE html>
	<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!-- Scripts -->
		<script src="{{ asset('js/app.js') }}" defer></script>
		<link href="{{ asset('css/app.css') }}" rel="stylesheet">
		<title>Print Purchase Report</title>
	</head>
	<body style="padding-top: 15px; padding-left: 50px;">
		<div>
			<div style="margin: 0 auto; width: 500px;">
				<table style="table-layout:fixed;">
					<tr>
						<td width="100"><img src="{{ asset('images/logo.png') }}" alt="Redstone Resort" width="100"></td>
						<td width="400">
							At Post Borgoan Budruk Dhoom Balkavadi Dam Road Tal.Wai Dist Satara. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Phone: +91 8623066564, E-Mail: info@redstoneresort.in
						</td>
					</tr>
					<tr>
						<td colspan="2" style="text-align: center;"><strong>PURCHASE AS AT {{ date_format($date_from, 'jS F Y') }} TO {{ date_format($date_to, 'jS F Y') }}</strong></td>
					</tr>
				</table>
				<div style="text-align: center;">
					@if ($acct_id != 0)
						<span><strong>Account:</strong> {{ $acct_name }} | </span>
					@endif
				</div>
			</div>
			<div style="border:2px solid black;">
				<table style="table-layout:fixed;" class="table">
					<thead>
						<tr>
						  <th style="text-align: left;">
						    S/No.
						  </th>
						  <th style="text-align: left;">
						    Date
						  </th>
						  <th style="text-align: left;">
						    Account
						  </th>
						  <th style="text-align: left;">
						    Motor No.
						  </th>
						  <th style="text-align: left;">
						    Item
						  </th>
						  <th style="text-align: left;">
						    Qty
						  </th>
						  <th style="text-align: left;">
						    Grwt
						  </th>
						  <th style="text-align: left;">
						    Rate
						  </th>
						  <th style="text-align: left;">
						    Amount
						  </th>
						  <th style="text-align: left;">
						    Levy
						  </th>
						  <th style="text-align: left;">
						    Map Levy
						  </th>
						  <th style="text-align: left;">
						    Apmc
						  </th>
						  <th style="text-align: left;"> 
						    Comm
						  </th>
						  <th style="text-align: left;"> 
						    Tds
						  </th>
						  <th style="text-align: left;"> 
						    Final Amount
						  </th>
						</tr>
					</thead>
					<tbody>
						@php
							$total_qty= 0;
							$total_grwt = 0;
							$total_rate = 0;
							$total_amount = 0;
							$total_levy = 0;
							$total_map_levy = 0;
							$total_apmc = 0;
							$total_comm = 0;
							$total_tds = 0;
							$total_final_amount = 0;
						@endphp
						@if ($get_report)
							@foreach ($get_report as $report)
							<tr>
								@php
									$total_qty = $total_qty + $report->qty;
									$total_grwt = $total_grwt + $report->grwt;
									$total_rate = $total_rate + $report->rate;
									$total_amount = $total_amount + $report->amount;
									$total_levy = $total_levy + $report->levy;
									$total_map_levy = $total_map_levy + $report->map_levy;
									$total_apmc = $total_apmc + $report->apmc;
									$total_comm = $total_comm + $report->comm;
									$total_tds = $total_tds + $report->tds;
									$total_final_amount = $total_final_amount + $report->final_amount;
								@endphp
								<td>{{ $report->sno }}</td>
								<td>{{ $report->enter_date }}</td>
								<td>{{ $report->acct_name }}</td>
								<td>{{ $report->motor_no }}</td>
								<td>{{ $report->item_name }}</td>
								<td>{{ $report->qty }}</td>
								<td>{{ $report->grwt }}</td>
								<td>{{ $report->rate }}</td>
								<td>{{ $report->amount }}</td>
								<td>{{ $report->levy }}</td>
								<td>{{ $report->map_levy }}</td>
								<td>{{ $report->apmc }}</td>
								<td>{{ $report->comm }}</td>
								<td>{{ $report->tds }}</td>
								<td>{{ $report->final_amount }}</td>
							</tr>
							@endforeach
							<tr>
							  <td colspan="5"><strong>TOTAL</strong></td>
							  <td><strong>{{ $total_qty }}</strong></td>
							  <td><strong>{{ $total_grwt }}</strong></td>
							  <td><strong>{{ $total_rate }}</strong></td>
							  <td><strong>{{ $total_amount }}</strong></td>
							  <td><strong>{{ $total_levy }}</strong></td>
							  <td><strong>{{ $total_map_levy }}</strong></td>
							  <td><strong>{{ $total_apmc }}</strong></td>
							  <td><strong>{{ $total_comm }}</strong></td>
							  <td><strong>{{ $total_tds }}</strong></td>
							  <td><strong>{{ $total_final_amount }}</strong></td>
							</tr>
						@endif
					</tbody>
				</table>
			</div>
		</div>
	</body>
	</html>
