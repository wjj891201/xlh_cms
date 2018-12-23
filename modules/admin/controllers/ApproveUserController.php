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
use app\models\approve\SignupForm;
use app\models\Organization;
use app\models\ApproveUser;
use Yii;
use yii\data\Pagination;

class ApproveUserController extends CommonController
{

    /**
     * 审批员列表
     * @return type
     */
    public function actionList()
    {
        $model = ApproveUser::find()->orderBy(['id' => SORT_DESC]);
        $count = $model->count();
        $pageSize = 10;
        $pages = new Pagination(['totalCount' => $count, 'pageSize' => $pageSize]);
        $data = $model->offset($pages->offset)->limit($pages->limit)->all();
        return $this->render('list', ['data' => $data, 'pages' => $pages]);
    }

    /**
     * 添加审批员
     * @return type
     */
    public function actionAdd()
    {
        $model = new SignupForm();
        if (Yii::$app->request->isPost)
        {
            $post = Yii::$app->request->post();
            if ($model->signup($post))
            {
                Yii::$app->session->setFlash("success", "添加成功");
                return $this->redirect(['approve-user/list']);
            }
        }
        #查询所有机构
        $allOrganization = (new Organization)->getOptions();
        return $this->render('add', ['model' => $model, 'allOrganization' => $allOrganization]);
    }

    /**
     * 编辑审批员
     * @return type
     */
    public function actionEdit()
    {
        $id = Yii::$app->request->get('id');
        $info = ApproveUser::find()->where(['id' => $id])->one();
        $model = new SignupForm();
        if (Yii::$app->request->isPost)
        {
            $post = Yii::$app->request->post();
            $post['SignupForm']['id'] = $id;
            if ($model->edit($post))
            {
                Yii::$app->session->setFlash("success", "编辑成功");
                return $this->redirect(['approve-user/list']);
            }
        }
        $model->id = $info->id;
        $model->username = $info->username;
        $model->belong = $info->belong;
        $model->email = $info->email;
        $model->telphone = $info->telphone;
        #查询所有机构
        $allOrganization = (new Organization)->getOptions();
        return $this->render('edit', ['model' => $model, 'allOrganization' => $allOrganization]);
    }

    /**
     * 删除审批员
     * @return type
     */
    public function actionUserDel()
    {
        $id = Yii::$app->request->get('id');
        ApproveUser::deleteAll('id=:id', [':id' => $id]);
        Yii::$app->session->setFlash("success", "删除成功");
        return $this->redirect(['approve-user/list']);
    }

    /**
     * 机构列表
     */
    public function actionOrganizationList()
    {
        $model = new Organization();
        $list = $model->getTreeList();
        return $this->render('organization-list', ['list' => $list]);
    }

    /**
     * 添加机构
     * @return type
     */
    public function actionOrganizationAdd()
    {
        $model = new Organization;
        $model->status = 1;
        if (Yii::$app->request->isPost)
        {
            $post = Yii::$app->request->post();
            if ($model->add($post))
            {
                Yii::$app->session->setFlash("success", "添加成功");
                return $this->redirect(['approve-user/organization-list']);
            }
        }
        //查询出所有一级机构~~~start
        $list = Organization::getData(['pid' => 0]);
        $list = ArrayHelper::map($list, 'id', 'name');
        $options_1 = ['' => '请选择上级机构'];
        foreach ($list as $key => $vo)
        {
            $options_1[$key] = $vo;
        }
        $list = $options_1;
        //查询出所有一级机构~~~end
        //查询出所有分行~~~start
        $branch = Organization::getData(['pid' => 4]);
        $branch = ArrayHelper::map($branch, 'id', 'name');
        $options_2 = ['' => '请选择分行'];
        foreach ($branch as $key => $vo)
        {
            $options_2[$key] = $vo;
        }
        $branch = $options_2;
        //查询出所有分行~~~end
        return $this->render('organization-add', ['model' => $model, 'list' => $list, 'branch' => $branch]);
    }

    /**
     * 编辑机构
     * @return type
     */
    public function actionOrganizationEdit()
    {
        $id = Yii::$app->request->get('id');
        $model = Organization::find()->where(['id' => $id])->one();
        if (Yii::$app->request->isPost)
        {
            $post = Yii::$app->request->post();
            if ($model->add($post))
            {
                Yii::$app->session->setFlash("success", "编辑成功");
                return $this->redirect(['approve-user/organization-list']);
            }
        }
        //查询出所有一级机构~~~start
        $list = Organization::getData(['pid' => 0]);
        $list = ArrayHelper::map($list, 'id', 'name');
        $options_1 = ['' => '请选择上级机构'];
        foreach ($list as $key => $vo)
        {
            $options_1[$key] = $vo;
        }
        $list = $options_1;
        //查询出所有一级机构~~~end
        //查询出所有分行~~~start
        $branch = Organization::getData(['pid' => 4]);
        $branch = ArrayHelper::map($branch, 'id', 'name');
        $options_2 = ['' => '请选择分行'];
        foreach ($branch as $key => $vo)
        {
            $options_2[$key] = $vo;
        }
        $branch = $options_2;
        //查询出所有分行~~~end
        return $this->render('organization-add', ['model' => $model, 'list' => $list, 'branch' => $branch]);
    }

    /**
     * 删除机构
     */
    public function actionOrganizationDel()
    {
        $id = Yii::$app->request->get('id');
        Organization::deleteAll(['id' => $id]);
        //删除机构时，删除该机构下的用户
        ApproveUser::deleteAll(['belong' => $id]);
        Yii::$app->session->setFlash("success", "删除成功");
        return $this->redirect(['approve-user/organization-list']);
    }

}
