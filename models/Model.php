<?php

namespace app\models;

use yii\db\ActiveRecord;
use Yii;

class Model extends ActiveRecord
{

    public static function tableName()
    {
        return "{{%model}}";
    }

    public function rules()
    {
        return [
            ['modelname', 'required', 'message' => '模型名称不能为空'],
            ['pagemax', 'required', 'message' => '每页显示数不能为空'],
            ['pagemax', 'integer', 'message' => '请填写整数'],
            [['lockin', 'isbase', 'isalbum', 'isclass'], 'safe']
        ];
    }

    public function add($data)
    {
        if ($this->load($data) && $this->save())
        {
            return true;
        }
        return false;
    }

    public static function getOne($where = [])
    {
        $one = self::find()->where($where)->one();
        return $one;
    }

    public static function getAll($where = [], $columns = [])
    {
        $all = self::find()->where($where)->orderBy($columns)->all();
        return $all;
    }

}