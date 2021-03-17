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
				<td>Name: {{ $data{0}->booking_order->user->fullName() }}</td>
			</tr>
			<tr>
				<td>Phone: +91 8623066564</td>
				<td>Phone: {{ $data{0}->booking_order->user->phone }}</td>
			</tr>
			<tr>
				<td>E-Mail: info@redstoneresort.in</td>
				<td>E-Mail: {{ $data{0}->booking_order->user->email }}</td>
			</tr>
		</table>
		<br>
		<table style="table-layout:fixed;" width="100%">
			<thead>
				<tr>
					<th style="text-align: left;">Booking ID</th>
					<th style="text-align: left;">Date</th>
				</tr>
			</thead>
			<tr>
				<td>{{ $data{0}->booking_order_id }}</td>
				<td>{{date('Y-m-d H:i A',strtotime(now()))}}</td>
			</tr>
		</table>
		<br>
		<table style="table-layout:fixed;" class="table" width="100%">
			<thead>
				<tr>
					<th>ROOM</th>
					<th>STATUS</th>
					<th>DAY STAYED</th>
					<th>EXTRA BED</th>
					<th>TIME IN</th>
					<th>TIME OUT</th>
					<th>COST ( &#8377 )</th>
				</tr>
			</thead>

				@php $total_room = 0 @endphp
				@php $total_gst = 0 @endphp
				@php $total_all = 0 @endphp
				@foreach ($data as $record)
				@php $total_room = $total_room + $record->room_cost @endphp
				@php $total_gst = $total_gst + $record->room_gst @endphp
				@php $total_all = $total_all + $record->total_amount @endphp
					<tr>
						<td>
							{{$record->room->name}}
						</td>
						<td>
							{{$record->status->name}}
						</td>
						<td>
							{{$record->day_stayed}}
						</td>
						<td>
							{{$record->extra_bed}}
						</td>
						<td>
							@if ($record->time_in)
								{{date('Y-m-d H:i A',strtotime($record->time_in))}}	
							@else
							nil
							@endif
							
						</td>
						<td>
							@if ($record->time_out)
								{{date('Y-m-d H:i A',strtotime($record->time_out))}}	
							@else
							nil
							@endif
						</td>
						<td>
							{{$record->room_cost}}
						</td>
					</tr>
				@endforeach
				<tr>
					<td colspan="6">
						<strong>TOTAL</strong>
					</td>
					<td>
						<strong>{{number_format($total_room, 2)}}</strong>
					</td>
				</tr>
				<tr>
					<td colspan="6">
						<strong>GST (16%)</strong>
					</td>
					<td>
						<strong>{{number_format($total_gst, 2)}}</strong>
					</td>
				</tr>
				<tr>
					<td colspan="6">
						<strong>TOTAL AMOUNT</strong>
					</td>
					<td>
						<strong>{{number_format($total_all, 2)}}</strong>
					</td>
				</tr>
		</table>
	</body>
	</html>
