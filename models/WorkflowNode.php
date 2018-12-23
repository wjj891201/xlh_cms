<?php

namespace app\models;

use yii\db\ActiveRecord;
use Yii;

class WorkflowNode extends ActiveRecord
{

    public static function tableName()
    {
        return "{{%workflow_node}}";
    }

    public function attributeLabels()
    {
        return [
            'node_name' => '节点名称',
            'node_key' => '节点标识',
            'organization_id' => '所属机构'
        ];
    }

    public function rules()
    {
        return [
                [['node_name', 'node_key', 'organization_id'], 'required', 'message' => '{attribute}不能为空'],
                ['node_key', 'validateNodeKey'],
                [['workflow_group_id', 'is_deleted', 'style', 'approve_user_id'], 'safe'],
        ];
    }

    /**
     * 自定义验证node_key唯一性
     */
    public function validateNodeKey()
    {
        if (!$this->hasErrors())
        {
            if ($this->id)
            {
                //编辑的验证(需排除自己)
                $data = self::find()->where(['AND', ['workflow_group_id' => $this->workflow_group_id, 'node_key' => $this->node_key], ['<>', 'id', $this->id]])->one();
            }
            else
            {
                //添加的验证
                $data = self::find()->where(['workflow_group_id' => $this->workflow_group_id, 'node_key' => $this->node_key])->one();
            }
            if (!is_null($data))
            {
                $this->addError('node_key', '节点标识已存在');
            }
        }
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

    /**
     * 获取机构名称
     */
    public function getOrganization()
    {
        return $this->hasOne(Organization::className(), ['id' => 'organization_id']);
    }

    /**
     * 获取审核员
     */
    public function getApproveUser()
    {
        return $this->hasOne(ApproveUser::className(), ['id' => 'approve_user_id']);
    }

}
