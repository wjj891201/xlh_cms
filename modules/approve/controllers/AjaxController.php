<?php

namespace app\modules\approve\controllers;

use Yii;
use yii\helpers\Url;
use app\libs\Tool;
use yii\helpers\ArrayHelper;
use app\models\EnterpriseLoan;
use app\models\WorkflowLog;
use app\models\EnterpriseLoanContract;

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

        $html = '';
        if ($loan_id)
        {
            $info = EnterpriseLoan::find()->alias('a')
                            ->select(['a.loan_id', 'b.base_id', 'b.enterprise_name'])
                            ->leftJoin('{{%enterprise_base}} b', 'b.base_id=a.base_id')
                            ->asArray()->one();

            $list = EnterpriseLoanContract::find()->alias('a')
                            ->select(['b.apply_amount', 'b.period_month', 'a.loan_create_time', 'a.contract_num', 'a.loan_amount_money', 'a.contract_loan_start_time', 'a.contract_loan_end_time', 'a.loan_day', 'a.loan_rate', 'a.loan_benchmark_rate', 'a.repayment_mode', 'a.loan_voucher'])
                            ->leftJoin('{{%enterprise_loan}} b', 'b.loan_id=a.loan_id')
                            ->where(['a.loan_id' => $loan_id])->asArray()->all();
            
            $repayment_mode = Yii::$app->params['repayment_mode']; //还款方式
            $repayment_mode = ArrayHelper::index($repayment_mode, 'id');
            if (!empty($list))
            {
                foreach ($list as $v)
                {
                    $html .= '<ul>';
                    $html .= '<li><label>贷款录入时间：</label><p>' . $v['loan_create_time'] . '</p></li>';
                    $html .= '<li><label>贷款企业名称：</label><p>' . $info['enterprise_name'] . '</p></li>';
                    $html .= '<li><label>期望贷款金额：</label><p>' . $v['apply_amount'] . '万</p></li>';
                    $html .= '<li><label>期望贷款周期：</label><p>' . $v['period_month'] . '月</p></li>';
                    $html .= '<li><label>贷款合同号：</label><p>' . $v['contract_num'] . '</p></li>';
                    $html .= '<li><label>实际放贷金额：</label><p>' . $v['loan_amount_money'] . '万</p></li>';
                    $html .= '<li><label>贷款开始时间：</label><p>' . $v['contract_loan_start_time'] . '</p></li>';
                    $html .= '<li><label>贷款结束时间：</label><p>' . $v['contract_loan_end_time'] . '</p></li>';
                    $html .= '<li><label>贷款周期：</label><p>' . $v['loan_day'] . '天</p></li>';
                    $html .= '<li><label>贷款利率：</label><p>' . $v['loan_rate'] . '%</p></li>';
                    $html .= '<li><label>基准利率：</label><p>' . $v['loan_benchmark_rate'] . '%</p></li>';
                    $repayment_mode_info = isset($repayment_mode[$v['repayment_mode']]['name']) ? $repayment_mode[$v['repayment_mode']]['name'] : '其他';
                    $html .= '<li><label>还款方式：</label><p>' . $repayment_mode_info . '</p></li>';
                    $html .= '<li><label>放款凭证：</label><p><a href="' . Url::to(['ajax/download', 'filename' => $v['loan_voucher']]) . '" style = "cursor:pointer;color:#4479cf">下载</a></p></li>';
                    $html .= '</ul>';
                }
            }
        }
        echo $html;
    }

    public function actionGetRepaymentInfo()
    {
        $get = Yii::$app->request->get();
        $loan_id = empty($get['loan_id']) ? 0 : intval($get['loan_id']);
        $html = '<option value="">请选择还款合同</option>';
        if (!empty($loan_id))
        {
            $list = EnterpriseLoanContract::find()
                            ->select(['contract_id', 'contract_num'])
                            ->where(['loan_contract_status' => 0, 'loan_id' => $loan_id])
                            ->asArray()->all();
            if (!empty($list))
            {
                foreach ($list as $v)
                {
                    $html .= '<option value="' . $v['contract_id'] . '">' . $v['contract_num'] . '</option>';
                }
            }
        }
        echo $html;
    }

    public function actionGetRepaymentList()
    {
        $get = Yii::$app->request->get();
        $loan_id = empty($get['loan_id']) ? 0 : intval($get['loan_id']);
        $type_id = empty($get['type_id']) ? 0 : intval($get['type_id']);

        $html = '';
        if ($loan_id)
        {
            $info = EnterpriseLoan::find()->alias('a')
                            ->select(['a.loan_id', 'b.base_id', 'b.enterprise_name'])
                            ->leftJoin('{{%enterprise_base}} b', 'b.base_id=a.base_id')
                            ->asArray()->one();

            $list = EnterpriseLoanContract::find()->alias('a')
                            ->select(['b.apply_amount', 'b.period_month', 'a.loan_create_time', 'a.repayment_create_time', 'a.contract_num', 'a.repayment_status', 'a.contract_repayment_start_time', 'a.contract_repayment_end_time', 'a.repayment_voucher'])
                            ->leftJoin('{{%enterprise_loan}} b', 'b.loan_id=a.loan_id')
                            ->where(['a.loan_id' => $loan_id, 'a.loan_contract_status' => 1])
                            ->asArray()->all();

            $repayment_status = Yii::$app->params['repayment_status'];
            $repayment_status = ArrayHelper::index($repayment_status, 'id');
            if (!empty($list))
            {
                foreach ($list as $v)
                {
                    $html .= '<ul>';
                    $html .= '<li><label>还款录入时间：</label><p>' . $v['repayment_create_time'] . '</p></li>';
                    $html .= '<li><label>贷款企业名称：</label><p>' . $info['enterprise_name'] . '</p></li>';
                    $html .= '<li><label>贷款合同号：</label><p>' . $v['contract_num'] . '</p></li>';
                    $repayment_status_info = isset($repayment_status[$v['repayment_status']]['name']) ? $repayment_status[$v['repayment_status']]['name'] : '其他';
                    $html .= '<li><label>还款状态：</label><p>' . $repayment_status_info . '</p></li>';
                    $html .= '<li><label>还款开始时间：</label><p>' . $v['contract_repayment_start_time'] . '</p></li>';
                    $html .= '<li><label>还款截止时间：</label><p>' . $v['contract_repayment_end_time'] . '</p></li>';
                    $html .= '<li><label>还款凭证：</label><p><a href="' . Url::to(['ajax/download', 'filename' => $v['repayment_voucher']]) . '" style = "cursor:pointer;color:#4479cf">下载</a></p></li>';
                    $html .= '</ul>';
                }
            }
        }
        echo $html;
    }

    /**
     * [actionUploads Ajax上传]
     * @return [string] [保存图片路径]
     */
    public function actionUploads()
    {
        $allowed_types = ['gif', 'jpg', 'jpeg', 'png', 'pdf', 'GIF', 'JPG', 'JPEG', 'PNG', 'PDF'];
        $max_size = 10240000; //10M

        $uploan_url = 'upfile/contract/' . date('Ymd') . '/';
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

    /**
     * [do_download 下载]
     * @return [void] 
     */
    public function actionDownload()
    {
        $filename = Yii::$app->request->get('filename');
        $filename = trim($filename, '/');
        if (@is_file($filename))
        {
            Tool::downloadFile($filename);
        }
        else
        {
            echo "文件不存在！";
        }
    }

}
