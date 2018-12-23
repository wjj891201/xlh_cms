<?php

namespace app\modules\admin\controllers;

use app\modules\admin\controllers\CommonController;
use Yii;
use app\models\Advert;
use app\models\AdvertType;
use yii\data\Pagination;

class AdvertController extends CommonController
{

    public function actionAdlist()
    {
        $atid = Yii::$app->request->get('atid');
        $where = empty($atid) ? ['lng' => $this->lang] : ['atid' => $atid, 'lng' => $this->lang];
        $model = Advert::find()->where($where)->orderBy(['pid' => SORT_ASC, 'addtime' => SORT_DESC]);
        $count = $model->count();
        $pageSize = 10;
        $pages = new Pagination(['totalCount' => $count, 'pageSize' => $pageSize]);
        $data = $model->offset($pages->offset)->limit($pages->limit)->all();
        return $this->render('adlist', ['data' => $data, 'pages' => $pages]);
    }

    public function actionAdd()
    {
        $model = new Advert();
        $model->adtype = 1;
        $model->islink = 1;
        $model->isclass = 1;
        if (Yii::$app->request->isPost)
        {
            $post = Yii::$app->request->post();
            if ($model->add($post, $this->lang))
            {
                Yii::$app->session->setFlash("success", "添加成功");
                return $this->redirect(['advert/adlist']);
            }
        }
        $list = AdvertType::getOptions(['lng' => $this->lang]);
        return $this->render('add', ['model' => $model, 'list' => $list]);
    }

    public function actionMod()
    {
        $adid = Yii::$app->request->get("adid");
        $model = Advert::find()->where('adid = :adid', [':adid' => $adid])->one();
        if (Yii::$app->request->isPost)
        {
            $post = Yii::$app->request->post();
            if ($model->add($post, $this->lang))
            {
                Yii::$app->session->setFlash("success", "编辑成功");
                return $this->redirect(['advert/adlist']);
            }
        }
        $list = AdvertType::getOptions(['lng' => $this->lang]);
        return $this->render('add', ['model' => $model, 'list' => $list]);
    }

    /**
     * 处理广告的批量删除和排序
     */
    public function actionDeal()
    {
        $post = Yii::$app->request->post();
        if ($post['action'] == 'del')
        {
            foreach ($post['adid'] as $vo)
            {
                Advert::deleteAll('adid = :adid', [":adid" => $vo]);
            }
            Yii::$app->session->setFlash("success", "删除成功");
        }
        if ($post['action'] == 'sort')
        {
            foreach ($post['pid'] as $key => $vo)
            {
                if (is_numeric($vo))
                {
                    Advert::updateAll(['pid' => $vo], ['adid' => $key]);
                }
                else
                {
                    break;
                }
            }
            Yii::$app->session->setFlash("success", "排序成功");
        }
        return $this->redirect(['advert/adlist']);
    }

}

?>
