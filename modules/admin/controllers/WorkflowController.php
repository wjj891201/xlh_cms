<?php

/**
 * 功能描述 （工作流）
 * ============================================================================
 * * All Rights Reserved by Xinlonghang Network Technology Co,.Ltd of SHANGHAI.
 * 网站地址: http://www.easyrong.com；
 * ============================================================================
 * $Author: wujiepeng $
 */

namespace app\modules\admin\controllers;

use app\modules\admin\controllers\CommonController;
use Yii;
use yii\helpers\ArrayHelper;
use app\models\Organization;
use app\models\WorkflowGroup;
use app\models\WorkflowNode;
use app\models\WorkflowAction;
use app\models\ApproveUser;

class WorkflowController extends CommonController
{

    /**
     * 流程组列表
     */
    public function actionGroupList()
    {
        $list = WorkflowGroup::find()->all();
        return $this->render('group-list', ['list' => $list]);
    }

    /**
     * 添加流程组
     */
    public function actionGroupAdd()
    {
        $model = new WorkflowGroup;
        if (Yii::$app->request->isPost)
        {
            $post = Yii::$app->request->post();
            if ($model->add($post))
            {
                Yii::$app->session->setFlash("success", "添加成功");
                return $this->redirect(['workflow/group-list']);
            }
        }
        $model->enable = 1;
        return $this->render('group-add', ['model' => $model]);
    }

    /**
     * 删除流程组
     */
    public function actionGroupDel()
    {
        $group_id = Yii::$app->request->get('group_id');
        $node_list = WorkflowNode::getData(['workflow_group_id' => $group_id]);
        if (empty($node_list))
        {
            WorkflowGroup::deleteAll(['id' => $group_id]);
            Yii::$app->session->setFlash("success", "删除成功");
            return $this->redirect(['workflow/group-list']);
        }
        else
        {
            Yii::$app->session->setFlash("error", "请先删除该流程下的节点");
            return $this->redirect(['workflow/group-list']);
        }
    }

    /**
     * 节点列表
     */
    public function actionNodeList()
    {
        # 流程组详情
        $group_id = Yii::$app->request->get('group_id');
        $groupInfo = WorkflowGroup::find()->where(['id' => $group_id])->asArray()->one();
        # 节点列表
        $list = WorkflowNode::find()->where(['workflow_group_id' => $group_id])->all();
        return $this->render('node-list', ['list' => $list, 'groupInfo' => $groupInfo]);
    }

    /**
     * 添加节点
     */
    public function actionNodeAdd()
    {
        $group_id = Yii::$app->request->get('group_id');
        $groupInfo = WorkflowGroup::find()->where(['id' => $group_id])->asArray()->one();
        $model = new WorkflowNode;
        if (Yii::$app->request->isPost)
        {
            $post = Yii::$app->request->post();
            if ($model->add($post))
            {
                Yii::$app->session->setFlash("success", "添加成功");
                return $this->redirect(['workflow/node-list', 'group_id' => $group_id]);
            }
        }
        $model->is_deleted = 0;
        $model->workflow_group_id = $group_id;
        #查询所有机构
        $allOrganization = (new Organization)->getOptions();
        #审核员初始化
        $approveUser = ['' => '请选择审核员'];
        return $this->render('node-add', ['model' => $model, 'groupInfo' => $groupInfo, 'allOrganization' => $allOrganization, 'approveUser' => $approveUser]);
    }

    /**
     * 编辑节点
     */
    public function actionNodeEdit()
    {
        $node_id = Yii::$app->request->get("node_id");
        $model = WorkflowNode::find()->where('id = :id', [':id' => $node_id])->one();
        $groupInfo = WorkflowGroup::find()->where(['id' => $model->workflow_group_id])->asArray()->one();
        if (Yii::$app->request->isPost)
        {
            $post = Yii::$app->request->post();
            if ($model->add($post))
            {
                Yii::$app->session->setFlash("success", "编辑成功");
                return $this->redirect(['workflow/node-list', 'group_id' => $model->workflow_group_id]);
            }
        }
        #查询所有机构
        $allOrganization = (new Organization)->getOptions();
        #审核员初始化
        $approveUser = ApproveUser::find()->select(['id', 'username'])->where(['belong' => $model->organization_id])->asArray()->all();
        $approveUser = ArrayHelper::map($approveUser, 'id', 'username');
        $options = ['' => '请选择审核员'];
        foreach ($approveUser as $key => $vo)
        {
            $options[$key] = $vo;
        }
        $approveUser = $options;
        return $this->render('node-add', ['model' => $model, 'groupInfo' => $groupInfo, 'allOrganization' => $allOrganization, 'approveUser' => $approveUser]);
    }

