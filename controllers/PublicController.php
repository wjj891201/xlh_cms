<?php

namespace app\controllers;

use app\controllers\CommonController;
use Yii;
use app\libs\Tool;
use app\models\Member;
use app\models\PhoneMessage;

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
            $info = Member::find()->where(['username' => $phone])->asArray()->one();
            if (!empty($info))
            {
                $data = ['code' => '20001', 'message' => '该手机号已注册，请更换手机号'];
            }
            else
            {
                # 恶意刷量控制~~~start
                //1.0
                $time_start = date('Y-m-d') . ' 00:00:00';
                $time_end = date('Y-m-d') . ' 23:59:59';
                $count = PhoneMessage::find()->where(['and', ['mobile' => $phone, 'status' => 1], ['between', 'create_time', $time_start, $time_end]])->count();
                if ($count >= 5)
                {
                    $data = ['code' => '20002', 'message' => '该手机号一天只能发送5条短信'];
                    echo json_encode($data);
                    exit;
                }
                //2.0
                $last_one = PhoneMessage::find()->where(['mobile' => $phone])->orderBy(['create_time' => SORT_DESC])->asArray()->one();
                $overtime = Yii::$app->params['overtime'];
                if ((strtotime($last_one['create_time']) + $overtime) > time())
                {
                    $data = ['code' => '20002', 'message' => '发送过于频繁，请等待' . $overtime . '秒后再做操作'];
                    echo json_encode($data);
                    exit;
                }
                # 恶意刷量控制~~~end
                $result = Tool::send_sms_java_api('00', $phone, $sms);
                if ($result['status'])
                {
                    $message = [
                        'mobile' => $phone,
                        'code' => $sms,
                        'type' => 1,
                        'status' => 1,
                        'remark' => json_encode($result['msg']),
                        'create_time' => date('Y-m-d H:i:s')
                    ];
                    Yii::$app->db->createCommand()->insert('{{%phone_message}}', $message)->execute();
                    $data = ['code' => '20000', 'message' => '验证码发送成功', 'short' => $sms];
                }
                else
                {
                    $data = ['code' => '20002', 'message' => '发送失败'];
                }
            }
            echo json_encode($data);
            exit;
        }
    }

}
