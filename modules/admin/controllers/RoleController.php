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
use yii\helpers\ArrayHelper;
use app\modules\admin\models\Role;
use app\modules\admin\models\RoleAccessRelation;
use app\modules\admin\models\Access;
use Yii;

class RoleController extends CommonController
{

    public function actionList()
    {
        $model = new Role();
        $all_role = $model->getData();
        return $this->render('list', ['all_role' => $all_role]);
    }

    public function actionAdd()
    {
        $model = new Role;
        if (Yii::$app->request->isPost)
        {
            $post = Yii::$app->request->post();
            if ($model->add($post))
            {
                Yii::$app->session->setFlash("success", "添加成功");
                return $this->redirect(['role/list']);
            }
        }
        return $this->render('set', ['model' => $model]);
    }

    public function actionMod()
    {
        $id = Yii::$app->request->get("id");
        $model = Role::find()->where('id = :id', [':id' => $id])->one();
        if (Yii::$app->request->isPost)
        {
            $post = Yii::$app->request->post();
            if ($model->modify($post))
            {
                Yii::$app->session->setFlash("success", "编辑成功");
                return $this->redirect(['role/list']);
            }
        }
        return $this->render('set', ['model' => $model]);
    }

    public function actionDel()
    {
        $id = Yii::$app->request->get('id');
        if (Role::deleteAll('id = :id', [":id" => $id]))
        {
            RoleAccessRelation::deleteAll(['role_id' => $id]);
            echo '1';
            exit;
        }
    }

    /*
     * 设置权限
     */

    public function actionSetaccess()
    {
        $id = Yii::$app->request->get('id');
        //查找该角色的权限
        $have_access = RoleAccessRelation::find()->where(['role_id' => $id])->asArray()->all();
        $have_access = ArrayHelper::getColumn($have_access, 'access_id'); //检索列
        //查出角色信息
        $info = Role::find()->where('id = :id', [':id' => $id])->one();
        //查出所有的权限
        $model = new Access();
        $access_list = $model->getAccess();
        if (Yii::$app->request->isPost)
        {
            $id = Yii::$app->request->post("id");
            RoleAccessRelation::deleteAll('role_id=:role_id', [':role_id' => $id]); //先删除再添加      
            $access_ids = Yii::$app->request->post("access_ids");
            if (!empty($access_ids))
            {
                foreach ($access_ids as $vo)
                {
                    Yii::$app->db->createCommand()->insert("mh_role_access", ['role_id' => $id, 'access_id' => $vo, 'created_time' => date('Y-m-d H:i:s')])->execute();
                }
                Yii::$app->session->setFlash('success', '权限设置成功！');
            }
            return $this->redirect(['role/list']);
        }
        return $this->render('setaccess', ['info' => $info, 'access_list' => $access_list, 'have_access' => $have_access]);
    }

}

?>
