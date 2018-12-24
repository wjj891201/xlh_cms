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
        $loan_id  = Yii::$app->request->get('loan_id');
        $loan_id  = empty($loan_id) ? 0 : intval($loan_id);
        $model    = new EnterpriseLoan();
        $loan_row = $model->find()->alias("a")->select('a.apply_amount,a.period_month,b.enterprise_name')->leftJoin('{{%enterprise_base}} b', 'b.base_id=a.base_id')->where(['a.loan_id' => $loan_id])->asArray()->one(); 
        $html = '';
        if(!empty($loan_row)){
            $html .= '<li><label>贷款企业名称</label><span>'. $loan_row['enterprise_name'] .'</span></li>';
            $html .= '<li><label>期望贷款金额</label><span>'. $loan_row['apply_amount'] .'万元</span></li>';
            $html .= '<li><label>期望贷款周期</label><span>'. $loan_row['period_month'] .'个月</span></li>';
        }                       
        echo $html;
    }
   
}