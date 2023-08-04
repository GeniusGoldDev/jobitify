<?php
$size = setting('_general.image_file_size');
return [
    'section' => [
       'id'     => '_seller', 
       'label'  => __('sidebar.seller_settings'), 
       'icon'   => '', 
    ],
    'fields' => [
        
        [
            'id'            => 'seller_price_search_range',
            'type'          => 'range',
            'label_title'   => __('settings.seller_price_search_range'),
            'options'       =>[
                'min' => 1,
                'max' => 300,
            ]
        ],
        [
            'id'                => 'seller_business_types',
            'type'              => 'repeater',
            'label_title'       => __('settings.seller_business_type'),
            'field'             => [
                'id'            => 'business_types',
                'type'          => 'text',
                'value'         => '',
                'class'         => '',
                'placeholder'   => __('settings.placeholder_business_type'),
            ]
        ],
        [
            'id'            => 'social_links',
            'type'          => 'switch',
            'class'         => '',
            'label_title'   => __('settings.social_links'),
            'field_title'   => __('general.enable'), 
            'field_desc'   => __('settings.social_links_desc'), 
            'value'       => '1',  
        ],
        [
            'id'            => 'min_withdrawal_amt',
            'type'          => 'text',
            'value'         => '100',
            'class'         => '',
            'label_title'   => __('settings.min_withdrawal_amt'),
            'label_desc'   => __('settings.min_withdrawal_amt_desc'),
            'placeholder'   => __('settings.min_withdrawal_amt_placeholder'),
            'hint'     => [
                'content' => __('settings.min_withdrawal_amt_placeholder'),
            ],
        ],
        [
            'id'            => 'seller_banner_img',
            'type'          => 'file',
            'class'         => '',
            'label_title'   => __('settings.default_seller_banner_img'),
            'field_desc'    => __('settings.image_option',['extension'=> 'jpg, png', 'size'=> !empty($size) ? $size.'mb' : '5mb']),
            'max_size'   => !empty($size) ? $size : '5',                  // size in MB
            'ext'    =>[
                'jpg',
                'png',
            ], 
        ],
    ] 
];