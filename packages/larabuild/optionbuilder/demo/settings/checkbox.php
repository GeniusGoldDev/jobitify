<?php
return [
    'section' => [
       'id'     => 'ob_checkbox', 
       'label'  => __('checkbox'), 
       'icon'   => '', 
    ],
    'fields' => [
        [
            'id'                    => 'checkbox',
            'type'                  => 'checkbox',
            'class'                 => '',
            'label_title'           => __('Single checkbox field'),
            'label_desc'            => __('This is the label description you can use here'),
            'field_desc'            => __('This is the field description you can use here'),
            'field_title'           => __('Checkbox single'), 
            'value'                 => '1', 
        ],
        [
            'id'            => 'multicheckbox_id',
            'type'          => 'checkbox',
            'class'         => '',
            'label_title'   => __('Multiple checkbox field'),
            'label_desc'    => __('This is the label description you can use here'),
            'options'       => [
                '1' => __('Option 1'),
                '2' => __('Option 2'),
                '3' => __('Option 3'),
                '4' => __('Option 4'),
                '5' => __('Option 5'),
                '6' => __('Option 6'),
            ],
            'default'       => [1,6],  
        ]
    ]
];