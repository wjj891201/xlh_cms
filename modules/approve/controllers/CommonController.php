<?php

namespace app\modules\approve\controllers;

use yii\web\Controller;
use Yii;
use app\models\Organization;

class CommonController extends Controller
{

    public function beforeAction($action)
    {
        //1.0 先验证是否已经登录
        if (Yii::$app->approvr_user->isGuest)
        {
            $this->redirect(['/approve/login/login']);
            Yii::$app->end();
        }
        else
        {
            $organizationName = Organization::find()->select('name')->where(['id' => Yii::$app->approvr_user->identity->belong])->scalar();
            $this->view->params['organizationName'] = $organizationName;
        }
        return true;
    }

}
