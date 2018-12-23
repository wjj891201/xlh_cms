<?php

namespace app\models;

use yii\db\ActiveRecord;
use Yii;

class WorkflowLog extends ActiveRecord
{

    public static function tableName()
    {
        return "{{%workflow_log}}";
    }

}
