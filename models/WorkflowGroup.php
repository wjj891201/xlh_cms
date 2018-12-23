<?php

namespace app\models;

use yii\db\ActiveRecord;
use Yii;

class WorkflowGroup extends ActiveRecord
{

    public static function tableName()
    {
        return "{{%workflow_group}}";
    }

    public function attributeLabels()
    {
        return [
            'group_name' => '流程组名称',
            'group_key' => '流程组标识',
            'enable' => '是否可用'
        ];
    }

    public function rules()
    {
        return [
                [['group_name', 'group_key'], 'required', 'message' => '{attribute}不能为空'],
                ['group_key', 'match', 'pattern' => '/^[a-z]+$/', 'message' => '请填小写字母'],
                ['enable', 'safe'],
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
        $result = self::find()->where($where)->all();
        return $result;
    }

}
