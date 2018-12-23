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
class KjdAsset extends AssetBundle
{

    public $basePath = '@webroot';
    public $baseUrl = '@web/public/kjd';
    public $css = [
        'css/style_login.css'
    ];
    public $js = [
        'js/jquery.js'
    ];
    public $jsOptions = [
        'position' => View::POS_HEAD,
    ];

}
