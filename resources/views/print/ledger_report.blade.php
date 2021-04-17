	<!DOCTYPE html>
	<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!-- Scripts -->
		<script src="{{ asset('js/app.js') }}" defer></script>
		<link href="{{ asset('css/app.css') }}" rel="stylesheet">
		<title>Print Ledger Report</title>
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
						<td colspan="2" style="text-align: center;"><strong>LEDGER AS AT {{ date_format($date_from, 'jS F Y') }} TO {{ date_format($date_to, 'jS F Y') }}</strong></td>
					</tr>
				</table>
				<div style="text-align: center;">
					@if ($acct_id != 0)
						<span><strong>Account:</strong> {{ $acct_name }}</span>
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
							<tr style="background-color: #FFEBEE;">
							  <td colspan="3"><strong>Opening Balance</strong></td>
							  @if ($open_bal < 0)
							  	<td><strong>{{ number_format($open_bal * -1, 2) }}</strong></td>
							  @else
							    <td></td>
							  @endif
							  @if ($open_bal > 0)
							  	<td><strong>{{number_format($open_bal, 2) }}</strong></td>
							  @else
							    <td></td>
							  @endif
							</tr>
							@foreach ($get_report as $report)
							@php
								$total_debit = $total_debit + $report->debit;
								$total_credit = $total_credit + $report->credit;
							@endphp
								<tr>
									<td>{{ $report->enter_date }}</td>
									<td>{{ $report->acct_name }}</td>
									<td>{{ $report->descp }}</td>
									<td>{{ $report->debit == 0 ? '' : $report->debit}}</td>
									<td>{{ $report->credit == 0 ? '' : $report->credit }}</td>
								</tr>
							@endforeach
							<tr style="background-color: #ECEFF1;">
							  <td colspan="3"><strong>TOTAL</strong></td>
							  <td><strong>{{ number_format($total_debit, 2) }}</strong></td>
							  <td><strong>{{ number_format($total_credit, 2) }}</strong></td>
							</tr>
							@php
								$closing_bal = $open_bal - ($total_debit - $total_credit);
							@endphp
							<tr style="background-color: #E8F5E9;">
							  <td colspan="3"><strong>Closing Balance</strong></td>
							  @if ($closing_bal < 0)
							  	<td><strong>{{ number_format($closing_bal * -1, 2) }}</strong></td>
							  @else
							    <td></td>
							  @endif
							  @if ($closing_bal > 0)
							  	<td><strong>{{ number_format($closing_bal, 2) }}</strong></td>
							  @else
							    <td></td>
							  @endif
							</tr>
						@endif
					</tbody>
				</table>
			</div>
		</div>
	</body>
	</html>
