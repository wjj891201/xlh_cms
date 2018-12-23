<?php

namespace app\modules\admin\controllers;

use app\modules\admin\controllers\CommonController;
use Yii;
use yii\helpers\ArrayHelper;
use app\models\Model;
use app\models\Type;
use app\models\News;
use app\models\NewsAlbum;
use app\models\NewsAttr;
use app\models\NewsContent;

class TypeController extends CommonController
{

    public function actionList()
    {
        $model = new Type;
        $cates = $model->getTreeList(['lng' => $this->lang]);
        return $this->render('list', ['cates' => $cates]);
    }

    public function actionAdd()
    {
        $styleid = Yii::$app->request->get("styleid", 0); //主分类 or 单网页 or 链接
        $upid = Yii::$app->request->get("upid", 0); //上级分类tid
        $model = new Type();
        //根据$styleid调取相应模型
        $isbase = $styleid == 4 ? '1' : '0';
        $allmodle = Model::getAll(['isbase' => $isbase]);
        $allmodle = ArrayHelper::toArray($allmodle);
        $allmodle = ArrayHelper::map($allmodle, 'id', 'modelname');
        $options = ['' => '请选择模型'];
        foreach ($allmodle as $key => $vo)
        {
            $options[$key] = $vo;
        }
        $allmodle = $options;
//        var_dump($allmodle);
        if (Yii::$app->request->isPost)
        {
            $post = Yii::$app->request->post();
            if ($model->add($post, $this->lang))
            {
                Yii::$app->session->setFlash("success", "添加成功");
                return $this->redirect(['type/list']);
            }
        }
        $model->styleid = $styleid;
        $model->upid = $upid;
        $model->isline = 1;
        $model->pagemax = 0;
        $model->ismenu = 0;
        $model->isorderby = 1;
        $model->ordertype = 1;
        $model->ispart = 1;
        $model->gotoline = 0;
        return $this->render("add", ['model' => $model, 'allmodle' => $allmodle]);
    }

    public function actionMod()
    {
        $tid = Yii::$app->request->get("tid");
        $model = Type::getone(['tid' => $tid]);
        if (Yii::$app->request->isPost)
        {
            $post = Yii::$app->request->post();
            if (isset($post['Type']['upid']) && $post['Type']['upid'] == $tid)
            {
                Yii::$app->session->setFlash('error', '抱歉！分类选择错误，请确保不要选择同一分类');
                return $this->redirect(['type/mod', 'tid' => $tid]);
            }
            if ($model->add($post, $this->lang))
            {
                Yii::$app->session->setFlash('success', '修改成功');
                return $this->redirect(['type/list']);
            }
        }
        $list = $model->getOptions(['lng' => 'cn']);
        $styleid_arr = ['2' => '信息列表', '1' => '频道主页'];
        return $this->render('mod', ['model' => $model, 'list' => $list, 'styleid_arr' => $styleid_arr]);
    }

    public function actionDel()
    {
        $tid = Yii::$app->request->get('tid');
        $num = Type::find()->where('upid = :upid', [":upid" => $tid])->count();
        if ($num > 0)
        {
            echo '0';
            exit;
        }
        if (Type::deleteAll('tid = :tid', [":tid" => $tid]))
        {
            //删除关联的数据
            $all = News::find()->select(['did'])->where(['tid' => $tid])->asArray()->all();
            if (!empty($all))
            {
                foreach ($all as $key => $vo)
                {
                    NewsAlbum::deleteAll('did = :did', [':did' => $vo['did']]);
                    NewsAttr::deleteAll('did = :did', [':did' => $vo['did']]);
                    NewsContent::deleteAll('did = :did', [':did' => $vo['did']]);
                }
                News::deleteAll('tid = :tid', [":tid" => $tid]);
            }
            echo '1';
            exit;
        }
    }

    /**
     * 排序
     */
    public function actionSort()
    {
        $post = Yii::$app->request->post();
        foreach ($post['pid'] as $key => $vo)
        {
            if (is_numeric($vo))
            {
                Type::updateAll(['pid' => $vo], ['tid' => $key]);
            }
            else
            {
                break;
            }
        }
        Yii::$app->session->setFlash("success", "排序成功");
        return $this->redirect(['type/list']);
    }

}

?>