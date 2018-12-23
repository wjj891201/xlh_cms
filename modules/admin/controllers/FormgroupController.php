<?php

namespace app\modules\admin\controllers;

use app\modules\admin\controllers\CommonController;
use Yii;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use app\models\FormGroup;
use app\models\FormAttr;
use app\models\FormValue;

class FormgroupController extends CommonController
{

    public function actionList()
    {
        $list = FormGroup::getData(['lng' => $this->lang]);

        return $this->render('list', ['list' => $list]);
    }

    public function actionAdd()
    {
        $model = new FormGroup;
        if (Yii::$app->request->isPost)
        {
            $post = Yii::$app->request->post();
            if ($model->add($post, $this->lang))
            {
                Yii::$app->session->setFlash("success", "添加成功");
                return $this->redirect(['formgroup/list']);
            }
        }
        return $this->render('add', ['model' => $model]);
    }

    public function actionEdit()
    {
        $fgid = Yii::$app->request->get('fgid');
        $model = FormGroup::find()->where(['fgid' => $fgid])->one();
        if (Yii::$app->request->isPost)
        {
            $post = Yii::$app->request->post();
            if ($model->add($post, $this->lang))
            {
                Yii::$app->session->setFlash("success", "编辑成功");
                return $this->redirect(['formgroup/list']);
            }
        }
        return $this->render('add', ['model' => $model]);
    }

    /**
     * 自定义表单删除
     */
    public function actionDel()
    {
        $fgid = Yii::$app->request->get('fgid');
        $allAttr = FormAttr::find()->where(['fgid' => $fgid])->all();
        foreach ($allAttr as $key => $vo)
        {
            $info = FormAttr::getOne(['faid' => $vo['faid']]);
            $countnum = FormAttr::find()->where(['attrname' => $info['attrname']])->count();
            if ($countnum == 1)
            {
                $sql = 'ALTER TABLE {{%form_value}} DROP COLUMN ' . $info['attrname'];
                $connection = Yii::$app->db;
                $connection->createCommand($sql)->query();
            }
            FormAttr::deleteAll('faid = :faid', [":faid" => $vo['faid']]);
        }
        FormGroup::deleteAll('fgid = :fgid', [":fgid" => $fgid]);
        exit(true);
    }

    /**
     * 自定义字段列表
     */
    public function actionAttrlist()
    {
        $fgid = Yii::$app->request->get('fgid');
        $info = FormGroup::getInfo(['fgid' => $fgid]);

        $db_where = "WHERE fgid = $fgid";
        $connection = Yii::$app->db;
//        $sql = 'SELECT * FROM (SELECT * FROM {{%model_att}} ' . $db_where . ' ORDER BY id desc) AS MODELATTR GROUP BY attrname ORDER BY id desc';
        $sql = 'SELECT * FROM {{%form_attr}} ' . $db_where . ' ORDER BY faid DESC';
        $array = $connection->createCommand($sql)->queryAll();
        $pages = new Pagination(['totalCount' => count($array), 'pageSize' => 12]);
        $data = $connection->createCommand($sql . " limit " . $pages->limit . " offset " . $pages->offset . "")->queryAll();
        return $this->render('attrlist', ['data' => $data, 'pages' => $pages, 'info' => $info]);
    }

    /**
     * 添加自定义字段
     */
    public function actionAttradd()
    {
        $fgid = Yii::$app->request->get('fgid');
        $info = FormGroup::getInfo(['fgid' => $fgid]);
        $typelist = Yii::$app->params['formType'];
        $typelist = ArrayHelper::map($typelist, 'key', 'name');
        $model = new FormAttr;
        if (Yii::$app->request->isPost)
        {
            $post = Yii::$app->request->post();
            if ($model->add($post))
            {
                Yii::$app->session->setFlash("success", "自助表单字段添加成功");
                return $this->redirect(['formgroup/attrlist', 'fgid' => $fgid]);
            }
        }
        $model->fgid = $fgid;
        $model->isvalidate = 0;
        $model->isclass = 1;
        $model->attrsize = 20;
        $model->attrrow = 5;
        return $this->render('attradd', ['model' => $model, 'typelist' => $typelist, 'info' => $info]);
    }

