<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = '个人中心-密码管理';
$this->params['breadcrumbs'][] = $this->title;
$this->registerMetaTag(['name' => 'keywords', 'content' => '']);
$this->registerMetaTag(['name' => 'description', 'content' => ''], 'description');
?>
<div class="gbox" style="padding-top: 20px">
    <div class="wrapper member">
        <div class="member_crumb w1200"><a href="###">会员中心</a> &gt;<a href="###">设置</a> &gt;<strong>密码管理</strong></div>
        <div class="mainContent">
            <div class="box">
                <div class="tab">
                    <div class="nav titleL">
                        <ul>
                            <li><a href="<?= Url::to(['member/center']) ?>">账号管理</a></li>
                            <li class="current"><a  class="on" href="javascript:void(0);">密码管理</a></li>
                        </ul>
                    </div>
                    <div class="content">
                        <ul>
                            <li>
                                <div class="forget_password" style="margin-left: 345px;margin-top: 0">
                                    <?php
                                    $form = ActiveForm::begin([
                                                'fieldConfig' => [
                                                    'template' => '<li>{label}{input}{error}</li>',
                                                    'labelOptions' => ['class' => false, 'for' => false],
                                                    'errorOptions' => ['class' => 'input_tip']
                                                ]
                                    ]);
                                    ?>
                                    <ul>       
                                        <?= $form->field($model, 'orpass')->passwordInput(['class' => 'forget_input', 'maxlength' => '20']); ?>
                                        <?= $form->field($model, 'password')->passwordInput(['class' => 'forget_input', 'maxlength' => '20']); ?>
                                        <?= $form->field($model, 'repass')->passwordInput(['class' => 'forget_input', 'maxlength' => '20']); ?>
                                    </ul>
                                    <?= Html::submitButton('提交', ['class' => 'forget_btn', 'style' => 'margin-top: 50px;margin-left: 110px']); ?>
                                    <?php ActiveForm::end(); ?>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

