<?php

use yii\helpers\Html;

$this->registerCssFile('@web/public/kjd/css/dandelion.css', ['depends' => ['app\assets\KjdAsset']]);
$this->title = $name;
$this->params['breadcrumbs'][] = $this->title;
$this->registerMetaTag(['name' => 'keywords', 'content' => '']);
$this->registerMetaTag(['name' => 'description', 'content' => ''], 'description');
?>
<div class="wrapper">
    <div class="titleBar" style="background:#3e9fff;">
        <div class="main1200" style="height:75px"></div>
    </div>
    <div id="da-wrapper" class="fluid">
        <div id="da-content">
            <div class="da-container">
                <div id="da-error-wrapper">
                    <div id="da-error-pin"></div>
                    <div id="da-error-code">
                        error <span>404</span>                    
                    </div>
                    <h1 class="da-error-heading"><?= Html::encode($this->title) ?></h1>
                    <p><?= nl2br(Html::encode($message)) ?><a href="../">点击进入首页</a></p>
                </div>
            </div>
        </div>
    </div>
</div>