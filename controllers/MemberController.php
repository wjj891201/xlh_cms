<?php

namespace app\controllers;

use app\controllers\CheckController;
use Yii;
use yii\helpers\Url;
use app\libs\Tool;
use app\models\Member;
use app\models\EnterpriseBase;
use app\models\WorkflowGroup;
use app\models\WorkflowLog;
use app\models\ApproveUser;
use app\models\Organization;
use app\models\WorkflowNode;
use app\models\EnterpriseLoanContract;

class MemberController extends CheckController
{

    /**
     * 会员中心~~~~账号管理
     */
    public function actionCenter()
    {

        return $this->render('center');
    }

    /**
     * 会员中心~~~~密码管理
     */
    public function actionPsw()
    {
        $model = new Member;
        $request = Yii::$app->request;
        if ($request->isPost)
        {
            $post = Yii::$app->request->post();
            if ($model->changePass($post))
            {
                return $this->redirect(['call/mess', 'mess' => '密码修改成功', 'url' => Url::to(['member/center'])]);
            }
        }
        return $this->render('psw', ['model' => $model]);
    }

    /**
     * 科技贷申请管理
     */
    public function actionLoanList()
    {
        # 1.0获取流程组id
        $loan_group_id = WorkflowGroup::find()->select('id')->where(['group_key' => 'loan'])->scalar();
        # 2.0查询列表
        $list = EnterpriseBase::find()->alias('eb')
                        ->select(['eb.enterprise_name', 'el.*'])
                        ->leftJoin('{{%enterprise_loan}} el', 'eb.base_id=el.base_id')
                        ->where(['eb.user_id' => $this->userid])
                        ->asArray()->all();
        $temp = [];
        foreach ($list as $key => $vo)
        {
            $log_info = WorkflowLog::find()->select(['id', 'user_id', 'node_id', 'result'])->where(['app_id' => $vo['base_id'], 'group_id' => $loan_group_id])->orderBy(['id' => SORT_DESC])->asArray()->one();
            $vo['log_id'] = $log_info['id'];
            $vo['approve_user_id'] = $log_info['user_id'];
            $approve_user_info = ApproveUser::find()->select(['username', 'belong'])->where(['id' => $log_info['user_id']])->asArray()->one();
            $vo['approve_user_name'] = $approve_user_info['username'];
            $vo['result'] = $log_info['result'];
            $vo['organization_name'] = Organization::find()->select('name')->where(['id' => $approve_user_info['belong']])->scalar();
            $vo['node_name'] = WorkflowNode::find()->select('node_name')->where(['id' => $log_info['node_id']])->scalar();
            $str = '';
            switch ($log_info['result'])
            {
                case 'pass':
                    $str = '通过';
                    break;
                case 'back':
                    $str = '退回';
                    break;
                case 'end':
                    $str = '终止';
                    break;
                case 'defer':
                    $str = '暂缓';
                    break;
                case 'grant':
                    $str = '授信';
                    break;
                case 'finish':
                    $str = '已通过';
                    break;
                default:
                    break;
            }
            $vo['result_cn'] = $str;
            $vo['loan_repay'] = EnterpriseLoanContract::find()->where(['loan_id' => $vo['loan_id']])->asArray()->all();
            $temp[] = $vo;
        }
        $list = $temp;
        return $this->render('loan-list', ['list' => $list]);
    }

    /**
     * 资质详情页
     */
    public function actionLoanDetail()
    {
        $base_id = Yii::$app->request->get('base_id');
        $base = EnterpriseBase::findOne(['base_id' => $base_id]);
        return $this->render('four_detail', ['base' => $base]);
    }

    /**
     * 科技资质认证管理
     */
    public function actionEnterpriseList()
    {
        # 1.0获取流程组id
        $group_id = WorkflowGroup::find()->select('id')->where(['group_key' => 'material'])->scalar();
        # 2.0查询列表
        $list = EnterpriseBase::find()->alias('eb')
                        ->select(['eb.*', 'tl.name town_name'])
                        ->leftJoin('{{%town_list}} tl', 'eb.town_id=tl.id')
                        ->where(['eb.user_id' => $this->userid])
                        ->asArray()->all();
        $temp = [];
        foreach ($list as $key => $vo)
        {
            $log_info = WorkflowLog::find()->select(['id', 'user_id', 'node_id', 'result'])->where(['app_id' => $vo['base_id'], 'group_id' => $group_id])->orderBy(['id' => SORT_DESC])->asArray()->one();
            $vo['log_id'] = $log_info['id'];
            $vo['approve_user_id'] = $log_info['user_id'];
            $approve_user_info = ApproveUser::find()->select(['username', 'belong'])->where(['id' => $log_info['user_id']])->asArray()->one();
            $vo['approve_user_name'] = $approve_user_info['username'];
            $vo['result'] = $log_info['result'];
            $vo['organization_name'] = Organization::find()->select('name')->where(['id' => $approve_user_info['belong']])->scalar();
            $vo['node_name'] = WorkflowNode::find()->select('node_name')->where(['id' => $log_info['node_id']])->scalar();
            $str = '';
            switch ($log_info['result'])
            {
                case 'pass':
                    $str = '通过';
                    break;
                case 'back':
                    $str = '退回';
                    break;
                case 'end':
                    $str = '终止';
                    break;
                case 'defer':
                    $str = '暂缓';
                    break;
                case 'grant':
                    $str = '授信';
                    break;
                case 'finish':
                    $str = '已通过';
                    break;
                default:
                    break;
            }
            $vo['result_cn'] = $str;
            $temp[] = $vo;
        }
        $list = $temp;
        return $this->render('enterprise-list', ['list' => $list]);
    }

    /**
     * 资质详情页
     */
    public function actionBaseDetail()
    {
        $base_id = Yii::$app->request->get('base_id');
        $base = EnterpriseBase::findOne(['base_id' => $base_id]);
        return $this->render('four_detail', ['base' => $base]);
    }

    /**
     * 下载模板文件
     */
    public function actionDownloadGuideFiles()
    {
        $type = Yii::$app->request->get('type');
        $file = Yii::$app->request->get('file');
        switch ($type)
        {
            case '1':
                $true_file = 'public/kjd/file/export_report.pdf';
                break;
            case '2':
                $true_file = $file;
                break;
        }
        Tool::downloadFile($true_file);
    }

    /**
     * 获取原因
     */
    public function actionGetReason()
    {
        $log_id = Yii::$app->request->post('log_id');
        $info = WorkflowLog::find()->where(['id' => $log_id])->asArray()->one();
        echo json_encode($info);
        exit;
    }

}
