@component('mail::message')
# Enquiry

## Name: {{ $data['name'] }}
## Email: {{ $data['email'] }}
## Subject: {{ $data['subject'] }}
@if ($data['phone'])
## Phone: {{ $data['phone'] }}
@endif
<br>

@component('mail::panel')
	{{ $data['message'] }}
@endcomponent

@endcomponent
