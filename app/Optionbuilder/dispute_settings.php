<?php
return [
    'section' => [
       'id'     => '_dispute', 
       'label'  => __('sidebar.dispute_settings'), 
       'icon'   => '', 
    ],
    'fields' => [
        
        [
            'id'                => 'buyer_dispute_issues',
            'type'              => 'repeater',
            'label_title'       => __('settings.buyer_dispute_issues'),
            'field'             => [
                'id'            => 'buyer_issues',
                'type'          => 'text',
                'value'         => '',
                'class'         => '',
                'placeholder'   => __('settings.enter_issue'),
            ]
        ],
        [
            'id'                => 'seller_dispute_issues',
            'type'              => 'repeater',
            'label_title'       => __('settings.seller_dispute_issues'),
            'field'             => [
                'id'            => 'seller_issues',
                'type'          => 'text',
                'value'         => '',
                'class'         => '',
                'placeholder'   => __('settings.enter_issue'),
            ]
        ],
        [
            'id'            => 'buyer_dispute_after_days',
            'type'          => 'number',
            'value'         => '3',
            'class'         => '',
            'label_title'   => __('settings.set_dispute_days'),
            'field_desc'   => __('settings.set_dispute_days_desc'),
            'placeholder'   => __('settings.dispute_after_placeholder'),
            'hint'     => [
                'content' => __('settings.dispute_after_placeholder'),
            ],
        ],
    ]
];