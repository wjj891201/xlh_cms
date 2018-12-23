<?php

namespace app\models;

use yii\db\ActiveRecord;
use Yii;

class NewsAttr extends ActiveRecord
{

    public static function tableName()
    {
        return "{{%news_attr}}";
    }

    public function add($data)
    {
        if ($this->load($data) && $this->save())
        {
            return true;
        }
        return false;
    }

    public static function getOne($where = '')
    {
        $one = self::find()->where($where)->one();
        return $one;
    }

    public static function getAll($where = '', $columns = '')
    {
        $all = self::find()->where($where)->orderBy($columns)->all();
        return $all;
    }

}