<x-mail::message>
# Hello 


{{ $message }}

Your new password is: {{ $password }}



Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
