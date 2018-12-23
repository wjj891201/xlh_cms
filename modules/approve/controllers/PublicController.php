<?php

namespace app\modules\approve\controllers;

use app\modules\approve\controllers\CommonController;
use yii\web\Controller;
use Yii;


class PublicController extends CommonController
{

    public function actionIndex()
    {
        return $this->render("index");
    }

}
