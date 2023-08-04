<?php
return [
    'section' => [
       'id'     => 'ob_colorpicker', 
       'label'  => __('color picker'), 
       'icon'   => '', 
    ],
    'fields' => [
        [
            'id'            => 'colorpicker',
            'type'          => 'colorpicker',
            'value'         => '',
            'class'         => '',
            'label_title'   => __('Color picker field'),
            'label_desc'    => __('This is the label description you can use here'),
            'field_desc'    => __('This is the field description text you can use here'),
            'placeholder'   => __('Add color code or select'),
        ],
    ]
];