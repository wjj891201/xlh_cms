<?php

use yii\helpers\Url;

$this->registerCssFile('@web/public/kjd/css/step2.css', ['depends' => ['app\assets\KjdAsset']]);
$this->registerCssFile('@web/public/kjd/css/apply.css', ['depends' => ['app\assets\KjdAsset']]);
$this->registerCssFile('@web/public/kjd/css/apply_base.css', ['depends' => ['app\assets\KjdAsset']]);
$this->registerCssFile('@web/public/kjd/css/apply_style.css', ['depends' => ['app\assets\KjdAsset']]);
$this->registerCssFile('@web/public/kjd/css/easy.css', ['depends' => ['app\assets\KjdAsset']]);

$this->title = '认定资料提交成功';
$this->params['breadcrumbs'][] = $this->title;
$this->registerMetaTag(['name' => 'keywords', 'content' => '']);
$this->registerMetaTag(['name' => 'description', 'content' => ''], 'description');
?>
<div class="titleBar">
    <div class="main1200">
        <img src="/public/kjd/images/edit.jpg" height="80" width="217" alt="">
    </div>
</div>
<div class="wrapper">
    <div class="main1200 steps"></div>
    <div class="main1200 mt20">
        <div class="introBox" style="padding: 45px 0 271px 57px;"></div>
    </div>
    <br/>
    <div class="main1200 pb60">
        <div class="mainBar p4025">
            <div class="step4Box">
                <img src="/public/kjd/images/edit06.png">
                <p class="succ">提交成功</p>
                <p>恭喜，您的申请资料已经成功提交！</p>
                <div class="succBtns">
                    <a href="#" class="i1"><i></i>我想咨询</a>
                    <a href="<?= Url::to(['member/enterprise-list']); ?>" class="i2"><i></i>我的资料</a>
                </div>
            </div>
        </div>
    </div>
</div>
