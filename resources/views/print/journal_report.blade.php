	<!DOCTYPE html>
	<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!-- Scripts -->
		<script src="{{ asset('js/app.js') }}" defer></script>
		<link href="{{ asset('css/app.css') }}" rel="stylesheet">
		<title>Print Journal Report</title>
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
						<td colspan="2" style="text-align: center;"><strong>JOURNAL AS AT {{ date_format($date_from, 'jS F Y') }} TO {{ date_format($date_to, 'jS F Y') }}</strong></td>
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
							  DATE
							</th>
							<th style="text-align: left;">
							  ACCOUNT
							</th>
							<th style="text-align: left;">
							  NARRATION
							</th>
							<th style="text-align: left;">
							  DEBIT &#8377
							</th>
							<th style="text-align: left;"> 
							  CREDIT &#8377
							</th>
						</tr>
					</thead>
					<tbody>
						@php
							$total_debit = 0;
							$total_credit = 0;
						@endphp
						@if ($get_report)
							@php
								$id = $get_report[0]->order_id 
							@endphp
							@foreach ($get_report as $report)
							@if ($report->order_id != $id)
									<tr>
									  <td colspan="3"><strong>TOTAL</strong></td>
									  <td><strong>{{ $total_debit }}</strong></td>
									  <td><strong>{{ $total_credit }}</strong></td>
									</tr>
									@php
										$total_debit = 0;
										$total_credit = 0;
										$id = $report->order_id 
									@endphp
								@endif
								@php
									$total_debit = $total_debit + $report->debit;
									$total_credit = $total_credit + $report->credit;
								@endphp
								<tr>
									<td>{{ date_format(date_create($report->enter_date), 'd-m-Y') }}</td>
									<td>{{ $report->acct_name }}</td>
									<td>{{ $report->descp }}</td>
									<td>{{ $report->debit == 0 ? '' : $report->debit}}</td>
									<td>{{ $report->credit == 0 ? '' : $report->credit }}</td>
								</tr>
							@endforeach
							<tr>
							  <td colspan="3"><strong>TOTAL</strong></td>
							  <td><strong>{{ $total_debit }}</strong></td>
							  <td><strong>{{ $total_credit }}</strong></td>
							</tr>
						@endif
					</tbody>
				</table>
			</div>
		</div>
	</body>
	</html>