    /**
     * 编辑字段
     */
    public function actionAttredit()
    {
        $fgid = Yii::$app->request->get("fgid");
        $info = FormGroup::getInfo(['fgid' => $fgid]);
        $faid = Yii::$app->request->get("faid");
        $model = FormAttr::find()->where(['faid' => $faid])->one();
        $typelist = Yii::$app->params['formType'];
        $typelist = ArrayHelper::map($typelist, 'key', 'name');
        if (Yii::$app->request->isPost)
        {
            $post = Yii::$app->request->post();
            if ($model->edit($post))
            {
                Yii::$app->session->setFlash("success", "自助表单字段编辑成功");
                return $this->redirect(['formgroup/attrlist', 'fgid' => $fgid]);
            }
        }
        return $this->render('attredit', ['model' => $model, 'typelist' => $typelist, 'info' => $info]);
    }

    /**
     * 处理自定义字段的批量删除和排序
     */
    public function actionDeal()
    {
        $post = Yii::$app->request->post();
        if ($post['action'] == 'del')
        {
            foreach ($post['faid'] as $vo)
            {
                $info = FormAttr::getOne(['faid' => $vo]);
                $countnum = FormAttr::find()->where(['attrname' => $info['attrname']])->count();
                if ($countnum == 1)
                {
                    $sql = 'ALTER TABLE {{%form_value}} DROP COLUMN ' . $info['attrname'];
                    $connection = Yii::$app->db;
                    $connection->createCommand($sql)->query();
                }
                FormAttr::deleteAll('faid = :faid', [":faid" => $vo]);
            }
            Yii::$app->session->setFlash("success", "删除成功");
        }
        if ($post['action'] == 'sort')
        {
            foreach ($post['pid'] as $key => $vo)
            {
                if (is_numeric($vo))
                {
                    FormAttr::updateAll(['pid' => $vo], ['faid' => $key]);
                }
                else
                {
                    break;
                }
            }
            Yii::$app->session->setFlash("success", "排序成功");
        }
        return $this->redirect(['formgroup/attrlist', 'fgid' => $post['fgid']]);
    }

    /**
     * 留言列表
     */
    public function actionMessage()
    {
        $fgid = Yii::$app->request->get("fgid");
        $model = FormValue::find()->where(['fgid' => $fgid])->orderBy(['addtime' => SORT_DESC]);
        $count = $model->count();
        $pageSize = 15;
        $pages = new Pagination(['totalCount' => $count, 'pageSize' => $pageSize]);
        $data = $model->offset($pages->offset)->limit($pages->limit)->all();
        return $this->render('message', ['data' => $data, 'pages' => $pages, 'fgid' => $fgid]);
    }

    /**
     * 留言查看
     */
    public function actionCheck()
    {
        $fvid = Yii::$app->request->get("fvid");
        $forumread = FormValue::findOne(['fvid' => $fvid]);
        $attrread = FormAttr::getFormatt($forumread['fgid'], false);
        if (is_array($attrread))
        {
            foreach ($attrread as $key => $value)
            {
                if ($value['inputtype'] == 'select' || $value['inputtype'] == 'radio')
                {
                    foreach ($value['attrvalue'] as $key2 => $value2)
                    {
                        if ($forumread[$value['attrname']] == trim($value2['name']))
                        {
                            $attrread[$key]['attrvalue'][$key2]['selected'] = 'selected';
                        }
                    }
                }
                elseif ($value['inputtype'] == 'checkbox')
                {
                    $expvale = explode(',', $forumread[$value['attrname']]);
                    foreach ($value['attrvalue'] as $key2 => $value2)
                    {
                        if (in_array(trim($value2['name']), $expvale))
                        {
                            $attrread[$key]['attrvalue'][$key2]['selected'] = 'selected';
                        }
                    }
                }
                else
                {
                    $attrread[$key]['attrvalue'] = $forumread[$value['attrname']];
                }
            }
        }
        return $this->render('check', ['attlist' => $attrread, 'forumread' => $forumread]);
    }

    /**
     * 删除留言
     */
    public function actionDelmess()
    {
        $post = Yii::$app->request->post();
        foreach ($post['fvid'] as $vo)
        {
            FormValue::deleteAll('fvid = :fvid', [":fvid" => $vo]);
        }
        Yii::$app->session->setFlash("success", "删除成功");
        return $this->redirect(['formgroup/message', 'fgid' => $post['fgid']]);
    }

}