<?php

namespace app\modules\approve\controllers;

use yii\web\Controller;
use app\models\approve\LoginForm;
use Yii;

/**
 * Default controller for the `approve` module
 */
class LoginController extends Controller
{

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionLogin()
    {
        // 判断用户是访客还是认证用户 
        if (!Yii::$app->approvr_user->isGuest)
        {
            $this->redirect(['public/index']);
            Yii::$app->end();
        }
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login())
        {
            $this->redirect(['public/index']);
            Yii::$app->end();
        }
        else
        {
            return $this->renderPartial('login', ['model' => $model]);
        }
    }

    /**
     * Logs out the current user.
     *
     */
    public function actionLogout()
    {
        Yii::$app->approvr_user->logout();
        $this->redirect(['login/login']);
    }

}
