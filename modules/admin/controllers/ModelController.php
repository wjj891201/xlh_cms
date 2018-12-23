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
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use Yii;
use app\models\Model;
use app\models\ModelAtt;

class ModelController extends CommonController
{

    /**
     * 模型列表
     */
    public function actionList()
    {
        $all = Model::getAll('', ['id' => SORT_DESC]);
        return $this->render('list', ['all' => $all]);
    }

    /**
     * 模型添加
     */
    public function actionAdd()
    {
        $model = new Model;
        if (Yii::$app->request->isPost)
        {
            $post = Yii::$app->request->post();
            if ($model->add($post))
            {
                Yii::$app->session->setFlash("success", "添加成功");
                return $this->redirect(['model/list']);
            }
        }
        $model->pagemax = 20;
        $model->lockin = 0;
        $model->isbase = 0;
        $model->isalbum = 0;
        $model->isclass = 1;
        return $this->render('add', ['model' => $model]);
    }

    /**
     * 模型编辑
     */
    public function actionEdit()
    {
        $mid = Yii::$app->request->get("mid");
        $model = Model::find()->where('id = :id', [':id' => $mid])->one();
        if (Yii::$app->request->isPost)
        {
            $post = Yii::$app->request->post();
            if ($model->add($post))
            {
                Yii::$app->session->setFlash("success", "编辑成功");
                return $this->redirect(['model/list']);
            }
        }
        return $this->render('add', ['model' => $model]);
    }

    /**
     * 模型删除
     */
    public function actionDel()
    {
        $mid = Yii::$app->request->get("mid");
        $result = ModelAtt::getAll(['mid' => $mid]);
        foreach ($result as $key => $vo)
        {
            $info = ModelAtt::getOne(['id' => $vo['id']]);
            if (!$info['lockin'])
            {
                $countnum = ModelAtt::find()->where(['attrname' => $info['attrname']])->count();
                if ($countnum == 1)
                {
                    $sql = 'ALTER TABLE {{%news_attr}} DROP COLUMN ' . $info['attrname'];
                    $connection = Yii::$app->db;
                    $connection->createCommand($sql)->query();
                }
            }
            if ($info['islockin'])
            {
                ModelAtt::deleteAll('id = :id', [":id" => $vo['id']]);
            }
        }
        Model::deleteAll(['id' => $mid]);
        exit(true);
    }

    /**
     * 模型字段列表
     */
    public function actionAttrlist()
    {
        $mid = Yii::$app->request->get("mid");
        $info = Model::getOne(['id' => $mid]); //模型详情
        $db_where = "WHERE mid IN (0,$mid)";
        $connection = Yii::$app->db;
        $sql = 'SELECT * FROM (SELECT * FROM {{%model_att}} ' . $db_where . ' ORDER BY id desc) AS MODELATTR GROUP BY attrname ORDER BY id desc';
        $array = $connection->createCommand($sql)->queryAll();
        $pages = new Pagination(['totalCount' => count($array), 'pageSize' => 12]);
        $data = $connection->createCommand($sql . " limit " . $pages->limit . " offset " . $pages->offset . "")->queryAll();
        return $this->render('attrlist', ['data' => $data, 'pages' => $pages, 'info' => $info]);
    }

    /**
     * 处理模型字段的批量删除和排序
     */
    public function actionDeal()
    {
        $post = Yii::$app->request->post();
        if ($post['action'] == 'del')
        {
            foreach ($post['id'] as $vo)
            {
                $info = ModelAtt::getOne(['id' => $vo]);
                if (!$info['lockin'])
                {
                    $countnum = ModelAtt::find()->where(['attrname' => $info['attrname']])->count();
                    if ($countnum == 1)
                    {
                        $sql = 'ALTER TABLE {{%news_attr}} DROP COLUMN ' . $info['attrname'];
                        $connection = Yii::$app->db;
                        $connection->createCommand($sql)->query();
                    }
                }
                if ($info['islockin'])
                {
                    ModelAtt::deleteAll('id = :id', [":id" => $vo]);
                }
            }
            Yii::$app->session->setFlash("success", "删除成功");
        }
        if ($post['action'] == 'sort')
        {
            foreach ($post['pid'] as $key => $vo)
            {
                if (is_numeric($vo))
                {
                    ModelAtt::updateAll(['pid' => $vo], ['id' => $key]);
                }
                else
                {
                    break;
                }
            }
            Yii::$app->session->setFlash("success", "排序成功");
        }
        return $this->redirect(['model/attrlist', 'mid' => $post['mid']]);
    }

    /**
     * 添加模型字段
     */
    public function actionAttradd()
    {
        $mid = Yii::$app->request->get("mid");
        $info = Model::getOne(['id' => $mid]); //模型详情
        $model = new ModelAtt;
        $typelist = Yii::$app->params['formType'];
        $typelist = ArrayHelper::map($typelist, 'key', 'name');
        if (Yii::$app->request->isPost)
        {
            $post = Yii::$app->request->post();
            if ($model->add($post))
            {
                Yii::$app->session->setFlash("success", "模型字段添加成功");
                return $this->redirect(['model/attrlist', 'mid' => $mid]);
            }
        }
        $model->mid = $mid;
        $model->isvalidate = 0;
        $model->isclass = 1;
        $model->attrsize = 20;
        $model->attrrow = 5;
        return $this->render('attradd', ['model' => $model, 'typelist' => $typelist, 'info' => $info]);
    }

    /**
     * 编辑模型字段
     */
    public function actionAttredit()
    {
        $mid = Yii::$app->request->get("mid");
        $info = Model::getOne(['id' => $mid]); //模型详情
        $aid = Yii::$app->request->get("aid");
        $model = ModelAtt::find()->where(['id' => $aid])->one();
        $typelist = Yii::$app->params['formType'];
        $typelist = ArrayHelper::map($typelist, 'key', 'name');
        if (Yii::$app->request->isPost)
        {
            $post = Yii::$app->request->post();
            if ($model->edit($post))
            {
                Yii::$app->session->setFlash("success", "模型字段编辑成功");
                return $this->redirect(['model/attrlist', 'mid' => $mid]);
            }
        }
        $model->smid = $info->id;
        return $this->render('attredit', ['model' => $model, 'typelist' => $typelist, 'info' => $info]);
    }

}
