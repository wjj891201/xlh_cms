<?php

namespace app\modules\admin\controllers;

use app\modules\admin\controllers\CommonController;
use app\models\Message;
use yii\data\Pagination;
use Yii;

class MessageController extends CommonController
{

    public function actionIndex()
    {
        $this->layout = "main";
        $model = Message::find()->orderBy('createtime DESC');
        $count = $model->count();
        $pageSize = 4;
        $pages = new Pagination(['totalCount' => $count, 'pageSize' => $pageSize]);
        $data = $model->offset($pages->offset)->limit($pages->limit)->all();
        return $this->render("index", ['data' => $data, 'pages' => $pages]);
    }

    public function actionCheck()
    {
        $this->layout = "main";
        $id = Yii::$app->request->get("id");
        $detail = Message::find()->where(['id' => $id])->asArray()->one();
        return $this->render("check", ['detail' => $detail]);
    }

    public function actionBatchdel()
    {
        $chkall = $_POST['chkall'];
        $chkall = Yii::$app->request->post();
        $arr_id = $chkall['chkall'];
        Message::deleteAll(['and', ['in', 'id', $arr_id]]);
        Yii::$app->session->setFlash("success", "删除成功");
        return $this->redirect(['message/index']);
    }

}