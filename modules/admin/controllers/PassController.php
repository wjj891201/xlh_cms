<?php

namespace app\modules\admin\controllers;

use app\modules\admin\controllers\CommonController;
use Yii;
use app\modules\admin\models\User;

class PassController extends CommonController
{

    public function actionEdit()
    {
        $model = new User;
        if (Yii::$app->request->isPost)
        {
            $post = Yii::$app->request->post();
            if ($model->changeSelfPass($post, Yii::$app->session['admin']['id']))
            {
                Yii::$app->session->setFlash('success', '密码修改成功');
                return $this->redirect(['pass/edit']);
            }
        }
        return $this->render('edit', ['model' => $model]);
    }

}