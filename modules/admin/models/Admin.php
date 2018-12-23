<?php

namespace app\modules\admin\models;

use yii\db\ActiveRecord;
use Yii;

class Admin extends ActiveRecord
{

    public $remember = true;
    public $repass;

    public static function tableName()
    {
        return "{{%admin}}";
    }

    public function attributeLabels()
    {
        return [
            'user' => '账号',
            'email' => '邮箱',
            'password' => '密码',
            'repass' => '确认密码',
        ];
    }

    public function rules()
    {
        return [
            ['user', 'required', 'message' => '管理员账号不能为空！', 'on' => ['login', 'seekpass', 'changepass', 'adminadd']],
            ['password', 'required', 'message' => '管理员密码不能为空！', 'on' => ['login', 'changepass', 'adminadd', 'change']],
            ['remember', 'boolean', 'on' => 'login'],
            ['password', 'validatePass', 'on' => 'login'],
            ['email', 'required', 'message' => '管理员邮箱不能为空！', 'on' => ['seekpass', 'adminadd']],
            ['email', 'email', 'message' => '管理员邮箱格式不正确！', 'on' => ['seekpass', 'adminadd']],
            ['email', 'unique', 'message' => '邮箱已被注册', 'on' => 'adminadd'],
            ['user', 'unique', 'message' => '管理员账号已被注册', 'on' => 'adminadd'],
            ['email', 'validateEmail', 'on' => 'seekpass'],
            ['repass', 'required', 'message' => '确认密码不能为空！', 'on' => ['changepass', 'adminadd', 'change']],
            ['repass', 'compare', 'compareAttribute' => 'password', 'message' => '两次密码输入不一致', 'on' => ['changepass', 'adminadd', 'change']],
        ];
    }

    public function validatePass()
    {
        if (!$this->hasErrors())
        {
            $data = self::find()->where('user = :user and password = :password', [":user" => $this->user, "password" => md5($this->password)])->one();
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
            //登陆
            $lifetime = $this->remember ? 24 * 3600 : 0;
            $session = Yii::$app->session;
            session_set_cookie_params($lifetime);

            $data = self::find()->select(['user', 'manager'])->where('user = :user', [":user" => $this->user])->one();

            $session['admin'] = [
                'user' => $this->user,
                'manager' => $data['manager'],
                'isLogin' => 1
            ];
            $this->updateAll(['logintime' => time(), 'loginip' => ip2long(Yii::$app->request->userIP)], ['user' => $this->user]);
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

    public function reg($data)
    {
        $this->scenario = "adminadd";
        if ($this->load($data) && $this->validate())
        {
            $this->password = md5($this->password);
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
            return true;
        }
        return false;
    }

}

?>
