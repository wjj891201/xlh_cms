<?php

/**
 * 功能描述
 * ============================================================================
 * * All Rights Reserved by Xinlonghang Network Technology Co,.Ltd of SHANGHAI.
 * 网站地址: http://www.easyrong.com；
 * ============================================================================
 * $Author: wujiepeng $
 */

namespace app\modules\admin\controllers;

use app\modules\admin\controllers\CommonController;
use app\modules\admin\models\Access;
use app\modules\admin\models\RoleAccessRelation;
use Yii;

class AccessController extends CommonController
{

    public function actionList()
    {
        $model = new Access();
        $access = $model->getTreeList();
        return $this->render('list', ['access' => $access]);
    }

    public function actionAdd()
    {
        $model = new Access;
        $model->sort = 100;
        $list = $model->getOptions();
        if (Yii::$app->request->isPost)
        {
            $post = Yii::$app->request->post();
            if ($model->add($post))
            {
                Yii::$app->session->setFlash("success", "添加成功");
                return $this->redirect(['access/list']);
            }
        }
        return $this->render('set', ['model' => $model, 'list' => $list]);
    }

    public function actionMod()
    {
        $id = Yii::$app->request->get("id");
        $model = Access::find()->where('id = :id', [':id' => $id])->one();
        $list = $model->getOptions();
        $model->urls = implode("\n", json_decode($model->urls, 1));
        if (Yii::$app->request->isPost)
        {
            $post = Yii::$app->request->post();
            if ($model->modify($post))
            {
                Yii::$app->session->setFlash("success", "编辑成功");
                return $this->redirect(['access/list']);
            }
        }
        return $this->render('set', ['model' => $model, 'list' => $list]);
    }

    public function actionDel()
    {
        $id = Yii::$app->request->get('id');
        if (Access::deleteAll('id = :id', [":id" => $id]))
        {
            RoleAccessRelation::deleteAll(['access_id' => $id]);
            echo '1';
            exit;
        }
    }

}

?>
