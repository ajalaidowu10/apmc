	<!DOCTYPE html>
	<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!-- Scripts -->
		<script src="{{ asset('js/app.js') }}" defer></script>
		<link href="{{ asset('css/app.css') }}" rel="stylesheet">
		<title>Print Stock Report</title>
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
						<td colspan="2" style="text-align: center;"><strong>STOCK AS AT  {{ date_format($date_to, 'jS F Y') }}</strong></td>
					</tr>
				</table>
				<div style="text-align: center;">
					@if ($item_id != 0)
						<span><strong>Item:</strong> {{ $item_name }} </span>
					@endif
				</div>
			</div>
			<div style="border:2px solid #ECEFF1;">
				<table style="table-layout:fixed;" class="table">
					<thead>
						<tr>
						  <th style="text-align: left;">
						    ITEM
						  </th>
						  <th style="text-align: left;">
						    INWARD QTY
						  </th>
						  <th style="text-align: left;">
						    OUTWARD QTY
						  </th>
						  <th style="text-align: left;">
						    BALANCE QTY
						  </th>
						</tr>
					</thead>
					<tbody>
						@php
							$total_inward= 0;
							$total_outward = 0;
						@endphp
						@if ($get_report)
							@foreach ($get_report as $report)
							<tr>
								@php
									$total_inward = $total_inward + $report->inward_qty;
									$total_outward = $total_outward + $report->outward_qty;
								@endphp
								<td>{{ $report->item_name }}</td>
								<td>{{ $report->inward_qty }}</td>
								<td>{{ $report->outward_qty }}</td>
								<td>{{ $report->inward_qty - $report->outward_qty }}</td>
							</tr>
							@endforeach
							<tr>
							  <td colspan="1"><strong>TOTAL</strong></td>
							  <td><strong>{{ $total_inward }}</strong></td>
							  <td><strong>{{ $total_outward }}</strong></td>
							  <td><strong>{{ $total_inward - $total_outward }}</strong></td>
							</tr>
						@endif
					</tbody>
				</table>
			</div>
		</div>
	</body>
	</html>
