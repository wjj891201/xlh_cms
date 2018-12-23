<?php

namespace app\models;

use yii\db\ActiveRecord;
use Yii;

class AdvertType extends ActiveRecord
{

    public static function tableName()
    {
        return "{{%advert_type}}";
    }

    public function rules()
    {
        return [
            ['adtypename', 'required', 'message' => '该处不能为空'],
            [['width', 'height'], 'required', 'message' => '该处不能为空'],
            [['width', 'height'], 'integer', 'message' => '请填写整数'],
            [['isclass', 'content'], 'safe'],
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

    public static function getData($where = [])
    {
        $all_label = self::find()->where($where)->asArray()->all();
        return $all_label;
    }

    public static function getOptions($where)
    {
        $data = self::getData($where);
        $options = ['' => '请选择广告位'];
        foreach ($data as $vo)
        {
            $options[$vo['atid']] = $vo['adtypename'];
        }
        return $options;
    }

}
