{{-- resources/views/emails/password.blade.php --}}

Kliknij tutaj, aby zresetować hasło: <a href="{{ url('password/reset/'.$token) }}">{{ url('password/reset/'.$token)
}}</a>