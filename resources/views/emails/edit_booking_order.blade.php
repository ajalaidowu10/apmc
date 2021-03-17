@component('mail::message')
# Edit Booking
## Name: {{ $data->user->fullName() }}
## Email: {{ $data->user->email }}
## Booking ID: {{ $data->id }}

{{ $data->message }}


Thanks,<br>
{{ config('app.name') }}
@endcomponent
