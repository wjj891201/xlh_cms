<?php

use yii\helpers\Url;
use app\models\News;

$this->registerCssFile('@web/public/kjd/css/grid.css', ['depends' => ['app\assets\KjdAsset']]);
$this->registerCssFile('@web/public/kjd/css/inner.css', ['depends' => ['app\assets\KjdAsset']]);
$this->title = $info['headtitle'];
$this->params['breadcrumbs'][] = $this->title;
$this->registerMetaTag(['name' => 'keywords', 'content' => $info['keywords']]);
$this->registerMetaTag(['name' => 'description', 'content' => $info['description']], 'description');
?>
<div class="gbox" style="padding-top: 20px">
    <div class="wrapper member">
        <div class="member_crumb w1200">
            <a href="###">首页</a> &gt;<a href="###">新闻</a> &gt;<strong>新闻详情</strong>
        </div>
        <div class="mainContent">
            <div class="box">
                <div class="clearfix container_25">
                    <div class="grid_17 alpha">
                        <div class="policy_detail">
                            <div class="policy_detail_title">
                                <h2><?= $info['title'] ?></h2>
                                <h6><?= date('Y-m-d H:i', $info['addtime']) ?></h6>
                            </div>
                            <div style="clear:both"></div>
                            <div class="policy_detail_content" style="width:585px;overflow:auto">
                                <?= $info['content']['content'] ?>
                            </div>
                        </div>
                    </div>
                    <!--右侧部分-->
                    <div class="right_bar">
                        <div class="recommend_message">
                            <div class="recommend_message_title">推荐信息</div>
                            <div style="border-bottom: 1px solid #cdcdcd;line-height: 24px;font-size: 8px;color: #5b5b5b;padding: 15px;">
                                <ul>
                                    <?php $news = News::getNews(['mid' => 1, 'tid' => 111, 'max' => 10]); ?>
                                    <?php foreach ($news as $key => $vo): ?>
                                        <li><a href="<?= Url::to(['article/detail', 'did' => $vo['did']]) ?>"><?= $vo['title'] ?></a></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>        
    </div>  
</div>