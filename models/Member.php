<?php

namespace app\models;

use yii\db\ActiveRecord;
use Yii;

class Member extends ActiveRecord
{

    public $remember = true;
    public $orpass, $repass;
    public $verifyCode;
    public $short;
    public $agreement = true;

    public static function tableName()
    {
        return "{{%member}}";
    }

    public function attributeLabels()
    {
        return [
            'orpass' => '原始密码',
            'username' => '手机号码',
            'password' => '密码',
            'repass' => '确认密码',
            'short' => '短信验证码',
            'verifyCode' => '验证码'
        ];
    }

    public function rules()
    {
        return [
                ['orpass', 'required', 'message' => '原密码不能为空', 'on' => ['changepass']],
                ['orpass', 'validateOrpass', 'on' => ['changepass']],
                ['username', 'required', 'message' => '手机号码不能为空', 'on' => ['login', 'seekpass', 'memberadd']],
                ['username', 'match', 'pattern' => '/^[1][358][0-9]{9}$/', 'message' => '手机号码格式错误', 'on' => ['login', 'seekpass', 'memberadd']],
                ['username', 'unique', 'message' => '手机号码已存在', 'on' => ['memberadd']],
                ['username', 'validateUsername', 'on' => 'seekpass'],
                ['password', 'required', 'message' => '密码不能为空', 'on' => ['login', 'changepass', 'seekpass', 'memberadd']],
                [['password', 'repass'], 'match', 'pattern' => '/^(?!^[0-9]+$)(?!^[A-z]+$)(?!^[^A-z0-9]+$)^.{6,20}$/', 'message' => '{attribute}格式错误', 'on' => ['memberadd', 'seekpass']],
                ['verifyCode', 'required', 'message' => '{attribute}不能为空', 'on' => ['memberadd', 'seekpass']],
                ['verifyCode', 'captcha', 'message' => '{attribute}错误', 'captchaAction' => '/public/captcha', 'on' => ['memberadd', 'seekpass']],
                ['short', 'required', 'message' => '{attribute}不能为空', 'on' => ['memberadd', 'seekpass']],
                ['short', 'validateShort', 'on' => ['memberadd', 'seekpass']],
                ['agreement', 'validateAgreement', 'on' => 'memberadd'],
                ['remember', 'boolean', 'on' => 'login'],
                ['password', 'validatePass', 'on' => 'login'],
                ['repass', 'required', 'message' => '确认密码不能为空', 'on' => ['changepass', 'seekpass', 'memberadd']],
                ['repass', 'compare', 'compareAttribute' => 'password', 'message' => '两次密码输入不一致', 'on' => ['changepass', 'seekpass', 'memberadd']],
        ];
    }

    //验证原始密码是否正确
    public function validateOrpass()
    {
        if (!$this->hasErrors())
        {
            $data = self::find()->where('userid = :userid and password = :orpass', [":userid" => Yii::$app->session['member']['userid'], ":orpass" => md5($this->orpass)])->one();
            if (is_null($data))
            {
                $this->addError("orpass", "原密码不正确");
            }
        }
    }

    public function validatePass()
    {
        if (!$this->hasErrors())
        {
            $data = self::find()->where('username = :username and password = :password', [":username" => $this->username, ":password" => md5($this->password)])->one();
            if (is_null($data))
            {
                $this->addError("password", "手机号码或者密码错误");
            }
        }
    }

    public function validateEmail()
    {
        if (!$this->hasErrors())
        {
            $data = self::find()->where('username = :username and email = :email', [":username" => $this->username, ":email" => $this->email])->one();
            if (is_null($data))
            {
                $this->addError("email", "管理员邮箱不匹配");
            }
        }
    }

    //验证短信验证码
    public function validateShort()
    {
        if (!$this->hasErrors())
        {
            if ($this->short != Yii::$app->cache->get($this->username))
            {
                $this->addError("short", "短信验证码不正确");
            }
        }
    }

    //验证协议是否勾选
    public function validateAgreement()
    {
        if (!$this->hasErrors())
        {
            if ($this->agreement == 0)
            {
                $this->addError("agreement", "请阅读并勾选协议");
            }
        }
    }

    //找回密码验证手机号是否存在
    public function validateUsername()
    {
        if (!$this->hasErrors())
        {
            $data = self::find()->where('username = :username', [":username" => trim($this->username)])->one();
            if (is_null($data))
            {
                $this->addError("username", "该手机号并未注册，请注册后使用");
            }
        }
    }

    /**
     * 登录
     * @param type $data
     * @return boolean
     */
    public function login($data)
    {
        $this->scenario = "login";
        if ($this->load($data) && $this->validate())
        {
            //登陆
            $lifetime = $this->remember ? 24 * 3600 : 0;
            $session = Yii::$app->session;
            session_set_cookie_params($lifetime);

            $data = self::find()->where('username = :username', [":username" => $this->username])->one();
            $session['member'] = [
                'userid' => $data['userid'],
                'username' => $data['username'],
                'isLogin' => 1
            ];
            $this->updateAll(['lasttime' => time(), 'lastip' => ip2long(Yii::$app->request->userIP)], ['username' => $this->username]);
            return (bool) $session['member']['isLogin'];
        }
        return false;
    }

    /**
     * 忘记密码时找回密码
     * @param type $data
     * @return boolean
     */
    public function seekPass($data)
    {
        $this->scenario = "seekpass";
        if ($this->load($data) && $this->validate())
        {
            return (bool) $this->updateAll(['password' => md5($this->password)], ['username' => $this->username]);
        }
        return false;
    }

    public function createToken($user, $time)
    {
        return md5(md5($user) . base64_encode(Yii::$app->request->userIP) . md5($time));
    }

    /**
     * 会员中心修改密码
     * @param type $data
     * @return boolean
     */
    public function changePass($data)
    {
        $this->scenario = "changepass";
        if ($this->load($data) && $this->validate())
        {
            return (bool) $this->updateAll(['password' => md5($this->password)], ['userid' => Yii::$app->session['member']['userid']]);
        }
        return false;
    }

    /**
     * 注册
     * @param type $data
     * @return boolean
     */
    public function reg($data)
    {
        $this->scenario = "memberadd";
        $this->addtime = time();
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

}
