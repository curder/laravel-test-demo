@component('mail::message')
# Thank you

we will get back to you as soon as possible.

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
