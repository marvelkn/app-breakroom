@component('mail::message')
# Password Reset

Your password has been reset by an administrator. Here is your new password:

**{{ $newPassword }}**

Please login with this password and change it immediately for security purposes.

@component('mail::button', ['url' => route('login')])
Login Now
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent