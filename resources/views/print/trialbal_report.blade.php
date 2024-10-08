	<!DOCTYPE html>
	<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!-- Scripts -->
		<script src="{{ asset('js/app.js') }}" defer></script>
		<link href="{{ asset('css/app.css') }}" rel="stylesheet">
		@if($groupcode_id == 0)
			<title>Print Trial Balance Report</title>
		@else
			<title>Print Schedule Report</title>
		@endif
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
						@if($groupcode_id == 0)
							<td colspan="2" style="text-align: center;"><strong>TRIAL BALANCE AS AT {{ date_format($date_from, 'jS F Y') }} TO {{ date_format($date_to, 'jS F Y') }}</strong></td>
						@else
							<td colspan="2" style="text-align: center;"><strong>{{ strtoupper($groupcode_name)}} AS AT {{ date_format($date_from, 'jS F Y') }} TO {{ date_format($date_to, 'jS F Y') }}</strong></td>
						@endif
						
					</tr>
				</table>
			</div>
			@php
			 function getHead($reportArray, $groupcode_id)
				 {
				 	 $name = '';
				 	 $debit = 0;
				 	 $credit = 0;
				 	 foreach ($reportArray as $data) {
				 	 	 if ($data->groupcode_id == $groupcode_id) 
				 	 	 {
				 	 	 	$name = $data->groupcode_name;
				 	 	 	$debit = $debit + $data->debit;
				 	 	 	$credit = $credit + $data->credit;
				 	 	 } 
				 	 }

				 	 return ['name'=>$name, 'debit'=>$debit, 'credit'=>$credit];
				 } 
			@endphp
			<div style="border:2px solid #ECEFF1;">
				<table style="table-layout:fixed;" class="table">
					<thead>
						<tr>
						  <th style="text-align: left;">
						    ACCOUNT
						  </th>
						  <th style="text-align: right;">
						    DEBIT &#8377
						  </th>
						  <th style="text-align: right;"> 
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
								$id = $get_report[0]->groupcode_id;
								$get_head = getHead($get_report, $id);
							@endphp
								<tr>
								  <td style="background-color: #ECEFF1;"><strong>{{ $get_head['name'] }}</strong></td>
								  <td style="text-align: right; background-color: #ECEFF1;"><strong>{{ $get_head['debit'] }}</strong></td>
								  <td style="text-align: right; background-color: #ECEFF1;"><strong>{{ $get_head['credit'] }}</strong></td>
								</tr>
							@foreach ($get_report as $report)
							@if ($report->groupcode_id != $id)
									@php
										$id = $report->groupcode_id;
										$get_head = getHead($get_report, $id);
									@endphp
									<tr>
									  <td style="background-color: #ECEFF1;"><strong>{{ $get_head['name'] }}</strong></td>
									  <td style="text-align: right; background-color: #ECEFF1;"><strong>{{ $get_head['debit'] }}</strong></td>
									  <td style="text-align: right; background-color: #ECEFF1;"><strong>{{ $get_head['credit'] }}</strong></td>
									</tr>
								@endif
								@php
									$total_debit = $total_debit + $report->debit;
									$total_credit = $total_credit + $report->credit;
								@endphp
								@if ($report->debit == 0 && $report->credit == 0)
								
								@else
									<tr>
										<td>{{ $report->acct_name }}</td>
										<td style="text-align: right;">{{ $report->debit == 0 ? '' : $report->debit}}</td>
										<td style="text-align: right;">{{ $report->credit == 0 ? '' : $report->credit }}</td>
									</tr>
								@endif
							@endforeach
							<tr>
							  <td style="background-color: #B0BEC5;"><strong>TOTAL</strong></td>
							  <td style="text-align: right; background-color: #B0BEC5;"><strong>{{ $total_debit }}</strong></td>
							  <td style="text-align: right; background-color: #B0BEC5;"><strong>{{ $total_credit }}</strong></td>
							</tr>
						@endif
					</tbody>
				</table>
			</div>
		</div>
	</body>
	</html>
