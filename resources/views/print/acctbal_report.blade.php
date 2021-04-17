	<!DOCTYPE html>
	<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!-- Scripts -->
		<script src="{{ asset('js/app.js') }}" defer></script>
		<link href="{{ asset('css/app.css') }}" rel="stylesheet">
		<title>Print Account Balance Report</title>
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
				</table>
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
							  BALANCE
							</th>
						</tr>
					</thead>
					<tbody>
						@if ($get_acct)
							<tr style="background-color: #E8F5E9;">
								<td>{{ $date_to }}</td>
								<td>{{ $get_acct->name }}</td>
								@if ($open_bal < 0)
									<td>{{ $open_bal * -1 }} DR</td>
								@elseif ($open_bal > 0)
									<td>{{ $open_bal }} CR</td>
								@else
									<td>00.00</td>
								@endif
								
							</tr>
						@endif
					</tbody>
				</table>
			</div>
		</div>
	</body>
	</html>
