<?php
return [
    'section' => [
       'id'     => 'ob_file', 
       'label'  => __('file uploader'), 
       'icon'   => '', 
    ],
    'fields' => [
        [
            'id'            => 'file_uploader',
            'type'          => 'file',
            'class'         => '',
            'label_title'   => __('Single file uploader field'),
            'label_desc'    => __('This is the file description you can use here'),
            'field_desc'    => __('This is the file uploader description text you can use here'),
            'max_size'   => 4,                  // size in MB
            'ext'    =>[
                'jpg',
                'png',
                'pdf',
                'doc',
                'xlsx',
                'ppt',
            ], 
        ],
        [
            'id'            => 'multifile_uploader',
            'type'          => 'file',
            'class'         => '',
            'label_title'   => __('Multi file uploader field'),
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
        ],
    ]
];