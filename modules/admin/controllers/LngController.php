<?php

namespace app\modules\admin\controllers;

use app\modules\admin\controllers\CommonController;
use Yii;
use app\models\Lng;

class LngController extends CommonController
{

    public function actionList()
    {
        $list = Lng::getData();
        return $this->render('list', ['list' => $list]);
    }

    public function actionAdd()
    {
        $model = new Lng;
        if (Yii::$app->request->isPost)
        {
            $post = Yii::$app->request->post();
            if ($model->add($post))
            {
                Yii::$app->session->setFlash("success", "添加成功");
                return $this->redirect(['lng/list']);
            }
        }
        $model->isopen = 1;
        return $this->render('add', ['model' => $model]);
    }

    public function actionEdit()
    {
        $id = Yii::$app->request->get('id');
        $model = Lng::find()->where(['id' => $id])->one();
        if (Yii::$app->request->isPost)
        {
            $post = Yii::$app->request->post();
            if ($model->add($post))
            {
                Yii::$app->session->setFlash("success", "编辑成功");
                return $this->redirect(['lng/list']);
            }
        }
        return $this->render('edit', ['model' => $model]);
    }

    /**
     * 处理广告的批量删除和排序
     */
    public function actionDeal()
    {
        $post = Yii::$app->request->post();
        if ($post['action'] == 'del')
        {
            foreach ($post['id'] as $vo)
            {
                Lng::deleteAll('id = :id', [":id" => $vo]);
            }
            Yii::$app->session->setFlash("success", "删除成功");
        }
        if ($post['action'] == 'sort')
        {
            foreach ($post['pid'] as $key => $vo)
            {
                if (is_numeric($vo))
                {
                    Lng::updateAll(['pid' => $vo], ['id' => $key]);
                }
                else
                {
                    break;
                }
            }
            Yii::$app->session->setFlash("success", "排序成功");
        }
        return $this->redirect(['lng/list']);
    }

}
