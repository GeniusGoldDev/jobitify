<?php
return [
    'section' => [
       'id'     => 'tab_editor', 
       'label'  => __('text editor'), 
       'icon'   => '', 
    ],
    'fields' => [
        [
            'id'            => 'texteditor',
            'type'          => 'editor',
            'class'         => '',
            'label_title'   => __('Text editor'),
            'label_desc'    => __('This is the label description you can use here'),
            'field_desc'    => __('This is the editor description text you can use here'),
        ],
    ]
];