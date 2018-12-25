<?php

use yii\bootstrap\ActiveForm;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;

//$this->registerCssFile('@web/public/kjd/css/step2.css', ['depends' => ['app\assets\KjdAsset']]);
//$this->registerCssFile('@web/public/kjd/css/land.css', ['depends' => ['app\assets\KjdAsset']]);
$this->registerCssFile('@web/public/kjd/css/apply.css', ['depends' => ['app\assets\KjdAsset']]);
$this->registerCssFile('@web/public/kjd/css/apply_base.css', ['depends' => ['app\assets\KjdAsset']]);
$this->registerCssFile('@web/public/kjd/css/apply_style.css', ['depends' => ['app\assets\KjdAsset']]);
$this->registerCssFile('@web/public/kjd/css/easy.css', ['depends' => ['app\assets\KjdAsset']]);

# layer~~~start
$this->registerJsFile('@web/public/kjd/js/layer/layer.js', ['depends' => ['app\assets\KjdAsset'], 'position' => View::POS_HEAD]);
# layer~~~end
$this->registerJsFile('@web/public/kjd/js/jquery.cookie.js', ['depends' => ['app\assets\KjdAsset'], 'position' => View::POS_HEAD]);
$this->title = '认定资料填写-第一步';
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
        <img src="/public/kjd/images/s1.png"  alt="">
        <ul>
            <li class="first">基本信息</li>
            <li class="second">财务信息</li>
            <li class="third">企业概述</li>
            <li class="last">贷款信息</li>
        </ul>
    </div>
    <div class="main1200 pb5">
        <div class="mainBar pt50 pl100 pr50 pb20 mb20">
            <h3 class="mb15">基础信息</h3>
            <?php $form = ActiveForm::begin(['options' => ['id' => 'step1', 'enctype' => 'multipart/form-data']]); ?>
            <div class="content_form">
                <ul class="step1box step3Box step2box">
                    <li>
                        <label> 企业名称：</label>
                        <?php if ($model->base_id): ?>
                            <?= $form->field($model, 'enterprise_name', ['template' => "{input}{error}", 'errorOptions' => ['class' => 'msg']])->textInput(['class' => 'company_name', 'id' => 'enterprise_name', 'readonly' => 'readonly', 'style' => 'background:#eee;'])->label(false); ?>
                        <?php else: ?>
                            <?= $form->field($model, 'enterprise_name', ['template' => "{input}<div class=\"checkReal\">检查名称真实性</div><div class=\"checkedReal\"></div>{error}", 'errorOptions' => ['class' => 'msg']])->textInput(['class' => 'company_name', 'id' => 'enterprise_name', 'placeholder' => '请输入工商登记的企业名称'])->label(false); ?>
                        <?php endif; ?>
                    </li>
                    <li class="area">
                        <label>所属区域：</label>
                        <span>江西省</span><span>南昌市</span>
                        <?= $form->field($model, 'town_id', ['errorOptions' => ['class' => 'msg']])->dropDownList($allArea, ['class' => 'gray_select', 'style' => 'width:166px;'])->label(false); ?>
                    </li>
                    <li>
                        <label>法定代表人：</label>
                        <?= $form->field($model, 'legal_person', ['errorOptions' => ['class' => 'msg']])->textInput(['id' => 'legal_person', 'placeholder' => '请输入法定代表人'])->label(false); ?>
                    </li>
                    <li>
                        <label>法人手机号：</label>
                        <?= $form->field($model, 'legal_person_phone', ['errorOptions' => ['class' => 'msg']])->textInput(['id' => 'legal_person_phone', 'placeholder' => '请输入法人手机号'])->label(false); ?>
                    </li>  
                    <li>
                        <label>通讯地址：</label>
                        <?= $form->field($model, 'contact_address', ['errorOptions' => ['class' => 'msg']])->textInput(['id' => 'contact_address', 'placeholder' => '请输入通讯地址'])->label(false); ?>
                    </li>
                    <li>
                        <label>企业联系人：</label>
                        <?= $form->field($model, 'contact_person_man', ['errorOptions' => ['class' => 'msg']])->textInput(['id' => 'contact_person_man', 'placeholder' => '请输入负责本次申请的联系人名称'])->label(false); ?>
                    </li>
                    <li>
                        <label>联系人手机号：</label>
                        <?= $form->field($model, 'contact_person_phone', ['errorOptions' => ['class' => 'msg']])->textInput(['id' => 'contact_person_phone', 'placeholder' => '请输入联系人手机号'])->label(false); ?>
                    </li>
                    <li>
                        <label>电子邮箱：</label>
                        <?= $form->field($model, 'contact_mail', ['errorOptions' => ['class' => 'msg']])->textInput(['id' => 'contact_mail', 'placeholder' => '请输入电子邮箱'])->label(false); ?>
                    </li>
                    <li class="area">
                        <label>选择行业：</label>
                        <?= $form->field($model, 'industry_id', ['errorOptions' => ['class' => 'msg']])->dropDownList($industry, ['class' => 'gray_select', 'style' => 'width:160px;'])->label(false); ?>
                    </li>
                    <li>
                        <label>企业简介：</label>
                        <?= $form->field($model, 'enterprise_info', ['errorOptions' => ['class' => 'msg']])->textArea(['class' => 'normal_text', 'placeholder' => '简要介绍下你的企业，100-2000字', 'rows' => '5', 'cols' => '33', 'id' => 'enterprise_info'])->label(false); ?>
                    </li>
                    <li>
                        <label style="vertical-align: top">营业执照上传：</label>
                        <div class="upload">
                            <input type="file" name="mypic" id="uploadfile" onchange="fileChange(this);">
                            <div class="upload_before">
                                <img src="/public/kjd/images/upload.png" id="upload-image-business_licence" style="cursor: pointer;">
                                <div class="upload_describe">
                                    <?php if ($model->business_licence): ?>
                                        <div class="title">上传成功</div>
                                        <div class="subtitle">重新上传营业执照<i></i></div>
                                    <?php else: ?>
                                        <div class="title">选择文件</div>
                                        <div class="subtitle">企业营业执照副本、组织机构代码证或统一社会信用代码证（复印件）</div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <?= $form->field($model, 'business_licence', ['errorOptions' => ['class' => 'msg']])->hiddenInput(['id' => 'business_licence'])->label(false); ?>
                    </li>
                </ul>
            </div>
            <?= $form->field($model, 'register_info')->hiddenInput(['id' => 'register_info'])->label(false); ?>
            <?= Html::submitButton('下一步', ['class' => 'nextbtn']); ?>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

