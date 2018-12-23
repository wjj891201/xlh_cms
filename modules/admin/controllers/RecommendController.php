<?php

namespace app\modules\admin\controllers;

use app\modules\admin\controllers\CommonController;
use Yii;
use yii\helpers\ArrayHelper;
use app\models\Model;
use app\models\Recommend;

class RecommendController extends CommonController
{

    public function actionList()
    {
        //左侧
        $model = new Recommend;
        $allmodle = Model::getAll(['isbase' => 0]);
        $allmodle = ArrayHelper::toArray($allmodle);
        $allmodle = ArrayHelper::map($allmodle, 'id', 'modelname');
        $options = ['' => '请选择模型'];
        foreach ($allmodle as $key => $vo)
        {
            $options[$key] = $vo;
        }
        $allmodle = $options;
        //右侧
        $all = Recommend::getData(['lng' => $this->lang]);
        //提交操作
        if (Yii::$app->request->isPost)
        {
            $post = Yii::$app->request->post();
            if ($model->add($post, $this->lang))
            {
                Yii::$app->session->setFlash("success", "添加成功");
                return $this->redirect(['recommend/list']);
            }
        }
        return $this->render('list', ['model' => $model, 'allmodle' => $allmodle, 'all' => $all]);
    }

    /**
     * 编辑
     */
    public function actionEdit()
    {
        $dlid = Yii::$app->request->get('dlid');
        $model = Recommend::find()->where(['dlid' => $dlid])->one();
        $allmodle = Model::getAll(['isbase' => 0]);
        $allmodle = ArrayHelper::toArray($allmodle);
        $allmodle = ArrayHelper::map($allmodle, 'id', 'modelname');
        $options = ['' => '请选择模型'];
        foreach ($allmodle as $key => $vo)
        {
            $options[$key] = $vo;
        }
        $allmodle = $options;
        //编辑操作
        if (Yii::$app->request->isPost)
        {
            $post = Yii::$app->request->post();
            if ($model->add($post, $this->lang))
            {
                Yii::$app->session->setFlash("success", "编辑成功");
                return $this->redirect(['recommend/list']);
            }
        }
        return $this->render('edit', ['model' => $model, 'allmodle' => $allmodle]);
    }

    /**
     * 批量删除
     */
    public function actionDel()
    {
        $post = Yii::$app->request->post();
        foreach ($post['dlid'] as $vo)
        {
            Recommend::deleteAll('dlid = :dlid', [":dlid" => $vo]);
        }
        Yii::$app->session->setFlash("success", "删除成功");
        return $this->redirect(['recommend/list']);
    }

}