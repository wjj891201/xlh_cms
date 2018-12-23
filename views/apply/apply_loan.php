<?php

use yii\bootstrap\ActiveForm;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;

$this->registerCssFile('@web/public/kjd/css/apply.css', ['depends' => ['app\assets\KjdAsset']]);
$this->registerCssFile('@web/public/kjd/css/apply_base.css', ['depends' => ['app\assets\KjdAsset']]);
$this->registerCssFile('@web/public/kjd/css/apply_style.css', ['depends' => ['app\assets\KjdAsset']]);
$this->registerCssFile('@web/public/kjd/css/easy.css', ['depends' => ['app\assets\KjdAsset']]);

# layer~~~start
$this->registerJsFile('@web/public/kjd/js/layer/layer.js', ['depends' => ['app\assets\KjdAsset'], 'position' => View::POS_HEAD]);
# layer~~~end
$this->registerJsFile('@web/public/kjd/js/jquery.cookie.js', ['depends' => ['app\assets\KjdAsset'], 'position' => View::POS_HEAD]);
$this->title = '认定资料填写-第四步';
$this->params['breadcrumbs'][] = $this->title;
$this->registerMetaTag(['name' => 'keywords', 'content' => '']);
$this->registerMetaTag(['name' => 'description', 'content' => ''], 'description');
?>
<div class="wrapper">
    <div class="titleBar">
        <div class="main1200">
            <img src="/public/kjd/images/edit.jpg" height="80" width="217" alt="">
        </div>
    </div>
    <div class="main1200 steps">
        <img src="/public/kjd/images/s4.png" alt="">
        <ul>
            <li class="first">基本信息</li>
            <li class="second">财务信息</li>
            <li class="third">企业概述</li>
            <li class="last">贷款信息</li>
        </ul>
    </div>
    <div class="main1200 pb5">
        <div class="mainBar pt50 pl100 pr50 pb20 mb20">
            <h3 class="mb15">贷款信息</h3>
            <?php $form = ActiveForm::begin(['options' => ['id' => 'step4', 'enctype' => 'multipart/form-data']]); ?>
            <div class="content_form" style="padding-bottom: 10px">
                <ul class="step2box step3Box step4Box">
                    <li>
                        <label>申请金额：</label>
                        <?= $form->field($model, 'apply_amount', ['template' => "{input} 万元{error}", 'errorOptions' => ['class' => 'msg']])->textInput(['id' => 'apply_amount', 'placeholder' => '申请金额'])->label(false); ?>
                    </li>  
                    <li class="finance_method ">
                        <label>申请期限：</label>
                        <?= $form->field($model, 'period_month', ['template' => "{input} 月{error}", 'errorOptions' => ['class' => 'msg']])->textInput(['id' => 'period_month', 'placeholder' => '请输入你要申请的贷款期限'])->label(false); ?>
                    </li>
                    <li>
                        <label>贷款用途：</label>
                        <?= $form->field($model, 'loan_purpose', ['errorOptions' => ['class' => 'msg']])->textArea(['class' => 'normal_text', 'placeholder' => '请输入贷款用途50字内'])->label(false); ?>
                    </li>
                    <div style="clear:both"></div>
                </ul>
            </div>
            <div style="clear:both"></div>
            <div class="save_btn">
                <a href="<?= Url::to(['apply/apply-describe']) ?>" class="left_btn">上一步</a>
                <?= Html::submitButton('完成', ['class' => 'nextbtn right_btn grey']); ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>


