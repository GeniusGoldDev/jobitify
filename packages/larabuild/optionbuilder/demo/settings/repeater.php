<?php
return [
    'section' => [
       'id'     => 'ob_repeator', 
       'label'  => __('repeator'), 
       'icon'   => '', 
    ],
    'fields' => [
        [
            'id'                => 'single_repeator',
            'type'              => 'repeater',
            'label_title'       => __('Single field repeator'),
            'label_desc'        => __('This is the repeator description you can use here'),
            'field'             => [
                'id'            => 'textbox_id',
                'type'          => 'text',
                'value'         => '',
                'class'         => '',
                'label_title'   => __('Textbox repeator'),
                'label_desc'    => __('This is the label description you can use here'),
                'field_desc'    => __('This is the field description you can use here'),
                'placeholder'   => __('Textbox placeholder'),
            ]
        ],
        [
            'id'                => 'multi_repeator',
            'type'              => 'repeater',
            'label_title'       => __('Multiple fields repeator'),
            'label_desc'        => __('This is the label description you can use here'),
            'repeater_title'    => __('Multi repeater title'),
            'multi'       => true,
            'fields'       =>[
                [
                    'id'            => 'repeator_textbox_id',
                    'type'          => 'text',
                    'value'         => '',
                    'class'         => '',
                    'label_title'   => __('Textbox in repeator'),
                    'label_desc'    => __('This is the label description you can use here'),
                    'field_desc'    => __('This is the field description you can use here'),
                    'placeholder'   => __('Textbox placeholder'),
                ],
                [
                    'id'            => 'repeator_textarea_id',
                    'type'          => 'textarea',
                    'class'         => '',
                    'value'         => '',
                    'label_title'   => __('Textarea'),
                    'label_desc'    => __('This is the label description you can use here'),
                    'field_desc'    => __('This is the field description you can use here'),
                ],
                [
                    'id'            => 'repeator_file_uploader',
                    'type'          => 'file',
                    'class'         => '',
                    'label_title'   => __('File uploader'),
                    'label_desc'    => __('This is the file description you can use here'),
                    'field_desc'    => __('This is the file uploader description text you can use here'),
                    'multi'       => true,
                    'max_size'   => 4,                  // size in MB
                    'ext'    =>[
                        'jpg',
                        'png',
                        'pdf',
                        'doc',
                        'xlsx',
                        'ppt',
                    ], 
                ]
            ],
        ],
    ]
];