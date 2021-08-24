<?php

return [

    'database' => [
        'connection' => null,
    ],

    'models' => [
        'redirect' => \Marshmallow\Redirectable\Models\Redirect::class,
    ],

    'types' => [
        \Marshmallow\Pages\Nova\Page::class,
    ],

    'http_codes' => [
        301 => '301 Moved Permanently',
    ],
];