<script>
    $(function () {
        $('.checkReal').click(function () {
            var name = $('#enterprise_name').val();
            if (name == '') {
                layer.tips('企业名称不能为空', '#enterprise_name', {tips: [1, '#EA2000']});
                return false;
            }
            if (!$(this).hasClass('not')) {
                $.cookie('enterprise_name', name, {expires: 1});
                $.ajax({
                    async: false,
                    dateType: "json",
                    type: 'post',
                    data: {name: name, _csrf: '<?= Yii::$app->request->csrfToken ?>'},
                    url: '<?= Url::to(['apply/ajax-query-enterprise-name']); ?>',
                    success: function (result) {
                        var info = eval("(" + result + ")");
                        ck = info.ck;
                        if (ck == 1) {
                            var data = info.data;
                            // 注册相关信息
                            $('#register_info').val(data.register_info);
                            // 填充其他信息
                            $('#legal_person').val(data.legal_person);
                            if ($('#legal_person_phone').val() == '') {
                                $('#legal_person_phone').val(data.legal_person_phone);
                            }
                            $('#contact_mail').val(data.contact_mail);
                            $('#contact_address').val(data.contact_address);
                            $('.checkedReal').html("<i></i>已验证真实性").attr('style', 'color:#000');
                            //倒计时
                            var time = setInterval(function () {
                                settime(time);
                            }, 1000);
                        } else {
                            $('.checkedReal').empty();
                            layer.tips(info.msg, '#enterprise_name', {tips: [1, '#EA2000']});
                            return false;
                        }
                    }
                });
            }
        });
    });

    //间隔时间
    var countdown = 59;
    //60秒后可重新发送
    function settime(time) {
        $('#enterprise_name').attr("readonly", "readonly");
        if (countdown <= 0) {
            clearInterval(time);
            $('.checkReal').removeClass("not");
            $('.checkReal').removeClass('btnclickon');
            $('#enterprise_name').attr('readonly', false);
            $('.checkReal').html("检查名称真实性");
            countdown = 59;
        } else {
            $('.checkReal').addClass("not");
            $('.checkReal').addClass('btnclickon');
            $('.checkReal').html("重新发送(" + countdown + ")");
            countdown--;
        }
    }

    //上传图片
    function fileChange(target) {
        var thisId = target.id;
        var formData = new FormData();
        formData.append("_csrf", "<?= Yii::$app->request->csrfToken ?>");
        formData.append("type", 'license');
        formData.append("file", $('#' + thisId)[0].files[0]);
        $.ajax({
            url: "<?= Url::to(['apply/ajax-upload-files']) ?>",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function () {
                //可以做一些正在上传的效果
            },
            success: function (data) {
                //data，我们这里是异步上传到后端程序所返回的图片地址
                var obj = JSON.parse(data);
                if (obj.code == 20000) {
                    $("#business_licence").val(obj.success.url);
                    $('.upload_before img').attr('src', '/public/kjd/images/file_finsh.png');
                    $('.upload_describe .title').html('上传成功');
                    $('.upload_describe .subtitle').html('重新上传营业执照<i></i>');
                    //为了让yii2的验证生效
                    $("#business_licence").focus();
                    $("#business_licence").blur();
                }
                if (obj.code == 20001) {
                    layer.msg(obj.error, {icon: 2, time: 2000});
                }
            },
            error: function (responseStr) {
                console.log(responseStr);
            }
        });
    }
</script>
