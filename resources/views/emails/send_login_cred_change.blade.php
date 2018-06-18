Witaj {{ $user->name }},<br><br>

Twoje dane do logowania są zmieniane:<br><br>

Użytkownik: {{ $user->email }}<br>
Hasło: {{ $password }}<br><br>

Możesz się zalogować <a href="{{ url('/login') }}">{{ str_replace("http://", "", url('/login')) }}</a>.<br><br>

Powodzenia,

