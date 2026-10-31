<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Meta Data
    |--------------------------------------------------------------------------
    |
    |
    */

    'meta_data' => [
        'full_name' => env('APP_FULL_NAME', 'Orientamento Formativo'),
        'description' => env('APP_DESCRIPTION', 'Iprase'),
        'short_description' => env('APP_SHORT_DESCRIPTION', 'Formazione per studenti delle scuole medie e superiori'),
        'default_color_scheme' => env('APP_DEFAULT_COLOR_SCHEME', 'light'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Header navigation Links
    |--------------------------------------------------------------------------
    |
    | The header navigation links are used to generate the header navigation
    | Header Navigation Item Interface: [
    |	'label' => string,
    |	'url' => string,
    |	'location_tag' => ?string,
    |	'auth' => ?boolean,
    |	'admin_only' => ?boolean,
    | ]
    |
    */

    'navigation' => [
        'header' => [
            ['label' => 'Home', 'route' => 'home', 'main_route' => 'home'],
        ],

        'footer' => [
            ['label' => 'Home', 'route' => 'home', 'main_route' => 'home'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Footer navigation Links
    |--------------------------------------------------------------------------
    |
    | The footer navigation links are used to generate the footer navigation
    | Footer Navigation Interface: [
        'column_name':string =>
    |		[
    |			'label' => string,
    |			'url' => string,
    |			'social_media' => ?string,
    |			'icon' => ?boolean,
    | 		]
    |	...
    | ]
    |
    */

    /*
    |--------------------------------------------------------------------------
    | Contacts
    |--------------------------------------------------------------------------
    */

    'contacts' => [
        'web' => ['url' => 'https://www.iprase.tn.it', 'label' => 'Sito Iprase'],
        'instagram' => ['url' => 'https://www.instagram.com/iprasetrentino/', 'label' => '@iprasetrentino'],
        // 'twitter' => ['url' => 'https://x.com/IpraseTrentino', 'label' => '@iprasetrentino',],
        'email' => ['url' => 'mailto:iprase@iprase.tn.it', 'label' => 'iprase@iprase.tn.it'],
        'facebook' => ['url' => 'https://www.facebook.com/IpraseTrentino/', 'label' => '@IpraseTrentino'],
        // 'whatsapp' => ['url' => 'https://wa.me/000000000', 'label' => '000 000000',],
        'phone' => ['url' => 'tel:+390461494399', 'label' => '+39 0461 494399'],
    ],

    'under_construction_whitelist' => [
        'studente.test@iprase.tn.it',
        // 'docente.test@iprase.tn.it',
    ],
];
