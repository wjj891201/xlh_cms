<?php

use yii\web\View;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

$this->registerCssFile('@web/public/backend/js/kindeditor/themes/default/default.css', ['depends' => ['app\assets\AdminAsset']]);
$this->registerJsFile('@web/public/backend/js/kindeditor/kindeditor.js', ['depends' => ['app\assets\AdminAsset'], 'position' => View::POS_HEAD]);
$this->registerJsFile('@web/public/backend/js/kindeditor/lang/zh_CN.js', ['depends' => ['app\assets\AdminAsset'], 'position' => View::POS_HEAD]);
?>
<div id="dcMain">
    <!-- 当前位置 -->
    <div id="urHere">管理中心<b>></b><strong>分类管理</strong> </div>   
    <div class="mainBox" style="height:auto!important;height:550px;min-height:550px;">
        <?= $this->render('../set/prompt.php'); ?>
        <h3>添加分类</h3>
        <?php $form = ActiveForm::begin(); ?>
        <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
            <tr><th colspan="4" style="background: #92D6E3; text-align: left; ">基础信息</th></tr>
            <tr>
                <td width="100" align="right">所属模型</td>
                <td colspan="3">
                    <?= $form->field($model, 'mid')->dropDownList($allmodle)->label(false); ?>
                </td>
            </tr>
            <tr>
                <td align="right">名称</td>
                <td colspan="3">
                    <?= $form->field($model, 'typename')->textInput(['class' => 'inpMain', 'size' => 40])->label(false); ?>
                </td>
            </tr>
            <?php if ($model->styleid == 3): ?>
                <tr>
                    <td align="right">跳转目标</td>
                    <td colspan="3"><?= $form->field($model, 'isline')->radioList(['0' => ' 内网', '1' => '外网'])->label(false); ?></td>
                </tr>

                <tr class="t_url" <?php if ($model->isline != 1): ?>style='display:none;'<?php endif; ?>>
                    <td align="right">跳转链接地址</td>
                    <td colspan="3">
                        <?= $form->field($model, 'typeurl')->textInput(['class' => 'inpMain', 'size' => 40])->label(false); ?>
                    </td>
                </tr>

                <tr class="t_tar" <?php if ($model->isline != 0): ?>style='display:none;'<?php endif; ?>>
                    <td align="right">跳转关联分类ID</td>
                    <td colspan="3">
                        <?= $form->field($model, 'gotoline')->textInput(['class' => 'inpMain', 'size' => 5])->label(false); ?>
                    </td>
                </tr>

            <?php endif; ?>
            <tr>
                <td align="right">代表图片</td>
                <td style="width: 40%;">
                    <div class="fileupload-preview thumbnail">
                        <?php if (!empty($model->typepic)): ?>
                            <img src="<?= $model->typepic ?>" width="200" height="150"/>
                        <?php else: ?>
                            <img src="/public/backend/images/upload.png"/>
                        <?php endif; ?>
                    </div>
                </td>
                <td colspan="2">
                    <button id="upload-image-typepic" type="button" class="btn">选择图片</button>
                    <?= $form->field($model, 'typepic')->hiddenInput(['id' => 'typepic'])->label(false); ?>
                </td>
            </tr>
            <tr>
                <td align="right">其他图片</td>
                <td style="width: 40%;">
                    <div class="fileupload-preview-2 thumbnail">
                        <?php if (!empty($model->orther_typepic)): ?>
                            <img src="<?= $model->orther_typepic ?>" width="200" height="150"/>
                        <?php else: ?>
                            <img src="/public/backend/images/upload.png"/>
                        <?php endif; ?>
                    </div>
                </td>
                <td colspan="2">
                    <button id="upload-image-orther_typepic" type="button" class="btn">选择图片</button>
                    <?= $form->field($model, 'orther_typepic')->hiddenInput(['id' => 'orther_typepic'])->label(false); ?>
                </td>
            </tr>
            <?php if (in_array($model->styleid, [1, 2, 4])): ?>
                <tr>
                    <td align="right" valign="top">介绍</td>
                    <td colspan="3">
                        <?= $form->field($model, 'content')->textarea(['id' => 'content', 'class' => 'textArea', 'style' => 'width:100%;height:300px;'])->label(false); ?>
                    </td>
                </tr>
            <?php endif; ?>
            <?php if (in_array($model->styleid, [1, 2])): ?>
                <tr><th colspan="4" style="background: #92D6E3; text-align: left; ">SEO优化相关设置</th></tr>
                <tr>
                    <td align="right">自定义TITLE</td>
                    <td colspan="3">
                        <?= $form->field($model, 'headtitle')->textInput(['class' => 'inpMain', 'size' => 120])->label(false); ?>
                    </td>
                </tr>
                <tr>
                    <td align="right">自定义Keywords</td>
                    <td colspan="3">
                        <?= $form->field($model, 'keywords')->textInput(['class' => 'inpMain', 'size' => 120])->label(false); ?>
                    </td>
                </tr>
                <tr>
                    <td align="right">自定义Description</td>
                    <td colspan="3">
                        <?= $form->field($model, 'description')->textInput(['class' => 'inpMain', 'size' => 120])->label(false); ?>
                    </td>
                </tr>
            <?php endif; ?>
            <tr><th colspan="4" style="background: #92D6E3; text-align: left; ">显示样式及其它属性</th></tr>
                    <?php if (in_array($model->styleid, [1, 2])): ?>
                <tr>
                    <td align="right">页面样式</td>
                    <td colspan="3"><?= $form->field($model, 'styleid')->dropDownList(['2' => '信息列表', '1' => '频道主页'], ['style' => 'width:200px;'])->label(false); ?></td>
                </tr>
                <tr>
                    <td align="right">频道主页模板</td>
                    <td colspan="3"><?= $form->field($model, 'indextemplates')->textInput(['class' => 'inpMain', 'size' => 40])->label(false); ?></td>
                </tr>
                <tr>
                    <td align="right">列表模板</td>
                    <td colspan="3"><?= $form->field($model, 'template')->textInput(['class' => 'inpMain', 'size' => 40])->label(false); ?></td>
                </tr>
            <?php else: ?>
                <tr><td colspan="4"><?= $form->field($model, 'styleid')->textInput()->hiddenInput()->label(false); ?></td></tr>
            <?php endif; ?>
            <?php if (in_array($model->styleid, [1, 2, 4])): ?>
                <tr>
                    <td align="right">阅读模板</td>
                    <td colspan="3"><?= $form->field($model, 'readtemplate')->textInput(['class' => 'inpMain', 'size' => 40])->label(false); ?></td>
                </tr>
            <?php endif; ?>
            <?php if (in_array($model->styleid, [1, 2])): ?>
                <tr>
                    <td align="right">每页显示数量</td>
                    <td colspan="3"><?= $form->field($model, 'pagemax')->textInput(['class' => 'inpMain', 'size' => 10])->label(false); ?></td>
                </tr>
            <?php endif; ?>
            <tr>
                <td align="right">主频道显示</td>
                <td colspan="3"><?= $form->field($model, 'ismenu')->radioList(['1' => '启用', '0' => '关闭'])->label(false); ?></td>
            </tr>
            <?php if (in_array($model->styleid, [1, 2])): ?>
                <tr>
                    <td align="right">显示排序</td>
                    <td><?= $form->field($model, 'isorderby')->radioList(['1' => '启用', '0' => '关闭'])->label(false); ?></td>
                </tr>
                <tr>
                    <td align="right">排序方式</td>
                    <td><?= $form->field($model, 'ordertype')->radioList(['1' => '启用', '0' => '关闭'])->label(false); ?></td>
                </tr>
                <tr>
                    <td align="right">列表内容显示范围</td>
                    <td colspan="3">
                        <?= $form->field($model, 'ispart')->radioList(['1' => ' 显示所有子分类内容', '0' => ' 仅显示当前分类内容'])->label(false); ?>
                    </td>
                </tr>
            <?php endif; ?>
            <tr>
                <td></td>
                <td colspan="3">
                    <?= $form->field($model, 'upid')->textInput()->hiddenInput()->label(false); ?>
                    <?= Html::submitButton('提交', ['class' => 'btn']); ?>
                </td>
            </tr>
        </table>
        <?php ActiveForm::end(); ?>
    </div>
</div>
<script>
    $(function () {
        $("input[name='Type[isline]']").on('change', function () {
            if ($(this).val() == 1) {
                $('.t_url').show();
                $('.t_tar').hide();
            } else {
                $('.t_tar').show();
                $('.t_url').hide();
            }
        });
    });

    KindEditor.ready(function (K) {
        K.create('textarea[id="content"]');
        var editor = K.editor({
            allowFileManager: true  //开启多文件上传
        });
        $("#upload-image-typepic").click(function () {
            editor.loadPlugin("image", function () {
                editor.plugin.imageDialog({
                    showRemote: false,
                    clickFn: function (url) {
                        $("#typepic").val(url);
                        $(".fileupload-preview").html('<img src="' + url + '" style="width:200px;height:150px;"/>');
                        editor.hideDialog();
                    }
                });
            });
        });
        $("#upload-image-orther_typepic").click(function () {
            editor.loadPlugin("image", function () {
                editor.plugin.imageDialog({
                    showRemote: false,
                    clickFn: function (url) {
                        $("#orther_typepic").val(url);
                        $(".fileupload-preview-2").html('<img src="' + url + '" style="width:200px;height:150px;"/>');
                        editor.hideDialog();
                    }
                });
            });
        });
    });
</script>