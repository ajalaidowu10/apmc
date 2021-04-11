	<!DOCTYPE html>
	<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!-- Scripts -->
		<script src="{{ asset('js/app.js') }}" defer></script>
		<link href="{{ asset('css/app.css') }}" rel="stylesheet">
		<title>Print Receipt</title>
	</head>
	<body style="padding-top: 15px; padding-left: 50px;">
		<div style="width: 500px">
			<table style="table-layout:fixed;">
				<tr>
					<td width="100"><img src="{{ asset('images/logo.png') }}" alt="Redstone Resort" width="100"></td>
					<td width="400">
						At Post Borgoan Budruk Dhoom Balkavadi Dam Road Tal.Wai Dist Satara. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Phone: +91 8623066564, E-Mail: info@redstoneresort.in
					</td>
				</tr>
				<tr>
					<td colspan="2" style="text-align: center;"><strong>{{ $data->cashbank_order->cashbank_type->name }}</strong></td>
				</tr>
			</table>
			<div style="border:2px solid #ECEFF1;">
				<table style="table-layout:fixed;" class="table">
					<tr>
						<td><strong>Date:</strong> {{ $data->cashbank_order->enter_date  }}</td>
							@if ($data->cashbank_order->cashbank_type_id == 1)
								<td><strong>Received From: </strong> {{ $data->acct_two->name  }}</td>
							@else
								<td><strong>Payment To: </strong> {{ $data->acct_two->name  }}</td>
							@endif
					</tr>
					<tr>
						<td><strong>Tel:</strong> {{ $data->acct_two->phone  }}</td>
						<td><strong>Payment Method:</strong> {{ $data->cashbank_order->payment_type->name  }}</td>
					</tr>
					<tr>
						<td colspan="2"><strong>The Sum of:</strong> {{ $data->amountInWords  }}</td>
					</tr>
					<tr>
						<td colspan="2"><strong>Narration:</strong> {{ $data->descp  }}</td>
					</tr>
					<tr>
						<td><strong>Amount Paid:</strong>&#8377 {{ $data->amount  }}</td>
						<td><strong>Receiver Signature:</td>
					</tr>
				</table>
			</div>
		</div>
			<br>
		<div style="width: 500px">
			<table style="table-layout:fixed;">
				<tr>
					<td width="100"><img src="{{ asset('images/logo.png') }}" alt="Redstone Resort" width="100"></td>
					<td width="400">
						At Post Borgoan Budruk Dhoom Balkavadi Dam Road Tal.Wai Dist Satara. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Phone: +91 8623066564, E-Mail: info@redstoneresort.in
					</td>
				</tr>
				<tr>
					<td colspan="2" style="text-align: center;"><strong>{{ $data->cashbank_order->cashbank_type->name }}</strong></td>
				</tr>
			</table>
			<div style="border:2px solid #ECEFF1;">
				<table style="table-layout:fixed;" class="table">
					<tr>
						<td><strong>Date:</strong> {{ $data->cashbank_order->enter_date  }}</td>
							@if ($data->cashbank_order->cashbank_type_id == 1)
								<td><strong>Received From: </strong> {{ $data->acct_two->name  }}</td>
							@else
								<td><strong>Payment To: </strong> {{ $data->acct_two->name  }}</td>
							@endif
					</tr>
					<tr>
						<td><strong>Tel:</strong> {{ $data->acct_two->phone  }}</td>
						<td><strong>Payment Method:</strong> {{ $data->cashbank_order->payment_type->name  }}</td>
					</tr>
					<tr>
						<td colspan="2"><strong>The Sum of:</strong> {{ $data->amountInWords  }}</td>
					</tr>
					<tr>
						<td colspan="2"><strong>Narration:</strong> {{ $data->descp  }}</td>
					</tr>
					<tr>
						<td><strong>Amount Paid:</strong>&#8377 {{ $data->amount  }}</td>
						<td><strong>Receiver Signature:</td>
					</tr>
				</table>
			</div>
		</div>
			<br>
		
	</body>
	</html>
