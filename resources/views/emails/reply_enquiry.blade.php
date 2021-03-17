@component('mail::message')
# Thanks {{ $data['name'] }}, for your enquiry

We will get back to you soon...


Thanks,<br>
{{ config('app.name') }}
@endcomponent
