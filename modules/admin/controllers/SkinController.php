<?php

namespace app\modules\admin\controllers;

use app\modules\admin\controllers\CommonController;
use Yii;
use app\models\Skin;

class SkinController extends CommonController
{

    public function actionList()
    {
        $all = Skin::getData();
        return $this->render('list', ['all' => $all]);
    }

    public function actionAdd()
    {
        $model = new Skin;
        if (Yii::$app->request->isPost)
        {
            $post = Yii::$app->request->post();
            if ($model->add($post))
            {
                Yii::$app->session->setFlash("success", "添加成功");
                return $this->redirect(['skin/list']);
            }
        }
        return $this->render('add', ['model' => $model]);
    }

    public function actionDel()
    {
        $skid = Yii::$app->request->get('skid');
        Skin::deleteAll('skid=:skid', [':skid' => $skid]);
        Yii::$app->session->setFlash("success", "删除成功");
        return $this->redirect(['skin/list']);
    }

    public function actionOpen()
    {
        $skid = Yii::$app->request->get('skid');
        Skin::updateAll(['isclass' => 0], ['isclass' => 1]);
        Skin::updateAll(['isclass' => 1], ['skid' => $skid]);
        Yii::$app->session->setFlash("success", "启用成功");
        return $this->redirect(['skin/list']);
    }

}
