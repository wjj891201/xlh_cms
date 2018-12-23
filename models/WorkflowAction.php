<?php

namespace app\models;

use yii\db\ActiveRecord;
use Yii;

class WorkflowAction extends ActiveRecord
{

    public static function tableName()
    {
        return "{{%workflow_action}}";
    }

    public function attributeLabels()
    {
        return [
            'action_name' => '动作名称',
            'action_key' => '动作标识',
            'next_node_id' => '下一个节点',
            'next_node_key' => '下一个节点标识'
        ];
    }

    public function rules()
    {
        return [
                [['action_name', 'action_key'], 'required', 'message' => '{attribute}不能为空'],
                [['workflow_node_id', 'is_deleted', 'next_node_id'], 'safe']
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
        $result = self::find()->where($where)->asArray()->all();
        return $result;
    }

}
