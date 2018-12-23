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
class AdminAsset extends AssetBundle
{

    public $basePath = '@webroot';
    public $baseUrl = '@web/public/backend';
    public $css = [
        'css/public.css',
    ];
    public $js = [
        'js/jquery.min.js',
        'js/global.js',
    ];
    public $jsOptions = [
        'position' => View::POS_HEAD,
    ];

}
