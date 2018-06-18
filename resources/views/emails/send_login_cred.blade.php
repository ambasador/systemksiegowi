Drogi {{ $user->name }},<br><br>

Jesteś zarejestrowany {{ url('/') }}.<br><br>

Twoje dane do logowania są takie same, jak poniżej:<br><br>

Użytkownik: {{ $user->email }}<br>
Hasło: {{ $password }}<br><br>

Możesz się zalogować <a href="{{ url('/login') }}">{{ str_replace("http://", "", url('/login')) }}</a>.<br><br>

Z poważaniem,