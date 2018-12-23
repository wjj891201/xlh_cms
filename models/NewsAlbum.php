<?php

namespace app\models;

use yii\db\ActiveRecord;
use Yii;

class NewsAlbum extends ActiveRecord
{

    public static function tableName()
    {
        return "{{%news_album}}";
    }

    public static function install_pic($did, $picfile = null, $del = true)
    {
        if ($del)
        {
            self::deleteAll('did=:did', [':did' => $did]);
        }
        $time = time();
        foreach ($picfile as $vo)
        {
            Yii::$app->db->createCommand()->insert("{{%news_album}}", ['did' => $did, 'picfile' => $vo, 'addtime' => $time])->execute();
        }
        return true;
    }

    public static function getAll($where = [])
    {
        $result = self::find()->where($where)->all();
        return $result;
    }

}