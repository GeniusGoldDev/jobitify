<?php
return [
    'section' => [
       'id'     => '_adsense', 
       'label'  => __('sidebar.adsense_settings'), 
       'icon'   => '', 
    ],
    'fields' => [
        [
            'id'            => 'adsense_client_id',
            'type'          => 'text',
            'class'         => '',
            'label_title'   => __('settings.adsense_client_id'),
            'field_desc'   => __('settings.adsense_client_desc'),
            'placeholder'   => __('settings.client_id'),
            'hint'     => [
                'content' => __('settings.adsense_client_desc'),
            ],
        ],
        [
            'id'            => 'seller_dashboard_adsense',
            'type'          => 'textarea',
            'class'         => '',
            'value'         => '',
            'label_title'   => __('settings.add_dashboard_adsense'),
            'label_desc'    => __('settings.dashboard_adsense_desc'),
            'field_desc'    => __('settings.dashboard_adsense_desc'),
        ],
        [
            'id'            => 'profile_adsense_code',
            'type'          => 'textarea',
            'class'         => '',
            'value'         => '',
            'label_title'   => __('settings.add_profile_adsense'),
            'label_desc'    => __('settings.profile_adsense_desc'),
            'field_desc'    => __('settings.profile_adsense_desc'),
        ],
        [
            'id'            => 'project_adsense_code',
            'type'          => 'textarea',
            'class'         => '',
            'value'         => '',
            'label_title'   => __('settings.add_profile_adsense'),
            'label_desc'    => __('settings.project_adsense_desc'),
            'field_desc'    => __('settings.project_adsense_desc'),
        ],
        [
            'id'            => 'add_gig_adsense',
            'type'          => 'textarea',
            'class'         => '',
            'value'         => '',
            'label_title'   => __('settings.add_profile_adsense'),
            'label_desc'    => __('settings.gig_adsense_desc'),
            'field_desc'    => __('settings.gig_adsense_desc'),
        ],
    ]
];