    /**
     * 删除节点
     */
    public function actionNodeDel()
    {
        $node_id = Yii::$app->request->get('node_id');
        $group_id = WorkflowNode::find()->select('workflow_group_id')->where(['id' => $node_id])->scalar();
        //先删除动作
        WorkflowAction::deleteAll(['workflow_node_id' => $node_id]);
        //再删除节点
        WorkflowNode::deleteAll(['id' => $node_id]);
        Yii::$app->session->setFlash("success", "删除成功");
        return $this->redirect(['workflow/node-list', 'group_id' => $group_id]);
    }

    /**
     * ajax获取机构用户
     */
    public function actionAjaxGetUser()
    {
        if (Yii::$app->request->isAjax)
        {
            $organization_id = Yii::$app->request->post('organization_id');
            $list = ApproveUser::find()->select(['id', 'username'])->where(['belong' => $organization_id])->asArray()->all();
            echo json_encode($list);
            exit;
        }
    }

    /**
     * 动作列表
     */
    public function actionActionList()
    {
        $node_id = Yii::$app->request->get('node_id');
        $nodeInfo = WorkflowNode::find()->where(['id' => $node_id])->asArray()->one();

        $list = WorkflowAction::find()->select(['a.*', 'n.node_name'])->alias('a')->leftJoin('{{%workflow_node}} n', 'n.id=a.next_node_id')->where(['a.workflow_node_id' => $node_id])->asArray()->all();
        return $this->render('action-list', ['nodeInfo' => $nodeInfo, 'list' => $list]);
    }

    /**
     * 添加动作
     */
    public function actionActionAdd()
    {
        $node_id = Yii::$app->request->get('node_id');
        $nodeInfo = WorkflowNode::find()->where(['id' => $node_id])->asArray()->one();
        $model = new WorkflowAction;
        if (Yii::$app->request->isPost)
        {
            $post = Yii::$app->request->post();
            if ($model->add($post))
            {
                Yii::$app->session->setFlash("success", "添加成功");
                return $this->redirect(['workflow/action-list', 'node_id' => $node_id]);
            }
        }
        $model->is_deleted = 0;
        $model->workflow_node_id = $node_id;
        #获取配置中的动作
        $action_key_list = Yii::$app->params['action_key_list'];
        #查询所有节点
        $allNode = WorkflowNode::find()->where(['AND', ['workflow_group_id' => $nodeInfo['workflow_group_id']], ['<>', 'id', $nodeInfo['id']]])->asArray()->all();
        $allNode = ArrayHelper::map($allNode, 'id', 'node_name');
        $options = ['' => '请选择节点'];
        foreach ($allNode as $key => $vo)
        {
            $options[$key] = $vo;
        }
        $allNode = $options;
        return $this->render('action-add', ['model' => $model, 'nodeInfo' => $nodeInfo, 'action_key_list' => $action_key_list, 'allNode' => $allNode]);
    }

    /**
     * 编辑动作
     */
    public function actionActionEdit()
    {
        $action_id = Yii::$app->request->get('action_id');
        $model = WorkflowAction::find()->where(['id' => $action_id])->one();
        $nodeInfo = WorkflowNode::find()->where(['id' => $model->workflow_node_id])->asArray()->one();
        if (Yii::$app->request->isPost)
        {
            $post = Yii::$app->request->post();
            if ($model->add($post))
            {
                Yii::$app->session->setFlash("success", "编辑成功");
                return $this->redirect(['workflow/action-list', 'node_id' => $model->workflow_node_id]);
            }
        }
        #获取配置中的动作
        $action_key_list = Yii::$app->params['action_key_list'];
        #查询所有节点
        $allNode = WorkflowNode::find()->where(['AND', ['workflow_group_id' => $nodeInfo['workflow_group_id']], ['<>', 'id', $nodeInfo['id']]])->asArray()->all();
        $allNode = ArrayHelper::map($allNode, 'id', 'node_name');
        $options = ['' => '请选择节点'];
        foreach ($allNode as $key => $vo)
        {
            $options[$key] = $vo;
        }
        $allNode = $options;
        return $this->render('action-add', ['model' => $model, 'nodeInfo' => $nodeInfo, 'action_key_list' => $action_key_list, 'allNode' => $allNode]);
    }

    /**
     * 删除动作
     */
    public function actionActionDel()
    {
        $action_id = Yii::$app->request->get('action_id');
        $node_id = WorkflowAction::find()->select('workflow_node_id')->where(['id' => $action_id])->scalar();
        WorkflowAction::deleteAll(['id' => $action_id]);
        Yii::$app->session->setFlash("success", "删除成功");
        return $this->redirect(['workflow/action-list', 'node_id' => $node_id]);
    }

}
