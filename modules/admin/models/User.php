<?php

namespace app\modules\admin\models;

use yii\db\ActiveRecord;
use Yii;
use yii\web\Cookie;

class User extends ActiveRecord
{

    public $remember = true;
    public $repass, $verifyCode;

    public static function tableName()
    {
        return "{{%user}}";
    }

    public function attributeLabels()
    {
        return [
            'name' => '账号',
            'email' => '邮箱',
            'password' => '密码',
            'repass' => '确认密码',
            'verifyCode' => '验证码'
        ];
    }

    public function rules()
    {
        return [
            ['name', 'required', 'message' => '{attribute}不能为空', 'on' => ['login', 'seekpass', 'changepass', 'adminadd']],
            ['password', 'required', 'message' => '{attribute}不能为空', 'on' => ['login', 'changepass', 'adminadd', 'change', 'self']],
            ['remember', 'boolean', 'on' => 'login'],
            ['password', 'validatePass', 'on' => 'login'],
            ['verifyCode', 'required', 'message' => '{attribute}不能为空', 'on' => 'login'],
            ['verifyCode', 'captcha', 'message' => '{attribute}错误', 'captchaAction' => '/admin/public/captcha', 'on' => 'login'],
            ['email', 'required', 'message' => '{attribute}不能为空', 'on' => ['seekpass', 'adminadd']],
            ['email', 'email', 'message' => '{attribute}格式不正确', 'on' => ['seekpass', 'adminadd']],
            ['email', 'unique', 'message' => '{attribute}已被注册', 'on' => 'adminadd'],
            ['name', 'unique', 'message' => '{attribute}已被注册', 'on' => 'adminadd'],
            ['email', 'validateEmail', 'on' => 'seekpass'],
            ['repass', 'required', 'message' => '{attribute}不能为空', 'on' => ['changepass', 'adminadd', 'change', 'self']],
            ['repass', 'compare', 'compareAttribute' => 'password', 'message' => '两次密码输入不一致', 'on' => ['changepass', 'adminadd', 'change', 'self']],
        ];
    }

    public function validatePass()
    {
        if (!$this->hasErrors())
        {
            $data = self::find()->where('name = :name and password = :password', [":name" => $this->name, "password" => md5($this->password)])->one();
            if (is_null($data))
            {
                $this->addError("password", "用户名或者密码错误");
            }
        }
    }

    public function validateEmail()
    {
        if (!$this->hasErrors())
        {
            $data = self::find()->where('user = :user and email = :email', [":user" => $this->user, "email" => $this->email])->one();
            if (is_null($data))
            {
                $this->addError("email", "管理员邮箱不匹配");
            }
        }
    }

    public function login($data)
    {
        $this->scenario = "login";
        if ($this->load($data) && $this->validate())
        {
            //设置默认语言（简体中文）---begin
            $cookies = Yii::$app->response->cookies;
            $cookies->add(new Cookie([
                        'name' => 'lang',
                        'value' => 'cn'
                    ]));
            //设置默认语言（简体中文）---end
            //登陆
            $lifetime = $this->remember ? 24 * 3600 : 0;
            $session = Yii::$app->session;
            session_set_cookie_params($lifetime);
            $info = self::find()->select(['id', 'name'])->where('name = :name', [":name" => $this->name])->one();
            $session['admin'] = [
                'id' => $info['id'],
                'name' => $this->name,
                'isLogin' => 1
            ];
            $this->updateAll(['updated_time' => date('Y-m-d H:i:s'), 'loginip' => ip2long(Yii::$app->request->userIP)], ['name' => $this->name]);
            return (bool) $session['admin']['isLogin'];
        }
        return false;
    }

    public function seekPass($data)
    {
        $this->scenario = "seekpass";
        if ($this->load($data) && $this->validate())
        {
            //发送邮件
            $time = time();
            $token = $this->createToken($data['Admin']['user'], $time);
            $mailer = Yii::$app->mailer->compose('seekpass', ['user' => $data['Admin']['user'], 'time' => $time, 'token' => $token]);
            $mailer->setFrom("15195861092@163.com");
            $mailer->setTo($data['Admin']['email']);
            $mailer->setSubject("招商门户-找回密码");
            if ($mailer->send())
            {
                return true;
            }
        }
        return false;
    }

    public function createToken($user, $time)
    {
        return md5(md5($user) . base64_encode(Yii::$app->request->userIP) . md5($time));
    }

    public function changePass($data)
    {
        $this->scenario = "changepass";
        if ($this->load($data) && $this->validate())
        {
            return (bool) $this->updateAll(['password' => md5($this->password)], ['user' => $this->user]);
        }
        return false;
    }

    public function changeSelfPass($data, $uid)
    {
        $this->scenario = "self";
        if ($this->load($data) && $this->validate())
        {
            return (bool) $this->updateAll(['password' => md5($this->password)], ['id' => $uid]);
        }
        return false;
    }

    public function reg($data)
    {
        $this->scenario = "adminadd";
        if ($this->load($data) && $this->validate())
        {
            $this->password = md5($this->password);
            $this->created_time = date('Y-m-d H:i:s');
            if ($this->save(false))
            {
                return true;
            }
        }
        return false;
    }

    public function change_users($data)
    {
        $this->scenario = "change";
        if ($this->load($data) && $this->validate())
        {
            return (bool) $this->updateAll(['password' => md5($this->password)], ['id' => $this->id]);
        }
        return false;
    }

}

?>
