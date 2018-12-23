<?php

namespace app\modules\admin\controllers;

use app\modules\admin\controllers\CommonController;
use Yii;
use app\models\Region;

class RegionController extends CommonController
{

    public function actionList()
    {
        $this->layout = "main";
        $model = new Region;
        $region = $model->getTreeList();
        return $this->render('list', ['region' => $region]);
    }

    public function actionAdd()
    {
        $this->layout = "main";
        $model = new Region;
        if (Yii::$app->request->isPost)
        {
            $post = Yii::$app->request->post();
            if ($model->add($post))
            {
                Yii::$app->session->setFlash('success', '添加成功');
                return $this->redirect(['region/add']);
            }
        }
        $list = $model->getOptions();
        $model->hot = 0;
        $model->closed = 0;
        return $this->render('add', ['model' => $model, 'list' => $list]);
    }

    public function actionMod()
    {
        $this->layout = "main";
        $id = Yii::$app->request->get("id");
        $model = Region::find()->where('region_id = :id', [':id' => $id])->one();
        if (Yii::$app->request->isPost)
        {
            $post = Yii::$app->request->post();
            if ($model->load($post) && $model->save())
            {
                Yii::$app->session->setFlash('success', '修改成功');
                return $this->redirect(['region/list']);
            }
        }
        $list = $model->getOptions();
        return $this->render('add', ['model' => $model, 'list' => $list]);
    }

}