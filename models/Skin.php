<?php

namespace app\models;

use yii\db\ActiveRecord;
use Yii;

class Skin extends ActiveRecord
{

    public static function tableName()
    {
        return "{{%skin}}";
    }

    public function attributeLabels()
    {
        return [
            'name' => '主题名称',
            'code' => '主题标识'
        ];
    }

    public function rules()
    {
        return [
            [['name', 'code'], 'required', 'message' => '{attribute}必填'],
            ['code', 'match', 'pattern' => '/^[A-Za-z]+$/', 'message' => '请填写字母'],
        ];
    }

    public function add($data)
    {
        $this->addtime = time();
        if ($this->load($data) && $this->save())
        {
            return true;
        }
        return false;
    }

    public static function getData($where = [])
    {
        $result = self::find()->where($where)->all();
        return $result;
    }

}
