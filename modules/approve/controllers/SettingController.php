<?php

namespace app\modules\approve\controllers;

use app\modules\approve\controllers\CommonController;
use Yii;
use app\models\approve\SignupForm;

class SettingController extends CommonController
{

    /**
     * 修改密码
     */
    public function actionPsw()
    {
        $model = new SignupForm;
        if (Yii::$app->request->isPost)
        {
            $post = Yii::$app->request->post();
            if ($model->psw($post))
            {
                //退出到登录界面
                Yii::$app->approvr_user->logout();
                return $this->redirect(['login/login']);
            }
        }
        return $this->render("psw", ['model' => $model]);
    }

}
