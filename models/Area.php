<?php

namespace app\models;

use yii\db\ActiveRecord;
use Yii;

class Area extends ActiveRecord
{

    public static function tableName()
    {
        return "{{%town_list}}";
    }

    public function rules()
    {
        return [
                [['name', 'sort'], 'required', 'message' => '{attribute}不能为空'],
                ['sort', 'integer', 'message' => '{attribute}需为数字'],
                ['create_time', 'default', 'value' => date('Y-m-d H:i:s')],
                ['status', 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => '地区名',
            'sort' => '排序',
            'status' => '状态'
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

    public static function getData($where = [])
    {
        $result = self::find()->where($where)->orderBy(['sort' => SORT_ASC])->all();
        return $result;
    }

}
