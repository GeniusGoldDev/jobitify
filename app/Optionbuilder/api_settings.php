<?php
return [
    'section' => [
       'id'     => '_api', 
       'label'  => __('sidebar.api_settings'), 
       'icon'   => '', 
    ],
    'fields' => [
        [
            'id'            => 'enable_zipcode',
            'type'          => 'switch',
            'class'         => '',
            'label_title'   => __('settings.add_zipcode'),
            'field_title'   => __('general.enable'), 
            'field_desc'   => __('settings.zipcode_desc'), 
            'value'       => '0',  
        ],
        [
            'id'            => 'google_map_key',
            'type'          => 'text',
            'value'         => '',
            'class'         => '',
            'label_title'   => __('settings.add_map_key'),
            'placeholder'   => __('settings.enter_api_key'),
            'field_desc'    => __('settings.map_key_desc',['get_api_key'=> '<a target="_blank" href="https://developers.google.com/maps/documentation/javascript/get-api-key">'. __("settings.get_api_key").' </a>' ]),
        ]
    ]
];