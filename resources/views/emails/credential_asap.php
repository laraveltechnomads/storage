@component('mail::message')
# Introduction

<p><b>Dear {{ $f_name . ' ' .$l_name }}</b></p>

{{--  The body of your message.  --}}
<h3>{{ $title }}</h3>
<h3>{{ $body }}</h3>

<p>Thanks,</p><br>
{{ config('app.name') }}
@endcomponent