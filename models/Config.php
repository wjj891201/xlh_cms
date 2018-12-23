<?php

namespace app\models;

use yii\db\ActiveRecord;
use Yii;

class Config extends ActiveRecord
{

    public static function tableName()
    {
        return "{{%config}}";
    }

    public static function getConfig($where)
    {
        $config = self::find()->where($where)->all();
        return $config;
    }

    public function add($data, $lng)
    {
        foreach ($data as $key => $vo)
        {
            Yii::$app->db->createCommand()->insert("{{%config}}", ['lng' => $lng, 'name' => $key, 'value' => $vo])->execute();
        }
        return true;
    }

    public function edit($info, $post, $lng)
    {
        foreach ($post as $key => $vo)
        {
            if (array_key_exists($key, $info))
            {
                //编辑
                $this->updateAll(['value' => $vo], ['id' => $info[$key]['id']]);
            }
            else
            {
                //添加
                Yii::$app->db->createCommand()->insert("{{%config}}", ['lng' => $lng, 'name' => $key, 'value' => $vo])->execute();
            }
        }
        return true;
    }

}
