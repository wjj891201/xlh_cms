<?php

use yii\bootstrap\ActiveForm;
use yii\web\View;
use yii\captcha\Captcha;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = '注册';
$this->params['breadcrumbs'][] = $this->title;
$this->registerMetaTag(['name' => 'keywords', 'content' => '']);
$this->registerMetaTag(['name' => 'description', 'content' => ''], 'description');

# layer~~~start
$this->registerJsFile('@web/public/kjd/js/layer/layer.js', ['depends' => ['app\assets\KjdAsset'], 'position' => View::POS_HEAD]);
# layer~~~end
?>
<div class="gbox">
    <div class="wraper2">
        <?php
        $form = ActiveForm::begin([
                    'options' => ['id' => 'register_form'],
                    'fieldConfig' => [
                        'template' => "<li>{label}{input}{error}</li>",
                        'labelOptions' => ['class' => false, 'for' => false],
                        'errorOptions' => ['class' => 'warn'],
                    ]
        ]);
        ?>
        <div class="register_box2">
            <ul>
                <?= $form->field($model, 'username', ['template' => "<li>{label}{input}{error}</li>", 'errorOptions' => ['class' => 'warn']])->textInput(['class' => 'reg_input reg_input_w forget_input', 'placeholder' => '请填写中国大陆手机号']); ?>
                <?=
                $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                    'template' => '{input}{image}',
                    'captchaAction' => '/public/captcha',
                    'options' => ['id' => 'verify', 'style' => 'float:left;', 'class' => 'reg_input reg_input_w2 forget_input', 'placeholder' => '请输入验证码'],
                    'imageOptions' => ['alt' => '点击换图', 'title' => '点击换图', 'style' => 'float:right;margin-right:22px;border-radius:3px;']
                ]);
                ?>
                <?= $form->field($model, 'short', ['template' => "<li>{label}{input}<input type=\"button\" class=\"getVerification_code\" value=\"获取验证码\" id=\"btnSend\">{error}</li>", 'errorOptions' => ['class' => 'warn']])->textInput(['id' => 'short', 'class' => 'reg_input reg_input_w2 forget_input', 'placeholder' => '请输入短信验证码']); ?>
                <?= $form->field($model, 'password', ['template' => "<li>{label}{input}{error}</li>", 'errorOptions' => ['class' => 'warn']])->passwordInput(['class' => 'reg_input reg_input_w forget_input', 'placeholder' => '6-20位字母数字组合']); ?>
                <?= $form->field($model, 'repass', ['template' => "<li>{label}{input}{error}</li>", 'errorOptions' => ['class' => 'warn']])->passwordInput(['class' => 'reg_input reg_input_w forget_input', 'placeholder' => '6-20位字母数字组合']); ?>
            </ul>
            <div class="reg_agree">
                <?= $form->field($model, 'agreement')->checkbox(['id' => 'agreement', 'template' => "<p>{input}<label for=\"agreement\">我已阅读并同意一融网</label><a href=\"" . Url::to(['single/detail', 'tid' => 112]) . "\" target=\"_blank\">《一融网用户使用协议》</a></p>{error}"]) ?>
            </div>
            <?= Html::submitButton('立即注册', ['class' => 'reg_button', 'id' => 'submit_button-btn']); ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
<script>
    //发送验证码
    $('#btnSend').on('click', function () {
        var phone = $("#member-username").val();
        if (phone == null || phone == "") {
            layer.msg('请输入手机号码', {icon: 2, time: 1500});
            return false;
        }
        if (!(/^1(3|4|5|7|8)\d{9}$/.test(phone))) {
            layer.msg('手机号码有误', {icon: 2, time: 1500});
            return false;
        }
        if (!$(this).hasClass('not')) {
            sendphonecode(phone);
        }
    });
    //验证手机号，发送验证码
    function sendphonecode(phoneNo) {
        $.get("<?= Url::to(['public/sms']) ?>", {"phone": phoneNo}, function (data) {
            if (data) {
                var time = setInterval(function () {
                    settime(time);
                }, 1000);
            }
        }, "json");
    }
    //验证码间隔时间
    var countdown = 60;
    //60秒后可重新发送
    function settime(time) {
        if (countdown <= 0) {
            clearInterval(time);
            $('#btnSend').removeClass("not");
            $('#btnSend').val("获取验证码");
            countdown = 60;
        } else {
            $('#btnSend').addClass("not");
            $('#btnSend').val("已发送(" + countdown + ")");
            countdown--;
        }
    }
</script>