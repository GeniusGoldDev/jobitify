<?php
return [
    'section' => [
       'id'     => 'ob_radio', 
       'label'  => __('radio'), 
       'icon'   => '', 
    ],
    'fields' => [
        [
            'id'            => 'gender',
            'type'          => 'radio',
            'class'         => '',
            'label_title'   => __('Radio button field'),
            'label_desc'    => __('This is the label description you can use here'),
            'field_desc'    => __('This is the field description you can use here'),
            'options'       => [
                'male'  => __('Male'),
                'femle' => __('Female'),
            ],
            'default'       => 'male',  
        ],
    ]
];