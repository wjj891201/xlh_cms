<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\View;
use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class ApproveAsset extends AssetBundle
{

    public $basePath = '@webroot';
    public $baseUrl = '@web/public/approve';
    public $css = [
        'css/base.css',
        'css/easy.css',
        'css/style.css',
        'css/mystyle.css',
        'css/change_pwd.css'
    ];
    public $js = [
        'js/jquery.js',
        'js/easy.js',
//        'js/echarts.common.min.js',
//        'js/moment.min.js',
//        'js/jquery.daterangepicker.js',
        'js/common.js',
//        'js/data.js'
        'js/layer/layer.js',
    ];
    public $jsOptions = [
        'position' => View::POS_HEAD,
    ];

}
