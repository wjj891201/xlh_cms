<?php

namespace app\controllers;

use app\controllers\CommonController;
use Yii;
use app\libs\Tool;
use app\models\Member;

class PublicController extends CommonController
{

    public function actions()
    {
        return [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'backColor' => 0x51ACFF,
                'foreColor' => 0xffffff,
                'height' => 36,
                'width' => 76,
                'minLength' => 4,
                'maxLength' => 4
            ],
        ];
    }

    /**
     * 登录
     */
    public function actionLogin()
    {
        $model = new Member;
        $request = Yii::$app->request;
        if ($request->isPost)
        {
            $post = $request->post();
            if ($model->login($post))
            {
                $this->redirect(['member/center']);
                Yii::$app->end();
            }
        }
        return $this->render('login', ['model' => $model]);
    }

    public function actionLogout()
    {
        Yii::$app->session->remove('member');
        if (!isset(Yii::$app->session['member']['isLogin']))
        {
            $this->redirect(['index/index']);
            Yii::$app->end();
        }
        $this->goBack();
    }

    /**
     * 注册 或者 修改密码
     */
    public function actionSignup()
    {
        $model = new Member;
        $request = Yii::$app->request;
        if ($request->isPost)
        {
            $post = $request->post();
            //注册
            if ($model->reg($post))
            {
                $this->redirect(['call/mess', 'mess' => '注册成功', 'url' => '/public/login']);
                Yii::$app->end();
            }
        }
        return $this->render('signup', ['model' => $model]);
    }

    public function actionSeekpass()
    {
        $model = new Member;
        $request = Yii::$app->request;
        if ($request->isPost)
        {
            $post = $request->post();
            //修改密码
            if ($model->seekPass($post))
            {
                $this->redirect(['call/mess', 'mess' => '密码修改成功', 'url' => '/public/login']);
                Yii::$app->end();
            }
        }
        return $this->render('seekpass', ['model' => $model]);
    }

    public function actionSms()
    {
        $phone = Yii::$app->request->get("phone");
        $sms = Tool::getNonceStr();
        Yii::$app->cache->set($phone, $sms, 600);
        if ($sms)
        {
            exit("$sms");
        }
    }

}
