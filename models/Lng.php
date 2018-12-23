<?php

namespace app\models;

use yii\db\ActiveRecord;
use Yii;

class Lng extends ActiveRecord
{

    public static function tableName()
    {
        return "{{%lng}}";
    }

    public function rules()
    {
        return [
            ['lng', 'required', 'message' => '该处不能为空'],
            ['lng', 'match', 'pattern' => '/^[a-z]+$/', 'message' => '请填小写字母'],
            ['lngtitle', 'required', 'message' => '该处不能为空'],
            ['isopen', 'safe'],
        ];
    }

    public function add($data)
    {
        $this->pid = 50;
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
