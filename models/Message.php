<?php

namespace app\models;

use yii\db\ActiveRecord;
use Yii;

class Message extends ActiveRecord
{

    public static function tableName()
    {
        return "{{%message}}";
    }

    public function rules()
    {
        return [
            ['name', 'required', 'message' => '姓名必填', 'on' => 'add'],
            ['telphone', 'required', 'message' => '联系电话必填', 'on' => 'add'],
            ['telphone', 'match', 'pattern' => '/^1[34578]\d{9}$/', 'message' => '手机号码错误', 'on' => 'add'],
            ['email', 'required', 'message' => '电子邮箱必填', 'on' => 'add'],
            ['email', 'email', 'message' => '邮箱格式错误', 'on' => 'add'],
            ['mark', 'required', 'message' => '需求必填', 'on' => 'add'],
            [['province', 'city', 'type', 'createtime'], 'safe']
        ];
    }

    public function add($data)
    {
        $this->scenario = "add";
        $data['Message']['province'] = $data['province'];
        $data['Message']['city'] = $data['city'];
        $data['Message']['createtime'] = date('Y-m-d H:i:s');
        if ($this->load($data) && $this->save())
        {
            return true;
        }
        return false;
    }

    public static function sentemail($data, $region_name)
    {
        //发送邮件
        $mailer = Yii::$app->mailer->compose('message', ['region_name' => $region_name, 'province' => $data['Join']['province'],
            'city' => $data['Join']['city'], 'company' => $data['Join']['company'], 'telphone' => $data['Join']['telphone'],
            'qq' => $data['Join']['qq'], 'email' => $data['Join']['email']]);
        $mailer->setFrom("15195861092@163.com");
        $mailer->setTo("517987404@qq.com");
        $mailer->setSubject("任意推门户-申请加盟");
        if ($mailer->send())
        {
            return true;
        }
    }

}
