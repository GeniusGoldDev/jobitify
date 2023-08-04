<?php
return [
    'section' => [
       'id'     => '_proposal', 
       'label'  => __('sidebar.proposal_settings'), 
       'icon'   => '', 
    ],
    'fields' => [
        [
            'id'            => 'proposal_default_status',
            'type'          => 'select',
            'class'         => '',
            'label_title'   => __('settings.proposal_default_status'),
            'field_desc'   => __('settings.proposal_default_status_desc'),
            'options'       => [
                'publish'       => __('settings.prop_auto_appr_opt'),
                'pending'       => __('settings.prop_pending_opt'),
            ],
            'placeholder'   => __('settings.select_option'),  
        ],
    ]
];