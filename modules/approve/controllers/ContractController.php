<?php 
namespace app\modules\approve\controllers;

use Yii;
use app\models\EnterpriseLoanContract;

class ContractController extends CommonController{

    // public function init(){}

    public function actionGetLoanInfo(){

    }

    public function actionAddLoanInfo(){
        /*
            [contract_num] => 111111111
            [loan_amount_money] => 111
            [contract_loan_start_time] => 2018-12-01
            [contract_loan_end_time] => 2018-12-25
            [loan_day] => 24
            [loan_rate] => 10
            [loan_benchmark_rate] => 10
            [repayment_mode] => 1
            [loan_voucher] => upfile/loan/20181225/0_1545722159.jpg
                
         */
        $post = Yii::$app->request->post();
        p($post);
    }
}
