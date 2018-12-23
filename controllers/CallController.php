<?php

namespace app\controllers;

use Yii;
use app\controllers\CommonController;
use yii\helpers\Url;

class CallController extends CommonController
{

    public function actionMess()
    {
        $mess = Yii::$app->request->get('mess', '操作成功');
        $url = Yii::$app->request->get('url', Url::to(['index/index']));
        return $this->render('mess', ['mess' => $mess, 'url' => $url]);
    }

}
