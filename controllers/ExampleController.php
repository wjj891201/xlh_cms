<?php

namespace app\controllers;


use sizeg\jwt\JwtHttpBearerAuth;
use yii\web\Controller;

class ExampleController extends Controller
{

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => JwtHttpBearerAuth::class,
        ];

        return $behaviors;
    }

    public function actionIndex()
    {
        
    }

}
