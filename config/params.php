<?php

return [
    # 系统后台需要数据
    'formType' => [
        0 => ['key' => 'string', 'name' => '单行文本', 'class' => 'text', 'alter' => 'VARCHAR', 'varlong' => '250'],
        1 => ['key' => 'text', 'name' => '多行文本', 'class' => 'textarea', 'alter' => 'TEXT', 'varlong' => '250'],
        2 => ['key' => 'editor', 'name' => '编辑器', 'class' => 'textarea', 'alter' => 'TEXT', 'varlong' => '250'],
        3 => ['key' => 'htmltext', 'name' => 'HTML文本', 'class' => 'textarea', 'alter' => 'TEXT', 'varlong' => '250'],
        4 => ['key' => 'int', 'name' => ' 整数类型', 'class' => 'text', 'alter' => 'INT', 'varlong' => '11'],
        5 => ['key' => 'float', 'name' => ' 小数类型', 'class' => 'text', 'alter' => 'FLOAT', 'varlong' => '11'],
        6 => ['key' => 'datetime', 'name' => '时间类型', 'class' => 'text', 'alter' => 'INT', 'varlong' => '11'],
        7 => ['key' => 'img', 'name' => '图片附件', 'class' => 'text', 'alter' => 'VARCHAR', 'varlong' => '250'],
#       8 => ['key' => 'addon', 'name' => '文件附件', 'class' => 'text', 'alter' => 'VARCHAR', 'varlong' => '250'],
#       9 => ['key' => 'video', 'name' => '视频附件', 'class' => 'text', 'alter' => 'VARCHAR', 'varlong' => '250'],
        10 => ['key' => 'select', 'name' => '下拉框', 'class' => 'select', 'alter' => 'VARCHAR', 'varlong' => '250'],
        11 => ['key' => 'radio', 'name' => '单选框', 'class' => 'radio', 'alter' => 'VARCHAR', 'varlong' => '250'],
        12 => ['key' => 'checkbox', 'name' => '多选框', 'class' => 'checkbox', 'alter' => 'VARCHAR', 'varlong' => '250'],
        13 => ['key' => 'selectinput', 'name' => '复合选项关联输入框', 'class' => 'text', 'alter' => 'VARCHAR', 'varlong' => '250'],
        14 => ['key' => 'decimal', 'name' => '价格', 'class' => 'text', 'alter' => 'FLOAT', 'varlong' => '50'],
    ],
    #系统后台审核动作
    'action_key_list' => [
        'pass' => 'pass',
        'back' => 'back',
        'end' => 'end',
        'defer' => 'defer',
        'grant' => 'grant', //授信
        'finish' => 'finish'
    ],
    # 短信间隔时间
    'overtime' => 120,
    # 企业适用会计制度
    'system' => [
            ['id' => 1, 'name' => '企业会计准则（一般企业）'],
            ['id' => 2, 'name' => '小企业会计准则'],
            ['id' => 3, 'name' => '其他']
    ],
    # 行业类型
    'industry' => [
            ['id' => 1, 'name' => "汽车及新能源汽车"],
            ['id' => 2, 'name' => "电子信息"],
            ['id' => 3, 'name' => "生物医药"],
            ['id' => 4, 'name' => "航空装备"],
            ['id' => 5, 'name' => "食品"],
            ['id' => 6, 'name' => "纺织服装"],
            ['id' => 7, 'name' => "新材料"],
            ['id' => 8, 'name' => "机电制造"],
            ['id' => 9, 'name' => "VR/AR产业"],
            ['id' => 10, 'name' => "其他"]
    ],
    # 企业类型
    'enterprise' => [
            ['id' => 1, 'name' => '国家科技型中小企业', 'special' => false],
            ['id' => 2, 'name' => '省级科技型中小企业', 'special' => false],
            ['id' => 3, 'name' => '国家高新技术企业', 'special' => false],
            ['id' => 4, 'name' => '其他', 'special' => true]
    ],
    # 金融支持
    'supports' => [
        'fund' => [
                ['id' => 1, 'name' => '科技银行贷款'],
                ['id' => 2, 'name' => '其他银行贷款'],
                ['id' => 3, 'name' => '小贷'],
                ['id' => 4, 'name' => '保理'],
                ['id' => 5, 'name' => '融资租赁'],
                ['id' => 6, 'name' => '担保'],
                ['id' => 7, 'name' => '其他']
        ],
        'orther' => [
                ['id' => 8, 'name' => '股权融资'],
                ['id' => 9, 'name' => '挂牌上市'],
                ['id' => 10, 'name' => '并购服务'],
                ['id' => 11, 'name' => '其他']
        ]
    ],
    
    #还款方式
    'repayment_mode' =>[
        1 => '先息后本',
        2 => '等额本息',
        3 => '等额本金',
        4 => '等本等息',
        5 => '灵活还款',
        6 => '随借随还',
        7 => '一次性还本付息'
    ],

    #还款状态
    'repayment_status' => [
        1 => '按期还款',
        2 => '提前还款',
        3 => '延期还款',
        4 => '已逾期',
    ],

    #放款状态
    'loan_status' => [
        0 => '未放款',
        1 => '未全额放款',
        2 => '已全额放款',
    ]                            
];
