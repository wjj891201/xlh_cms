<?php

namespace app\modules\approve\controllers;

use app\modules\approve\controllers\CommonController;
use Yii;
use yii\data\Pagination;
use app\models\WorkflowLog;
use app\models\WorkflowNode;
use app\models\WorkflowAction;
use app\models\WorkflowGroup;

class LoanHandleController extends CommonController
{

    public $group_id;
    public $loan_group_id;

    public function init()
    {
        $this->group_id = WorkflowGroup::find()->select('id')->where(['group_key' => 'material'])->scalar();
        $this->loan_group_id = WorkflowGroup::find()->select('id')->where(['group_key' => 'loan'])->scalar();
    }

    /**
     * 待审核企业
     */
    public function actionLoanWaitFor()
    {
        $approve_user_id = Yii::$app->approvr_user->identity->id;
        $pageSize = 20;
        $query = WorkflowLog::find()->alias('wfl')
                ->select([
                    'wfl.id workflow_log_id', 'wfl.app_id', 'wfl.group_id', 'wfl.user_id approve_user_id', 'wfl.group_id', 'wfl.node_id', 'wfl.is_read',
                    'b.base_id', 'b.enterprise_name', 'b.contact_person_man', 'b.contact_person_phone', 'b.base_create_time',
                    'l.loan_id', 'l.apply_amount', 'l.period_month',
                    'tl.name town_name',
                ])
                ->leftJoin('{{%enterprise_base}} b', 'b.base_id=wfl.app_id')
                ->leftJoin('{{%enterprise_loan}} l', 'l.base_id=wfl.app_id')
                ->leftJoin('{{%town_list}} tl', 'tl.id=b.town_id')
                ->where(['AND', ['wfl.user_id' => $approve_user_id], ['OR', ['wfl.result' => null], ['wfl.result' => '']], ['wfl.group_id' => $this->loan_group_id]]);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => $pageSize]);
        $data = $query->offset($pages->offset)->limit($pages->limit)->asArray()->all();
        $temp = [];
        foreach ($data as $key => $vo)
        {
            #根据节点获取该节点具有的动作
            $vo['actionList'] = WorkflowAction::getData(['workflow_node_id' => $vo['node_id']]);
            $temp[] = $vo;
        }
        $data = $temp;
        return $this->render("wait-for", ['data' => $data, 'pages' => $pages]);
    }

    /**
     * 被终止企业
     */
    public function actionLoanEnd()
    {
        $app_ids = WorkflowLog::find()->select('app_id')->where(['user_id' => Yii::$app->approvr_user->identity->id])->asArray()->column();
        $pageSize = 20;
        $query = WorkflowLog::find()->alias('wfl')
                ->select([
                    'wfl.id workflow_log_id', 'wfl.app_id', 'wfl.group_id', 'wfl.user_id approve_user_id',
                    'b.base_id', 'b.enterprise_name', 'b.contact_person_man', 'b.contact_person_phone', 'b.base_create_time',
                    'l.loan_id', 'l.apply_amount', 'l.period_month',
                    'tl.name town_name',
                ])
                ->leftJoin('{{%enterprise_base}} b', 'b.base_id=wfl.app_id')
                ->leftJoin('{{%enterprise_loan}} l', 'l.base_id=wfl.app_id')
                ->leftJoin('{{%town_list}} tl', 'tl.id=b.town_id')
                ->where(['AND', ['IN', 'wfl.app_id', $app_ids], ['wfl.result' => 'end'], ['wfl.group_id' => $this->loan_group_id]]);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => $pageSize]);
        $data = $query->offset($pages->offset)->limit($pages->limit)->asArray()->all();
        return $this->render("end", ['data' => $data, 'pages' => $pages]);
    }

    /**
     * 被退回企业
     */
    public function actionLoanBack()
    {
        $app_ids = WorkflowLog::find()->select('app_id')->where(['user_id' => Yii::$app->approvr_user->identity->id])->asArray()->column();
        $pageSize = 20;
        $query = WorkflowLog::find()->alias('wfl')
                ->select([
                    'wfl.id workflow_log_id', 'wfl.app_id', 'wfl.group_id', 'wfl.user_id approve_user_id',
                    'b.base_id', 'b.enterprise_name', 'b.contact_person_man', 'b.contact_person_phone', 'b.base_create_time',
                    'l.loan_id', 'l.apply_amount', 'l.period_month',
                    'tl.name town_name',
                ])
                ->leftJoin('{{%enterprise_base}} b', 'b.base_id=wfl.app_id')
                ->leftJoin('{{%enterprise_loan}} l', 'l.base_id=wfl.app_id')
                ->leftJoin('{{%town_list}} tl', 'tl.id=b.town_id')
                ->where(['AND', ['IN', 'wfl.app_id', $app_ids], ['wfl.result' => 'back'], ['wfl.group_id' => $this->loan_group_id]]);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => $pageSize]);
        $data = $query->offset($pages->offset)->limit($pages->limit)->asArray()->all();
        return $this->render("back", ['data' => $data, 'pages' => $pages]);
    }

    /**
     * 被暂存企业
     */
    public function actionLoanDefer()
    {
        $approve_user_id = Yii::$app->approvr_user->identity->id;
        $approve_organization_id = Yii::$app->approvr_user->identity->belong;
        $app_ids = WorkflowLog::find()->select('app_id')->where(['user_id' => Yii::$app->approvr_user->identity->id])->asArray()->column();
        $pageSize = 20;
        $query = WorkflowLog::find()->alias('wfl')
                ->select([
                    'wfl.id workflow_log_id', 'wfl.app_id', 'wfl.group_id', 'wfl.user_id approve_user_id',
                    'b.base_id', 'b.enterprise_name', 'b.contact_person_man', 'b.contact_person_phone', 'b.base_create_time',
                    'l.loan_id', 'l.apply_amount', 'l.period_month',
                    'tl.name town_name',
                ])
                ->leftJoin('{{%enterprise_base}} b', 'b.base_id=wfl.app_id')
                ->leftJoin('{{%enterprise_loan}} l', 'l.base_id=wfl.app_id')
                ->leftJoin('{{%town_list}} tl', 'tl.id=b.town_id')
                ->where(['AND', ['IN', 'wfl.app_id', $app_ids], ['wfl.result' => 'defer'], ['wfl.group_id' => $this->loan_group_id]]);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => $pageSize]);
        $data = $query->offset($pages->offset)->limit($pages->limit)->asArray()->all();

        #获取用户要审批哪个节点 1先用审批用户id去查 2再用审批用户所属机构去查
        $nodeInfo = WorkflowNode::find()->where(['approve_user_id' => $approve_user_id])->asArray()->one();
        if (!empty($nodeInfo))
        {
            $node_id = $nodeInfo['id'];
        }
        else
        {
            $nodeInfo = WorkflowNode::find()->where(['organization_id' => $approve_organization_id])->asArray()->one();
            $node_id = !empty($nodeInfo) ? $nodeInfo['id'] : '';
        }
        #根据节点获取该节点具有的动作
        $actionList = WorkflowAction::getData(['workflow_node_id' => $node_id]);
        return $this->render("defer", ['data' => $data, 'pages' => $pages, 'actionList' => $actionList]);
    }

    /**
     * 已通过企业
     */
    public function actionLoanFinish()
    {
        $app_ids = WorkflowLog::find()->select('app_id')->where(['user_id' => Yii::$app->approvr_user->identity->id])->asArray()->column();
        $pageSize = 20;
        $query = WorkflowLog::find()->alias('wfl')
                ->select([
                    'wfl.id workflow_log_id', 'wfl.app_id', 'wfl.group_id', 'wfl.user_id approve_user_id',
                    'b.base_id', 'b.enterprise_name', 'b.contact_person_man', 'b.contact_person_phone', 'b.base_create_time',
                    'l.loan_id', 'l.apply_amount', 'l.period_month',
                    'tl.name town_name',
                ])
                ->leftJoin('{{%enterprise_base}} b', 'b.base_id=wfl.app_id')
                ->leftJoin('{{%enterprise_loan}} l', 'l.base_id=wfl.app_id')
                ->leftJoin('{{%town_list}} tl', 'tl.id=b.town_id')
                ->where(['AND', ['IN', 'wfl.app_id', $app_ids], ['OR', ['wfl.result' => 'finish'], ['wfl.result' => 'grant']], ['wfl.group_id' => $this->loan_group_id]]);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => $pageSize]);
        $data = $query->offset($pages->offset)->limit($pages->limit)->asArray()->all();
        return $this->render("finish", ['data' => $data, 'pages' => $pages]);
    }

}
