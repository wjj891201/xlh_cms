<?php

namespace app\controllers;

use Yii;
use app\controllers\CommonController;
use app\models\News;
use app\models\Advert;
use app\models\WorkflowGroup;
use app\models\EnterpriseBase;
use app\models\EnterpriseLoan;
use app\models\Area;

class IndexController extends CommonController
{

    public $group_id;
    public $loan_group_id;

    public function init()
    {
        parent::init();
        $this->group_id = WorkflowGroup::find()->select('id')->where(['group_key' => 'material'])->scalar();
        $this->loan_group_id = WorkflowGroup::find()->select('id')->where(['group_key' => 'loan'])->scalar();
    }

    public function actionIndex()
    {
        $this->layout = false;
        # 公告
        $news = News::getNews(['mid' => 1, 'tid' => 111, 'max' => 10]);
        # 顶部logo
        $logo = Advert::get_one(['atid' => 1]);
        # 统计
        //企业申请总数
        $one_num = EnterpriseBase::apply_all_statistics();
        $one_town_list = Area::find()->select(['id', 'name'])->asArray()->all();
        foreach ($one_town_list as $key => $vo)
        {
            $one_town_list[$key]['count'] = EnterpriseBase::apply_all_statistics(['town_id' => $vo['id']]);
        }
        $one_industry = Yii::$app->params['industry'];
        foreach ($one_industry as $key => $vo)
        {
            $one_industry[$key]['count'] = EnterpriseBase::apply_all_statistics(['industry_id' => $vo['id']]);
        }
        $one_company = EnterpriseBase::find()->select(['enterprise_name'])->asArray()->all();
        //企业入库总数
        $two_num = EnterpriseBase::apply_in_statistics(['wl.group_id' => $this->group_id, 'wl.result' => 'finish']);
        $two_town_list = Area::find()->select(['id', 'name'])->asArray()->all();
        foreach ($two_town_list as $key => $vo)
        {
            $two_town_list[$key]['count'] = EnterpriseBase::apply_in_statistics(['wl.group_id' => $this->group_id, 'wl.result' => 'finish', 'eb.town_id' => $vo['id']]);
        }
        $two_industry = Yii::$app->params['industry'];
        foreach ($two_industry as $key => $vo)
        {
            $two_industry[$key]['count'] = EnterpriseBase::apply_in_statistics(['wl.group_id' => $this->group_id, 'wl.result' => 'finish', 'eb.industry_id' => $vo['id']]);
        }
        $two_company = EnterpriseBase::find()->alias('eb')->select(['eb.enterprise_name'])->leftJoin('{{%workflow_log}} wl', 'eb.base_id=wl.app_id')->where(['wl.group_id' => $this->group_id, 'wl.result' => 'finish'])->asArray()->all();
        //金融需求总数
        $three_num = EnterpriseLoan::find()->count();
        //金融受理总数
        $four_num = EnterpriseLoan::find()->alias('el')->leftJoin('{{%workflow_log}} wl', 'el.base_id=wl.app_id')->where(['wl.group_id' => $this->loan_group_id, 'wl.result' => 'grant'])->count();
        return $this->render("index", [
                    'news' => $news, 'logo' => $logo,
                    'one_num' => $one_num, 'one_town_list' => $one_town_list, 'one_industry' => $one_industry, 'one_company' => $one_company,
                    'two_num' => $two_num, 'two_town_list' => $two_town_list, 'two_industry' => $two_industry, 'two_company' => $two_company,
                    'three_num' => $three_num,
                    'four_num' => $four_num
        ]);
    }

}
