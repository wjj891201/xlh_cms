<?php

namespace app\models;

use yii\db\ActiveRecord;
use Yii;

class NewsContent extends ActiveRecord
{

    public static function tableName()
    {
        return "{{%news_content}}";
    }

}