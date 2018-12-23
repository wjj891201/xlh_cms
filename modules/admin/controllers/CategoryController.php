<?php

namespace app\modules\admin\controllers;

use app\modules\admin\controllers\CommonController;
use Yii;
use app\models\Category;

class CategoryController extends CommonController
{

    public function actionList()
    {
        $this->layout = "main";
        $model = new Category;
        $cates = $model->getTreeList();
        $temp = [];
        foreach ($cates as $key => $vo)
        {
            switch ($vo['type'])
            {
                case 1:
                    $vo['type'] = "列表分类";
                    break;
                case 2:
                    $vo['type'] = "<font color=\"#2E43E0\">单网页</font>";
                    break;
                case 3:
                    $vo['type'] = "<font color=\"#FF0F0F\">跳转链接</font>";
                    break;
            }
            $temp[] = $vo;
        }
        $cates = $temp;
        return $this->render('list', ['cates' => $cates]);
    }

    public function actionAdd()
    {
        $this->layout = "main";
        $type = Yii::$app->request->get("type"); //列表 or 单页 or 链接
        $model = new Category();
        $model->status = 2; //默认非导航
        $model->type = $type;
        $model->displayorder = 100;
        $list = $model->getOptions();

        if (Yii::$app->request->isPost)
        {
            $post = Yii::$app->request->post();
            if ($model->add($post, $type))
            {
                Yii::$app->session->setFlash("success", "添加成功");
                return $this->redirect(['category/list']);
            }
        }
        return $this->render("add", ['list' => $list, 'model' => $model]);
    }

    public function actionMod()
    {
        $this->layout = "main";
        $cateid = Yii::$app->request->get("cateid");
        $model = Category::find()->where('id = :id', [':id' => $cateid])->one();
        if (Yii::$app->request->isPost)
        {
            $post = Yii::$app->request->post();
            if ($model->add($post, $model->type))
            {
                Yii::$app->session->setFlash('success', '修改成功');
                return $this->redirect(['category/list']);
            }
        }
        $list = $model->getOptions();
        return $this->render('add', ['model' => $model, 'list' => $list]);
    }

    public function actionDel()
    {
        $id = Yii::$app->request->get('id');
        $data = Category::find()->where('parentid = :pid', [":pid" => $id])->one();
        if ($data)
        {
            echo '0';
            exit;
        }
        if (Category::deleteAll('id = :id', [":id" => $id]))
        {
            echo '1';
            exit;
        }
    }

}

?>