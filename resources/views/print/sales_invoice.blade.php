	<!DOCTYPE html>
	<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!-- Scripts -->
		<script src="{{ asset('js/app.js') }}" defer></script>
		<link href="{{ asset('css/app.css') }}" rel="stylesheet">
		<title>Print Invoice</title>
	</head>
	<body style="padding: 15px;">
		<table style="table-layout:fixed;" width="100%">
			<tr>
				<td><img src="{{ asset('images/logo.png') }}" alt="Redstone Resort" width="100"></td>
			</tr>
		</table>
			<br>
		<table style="table-layout:fixed;" width="100%">
			<thead>
				<tr>
					<th style="text-align: left;">Hotel Details</th>
					<th style="text-align: left;">Customer Details</th>
				</tr>
			</thead>
			<tr>
				<td>Address: At Post Borgoan Budruk Dhoom Balkavadi Dam Road Tal.Wai Dist Satara</td>
				<td>Name: {{ $data->cus_acct->user->fullName() }}</td>
			</tr>
			<tr>
				<td>Phone: +91 8623066564</td>
				<td>Phone: {{ $data->cus_acct->user->phone }}</td>
			</tr>
			<tr>
				<td>E-Mail: info@redstoneresort.in</td>
				<td>E-Mail: {{ $data->cus_acct->user->email }}</td>
			</tr>
		</table>
		<br>
		<table style="table-layout:fixed;" width="100%">
			<thead>
				<tr>
					<th style="text-align: left;">Invoice ID</th>
					<th style="text-align: left;">Date</th>
				</tr>
			</thead>
			<tr>
				<td>{{ $data->id }}</td>
				<td>{{date('Y-m-d H:i A',strtotime(now()))}}</td>
			</tr>
		</table>
		<br>
		<table style="table-layout:fixed;" class="table" width="100%">
			<thead>
				<tr>
					<th style="text-align: left;">QTY</th>
					<th style="text-align: left;">ITEM</th>
					<th style="text-align: left;">RATE</th>
					<th style="text-align: left;">AMOUNT ( &#8377 )</th>
				</tr>
			</thead>

				{{-- @php $total_all = 0 @endphp --}}
				@foreach ($data->sales_order_items as $record)
					<tr>
						<td>
							{{$record->qty}}
						</td>
						<td>
							{{$record->item->name}}
						</td>
						<td>
							{{$record->item_price}}
						</td>
						<td>
							{{$record->amount}}
						</td>
				@endforeach
				<tr>
					<td>
						<strong>{{number_format($data->total_qty, 2)}}</strong>
					</td>
					<td colspan="2">
						<strong>TOTAL</strong>
					</td>
					<td>
						<strong>{{number_format($data->total_amount, 2)}}</strong>
					</td>
				</tr>
		</table>
	</body>
	</html>
