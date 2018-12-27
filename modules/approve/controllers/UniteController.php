<?php

namespace app\modules\approve\controllers;

use app\modules\approve\controllers\CommonController;
use Yii;
use app\models\WorkflowLog;
use app\models\WorkflowNode;
use app\models\Organization;
use app\models\WorkflowGroup;
use app\models\EnterpriseLoan;
use app\models\EnterpriseBase;
use Mypdf;

class UniteController extends CommonController
{

    public $group_id;
    public $loan_group_id;

    public function init()
    {
        $this->group_id = WorkflowGroup::find()->select('id')->where(['group_key' => 'material'])->scalar();
        $this->loan_group_id = WorkflowGroup::find()->select('id')->where(['group_key' => 'loan'])->scalar();
    }

    /**
     * 处理具体的审核动作
     */
    public function actionResult()
    {
        if (Yii::$app->request->isGet)
        {
            $workflow_log_id = Yii::$app->request->get('workflow_log_id');
            $action_key = Yii::$app->request->get('action_key');
            $next_node_id = Yii::$app->request->get('next_node_id');
            $data = ['result' => $action_key, 'update_time' => time(), 'is_read' => 1];
        }
        if (Yii::$app->request->isPost)
        {
            $workflow_log_id = Yii::$app->request->post('workflow_log_id');
            $action_key = Yii::$app->request->post('action_key');
            $next_node_id = Yii::$app->request->post('next_node_id');
            $comment = Yii::$app->request->post('comment');
            $data = ['result' => $action_key, 'update_time' => time(), 'comment' => $comment, 'is_read' => 1];
        }
        //当前记录
        $logInfo = WorkflowLog::findOne($workflow_log_id);
        //只有pass、back有下一个节点
        if (in_array($action_key, ['pass', 'back']))
        {
            if ($next_node_id)
            {
                $next_node_info = WorkflowNode::find()->where(['id' => $next_node_id])->asArray()->one();
                if ($next_node_info['approve_user_id'])
                {
                    //有审核用户
                    $user_id = $next_node_info['approve_user_id'];
                }
                else
                {
                    //无审核用户
                    //找出属于该机构的下属（目前暂定主键倒序的第一个，后期根据前台选择的来决定）
                    $info = Organization::find()->alias('o')->select(['o.name', 'au.id approve_user_id'])
                                    ->leftJoin('{{%approve_user}} au', 'au.belong=o.id')
                                    ->where(['o.pid' => $next_node_info['organization_id']])->orderBy(['o.id' => SORT_DESC])
                                    ->asArray()->one();
                    if (empty($info['approve_user_id']))
                    {
                        echo '<script>alert("机构(' . $info['name'] . ')下没有审核用户");</script>';
                        exit;
                    }
                    else
                    {
                        $user_id = $info['approve_user_id'];
                    }
                }
                //生成下一条审核的预信息
                $data2 = [
                    'app_id' => $logInfo['app_id'],
                    'user_id' => $user_id,
                    'group_id' => $logInfo['group_id'],
                    'node_id' => $next_node_id,
                    'operate_user_id' => Yii::$app->approvr_user->identity->id,
                    'create_time' => time()
                ];
                Yii::$app->db->createCommand()->insert("{{%workflow_log}}", $data2)->execute();
            }
        }
        //把审批结果更新一下
        if ($next_node_id || in_array($action_key, ['end', 'defer', 'finish', 'grant']))
        {
            if ($action_key == 'grant')
            { //授信
                $grant_data['credit_amount'] = Yii::$app->request->post('credit_amount');
                $grant_data['credit_time'] = Yii::$app->request->post('credit_time');
                $grant_data['credit_validity'] = Yii::$app->request->post('credit_validity');
                $grant_data['loan_id'] = Yii::$app->request->post('loan_id');
                $model = new EnterpriseLoan();
                $res = $model->grant_edit($grant_data, ['loan_id' => $grant_data['loan_id']]);
                $errors = $model->firstErrors;
                if (!$res && !empty($errors))
                {
                    $i = 0;
                    $arr = [];
                    foreach ($errors as $k => $v)
                    {
                        if ($i == 0)
                        {
                            $arr['key'] = $k;
                            $arr['val'] = $v;
                        }
                        $i++;
                    }
                    exit(json_encode(['status' => false, 'msg' => $arr]));
                }
                else
                {
                    WorkflowLog::updateAll($data, ['id' => $workflow_log_id]);
                    exit(json_encode(['status' => true, 'msg' => '授信成功']));
                }
                exit;
            }
            WorkflowLog::updateAll($data, ['id' => $workflow_log_id]);
        }
        else
        {
            //没下一个节点同时满足$action_key为back，则意味着退回到了资料提交者，可以再次编辑
            if ($action_key == 'back')
            {
                $data['is_origin'] = 1;
                WorkflowLog::updateAll($data, ['id' => $workflow_log_id]);
            }
        }
        #如果科技资质认证管理审核结束，那么就进行科技贷申请的流程审核~~~start
        if ($logInfo['group_id'] == $this->group_id && $action_key == 'finish')
        {
            $first_loan_node_info = WorkflowNode::find()->where(['workflow_group_id' => $this->loan_group_id, 'node_key' => 'node_1'])->asArray()->one();
            if ($first_loan_node_info['approve_user_id'])
            {
                //有审核用户
                $user_id = $first_loan_node_info['approve_user_id'];
            }
            //生成贷款审核的预信息
            $data3 = [
                'app_id' => $logInfo['app_id'],
                'user_id' => $user_id,
                'group_id' => $this->loan_group_id,
                'node_id' => $first_loan_node_info['id'],
                'operate_user_id' => Yii::$app->approvr_user->identity->id,
                'create_time' => time()
            ];
            Yii::$app->db->createCommand()->insert("{{%workflow_log}}", $data3)->execute();
        }
        #如果科技资质认证管理审核结束，那么就进行科技贷申请的流程审核~~~end   
        //从哪来回哪去
        $this->goBack(Yii::$app->request->headers['Referer']);
    }

    /**
     * 查看申请资料
     */
    public function actionGetInfo()
    {
        $base_id = Yii::$app->request->get('base_id');
        $base = EnterpriseBase::findOne(['base_id' => $base_id]);
        return $this->render("get_info", ['base' => $base]);
    }

}
