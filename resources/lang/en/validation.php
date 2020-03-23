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

    'accepted'             => ':attribute debe ser aceptado.',
    'active_url'           => 'El campo :attribute no es una URL válida.',
    'after'                => 'El campo :attribute debe ser una fecha posterior a :date.',
    'after_or_equal'       => 'El campo :attribute debe ser una fecha posterior o igual a :date.',
    'alpha'                => 'El campo :attribute debe contener solo letras.',
    'alpha_dash'           => 'El campo :attribute debe contener solo letras números y guiones.',
    'alpha_num'            => 'El campo :attribute debe contenterdebe contenter letras y números.',
    'array'                => 'El campo :attribute debe ser un array.',
    'before'               => 'El campo :attribute debe ser una fecha anterior a :date.',
    'before_or_equal'      => 'El campo :attribute debe ser una fecha anterior o igual a :date.',
    'between'              => [
        'numeric' => 'El campo :attribute debe estar entre :min y :max.',
        'file'    => 'El campo :attribute ebe estar entre :min y :max kilobytes.',
        'string'  => 'El campo :attribute ebe estar entre :min y :max carácteres.',
        'array'   => 'El campo :attribute debe tener entre :min y :max elementos.',
    ],
    'boolean'              => 'El campo :attribute debe ser verdadero o falso.',
    'confirmed'            => 'El campo :attribute confirmación no coincide.',
    'date'                 => 'El campo :attribute no es una fecha válida.',
    'date_format'          => 'El campo :attribute does not match the format :format.',
    'different'            => 'El campo :attribute y :other deben ser diferentes.',
    'digits'               => 'El campo :attribute debe ser de :digits dígitos.',
    'digits_between'       => 'El campo :attribute debe estar entre :min y :max dígitos.',
    'dimensions'           => 'El campo :attribute tiene dimensiones de tamaño inválidas.',
    'distinct'             => 'El campo :attribute tiene un valor duplicado.',
    'email'                => 'El campo :attribute debe ser una dirección de correo válida.',
    'exists'               => 'El campo :attribute no es válido.',
    'file'                 => 'El campo :attribute debe ser un archivo.',
    'filled'               => 'El campo :attribute es obligatorio.',
    'image'                => 'El campo :attribute debe ser una imagen.',
    'in'                   => 'El campo :attribute no es válido',
    'in_array'             => 'El campo :attribute no existe en :other.',
    'integer'              => 'El campo :attribute debe ser un entero.',
    'ip'                   => 'El campo :attribute debe ser una dirección IP válida.',
    'ipv4'                 => 'El campo :attribute debe ser una dirección IPv4 válida.',
    'ipv6'                 => 'El campo :attribute debe ser una dirección IPv6 válida.',
    'json'                 => 'El campo :attribute debe ser una cadena JSON válida.',
    'max'                  => [
        'numeric' => 'El campo :attribute no debe ser mayor que :max.',
        'file'    => 'El campo :attribute no debe ser mayor que :max kilobytes.',
        'string'  => 'El campo :attribute no debe ser mayor que :max carácteres.',
        'array'   => 'El campo :attribute no debe contener más de :max elementos.',
    ],
    'mimes'                => 'El campo :attribute debe ser un archivo del tipo: :values.',
    'mimetypes'            => 'El campo :attribute debe ser un archivo de tipo: :values.',
    'min'                  => [
        'numeric' => 'El campo :attribute debe ser de al menos :min.',
        'file'    => 'El campo :attribute debe ser de al menos :min kilobytes.',
        'string'  => 'El campo :attribute debe ser de al menos :min carácteres.',
        'array'   => 'El campo :attribute debe tener al menos :min elementos.',
    ],
    'not_in'               => 'El campo selected :attribute no es válido.',
    'not_regex'            => 'El formato del campo :attribute es inválido.',
    'numeric'              => 'El campo :attribute debe ser un número.',
    'present'              => 'El campo :attribute debe estar presente.',
    'regex'                => 'El formatp del campo :attribute no es válido.',
    'required'             => 'El campo :attribute es obligatorio.',
    'required_if'          => 'El campo :attribute es obligatorio cuando :other es :value.',
    'required_unless'      => 'El campo :attribute es obligatorio a menos que :other esté en :values.',
    'required_with'        => 'El campo :attribute es obligatorio cuando :values está presente.',
    'required_with_all'    => 'El campo :attribute es obligatorio cuando :values está presente.',
    'required_without'     => 'El campo :attribute es obligatorio cuando :values no está presente.',
    'required_without_all' => 'El campo :attribute es obligatorio cuando ninguno de :values está presente.',
    'same'                 => 'Los campos :attribute y :other deben coincidir.',
    'size'                 => [
        'numeric' => 'El campo :attribute debe ser de :size.',
        'file'    => 'El campo :attribute debe ser de :size kilobytes.',
        'string'  => 'El campo :attribute debe ser de :size carácteres.',
        'array'   => 'El campo :attribute debe contenter :size elementos.',
    ],
    'string'               => 'El campo :attribute debe ser una cadena de texto.',
    'timezone'             => 'El campo :attribute debe ser una zona válida.',
    'unique'               => 'El campo :attribute debe ser único.',
    'uploaded'             => 'El campo :attribute fallo al subir.',
    'url'                  => 'El campo :attribute tiene un formato no válido.',

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
