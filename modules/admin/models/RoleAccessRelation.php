<?php

namespace app\modules\admin\models;

use yii\db\ActiveRecord;
use Yii;

class RoleAccessRelation extends ActiveRecord
{

    public static function tableName()
    {
        return "{{%role_access}}";
    }

}
