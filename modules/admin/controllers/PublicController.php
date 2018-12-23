<?php

namespace app\modules\admin\controllers;

use yii\web\Controller;
use app\modules\admin\models\User;
use Yii;

class PublicController extends Controller
{

    public function actions()
    {
        return [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'backColor' => 0x51ACFF,
                'foreColor' => 0xffffff,
                'height' => 42,
                'width' => 76,
                'minLength' => 4,
                'maxLength' => 4
                ],
        ];
    }

    public function actionLogin()
    {
        $model = new User;
        $request = Yii::$app->request;
        if ($request->isPost)
        {
            $post = $request->post();
            if ($model->login($post))
            {
                $this->redirect(['default/index']);
                Yii::$app->end();
            }
        }
        return $this->renderPartial('login', ['model' => $model]);
    }

    public function actionLogout()
    {
        Yii::$app->session->removeAll();
        if (!isset(Yii::$app->session['admin']['isLogin']))
        {
            $this->redirect(['public/login']);
            Yii::$app->end();
        }
        $this->goBack();
    }

    public function actionSeekpassword()
    {
        $model = new Admin;
        $request = Yii::$app->request;
        if ($request->isPost)
        {
            $post = $request->post();
            if ($model->seekPass($post))
            {
                Yii::$app->session->setFlash('info', '电子邮件发送成功，请查收');
            }
        }
        return $this->renderPartial('seekpassword', ['model' => $model]);
    }

}
