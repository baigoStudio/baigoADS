<?php return array(
    'text' => array(
        'type'      => 'text', //可选 text, textarea, select, radio（必须）
        'min'       => 1, //最短（必须）
        'default'   => 100, //默认值（必须）
        'label'     => '文本框',
        'format'    => 'int', //可选 text, int, digit
        'note'      => '备注', //备注
    ),
    'textarea' => array(
        'type'      => 'textarea',
        'label'     => '文本域',
        'format'    => 'text',
        'min'       => 0,
        'default'   => '默认值',
    ),
    'select' => array(
        'type'      => 'select',
        'label'     => '下拉菜单',
        'min'       => 1,
        'default'   => 'opt_1',
        'option'    => array(
            'opt_1' => '选项-1',
            'opt_2' => '选项-2',
            'opt_3' => '选项-3',
        ),
    ),
    'radio' => array(
        'type'       => 'radio',
        'label'      => '单选',
        'min'        => 1,
        'default'    => 'opt_1',
        'option'     => array(
            'opt_1'  => array(
                'value'    => '选项-1',
                'note'     => '选项备注', //备注
            ),
            'opt_2'  => array(
                'value'    => '选项-2',
            ),
        ),
    ),
);
