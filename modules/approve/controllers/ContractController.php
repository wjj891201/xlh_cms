<?php 
namespace app\modules\approve\controllers;

use Yii;
use app\models\EnterpriseLoanContract;

class ContractController extends CommonController{

    // public function init(){}

    public function actionGetLoanInfo(){

    }

    public function actionAddLoanInfo(){
        $post = Yii::$app->request->post();
        p($post);
    }
}
