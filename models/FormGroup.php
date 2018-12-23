<?php

namespace app\models;

use yii\db\ActiveRecord;
use Yii;

class FormGroup extends ActiveRecord
{

    public static function tableName()
    {
        return "{{%form_group}}";
    }

    public function rules()
    {
        return [
            ['formgroupname', 'required', 'message' => '表单名称不能为空'],
            ['template', 'required', 'message' => '表单模板不能为空'],
            [['content', 'successtext'], 'safe'],
        ];
    }

    public function add($data, $lng = 'cn')
    {
        $this->lng = $lng;
        if ($this->load($data) && $this->save())
        {
            return true;
        }
        return false;
    }

    public static function getData($where)
    {
        $all = self::find()->where($where)->all();
        return $all;
    }

    public static function getInfo($where)
    {
        $result = self::find()->where($where)->one();
        return $result;
    }

}
