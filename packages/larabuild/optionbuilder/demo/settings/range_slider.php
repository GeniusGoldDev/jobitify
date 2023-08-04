<?php
return [
    'section' => [
       'id'     => 'ob_ranger_slider', 
       'label'  => __('range slider'), 
       'icon'   => '', 
    ],
    'fields' => [
        [
            'id'            => 'ranger_slider',
            'type'          => 'range',
            'label_title'   => __('Textbox field'),
            'label_desc'    => __('This is the label description you can use here'),
            'options'       =>[
                'min'       => 100,
                'max'       => 500,
                'format'    => 'number',    // number/decimal
            ]
        ]
    ]
];