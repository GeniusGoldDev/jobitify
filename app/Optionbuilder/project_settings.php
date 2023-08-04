<?php
return [
    'section' => [
       'id'     => '_project', 
       'label'  => __('sidebar.project_settings'), 
       'icon'   => '', 
    ],
    'fields' => [
        [
            'id'            => 'project_price_search_range',
            'type'          => 'range',
            'label_title'   => __('settings.project_price_search_range'),
            'options'       =>[
                'min' => 1,
                'max' => 100000
            ]
        ],
        [
            'id'            => 'projet_min_amount',
            'type'          => 'number',
            'value'         => '100',
            'class'         => '',
            'label_title'   => __('settings.projet_min_amount'),
            'field_desc'   => __('settings.projet_min_amount_desc'),
            'placeholder'   => __('settings.projet_min_amount'),
            'hint'     => [
                'content' => __('settings.projet_min_amount'),
            ],
        ],
        [
            'id'            => 'maximum_freelancer',
            'type'          => 'number',
            'value'         => '10',
            'class'         => '',
            'label_title'   => __('settings.maximum_freelancer'),
            'field_desc'   => __('settings.maximum_freelancer_desc'),
            'placeholder'   => __('settings.maximum_freelancer'),
            'hint'     => [
                'content' => __('settings.maximum_freelancer'),
            ],
        ],
        [
            'id'            => 'project_default_status',
            'type'          => 'select',
            'class'         => '',
            'label_title'   => __('settings.project_default_status'),
            'field_desc'   => __('settings.project_default_status_desc'),
            'options'       => [
                'publish'       => __('settings.publish'),
                'pending'       => __('settings.pending'),
            ],
            'placeholder'   => __('settings.select_option'),  
        ],
        [
            'id'            => 'step2_validation',
            'type'          => 'select',
            'class'         => '',
            'multi'         => true,
            'label_title'   => __('settings.step2_validation'),
            'field_desc'   => __('settings.step2_validation_desc'),
            'options'       => [
                'duration'      => __('settings.step2_duration_opt'),
                'category'        => __('settings.step2_category_opt'),
                'project_detail'  => __('settings.step2_project_detail_opt'),
            ],
            'default'   =>['duration', 'project_detail', 'category'],
            'placeholder'   => __('settings.select_option'),  
        ],
        [
            'id'            => 'step3_validation',
            'type'          => 'select',
            'class'         => '',
            'multi'         => true,
            'label_title'   => __('settings.step3_validation'),
            'field_desc'   => __('settings.step3_validation_desc'),
            'options'       => [
                'expertlevel'     => __('settings.step3_expert_level_opt'),
                'skills'        => __('settings.step3_skills_opt'),
                'languages'        => __('settings.step3_languages_opt'),
            ],
            'default'   =>['languages', 'expertlevel', 'skills'],
            'placeholder'   => __('settings.select_option'),  
        ],
        [
            'id'            => 'project_recomended_freelancer_opt',
            'type'          => 'select',
            'class'         => '',
            'multi'         => true,
            'label_title'   => __('settings.recommended_opt'),
            'field_desc'   => __('settings.recommended_opt_desc'),
            'options'       => [
                'languages'     => __('settings.rec_options_skill'),
                'skills'        => __('settings.rec_options_lang'),
            ],
            'default'   =>['languages', 'skills'],
            'placeholder'   => __('settings.select_option'),  
        ],
    ]
];