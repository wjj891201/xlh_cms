<?php

/**
 * 验证前台是否登录
 * $Author: wujiepeng
 */

namespace app\controllers;

use Yii;
use app\controllers\CommonController;

class CheckController extends CommonController
{

    public $userid;

    public function init()
    {
        parent::init();
        if (Yii::$app->session['member']['isLogin'] != 1)
        {
            return $this->redirect(['/public/login']);
        }
        else
        {
            $this->userid = Yii::$app->session['member']['userid'];
        }
    }

}
