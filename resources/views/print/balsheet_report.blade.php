	<!DOCTYPE html>
	<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!-- Scripts -->
		<script src="{{ asset('js/app.js') }}" defer></script>
		<link href="{{ asset('css/app.css') }}" rel="stylesheet">
		<title>Print Balance Sheet Report</title>
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
						<td colspan="2" style="text-align: center;"><strong>BALANCE SHEET AS AT {{ date_format($date_to, 'jS F Y') }} </strong></td>
					</tr>
				</table>
			</div>
			@php
			 function getHead($reportArray, $groupcode_id)
				 {
				 	 $name = '';
				 	 $amount = 0;
				 	 foreach ($reportArray as $data) {
				 	 	 if ($data['groupcode_id'] == $groupcode_id) 
				 	 	 {
				 	 	 	$name = $data['groupcode_name'];
				 	 	 	$amount = $amount + $data['amount'];
				 	 	 } 
				 	 }

				 	 return ['name'=>$name, 'amount'=>$amount];
				 } 

			@endphp
			<div style="border:2px solid #ECEFF1; width: 50%; float: left;">
				<h2>LIABILITY</h2>
				<table style="table-layout:fixed;" class="table">
					<thead>
						<tr>
						  <th style="text-align: left;">
						    ACCOUNT
						  </th>
						  <th style="text-align: right;">
						    AMOUNT &#8377
						  </th>
						</tr>
					</thead>
					<tbody>
						@php
							$total_amount = 0;
						@endphp
						@if ($liability)
							@php
								$id = $liability{0}['groupcode_id'];
								$get_head = getHead($liability, $id);
							@endphp
								<tr>
								  <td style="background-color: #ECEFF1;"><strong>{{ $get_head['name'] }}</strong></td>
								  <td style="text-align: right; background-color: #ECEFF1;"><strong>{{ $get_head['amount'] }}</strong></td>
								</tr>
							@foreach ($liability as $report)
							@if ($report['groupcode_id'] != $id)
									@php
										$id = $report['groupcode_id'];
										$get_head = getHead($liability, $id);
									@endphp
									<tr>
									  <td style="background-color: #ECEFF1;"><strong>{{ $get_head['name'] }}</strong></td>
									  <td style="text-align: right; background-color: #ECEFF1;"><strong>{{ $get_head['amount'] }}</strong></td>
									</tr>
								@endif
								@php
									$total_amount = $total_amount + $report['amount'];
								@endphp
									<tr>
										<td>{{ $report['acct_name'] }}</td>
										<td style="text-align: right;">{{ $report['amount'] }}</td>
									</tr>
							@endforeach
							<tr>
							  <td style="background-color: #B0BEC5;"><strong>TOTAL</strong></td>
							  <td style="text-align: right; background-color: #B0BEC5;"><strong>{{ $total_amount }}</strong></td>
							</tr>
						@endif
					</tbody>
				</table>
			</div>
			<div style="border:2px solid #ECEFF1; width: 50%; float: left;">
				<h2>ASSET</h2>
				<table style="table-layout:fixed;" class="table">
					<thead>
						<tr>
						  <th style="text-align: left;">
						    ACCOUNT
						  </th>
						  <th style="text-align: right;">
						    AMOUNT &#8377
						  </th>
						</tr>
					</thead>
					<tbody>
						@php
							$total_amount = 0;
						@endphp
						@if ($asset)
							@php
								$id = $asset{0}['groupcode_id'];
								$get_head = getHead($asset, $id);
							@endphp
								<tr>
								  <td style="background-color: #ECEFF1;"><strong>{{ $get_head['name'] }}</strong></td>
								  <td style="text-align: right; background-color: #ECEFF1;"><strong>{{ $get_head['amount'] }}</strong></td>
								</tr>
							@foreach ($asset as $report)
							@if ($report['groupcode_id'] != $id)
									@php
										$id = $report['groupcode_id'];
										$get_head = getHead($asset, $id);
									@endphp
									<tr>
									  <td style="background-color: #ECEFF1;"><strong>{{ $get_head['name'] }}</strong></td>
									  <td style="text-align: right; background-color: #ECEFF1;"><strong>{{ $get_head['amount'] }}</strong></td>
									</tr>
								@endif
								@php
									$total_amount = $total_amount + $report['amount'];
								@endphp
									<tr>
										<td>{{ $report['acct_name'] }}</td>
										<td style="text-align: right;">{{ $report['amount'] }}</td>
									</tr>
							@endforeach
							<tr>
							  <td style="background-color: #B0BEC5;"><strong>TOTAL</strong></td>
							  <td style="text-align: right; background-color: #B0BEC5;"><strong>{{ $total_amount }}</strong></td>
							</tr>
						@endif
					</tbody>
				</table>
			</div>
		</div>
	</body>
</html>
