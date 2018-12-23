<?php

namespace app\modules\admin\controllers;

use app\modules\admin\controllers\CommonController;
use Yii;
use yii\helpers\ArrayHelper;
use app\modules\admin\models\User;
use app\modules\admin\models\Role;
use app\modules\admin\models\UserRoleRelation;
use yii\data\Pagination;

class ManageController extends CommonController
{

    public function actionMailchangepass()
    {
        $request = Yii::$app->request;
        $time = $request->get("timestamp");
        $user = $request->get("user");
        $token = $request->get("token");
        $model = new User;
        $myToken = $model->createToken($user, $time);
        if ($token != $myToken)
        {
            $this->redirect(['public/login']);
            Yii::$app->end();
        }
        if (time() - $time > 300)
        {
            $this->redirect(['public/login']);
            Yii::$app->end();
        }

        if ($request->isPost)
        {
            $post = $request->post();
            if ($model->changePass($post))
            {
                Yii::$app->session->setFlash('info', '密码修改成功');
            }
        }
        $model->user = $user;
        return $this->renderPartial("mailchangepass", ['model' => $model]);
    }

    public function actionList()
    {
        $model = User::find();
        $count = $model->count();
        $pageSize = 15;
        $pages = new Pagination(['totalCount' => $count, 'pageSize' => $pageSize]);
        $list = $model->offset($pages->offset)->limit($pages->limit)->all();
        return $this->render("list", ['list' => $list, 'pages' => $pages]);
    }

    public function actionReg()
    {
        $model = new User;
        if (Yii::$app->request->isPost)
        {
            $post = Yii::$app->request->post();
            if ($model->reg($post))
            {
                Yii::$app->session->setFlash('success', '添加成功');
                return $this->redirect(['manage/list']);
            }
        }
        $model->password = '';
        $model->repass = '';
        return $this->render("reg", ['model' => $model]);
    }

    public function actionDel()
    {
        $id = Yii::$app->request->get('id');
        User::deleteAll('id = :id', [":id" => $id]);
        UserRoleRelation::deleteAll('uid = :uid', [':uid' => $id]);
        Yii::$app->session->setFlash('success', '删除成功！');
        return $this->redirect(['manage/list']);
    }

    public function actionMod()
    {
        $id = Yii::$app->request->get("id");
        $model = User::find()->where('id = :id', [':id' => $id])->one();
        if (Yii::$app->request->isPost)
        {
            $post = Yii::$app->request->post();
            if ($model->change_users($post))
            {
                Yii::$app->session->setFlash('success', '密码修改成功！');
                return $this->redirect(['manage/list']);
            }
        }
        $model->password = "";
        $model->repass = "";
        return $this->render('mod', ['model' => $model]);
    }

    public function actionMake()
    {
        $id = Yii::$app->request->get("id");
        //查找该用户的角色
        $have_role = UserRoleRelation::find()->where(['uid' => $id])->asArray()->all();
        $have_role = ArrayHelper::getColumn($have_role, 'role_id'); //检索列
        //用户信息
        $userDetail = User::find()->where('id = :id', [':id' => $id])->one();
        $role = Role::find()->all();
        if (Yii::$app->request->isPost)
        {
            $uid = Yii::$app->request->post("uid");
            UserRoleRelation::deleteAll('uid=:uid', [':uid' => $uid]); //先删除再添加
            $role_id = Yii::$app->request->post("role_id");
            if (!empty($role_id))
            {
                foreach ($role_id as $vo)
                {
                    Yii::$app->db->createCommand()->insert("mh_user_role", ['uid' => $uid, 'role_id' => $vo, 'created_time' => date('Y-m-d H:i:s')])->execute();
                }
                Yii::$app->session->setFlash('success', '角色分配成功！');
            }
            return $this->redirect(['manage/list']);
        }
        return $this->render('make', ['userDetail' => $userDetail, 'role' => $role, 'have_role' => $have_role]);
    }

}

?>
