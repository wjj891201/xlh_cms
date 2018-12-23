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
use Yii;
use yii\helpers\ArrayHelper;
use app\models\Config;

class SystemController extends CommonController
{

    public function actionConfig()
    {
        $info = Config::getConfig(['lng' => $this->lang]);
        $info = ArrayHelper::map($info, 'name', 'value');
        return $this->render('config', ['info' => $info]);
    }

    public function actionTodo()
    {
        $model = new Config;
        if (Yii::$app->request->isPost)
        {
            $post = Yii::$app->request->post();
            $info = $model->getConfig(['lng' => $this->lang]);
            if (!empty($post))
            {
                if (empty($info))
                {
                    //添加
                    if ($model->add($post, $this->lang))
                    {
                        Yii::$app->session->setFlash("success", "设置成功");
                        return $this->redirect(['system/config']);
                    }
                }
                else
                {
                    $info = ArrayHelper::index($info, 'name');
                    //编辑
                    if ($model->edit($info, $post, $this->lang))
                    {
                        Yii::$app->session->setFlash("success", "设置成功");
                        return $this->redirect(['system/config']);
                    }
                }
            }
        }
    }

}