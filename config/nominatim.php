<?php

return [
    'url' => env('NOMINATIM_URL', 'http://nominatim.openstreetmap.org/'),
    'format' => 'jsonv2',

    'details' => [
        'include_address_details' => true,
        'include_extra_tags' => true,
        'include_name_details' => true,
    ],

    'polygon' => [
        'include_polygon' => true,
        'polygon_type' => 'svg',
    ],

    'email' => [
        'include_email' => true,
        'include_email_type' => 'default',

        'default_email' => env('NOMINATIM_DEFAULT_EMAIL', ''),
        'auth_email_field' => 'email',
    ],
];
