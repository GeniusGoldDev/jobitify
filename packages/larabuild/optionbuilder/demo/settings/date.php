<?php
return [
    'section' => [
       'id'     => 'ob_datepicker', 
       'label'  => __('date picker'), 
       'icon'   => '', 
    ],
    'fields' => [
        [
            'id'            => 'datepicker',
            'type'          => 'datepicker',
            'value'         => '',
            'class'         => '',
            'label_title'   => __('Date picker field'),
            'label_desc'    => __('This is the label description you can use here'),
            'field_desc'    => __('This is the field description you can use here'),
            'placeholder'   => __('Select date'),
            'format'        => 'Y-m-d',
        ],
        [
            'id'            => 'datepicker_time',
            'type'          => 'datepicker',
            'value'         => '',
            'class'         => '',
            'label_title'   => __('Date time field'),
            'label_desc'    => __('This is the label description you can use here'),
            'field_desc'    => __('This is the field description you can use here'),
            'placeholder'   => __('Select date time'),
            'format'        => 'Y-m-d H:i:s',
            'time'    =>[
                'enable'    => true,
                'time_24hr' => true,
            ]  
        ],
        [
            'id'            => 'date_range',
            'type'          => 'datepicker',
            'value'         => '',
            'class'         => '',
            'label_title'   => __('Date range picker field'),
            'label_desc'    => __('This is the label description you can use here'),
            'field_desc'    => __('This is the field description you can use here'),
            'placeholder'   => __('Select date range'),
            'format'        => 'Y-m-d',
            'mode'          => 'range',
             
        ],
        [
            'id'            => 'specific_dates',
            'type'          => 'datepicker',
            'value'         => '',
            'class'         => '',
            'label_title'   => __('Specific dates picker field'),
            'label_desc'    => __('This is the label description you can use here'),
            'field_desc'    => __('This is the field description you can use here'),
            'placeholder'   => __('Select dates'),
            'format'        => 'Y-m-d',
            'mode'          => 'multiple',
             
        ],
        [
            'id'            => 'time',
            'type'          => 'timepicker',
            'value'         => '',
            'class'         => '',
            'label_title'   => __('Time picker field'),
            'label_desc'    => __('This is the label description you can use here'),
            'field_desc'    => __('This is the field description you can use here'),
            'placeholder'   => __('Select time'),
            'mode'          => 'range',
            'time_24hr'     => false,
        ]
    ]
];