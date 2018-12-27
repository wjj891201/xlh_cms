<?php

use yii\bootstrap\ActiveForm;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;

$this->registerCssFile('@web/public/kjd/css/apply.css', ['depends' => ['app\assets\KjdAsset']]);
$this->registerCssFile('@web/public/kjd/css/apply_base.css', ['depends' => ['app\assets\KjdAsset']]);
$this->registerCssFile('@web/public/kjd/css/apply_style.css', ['depends' => ['app\assets\KjdAsset']]);
$this->registerCssFile('@web/public/kjd/css/easy.css', ['depends' => ['app\assets\KjdAsset']]);
$this->registerCssFile('@web/public/kjd/css/common.css', ['depends' => ['app\assets\KjdAsset']]);

# layer~~~start
$this->registerJsFile('@web/public/kjd/js/layer/layer.js', ['depends' => ['app\assets\KjdAsset'], 'position' => View::POS_HEAD]);
# layer~~~end
$this->title = '认定资料填写-第三步';
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
        <img src="/public/kjd/images/s3.png" alt=""/>
        <ul>
            <li class="first">基本信息</li>
            <li class="second">财务信息</li>
            <li class="third">企业概述</li>
            <li class="last">贷款信息</li>
        </ul>
    </div>
    <div class="main1200 pb5">
        <div class="mainBar pt50 pl100 pr50 pb20 mb20">
            <h3 class="mb15">企业概述</h3>
            <?php $form = ActiveForm::begin(['options' => ['id' => 'step3', 'enctype' => 'multipart/form-data']]); ?>
            <div class="content_form">
                <ul class="step2box step3Box">
                    <li>
                        <label class="labelT">主要产品及技术领域：</label>
                        <?= $form->field($model, 'product_tech_desc', ['errorOptions' => ['class' => 'msg']])->textArea(['placeholder' => '请输入10-500字的内容'])->label(false); ?>
                    </li>
                    <li>
                        <label>企业拥有知识产权数：</label>
                        <?= $form->field($model, 'equity_num', ['errorOptions' => ['class' => 'msg']])->textInput(['id' => 'research_num'])->label(false); ?>
                    </li>
                    <li>
                        <label>核心管理人员职业经历：</label>
                        <div class="core_member_box addp_style">
                            <a class="add_person" id="profession_add_btn">+ 添加经历</a>
                            <div class="clear"></div>
                            <div style="width:700px;float: right;" id="this_here">
                                <?php $profession = json_decode($model->profession, true); ?>
                                <?php if (!empty($profession)): ?>
                                    <?php foreach ($profession as $key => $vo): ?>
                                        <ul class="exper_conts" data-id="<?= $key ?>">
                                            <li><label style="width:90px;">姓名：</label><?= $vo['name'] ?><input name="pro_name[]" type="hidden" value="<?= $vo['name'] ?>"></li>
                                            <li><label style="width:90px;">职位：</label><?= $vo['position'] ?><input name="pro_job[]" type="hidden" value="<?= $vo['position'] ?>"></li>
                                            <li>
                                                <label style="width:90px;">经历：</label>
                                                <p class="over-experience" style="width:210px;height: 100px;word-wrap : break-word"><?= $vo['experience'] ?></p>
                                                <input name="pro_exp[]" type="hidden" value="<?= $vo['experience'] ?>">
                                            </li>
                                            <div class="oper_btns">
                                                <a class="exper_btns_a exper_btns1">编辑</a><a class="exper_btns_a exper_btns2">删除</a>
                                            </div>
                                        </ul>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?= $form->field($model, 'code', ['errorOptions' => ['class' => 'msg']])->hiddenInput(['id' => 'code'])->label(false); ?>
                    </li>
                    <li>
                        <label>企业拥有资质：</label>
                        <div class="core_member_box addp_style">
                            <?php $qualification_certificate = json_decode($model->qualification_certificate, true); ?>
                            <?php if (!empty($qualification_certificate)): ?>
                                <?php foreach ($qualification_certificate as $key => $vo): ?>
                                    <div class="natural_file">
                                        <p class="natural_file_name"><?= $vo['name'] ?><span class="natural_file_del">x</span></p>
                                        <p class="natural_rel_name"><a href="" class="put_name"><?= $vo['file_name'] ?></a></p>
                                        <input type="hidden" name="u_zizhi_enterprise[]" value="<?= $vo['id'] ?>">
                                        <input type="hidden" name="u_zizhi_china_enterprise[]" value="<?= $vo['name'] ?>">
                                        <input type="hidden" name="u_zizhi_file[]" value="<?= $vo['path'] ?>">
                                        <input type="hidden" name="u_zizhi_file_name[]" value="<?= $vo['file_name'] ?>">
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            <div class="add_natural">
                                <p>+&nbsp;添加资质</p>
                            </div>
                        </div>
                        <?= $form->field($model, 'qualification', ['errorOptions' => ['class' => 'msg']])->hiddenInput(['id' => 'qualification'])->label(false); ?>
                    </li>
                </ul>
            </div>
            <div style="clear:both"></div>
            <div class="save_btn">
                <a href="<?= Url::to(['apply/apply-finance']) ?>" class="left_btn">上一步</a>
                <?= Html::submitButton('下一步', ['class' => 'nextbtn right_btn grey']); ?>
            </div>
            <?php ActiveForm::end(); ?>    
        </div>
    </div>
    <div class="special_1" style="display: none;">
        <div class="dialog dialog_edit_add">
            <div class="dcontent">
                <div>
                    <ul class="add_contents">
                        <li>
                            <label>姓名：</label>
                            <input type="text" class="pname normal_input" placeholder="10字以内">
                        </li>
                        <li>
                            <label>职位：</label>
                            <input type="text" class="pjob normal_input" placeholder="10字以内">
                        </li>
                        <li>
                            <label>经历：</label>
                            <textarea class="pexperience normal_text" placeholder="请输入职业经历，10-200字"></textarea>
                        </li>
                    </ul>
                    <div class="clear"></div>
                    <a href="javascript:void(0);" class="dokay2">确定</a>
                </div>
            </div>
        </div>
    </div>

    <div class="special_2" style="display: none;">
        <div class="dialog uploadFileBox"> 
            <div class="dcontent">
                <div>
                    <ul class="add_contents">
                        <li></li>
                        <li>
                            <label>企业类型：</label>
                            <select class="zizhi_enterprise normal_input">
                                <option value="">请选择</option>
                                <?php foreach ($enterprise as $key => $vo): ?>
                                    <option value="<?= $vo['id'] ?>"><?= $vo['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </li>
                        <li>
                            <label>上传资质：</label>
                            <div class="upload" style="width:80%;float: right;background-color:#ffffff;position:relative;">
                                <input type="file" name="mypic" id="uploadfile" style="width:65px;height:65px;top:28px;left: 8px;">
                                <input id="file" name="zizhi_file" class="zizhi_file" type="hidden">
                                <input id="file_name" name="zizhi_file_name" class="zizhi_file_name" type="hidden">
                                <div class="upload_before">
                                    <img style="padding-top: 0px;" src="/public/kjd/images/upload.png" alt="选择文件">
                                    <div class="upload_describe">
                                        <div class="title" style="border: none;">选择文件</div>
                                        <div class="subtitle">请选择附件上传</div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <div class="clear"></div>
                    <a href="javascript:void(0);" class="dokay3">确定</a>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {
        //核心管理人员相关的js~~~start
        $('#profession_add_btn').click(function () {
            bbb = layer.open({
                type: 1,
                title: '添加经历',
                skin: 'layui-layer-rim',
                area: ['600px', '390px'], //宽高
                content: $('.special_1'),
                end: function () {
                    //初始化数据
                    $('.dokay2').attr('data-id', '');
                    $('.pname,.pjob,.pexperience').val("");
                    //#this_here下有没有管理人员
                    var exper_conts = $('.exper_conts');
                    if (exper_conts.length != 0) {
                        $("#code").val(1);
                    } else {
                        $("#code").val('');
                    }
                    //为了让yii2框架的验证生效
                    $("#code").focus();
                    $("#code").blur();
                }
            });
        });
        $(document).on('click', '.dokay2', function () {
            var data_id = $(this).attr('data-id');
            var pname = $('.pname').val();
            if (pname == '') {
                layer.tips('请填写姓名', '.pname');
                return false;
            }
            var pjob = $('.pjob').val();
            if (pjob == '') {
                layer.tips('请填写职位', '.pjob');
                return false;
            }
            var pexperience = $('.pexperience').val();
            if (pexperience == '') {
                layer.tips('请填写经历', '.pexperience');
                return false;
            }
            if (data_id) {
                //编辑
                var editnode = $('.core_member_box ul[data-id=' + data_id + ']');
                editnode.find('li:eq(0)').html('<label style="width:90px;">姓名：</label>' + pname + '<input name="pro_name[]" type="hidden" value="' + pname + '"/>');
                editnode.find('li:eq(1)').html('<label style="width:90px;">职位：</label>' + pjob + '<input name="pro_job[]" type="hidden" value="' + pjob + '"/>');
                editnode.find('li:eq(2)').html('<label style="width:90px;">经历：</label><p class="over-experience" style="width:210px;height: 100px;word-wrap : break-word">' + pexperience + '</p><input name="pro_exp[]" type="hidden" value="' + pexperience + '"/>');
                layer.close(ccc);
            } else {
                //添加
                var html = '<ul class="exper_conts">';
                html += '<li><label style="width:90px;">姓名：</label>' + pname + '<input name="pro_name[]" type="hidden" value="' + pname + '"/></li>';
                html += '<li><label style="width:90px;">职位：</label>' + pjob + '<input name="pro_job[]" type="hidden" value="' + pjob + '"/></li>';
                html += '<li><label style="width:90px;">经历：</label><p class="over-experience" style="width:210px;height: 100px;word-wrap : break-word">' + pexperience + '</p><input name="pro_exp[]" type="hidden" value="' + pexperience + '"/></li>';
                html += '<div class="oper_btns"><a class="exper_btns_a exper_btns1">编辑</a><a class="exper_btns_a exper_btns2">删除</a></div>';
                html += '</ul>';
                $("#this_here").append(html);
                id_value();
                layer.close(bbb);
            }
        });
        $(document).on('click', '.exper_btns2', function () {
            $(this).parents(".exper_conts").remove();
            id_value();
            //#this_here下有没有管理人员
            var exper_conts = $('.exper_conts');
            if (exper_conts.length != 0) {
                $("#code").val(1);
            } else {
                $("#code").val('');
            }
            //为了让yii2框架的验证生效
            $("#code").focus();
            $("#code").blur();
        });
        $(document).on('click', '.exper_btns1', function () {
            var edit_npde = $(this).parents(".exper_conts");
            var data_id = edit_npde.attr('data-id');
            $('.dokay2').attr('data-id', data_id);
            //姓名
            var obj = edit_npde.find("li:eq(0)").clone();
            obj.find(':nth-child(n)').remove();
            var pname = obj.html().trim();
            //职务
            var obj = edit_npde.find("li:eq(1)").clone();
            obj.find(':nth-child(n)').remove();
            var pjob = obj.html().trim();
            //经历
            var pexperience = edit_npde.find("li:eq(2) p").text().trim();
            //赋值
            $('.pname').val(pname);
            $('.pjob').val(pjob);
            $('.pexperience').val(pexperience);
            //弹出层
            ccc = layer.open({
                type: 1,
                title: '编辑经历',
                skin: 'layui-layer-rim',
                area: ['600px', '390px'], //宽高
                content: $('.special_1'),
                end: function () {
                    $('.dokay2').attr('data-id', '');
                    $('.pname,.pjob,.pexperience').val("");
                }
            });
        });
        var id_value = function () {
            var liNode = $('.core_member_box .exper_conts');
            liNode.each(function () {
                $(this).attr('data-id', $(this).index());
            });
        };
        //核心管理人员相关的js~~~end
        //上传文件相关的js~~~start
        $(".add_natural").click(function () {
            //aaa为全局变量
            aaa = layer.open({
                type: 1,
                title: '添加资质',
                skin: 'layui-layer-rim',
                area: ['600px', '390px'], //宽高
                content: $('.special_2'),
                end: function () {
                    $('.zizhi_enterprise,.zizhi_file,.zizhi_file_name').val("");
                    $('.upload img').attr('src', "/public/kjd/images/upload.png");
                    $(".upload_describe .title").html('选择文件');
                    $(".upload_describe .subtitle").html('请选择附件上传');
                    //.add_natural下有没有资质
                    var natural_file = $('.natural_file');
                    if (natural_file.length != 0) {
                        $("#qualification").val(1);
                    } else {
                        $("#qualification").val('');
                    }
                    //为了让yii2框架的验证生效
                    $("#qualification").focus();
                    $("#qualification").blur();
                }
            });
        });
        $(document).on('change', '#uploadfile', function () {
            var thisId = this.id;
            var formData = new FormData();
            formData.append("_csrf", "<?= Yii::$app->request->csrfToken ?>");
            formData.append("type", 'zz');
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
                        $('.upload img').attr('src', '/public/kjd/images/file_finsh.png');
                        $('.upload_describe .title').html('上传成功');
                        $('.upload_describe .subtitle').html('重新上传营业执照<i></i>');
                        $(".zizhi_file").val(obj.success.url);
                        $(".zizhi_file_name").val(obj.success.name);
                    }
                    if (obj.code == 20001) {
                        layer.msg(obj.error, {icon: 2, time: 2000});
                    }
                },
                error: function (responseStr) {
                    console.log(responseStr);
                }
            });
        });
        $(document).on('click', '.dokay3', function () {
            var zizhi_enterprise = $('.zizhi_enterprise').val();
            var title = $(".zizhi_enterprise").find("option:selected").text();
            if (zizhi_enterprise == '') {
                layer.tips('请选择企业类型', '.zizhi_enterprise');
                return false;
            }
            var zizhi_file = $('.zizhi_file').val();
            var zizhi_file_name = $('.zizhi_file_name').val();
            if (zizhi_file == '') {
                layer.tips('请上传资质文件', '.upload');
                return false;
            }
            var html = "<div class=\"natural_file\">";
            html += "<p class=\"natural_file_name\">" + title + "<span class=\"natural_file_del\">x</span></p>";
            html += "<p class=\"natural_rel_name\"><a href=\"\" class=\"put_name\">" + zizhi_file_name + "</a></p>";
            html += "<input type=\"hidden\" name=\"u_zizhi_enterprise[]\" value=\"" + zizhi_enterprise + "\" >";
            html += "<input type=\"hidden\" name=\"u_zizhi_china_enterprise[]\" value=\"" + title + "\" >";
            html += "<input type=\"hidden\" name=\"u_zizhi_file[]\" value=\"" + zizhi_file + "\" >";
            html += "<input type=\"hidden\" name=\"u_zizhi_file_name[]\" value=\"" + zizhi_file_name + "\" >";
            html += "</div>";
            $(".add_natural").before(html);
            layer.close(aaa);
        });
        $(document).on('click', '.natural_file_del', function () {
            $(this).parents(".natural_file").remove();
            //.add_natural下有没有资质
            var natural_file = $('.natural_file');
            if (natural_file.length != 0) {
                $("#qualification").val(1);
            } else {
                $("#qualification").val('');
            }
            //为了让yii2框架的验证生效
            $("#qualification").focus();
            $("#qualification").blur();
        });
        //上传文件相关的js~~~end
    });
</script>
