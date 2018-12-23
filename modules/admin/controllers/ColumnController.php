<?php

namespace app\modules\admin\controllers;

use app\modules\admin\controllers\CommonController;
use Yii;
use app\models\Column;

class ColumnController extends CommonController
{

    public function actionList()
    {
        $this->layout = "main";
        $model = new Column();
        if (Yii::$app->request->isPost)
        {
            $post = Yii::$app->request->post();
            $post['Column']['type'] = 1;
            if ($model->add($post))
            {
                Yii::$app->session->setFlash("success", "添加成功");
                return $this->redirect(['column/list']);
            }
        }
        $all_label = $model->getData('1');
        return $this->render('list', ['model' => $model, 'all_label' => $all_label]);
    }

    public function actionDel()
    {
        $id = Yii::$app->request->get('id');
        if (Column::deleteAll('id = :id', [":id" => $id]))
        {
            echo '1';
            exit;
        }
    }

}