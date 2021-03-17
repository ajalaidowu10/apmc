@component('mail::message')
# Booking Blocked
##Booking ID: {{ $data->id }}

Hi, {{ $data->user->fullName() }}
<br>

@component('mail::panel')
	Thank you for booking.
	Here are the details of your booking.
@endcomponent

@component('mail::table')
| Booking       		| Details     |     
| ------------- 		|-------------|
| CHECKIN       		| {{ $data->date_from }}  		 | 
| CHECKOUT      		| {{ $data->date_to }}    		 |
| NUMBER OF NIGHT   | {{ $data->num_of_night }} 	 |
| TOTAL ROOMS       | {{ $data->total_room }} 		 |
| TOTAL EXTRA BED   | {{ $data->total_extra_bed }} |

| Payment Details      	| Amount (&#8377;) |      
| ------------- 		|-------------|
| {{ $data->total_room }} Rooms   {{ $data->room_price }} / Per Night					| {{ $data->total_room_amount }}  	 | 
| {{ $data->total_extra_bed }} Extra Beds  {{ $data->extra_bed_price }} / Per Night     | {{ $data->total_extra_bed_amount }}|
| TOTAL ROOM COST      																    | {{ $data->total_room_cost }} 		 |
| Other Charges   																		| {{ $data->other_charge }} 	 	 |
| TOTAL   																				| {{ $data->total_amount }}    		 |

@endcomponent

@component('mail::panel')
	Kindly note that this booking is blocked untill payment is confirmed.
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
