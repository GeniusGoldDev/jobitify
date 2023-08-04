<?php
return [
    'section' => [
       'id'     => 'ob_select', 
       'label'  => __('select'), 
       'icon'   => '', 
    ],
    'fields' => [
        [
            'id'            => 'select',
            'type'          => 'select',
            'class'         => '',
            'label_title'   => __('Single select field'),
            'label_desc'    => __('This is the label description you can use here'),
            'field_desc'    => __('This is the field description you can use here'),
            'options'       => [
                'alabama'   => 'Alabama',
                'wyoming'   => 'Wyoming',
                'choice'    => 'Choice',
                'usa'       => 'USA',
                'france'    => 'France',
                'japan'     => 'Japan',
                'itly'      => 'Itly',
                'uae'       => 'UAE',
                'uk'        => 'United kindom',
                'germany'   => 'Germany',
            ],
            'default'       => '',  
            'placeholder'   => __('Select from the list'),  
        ],
        [
            'id'            => 'multiselect',
            'type'          => 'select',
            'class'         => '',
            'multi'         => true,
            'label_title'   => __('Multi Select field'),
            'label_desc'    => __('This is the label description you can use here'),
            'field_desc'    => __('This is the field description you can use here'),
            'options'       => [
                'usa'       => 'USA',
                'france'    => 'France',
                'japan'     => 'Japan',
                'itly'      => 'Itly',
                'uae'       => 'UAE',
                'alabama'   => 'Alabama',
                'wyoming'   => 'Wyoming',
                'choice'    => 'Choice',
                'uk'        => 'United kindom',
                'germany'   => 'Germany',
            ],
            'default'       => ['uk'],  
            'placeholder'   => __('Select from the list'),   
        ]
    ]
];