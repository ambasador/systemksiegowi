<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => 'Atrybut: musi zostać zaakceptowany.',
    'active_url'           => 'Atrybut: atrybut nie jest prawidłowym adresem URL.',
    'after'                => 'Atrybut: atrybut musi być datą po :date.',
    'alpha'                => 'Atrybut: może zawierać tylko litery.',
    'alpha_dash'           => 'Atrybut: może zawierać tylko litery, liczby i myślniki.',
    'alpha_num'            => 'Atrybut: może zawierać tylko litery i cyfry.',
    'array'                => 'Atrybut: atrybut musi być tablicą.',
    'before'               => 'Atrybut: atrybut musi być datą przed  :date.',
    'between'              => [
        'numeric' => 'Atrybut: musi mieścić się między :min a :max.',
        'file'    => 'Atrybut: musi mieścić się między :min i :max kilobajty.',
        'string'  => 'Atrybut: musi mieścić się między :min i :max znaków.',
        'array'   => 'Atrybut: musi zawierać między :min i :max',
    ],
    'boolean'              => 'Pole atrybutu: musi być prawdziwe lub fałszywe.',
    'confirmed'            => 'Potwierdzenie atrybutu: nie zgadza się.',
    'date'                 => 'Atrybut: atrybut nie jest ważną datą.',
    'date_format'          => 'Atrybut: nie jest zgodny z formatem :format.',
    'different'            => 'Atrybut :other musi być inny.',
    'digits'               => 'Atrybut: musi być :digits cyfrą.',
    'digits_between'       => 'Atrybut: musi mieścić się między :min i :max cyfr.',
    'distinct'             => 'Pole: atrybut ma podwójną wartość.',
    'email'                => 'Atrybut: atrybut musi być prawidłowym adresem e-mail.',
    'exists'               => 'Wybrany :attribute jest nieprawidłowy.',
    'filled'               => 'Wymagane jest pole :attribute.',
    'image'                => 'Atrybut :attribute musi być obrazem.',
    'in'                   => 'Wybrany :attribute jest nieprawidłowy.',
    'in_array'             => 'Pole :attribute nie istnieje w :other.',
    'integer'              => 'Atrybut :attribute musi być liczbą całkowitą.',
    'ip'                   => 'Atrybut :attribute musi być prawidłowym adresem IP.',
    'json'                 => 'Atrybut :attribute musi być prawidłowym ciągiem JSON.',
    'max'                  => [
        'numeric' => 'Atrybut :attribute nie może być większy niż: max.',
        'file'    => 'Atrybut :attribute nie może być większy niż :max. Kilobajty.',
        'string'  => 'Atrybut :attribute nie może być większy niż :max.',
        'array'   => 'Atrybut :attribute nie może zawierać więcej niż :max elementów.',
    ],
    'mimes'                => 'Atrybut :attribute musi być plikiem typu: :values.',
    'min'                  => [
        'numeric' => 'Atrybut :attribute musi wynosić co najmniej: min.',
        'file'    => 'Atrybut :attribute musi wynosić co najmniej :min kilobajty.',
        'string'  => 'Atrybut :attribute musi zawierać co najmniej :min znaków.',
        'array'   => 'Atrybut :attribute musi zawierać co najmniej :min pozycji.',
    ],
    'not_in'               => 'Wybrany :attribute jest nieprawidłowy.',
    'numeric'              => 'Atrybut :attribute musi być liczbą.',
    'present'              => 'Pole :attribute musi być obecne.',
    'regex'                => 'Format :attribute jest nieprawidłowy.',
    'required'             => 'Wymagane jest pole :attribute.',
    'required_if'          => 'Pole :attribute jest wymagane, gdy :other jest :value.',
    'required_unless'      => 'Pole :attribute wymagane jest, chyba że :other są w :values.',
    'required_with'        => 'Pole :attribute jest wymagane, gdy :values są obecne.',
    'required_with_all'    => 'Pole :attribute jest wymagane, gdy: :values są obecne.',
    'required_without'     => 'Pole :attribute jest wymagane, gdy :values nie są obecne.',
    'required_without_all' => 'Pole :attribute jest wymagane, gdy żadna z :values nie jest obecna.',
    'same'                 => ':attribute i :other musi się zgadzać.',
    'size'                 => [
        'numeric' => 'Atrybut :attribute musi obejmować :size.',
        'file'    => ':attribute musi mieć :size kilobajty.',
        'string'  => ':attribute musi być :size wielkości.',
        'array'   => ':attribute musi zawierać :size rozmiaru.',
    ],
    'string'               => 'Atrybut :attribute musi być ciągiem.',
    'timezone'             => 'Atrybut :attribute musi być poprawną strefą.',
    'unique'               => 'Atrybut :attribute został już podany.',
    'url'                  => 'Format :attribute jest nieprawidłowy.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [],

];
