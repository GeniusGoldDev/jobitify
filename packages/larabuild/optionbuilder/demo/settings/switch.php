<?php
return [
    'section' => [
       'id'     => 'ob_switch', 
       'label'  => __('switch'), 
       'icon'   => '', 
    ],
    'fields' => [
        [
            'id'            => 'switch',
            'type'          => 'switch',
            'class'         => '',
            'label_title'   => __('Single switch field'),
            'label_desc'    => __('This is the label description you can use here'),
            'field_title'   => __('Single switch title'), 
            'field_desc'    => __('This is the field description you can use here'), 
            'value'         => '1',  
        ],
        [
            'id'            => 'multiswitch',
            'type'          => 'switch',
            'class'         => '',
            'label_title'   => __('Multiple switch field'),
            'label_desc'    => __('This is the label description you can use here'),
            'field_desc'    => __('This is the field description you can use here'), 
            'options'       => [
                '1' => __('Switch opt 1'),
                '2' => __('Switch opt 2'),
                '3' => __('Switch opt 3'),
                '4' => __('Switch opt 4'),
                '5' => __('Switch opt 5'),
                '6' => __('Switch opt 6'),
            ],
            'default'       => [2,6,4],  
        ],
    ]
];