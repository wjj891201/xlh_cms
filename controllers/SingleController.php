<?php

namespace app\controllers;

use app\controllers\CommonController;
use Yii;
use app\models\News;
use app\models\Type;

class SingleController extends CommonController
{

    public function actionDetail()
    {
        $tid = Yii::$app->request->get("tid");
        $info = News::getOne(['tid' => $tid]);
        //分类
        $type = Type::getone(['tid' => $tid]);
//        $this->view->params['tid'] = $info['tid'];
        return $this->render($info['template'], ['info' => $info, 'type' => $type]);
    }

}
