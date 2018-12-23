<?php

use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use yii\helpers\Html;
use yii\helpers\Url;
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
        <title>南昌科技贷后台登录</title>
        <meta name="author" content="DeathGhost">
        <link rel="stylesheet" type="text/css" href="/public/backend/css/style.css" tppabs="css/style.css">
        <style>
            body{height:100%;overflow:hidden;background:url('/public/backend/images/bg.jpg'); }
            canvas{z-index:-1;position:absolute;}
        </style>
        <script src="/public/backend/js/jquery.min.js"></script>
        <script src="/public/backend/js/Particleground.js"></script>
        <script>
            $(document).ready(function () {
                //粒子背景特效
                $('body').particleground({
                    dotColor: '#66B3FF',
                    lineColor: '#66B3FF'
                });
            });
        </script>
    </head>
    <body>
        <canvas class="pg-canvas" width="1366" height="635"></canvas>
        <dl class="admin_login">
            <dt>
                <strong>南昌科技贷后台管理</strong>
                <em>Management System</em>
            </dt>
            <?php
            $form = ActiveForm::begin([
                        'fieldConfig' => [
                            'template' => "{input}{error}",
                            'errorOptions' => ['style' => 'color:#FB9301;'],
                        ]
            ]);
            ?>
            <dd class="user_icon">
                <?= $form->field($model, 'name')->textInput(['class' => 'login_txtbx', 'placeholder' => '账号'])->label(false); ?>
            </dd>
            <dd class="pwd_icon">
                <?= $form->field($model, 'password')->passwordInput(['class' => 'login_txtbx', 'placeholder' => '密码'])->label(false); ?>
            </dd>
            <dd class="val_icon">
                <div class="checkcode">
                    <?=
                    $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                        'template' => '{input}{image}',
                        'captchaAction' => '/admin/public/captcha',
                        'options' => ['class' => 'login_txtbx', 'placeholder' => '验证码', 'maxlength' => '4'],
                        'imageOptions' => ['alt' => '点击换图', 'title' => '点击换图', 'style' => 'cursor:pointer;float:right;'],
                    ])->label(false);
                    ?>
                </div>
            </dd>
            <dd>
                <?php echo Html::submitButton('登录', ["class" => "submit_btn"]); ?>
            </dd>
            <?php ActiveForm::end(); ?>
            <dd>
                <p>© 2018 上海信隆行信息科技股份有限公司 版权所有</p>
            </dd>
        </dl>
        <script>
            $(function () {
                $("#user-verifycode-image").click(function () {
                    $.get('<?= Url::to(['public/captcha', 'refresh' => '']) ?>', function (res) {
                        $("#user-verifycode-image").attr('src', res.url);
                    });
                });
            });
        </script>
    </body>
</html>