<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url; //使用Url类
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link href="assets/admin/assets/css/bootstrap.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="assets/admin/assets/css/font-awesome.min.css" />
        <!--[if IE 7]>
          <link rel="stylesheet" href="assets/admin/assets/css/font-awesome-ie7.min.css" />
        <![endif]-->
        <link rel="stylesheet" href="assets/admin/assets/css/ace.min.css" />
        <link rel="stylesheet" href="assets/admin/assets/css/ace-rtl.min.css" />
        <link rel="stylesheet" href="assets/admin/assets/css/ace-skins.min.css" />
        <link rel="stylesheet" href="assets/admin/css/style.css"/>
        <!--[if lte IE 8]>
          <link rel="stylesheet" href="assets/admin/assets/css/ace-ie.min.css" />
        <![endif]-->
        <script src="assets/admin/assets/js/ace-extra.min.js"></script>
        <!--[if lt IE 9]>
        <script src="assets/admin/assets/js/html5shiv.js"></script>
        <script src="assets/admin/assets/js/respond.min.js"></script>
        <![endif]-->
        <script src="assets/admin/js/jquery-1.9.1.min.js"></script>        
        <script src="assets/admin/assets/layer/layer.js" type="text/javascript"></script>
        <title>修改密码</title>
    </head>

    <body class="login-layout">
        <div class="logintop">    
            <span>欢迎后台管理界面平台</span>    
            <ul>
                <li><a href="#">返回首页</a></li>
                <li><a href="#">帮助</a></li>
                <li><a href="#">关于</a></li>
            </ul>    
        </div>
        <div class="loginbody">
            <div class="login-container">
                <div class="center"></div>
                <div class="space-6"></div>
                <div class="position-relative">
                    <div id="login-box" class="login-box widget-box no-border visible">
                        <div class="widget-body">
                            <div class="widget-main">
                                <h4 class="header blue lighter bigger">
                                    <i class="icon-coffee green"></i>
                                    修改密码
                                </h4>

                                <?php if (Yii::$app->session->hasFlash('info')): ?>
                                    <?= Yii::$app->session->getFlash('info') ?>
                                <?php endif; ?>

                                <div class="login_icon"><img src="assets/admin/images/login.png" /></div>

                                <?php
                                $form = ActiveForm::begin([
                                            'fieldConfig' => [
                                                'template' => '{input}{error}',
                                                ],
                                        ]);
                                ?>
                                <fieldset>
                                    <label class="block clearfix">
                                        <span class="block input-icon input-icon-right">
                                            <?php echo $form->field($model, 'user')->hiddenInput(); ?>
                                        </span>
                                    </label>

                                    <label class="block clearfix">
                                        <span class="block input-icon input-icon-right">
                                            <?php echo $form->field($model, 'password')->passwordInput(['class' => 'form-control', 'placeholder' => '新密码']); ?>
                                            <i class="icon-lock"></i>
                                        </span>
                                    </label>

                                    <label class="block clearfix">
                                        <span class="block input-icon input-icon-right">
                                            <?php echo $form->field($model, 'repass')->passwordInput(['class' => 'form-control', 'placeholder' => '确认密码']); ?>
                                            <i class="icon-lock"></i>
                                        </span>
                                    </label>

                                    <div class="clearfix">
                                        <?php echo Html::submitButton('修改', ["class" => "width-35 pull-right btn btn-sm btn-primary", 'id' => "login_btn"]); ?>
                                    </div>

                                    <div class="space-4"></div>
                                </fieldset>
                                <?php ActiveForm::end(); ?>

                                <div class="social-or-login center">
                                    <span class="bigger-110"></span>
                                </div>

                                <div class="social-login center">
                                    <a href="<?php echo Url::to(['public/login']) ?>">返回登陆</a>
                                </div>
                            </div><!-- /widget-main -->

                            <div class="toolbar clearfix"></div>
                        </div><!-- /widget-body -->
                    </div><!-- /login-box -->
                </div><!-- /position-relative -->
            </div>
        </div>
        <div class="loginbm">版权所有  2016  <a href="">上海信隆行</a> </div><strong></strong>
    </body>
</html>