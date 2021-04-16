	<!DOCTYPE html>
	<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!-- Scripts -->
		<script src="{{ asset('js/app.js') }}" defer></script>
		<link href="{{ asset('css/app.css') }}" rel="stylesheet">
		<style type="text/css">

		  table{ 
		    font-size:0.6em!important;
		    margin-bottom: 0px;
		  }
		  .table-bordered{
		    border-left: none!important;
		    border-bottom: none!important;
		  }
		  .table-bordered > thead > tr > th, .bill-to{
		    background-color: #f8f9fa;
		  }
		  .table-bordered > thead > tr > th,
		  .table-bordered > tbody > tr > th,
		  .table-bordered > tfoot > tr > th,
		  .table-bordered > thead > tr > td,
		  .table-bordered > tbody > tr > td,
		  .table-bordered > tfoot > tr > td {
		    border: none;
		    border-left: 1px solid #ddd;
		    border-bottom: 1px solid #ddd;
		  }
		  /*.table-bordered{border:none!important;}*/
		   
		  .table-bordered > thead > tr > th,
		  .table-bordered > thead > tr > td {
		    border-bottom-width: 1px;
		  }

		  .company-info, .bill-to{
		    border: 1px solid #ddd;
		    padding: 5px 10px;
		    font-family: ProximaNovaLtSemibold,ProximaNovaRegular,Arial,sans-serif;
		  }
		  .company-info p{
		    font-size: .7em;
		  }
		  .bill-to p{
		    margin-bottom: 0;
		    font-weight: bold;
		  }
		</style>
		<title>Print Sales Bill</title>
	</head>
	<body>
		@if (isset($company->invheader))
			<figure style="width: 100%;">
				<img src="{{ asset('storage/images/company/'.$company->invheader) }}" width="100%">
			</figure>
		@endif
		<table class="table table-bordered" cellspacing="0">
		  <tbody>
		    <tr>
		      <td>
		        <p>
		          <strong>Invoice#:</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $get_report{0}->inv_no }}
		        </p>
		        <p>
		         <strong>Invoice Date:</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ date_format($date, 'jS F Y') }}</p> 
		      </td>
		      <td style="padding:10px 50px;">
		        &nbsp; 
		      </td>
		    </tr>
		  </tbody>
		</table> 
		<table class="table table-bordered" cellspacing="0" style="margin-top: -20px;">
		  <thead>
		    <tr style="text-align: left; background-color: #f8f9fa;">
		      <th>BILL TO: {{ $get_report{0}->acct_name }} | {{ $get_report{0}->area }}</th>
		    </tr>
		  </thead>
		</table> 
		<table class="table  table-bordered" cellspacing="0" style="margin-top: -20px;"> 
		 <thead> 
		  <tr style="background-color: #f8f9fa;"> 
		    <th style="text-align: left;">ITEM</th> 
		    <th style="text-align: right;">QTY</th>
		    <th style="text-align: right;">WEIGHT</th>
		    <th style="text-align: right;">RATE</th>
		    <th style="text-align: right;">AMOUNT</th>
		  </tr> 
		 </thead> 
		  <tbody>
		  	@php
		  		$total_qty = 0;
		  		$total_grwt = 0;
		  		$total_amount = 0;
		  		$total_rate = 0;
		  		$total_comm = 0;
		  		$total_levy= 0;
		  		$total_apmc = 0;
		  		$total_final_amount= 0;
		  	@endphp
		    @foreach ($get_report as $bill)
		    	@php
		    		$total_qty = $total_qty + $bill->qty;
		    		$total_grwt = $total_grwt + $bill->grwt;
		    		$total_rate = $total_rate + $bill->rate;
		    		$total_amount = $total_amount + $bill->amount;
		    		$total_comm = $total_comm + $bill->comm;
		    		$total_apmc = $total_apmc + $bill->apmc + $bill->map_levy;
		    		$total_levy = $total_levy + $bill->levy ;
		    		$total_final_amount = $total_final_amount + $bill->final_amount;
		    	@endphp
		    	<tr> 
		    	  <td>{{ $bill->item_name }}</td>
		    	  <td style="text-align: right;">{{ number_format($bill->qty, 2) }}</td>
		    	  <td style="text-align: right;">{{ number_format($bill->grwt, 2) }}</td>
		    	  <td style="text-align: right;">{{ number_format($bill->rate, 2) }}</td>
		    	  <td style="text-align: right;">{{ number_format($bill->amount, 2) }}</td>
		    	</tr>
		    @endforeach
		    <tr>
		    	<td><strong>SUB TOTAL</strong></td>
		    	<td style="text-align: right;"><strong>{{ number_format($total_qty, 2) }}</strong></td>
		    	<td style="text-align: right;"><strong>{{ number_format($total_grwt, 2) }}</strong></td>
		    	<td style="text-align: right;"></td>
		    	<td style="text-align: right;"><strong>{{ number_format($total_amount, 2) }}</strong></td>
		    </tr>
		    <tr>
		      <td colspan="3">Notice Pay within 14 days</td>
		      <td><strong>MF</strong></td>
		      <td style="text-align: right;">{{ number_format($total_apmc, 2) }}</td>
		    </tr>
		    <tr>
		      <td colspan="3">&nbsp;</td>
		      <td><strong>LEVY</strong></td>
		      <td style="text-align: right;">{{ number_format($total_levy, 2) }}</td>
		    </tr>
		    <tr>
		      <td colspan="3">&nbsp;</td>
		      <td><strong>ADAT</strong></td>
		      <td style="text-align: right;">{{ number_format($total_comm, 2) }}</td>
		    </tr>
		    <tr>
		      <td colspan="3">&nbsp;</td>
		      <td><strong>TOTAL</strong></td>
		      <td style="text-align: right;">{{ number_format(round($total_final_amount), 2) }}</td>
		    </tr>
		    <tr>
		      <td colspan="3">&nbsp;</td>
		      <td><strong>PREVIOUS BALANCE</strong></td>
		      <td style="text-align: right;">{{ number_format(round($prev_bal), 2) }}</td>
		    </tr>
		    @php
		    	$total = $prev_bal + $total_final_amount;
		    	$amount_paid_today = $cur_bal;
		    	$new_total = $total - $amount_paid_today;
		    @endphp
		    <tr>
		      <td colspan="3">&nbsp;</td>
		      <td><strong>TOTAL</strong></td>
		      <td style="text-align: right;"><strong>{{ number_format(round($total), 2) }}</strong></td>
		    </tr>
		    <tr>
		      <td colspan="3">Subject to Navi Mumbai Jurisdiction</td>
		      <td><strong>AMOUNT RECEIVED</strong></td>
		      <td style="text-align: right;">{{ number_format(round($amount_paid_today), 2) }}</td>
		    </tr>
		    <tr>
		      <td colspan="3">E. & O. E.</td>
		      <td><strong>TOTAL</strong></td>
		      <td style="text-align: right;"><strong>{{ number_format(round($new_total), 2) }}</strong></td>
		    </tr>
		  </tbody> 
		</table>
		@if (isset($company->invfooter))
			<figure style="width: 100%;">
				<img src="{{ asset('storage/images/company/'.$company->invfooter) }}" width="100%">
			</figure>
		@endif
	</body>
	</html>
