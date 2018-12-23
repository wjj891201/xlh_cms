<?php 
namespace app\modules\approve\controllers;

use Yii;
use yii\data\Pagination;
use app\models\EnterpriseLoanContract;

class ContractController extends CommonController{

    // public function init(){}

    public function actionIndex(){
        EnterpriseLoanContract::getList();
        echo 'OK';
    }
}
