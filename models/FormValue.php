<?php

namespace app\models;

use yii\db\ActiveRecord;
use Yii;

class FormValue extends ActiveRecord
{

    public static function tableName()
    {
        return "{{%form_value}}";
    }

    public function getUser()
    {
        return $this->hasOne(Member::className(), ['userid' => 'userid']);
    }

}
