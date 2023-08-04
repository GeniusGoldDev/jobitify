<?php
return [
    'section' => [
       'id'     => 'ob_textbox', 
       'label'  => __('textbox'), 
       'icon'   => '', 
    ],
    'fields' => [
        [
            'id'            => 'textbox',
            'type'          => 'text',
            'value'         => '',
            'class'         => '',
            'label_title'   => __('Textbox field'),
            'label_desc'    => __('This is the label description you can use here'),
            'field_desc'    => __('This is the field description you can use here'),
            'placeholder'   => __('Textbox placeholder'),
            'hint'     => [
                'content' => __('Hint content about this field!'),
            ],
        ]
    ]
];