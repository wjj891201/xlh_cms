<?php

/**
 * 设置cookie用于语言切换
 * $Author: wujiepeng 
 */

namespace app\modules\admin\controllers;

use Yii;
use yii\web\Cookie;
use app\modules\admin\controllers\CommonController;

class SetcookieController extends CommonController
{

    public function actionDeal()
    {
        $lang = Yii::$app->request->get("lang");
        $cookies = Yii::$app->response->cookies;
        $cookies->add(new Cookie([
                    'name' => 'lang',
                    'value' => $lang
                ]));
        //切换完语言哪来的返回到哪里
        $this->goBack(Yii::$app->request->headers['Referer']);
    }

}

?>
