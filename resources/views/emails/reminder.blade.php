@component('mail::message')
# Reminder

Hallo, berikut adalah informasi terkait catatan yang akan expired. Mohon untuk segera di update 

@component('mail::table')
| Nama Catatan | Masa Berlaku | Tanggal expired |
| :------- | :------- | :------- | :-------|
@foreach ($reminders as $r)
| {{ $r->nama}} | <b>From</b> {{ $r->from }} <b>To</b> {{ $r->to }}|{{ $r->tanggal_expired }} |

    
@endforeach
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
