<?php

namespace app\modules\admin\controllers;

use app\modules\admin\controllers\CommonController;
use Yii;
use app\models\AdvertType;

class AdverttypeController extends CommonController
{

    public function actionList()
    {
        $all = AdvertType::find()->where(['lng' => $this->lang])->all();
        return $this->render('list', ['all' => $all]);
    }

    public function actionAdd()
    {
        $model = new AdvertType;
        if (Yii::$app->request->isPost)
        {
            $post = Yii::$app->request->post();
            if ($model->add($post, $this->lang))
            {
                Yii::$app->session->setFlash("success", "添加成功");
                return $this->redirect(['adverttype/list']);
            }
        }
        $model->isclass = 1;
        $model->width = 0;
        $model->height = 0;
        return $this->render('add', ['model' => $model]);
    }

    public function actionEdit()
    {
        $atid = Yii::$app->request->get('atid');
        $model = AdvertType::find()->where(['atid' => $atid])->one();
        if (Yii::$app->request->isPost)
        {
            $post = Yii::$app->request->post();
            if ($model->add($post, $this->lang))
            {
                Yii::$app->session->setFlash("success", "修改成功");
                return $this->redirect(['adverttype/list']);
            }
        }
        return $this->render('add', ['model' => $model]);
    }

    public function actionDel()
    {
        $post = Yii::$app->request->post();
        foreach ($post['atid'] as $vo)
        {
            AdvertType::deleteAll('atid = :atid', [":atid" => $vo]);
        }
        Yii::$app->session->setFlash("success", "删除成功");
        return $this->redirect(['adverttype/list']);
    }

}
