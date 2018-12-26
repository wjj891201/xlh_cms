<?php

namespace app\modules\approve\controllers;

use Yii;
use app\models\EnterpriseLoan;
use app\models\WorkflowLog;

class AjaxController extends CommonController
{

    public function init()
    {
        parent::init();
    }

    /**
     * [actionGetLoanInfo 银行审批授信 获取贷款信息]
     * @return [html] [html or empty]
     */
    public function actionGetLoanInfo()
    {
        $get = Yii::$app->request->get();
        $loan_id = empty($get['loan_id']) ? 0 : intval($get['loan_id']);
        $type_id = empty($get['type_id']) ? 0 : intval($get['type_id']);

        $model = new EnterpriseLoan();
        $loan_row = $model->find()->alias("a")
                        ->select('a.apply_amount,a.period_month,a.credit_amount,a.already_loan_amount,b.enterprise_name')
                        ->leftJoin('{{%enterprise_base}} b', 'b.base_id=a.base_id')
                        ->where(['a.loan_id' => $loan_id])->asArray()->one();
        $html = '';
        if (!empty($loan_row))
        {
            $html .= '<li><label>贷款企业名称：</label><span>' . $loan_row['enterprise_name'] . '</span></li>';
            $html .= '<li><label>期望贷款金额：</label><span>' . $loan_row['apply_amount'] . '万元</span></li>';
            $html .= '<li><label>期望贷款周期：</label><span>' . $loan_row['period_month'] . '个月</span></li>';
            if ($type_id == 1)
            {
                $amount_money = round($loan_row['credit_amount'] - $loan_row['already_loan_amount'], 6);
                $html .= '<li><label>可用授信金额：</label><span>' . $amount_money . '</span>万</li>';
            }
        }
        echo $html;
    }

    public function actionGetLoanList()
    {
        $get = Yii::$app->request->get();
        $loan_id = empty($get['loan_id']) ? 0 : intval($get['loan_id']);
        $type_id = empty($get['type_id']) ? 0 : intval($get['type_id']);
    }

    /**
     * [actionUploads Ajax上传]
     * @return [string] [保存图片路径]
     */
    public function actionUploads()
    {
        $allowed_types = ['gif', 'jpg', 'jpeg', 'png', 'pdf', 'GIF', 'JPG', 'JPEG', 'PNG', 'PDF'];
        $max_size = 10240000; //10M

        $uploan_url = 'upfile/loan/' . date('Ymd') . '/';
        $result = $this->ajax_upload_do($uploan_url, 0, $allowed_types, $max_size);
        $result = json_decode($result, true);
        $file_path = '';
        if ($result['code'] == 20000)
        {
            $file_path = $result['success']['url'];
        }
        echo $file_path;
    }

    /**
     * 获取审核记录
     */
    public function actionGetStream()
    {
        $app_id = Yii::$app->request->post('app_id');
        $group_id = Yii::$app->request->post('group_id');
        $logs = WorkflowLog::find()->alias('wl')
                        ->select([
                            'o.name organization_name', 'wl.result', 'ifnull(wl.comment,\'\') comment', 'wn.node_name',
                            '(CASE WHEN wl.result = \'pass\' THEN \'通过\' WHEN wl.result = \'back\' then \'退回\' WHEN wl.result = \'end\' then \'终止\' WHEN wl.result = \'grant\' then \'成功\' WHEN wl.result = \'finish\' then \'完成\' ELSE \'\' END) AS result_ch',
                            'from_unixtime(wl.create_time,"%Y-%m-%d %H:%i:%s") create_time'
                        ])
                        ->leftJoin('{{%approve_user}} au', 'au.id=wl.user_id')
                        ->leftJoin('{{%organization}} o', 'o.id=au.belong')
                        ->leftJoin('{{%workflow_node}} wn', 'wn.id=wl.node_id')
                        ->where(['AND', ['wl.app_id' => $app_id, 'wl.group_id' => $group_id], ['NOT', ['wl.result' => null]]])
                        ->orderBy(['wl.id' => SORT_DESC])->asArray()->all();
        echo json_encode($logs);
        exit;
    }

}
