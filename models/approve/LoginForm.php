<?php

namespace app\models\approve;

use Yii;
use yii\base\Model;
use app\models\ApproveUser;

class LoginForm extends Model
{

    public $username;
    public $password;
    public $rememberMe = true;
    private $_user = false;

    /**
     * @inheritdoc
     * 对表单数据进行验证的rule
     */
    public function rules()
    {
        return [
                [['username', 'password'], 'required', 'message' => '请填写该项'],
                ['rememberMe', 'boolean'],
                ['password', 'validatePassword'],
        ];
    }

    /**
     * 自定义的密码认证方法
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors())
        {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password))
            {
                $this->addError($attribute, '用户名或者密码错误');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate())
        {
            return Yii::$app->approvr_user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        }
        else
        {
            return false;
        }
    }

    /**
     * 根据用户名获取用户的认证信息
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === false)
        {
            $this->_user = ApproveUser::findByUsername($this->username);
        }
        return $this->_user;
    }

}
