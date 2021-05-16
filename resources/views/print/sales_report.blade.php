	<!DOCTYPE html>
	<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!-- Scripts -->
		<script src="{{ asset('js/app.js') }}" defer></script>
		<link href="{{ asset('css/app.css') }}" rel="stylesheet">
		<title>Print Sales Report</title>
	</head>
	<body style="padding-top: 15px; padding-left: 50px;">
		<div>
			<div style="margin: 0 auto; width: 500px;">
				<table style="table-layout:fixed;">
					<tr>
						<td width="400" style="text-align: center;">
							{{ $company->name }} <br> 
							Phone: {{ $company->phone }}<br> 
							E-Mail: {{ $company->email }}<br>
							Address: {{ $company->address }}
						</td>
					</tr>
					<tr>
						<td colspan="2" style="text-align: center;"><strong>SALES AS AT {{ date_format($date_from, 'jS F Y') }} TO {{ date_format($date_to, 'jS F Y') }}</strong></td>
					</tr>
				</table>
				<div style="text-align: center;">
					@if ($acct_id != 0)
						<span><strong>Account:</strong> {{ $acct_name }} | </span>
					@endif
				</div>
			</div>
			<div style="border:2px solid #ECEFF1;">
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
						    Round Off
						  </th>
						  <th style="text-align: left;"> 
						    Final Amount
						  </th>
						</tr>
					</thead>
					<tbody>
						@if ($get_report)
							@php
								$id = $get_report[0]->sno; 
								$total = $get_report[0];
							@endphp
							@foreach ($get_report as $report)
							@if ($report->sno != $id)
									<tr>
									  <td colspan="7"><strong>TOTAL</strong></td>
									  <td><strong>{{ $total->sales_amount }} </strong></td>
									  <td><strong>{{ $total->t_levy }} </strong></td>
									  <td><strong>{{ $total->t_maplevy }} </strong></td>
									  <td><strong>{{ $total->t_apmc }} </strong></td>
									  <td><strong>{{ $total->t_comm }} </strong></td>
									  <td><strong>{{ $total->other_charges }} </strong></td>
									  <td><strong>{{ $total->total_amount }} </strong></td>
									</tr>
									@php
										$id = $report->sno; 
										$total = $report;
									@endphp
							@endif
							<tr>
								<td>{{ $report->sno }}</td>
								<td>{{ $report->enter_date }}</td>
								<td>{{ $report->acct_name }}</td>
								<td>{{ $report->item_name }}</td>
								<td>{{ $report->qty }}</td>
								<td>{{ $report->grwt }}</td>
								<td>{{ $report->rate }}</td>
								<td>{{ $report->amount }}</td>
								<td colspan="6"></td>
							</tr>
							@endforeach
							<tr>
							  <td colspan="7"><strong>TOTAL</strong></td>
							  <td><strong>{{ $total->sales_amount }} </strong></td>
							  <td><strong>{{ $total->t_levy }} </strong></td>
							  <td><strong>{{ $total->t_maplevy }} </strong></td>
							  <td><strong>{{ $total->t_apmc }} </strong></td>
							  <td><strong>{{ $total->t_comm }} </strong></td>
							  <td><strong>{{ $total->other_charges }} </strong></td>
							  <td><strong>{{ $total->total_amount }} </strong></td>
							</tr>
						@endif
					</tbody>
				</table>
			</div>
		</div>
	</body>
	</html>
