<?php

namespace app\models;

use yii\db\ActiveRecord;
use Yii;

class PhoneMessage extends ActiveRecord
{

    public static function tableName()
    {
        return "{{%phone_message}}";
    }

}
