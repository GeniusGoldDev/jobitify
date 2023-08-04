<?php
$size = setting('_general.image_file_size');

return [
    'section' => [
       'id'     => '_email', 
       'label'  => __('sidebar.email_settings'), 
       'icon'   => '', 
    ],
    'fields' => [
        [
            'id'            => 'email_logo',
            'type'          => 'file',
            'class'         => '',
            'label_title'   => __('settings.logo'),
            'field_desc'    => __('settings.image_option',['extension'=> 'jpg, png', 'size'=> !empty($size) ? $size.'mb' : '5mb']),
            'max_size'   => !empty($size) ? $size : '5',                  // size in MB
            'ext'    =>[
                'jpg',
                'png',
            ], 
        ],
        [
            'id'            => 'sender_name',
            'type'          => 'text',
            'value'         => '',
            'class'         => '',
            'label_title'   => __('settings.sender_name'),
            'field_desc'   => __('settings.sender_name_desc'),
            'placeholder'   => __('settings.sender_name'),
            'hint'     => [
                'content' => __('settings.sender_name'),
            ],
        ],
        [
            'id'            => 'sender_email',
            'type'          => 'text',
            'value'         => '',
            'class'         => '',
            'label_title'   => __('settings.sender_email'),
            'field_desc'   => __('settings.sender_email_desc'),
            'placeholder'   => __('settings.sender_email'),
            'hint'     => [
                'content' => __('settings.sender_email'),
            ],
        ],
        [
            'id'            => 'footer_text',
            'type'          => 'text',
            'value'         => '',
            'class'         => '',
            'label_title'   => __('settings.footer_text'),
            'field_desc'   => __('settings.footer_text_desc'),
            'placeholder'   => __('settings.footer_text'),
            'hint'     => [
                'content' => __('settings.footer_text'),
            ],
        ],
        [
            'id'            => 'sender_signature',
            'type'          => 'textarea',
            'value'         => '',
            'class'         => '',
            'label_title'   => __('settings.sender_signature'),
            'field_desc'   => __('settings.sender_signature_desc',['app_name'=> env('APP_NAME')]),
            'placeholder'   => __('settings.sender_signature'),
        ],
    ]
];