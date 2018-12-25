<?php
namespace app\modules\approve\controllers;
use Yii;
use app\models\EnterpriseLoan;

class AjaxController extends CommonController{
    public function init(){
        parent::init();
    }

    /**
     * [actionGetLoanInfo 银行审批授信 获取贷款信息]
     * @return [html] [html or empty]
     */
    public function actionGetLoanInfo(){
        $get      = Yii::$app->request->get();
        $loan_id  = empty($get['loan_id']) ? 0 : intval($get['loan_id']);
        $type_id  = empty($get['type_id']) ? 0 : intval($get['type_id']);

        $model    = new EnterpriseLoan();
        $loan_row = $model->find()->alias("a")
                          ->select('a.apply_amount,a.period_month,a.credit_amount,a.already_loan_amount,b.enterprise_name')
                          ->leftJoin('{{%enterprise_base}} b', 'b.base_id=a.base_id')
                          ->where(['a.loan_id' => $loan_id])->asArray()->one(); 
        $html = '';
        if(!empty($loan_row)){
            $html .= '<li><label>贷款企业名称：</label><span>'. $loan_row['enterprise_name'] .'</span></li>';
            $html .= '<li><label>期望贷款金额：</label><span>'. $loan_row['apply_amount'] .'万元</span></li>';
            $html .= '<li><label>期望贷款周期：</label><span>'. $loan_row['period_month'] .'个月</span></li>';
            if($type_id == 1){
                $amount_money = round($loan_row['credit_amount']-$loan_row['already_loan_amount'], 6);
                $html .= '<li><label>可用授信金额：</label><span>'. $amount_money .'</span>万</li>';
            }
        }      
        echo $html;
    }
   
}