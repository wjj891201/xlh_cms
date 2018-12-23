<?php

namespace app\controllers;

use app\controllers\CommonController;
use Yii;
use app\models\News;
use app\models\Type;
use yii\data\Pagination;

class ArticleController extends CommonController
{

    /**
     * 频道页
     */
    public function actionChannel()
    {
        $tid = Yii::$app->request->get("tid");
        $info = Type::getone(['tid' => $tid]);
        $this->view->params['tid'] = $info['tid'];
        return $this->render($info['indextemplates'], ['info' => $info]);
    }

    /**
     * 列表页
     */
    public function actionList()
    {
        $tid = Yii::$app->request->get("tid");
        $this->view->params['tid'] = $tid;
        //分类详情
        $info = Type::getone(['tid' => $tid]);
        $cate = Type::getData(['lng' => 'cn']);
        $tids = Type::getChildsid($cate, $tid);
        array_unshift($tids, (string) $tid);
        $where = ['AND',['IN', 'tid', $tids],['<>','did',119]];
        $model = News::find()->where($where)->orderBy(['pid' => SORT_DESC, 'addtime' => SORT_DESC]);
        $count = $model->count();
        $pageSize = 20;
        $pages = new Pagination(['totalCount' => $count, 'pageSize' => $pageSize]);
        $data = $model->offset($pages->offset)->limit($pages->limit)->all();
        return $this->render($info['template'], ['data' => $data, 'pages' => $pages, 'info' => $info]);
    }

    /**
     * 新闻详情页
     */
    public function actionDetail()
    {
        $did = Yii::$app->request->get("did");
        $info = News::getOne(['did' => $did]);
        $this->view->params['tid'] = $info['tid'];
        //分类详情
        $type = Type::getone(['tid' => $info['tid']]);
        //点击数+1
        News::updateAll(['click' => $info['click'] + 1], ['did' => $did]);
        //上一篇   下一篇
        $up = News::getOne(['AND', ['tid' => $info['tid']], ['>', 'did', $info['did']]]);
        $down = News::getOne(['AND', ['tid' => $info['tid']], ['<', 'did', $info['did']]]);
        return $this->render($info['template'], ['info' => $info, 'up' => $up, 'down' => $down, 'type' => $type]);
    }

    //获取点击数
    public function actionClick()
    {
        $did = Yii::$app->request->get("did");
        $info = News::findOne(['did' => $did]);
        exit('document.write("' . $info['click'] . '")');
    }

}