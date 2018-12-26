<?php 
namespace app\modules\approve\controllers;

use Yii;
use app\models\EnterpriseLoanContract;
use app\models\EnterpriseLoan;


class ContractController extends CommonController{

    public function actionAddLoanInfo(){
        $request   = Yii::$app->request;
        if($request->isPost){
            $post  = $request->post();
            $model = new EnterpriseLoanContract();

            $model->scenario = "add_loan_info";
            $model->setAttributes($post);
            
            if($model->validate()){
                $apply_amount      = EnterpriseLoan::find()->select(["loan_id","apply_amount"])->where(['loan_id' => $post['loan_id']])->asArray()->one();
                $loan_amount_money = $model->find()->select(["loan_id","round(sum(loan_amount_money), 6) loan_amount_money"])->where(['loan_id' => $post['loan_id']])->asArray()->one();
                
                $total  = round($apply_amount['apply_amount'], 6); //授信金额
                $amount = round($loan_amount_money['loan_amount_money']+$post['loan_amount_money'], 6); //放款金额综合
                if($amount > $total){
                    ajaxReturn(['code'=>'201', 'msg'=>'超过可用授信额度']);
                }
                if(empty($total)){
                    $model->loan_status = 0;
                }else if($post['loan_amount_money'] == $total){
                    $model->loan_status = 2;
                }else if($post['loan_amount_money'] !== $total){
                    $model->loan_status = 1;
                }
                $model->loan_create_time = date('Y-m-d H:i:s');
                $info = $model->save();
                if($info){
                    EnterpriseLoan::updateAllCounters(['already_loan_amount'=>$post['loan_amount_money']], ['loan_id'=>$post['loan_id']]);
                    ajaxReturn(['code'=>'200', 'msg'=>'填写放贷信息成功']);
                }
                ajaxReturn(['code'=>'201', 'msg'=>'填写放贷信息失败']);
            }else{
                ajaxReturn(['code'=>'202', 'msg'=>$this->getModelError($model)]);
            }
        }
    }

    public function actionAddRepaymentInfo(){
        $request   = Yii::$app->request;
        if($request->isPost){
            $post  = $request->post();
            $model = new EnterpriseLoanContract();

            $model->scenario = "add_repayment_info";
            $model->setAttributes($post);
            if($model->validate()){
                $post['repayment_create_time'] = date('Y-m-d H:i:s');
                $post['loan_contract_status']  = 1;
                $info = $model->updateAll($post, ['contract_id'=>$post['contract_id'], 'loan_id'=>$post['loan_id']]);
                if($info){
                    ajaxReturn(['code'=>'200', 'msg'=>'填写还款信息成功']);
                }
                ajaxReturn(['code'=>'201', 'msg'=>'填写还款信息失败']);
            }else{
                ajaxReturn(['code'=>'202', 'msg'=>$this->getModelError($model)]);
            }
        }
    }
}
