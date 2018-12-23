<?php

return [
    'class' => 'yii\web\UrlManager',
    'enablePrettyUrl' => true,
    'showScriptName' => false, //隐藏index.php 
    'suffix' => '',
    'rules' => [
        'http://admin.xlh_cms.deve' => 'admin',
        'http://approve.xlh_cms.deve' => 'approve'
    ],
];
