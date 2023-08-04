<?php
$size = setting('_general.image_file_size');

return [
    'section' => [
       'id'     => '_site', 
       'label'  => __('sidebar.site_settings'), 
       'icon'   => '', 
    ],
    'fields' => [
        [
            'id'            => 'rtl',
            'type'          => 'switch',
            'class'         => '',
            'label_title'   => __('settings.rtl_label'),
            'field_title'   => __('general.enable'), 
            'field_desc'    => __('settings.rtl_desc'), 
            'value'         => '1',
        ],
        [
            'id'            => 'site_name',
            'type'          => 'text',
            'value'         => '',
            'class'         => '',
            'label_title'   => __('settings.site_title'),
            'placeholder'   => __('settings.site_title_placeholder'),
            'hint'     => [
                'content' => __('settings.site_title_placeholder'),
            ],
        ],
        [
            'id'            => 'site_favicon',
            'type'          => 'file',
            'class'         => '',
            'label_title'   => __('settings.site_favicon'),
            'field_desc'    => __('settings.image_option',['extension'=> 'jpg, png', 'size'=> !empty($size) ? $size.'mb' : '5mb']),
            'max_size'   => !empty($size) ? $size : '5',                  // size in MB
            'ext'    =>[
                'jpg',
                'png',
            ], 
        ],
        [
            'id'            => 'site_dark_logo',
            'type'          => 'file',
            'class'         => '',
            'label_title'   => __('settings.site_dark_logo'),
            'field_desc'    => __('settings.image_option',['extension'=> 'jpg, png', 'size'=> !empty($size) ? $size.'mb' : '5mb']),
            'max_size'   => !empty($size) ? $size : '5',                  // size in MB
            'ext'    =>[
                'jpg',
                'png',
            ], 
        ],
        [
            'id'            => 'site_lite_logo',
            'type'          => 'file',
            'class'         => '',
            'label_title'   => __('settings.site_lite_logo'),
            'field_desc'    => __('settings.image_option',['extension'=> 'jpg, png', 'size'=> !empty($size) ? $size.'mb' : '5mb']),
            'max_size'   => !empty($size) ? $size : '5',                  // size in MB
            'ext'    =>[
                'jpg',
                'png',
            ], 
        ],
        [
            'id'            => 'auth_bg',
            'type'          => 'file',
            'class'         => '',
            'label_title'   => __('settings.auth_pages_bg'),
            'label_desc'   => __('settings.auth_pages_desc'),
            'field_desc'    => __('settings.image_option',['extension'=> 'jpg, png', 'size'=> !empty($size) ? $size.'mb' : '5mb']),
            'max_size'   => !empty($size) ? $size : '5',                  // size in MB
            'ext'    =>[
                'jpg',
                'png',
            ], 
        ],
    ]
];