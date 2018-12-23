<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url; //使用Url类
?>
<!-- KindEditor -->
<link rel="stylesheet" href="/assets/backend/js/kindeditor/themes/default/default.css" />
<script charset="utf-8" src="/assets/backend/js/kindeditor/kindeditor.js"></script>
<script charset="utf-8" src="/assets/backend/js/kindeditor/lang/zh_CN.js"></script>

<script>
    KindEditor.ready(function(K) { 
        K.create('textarea[id="content"]');
        var editor = K.editor({
            allowFileManager : true  //开启多文件上传
        });
        $("#upload-image-thumb").click(function() {
            editor.loadPlugin("image", function() {
                editor.plugin.imageDialog({
                    showRemote : false,
                    clickFn : function(url) {
                        $("#thumb").val(url);
                        $(".fileupload-preview").html('<img src="'+url+'" style="width:200px;height:150px;"/>');
                        editor.hideDialog();
                    }
                });
            });
        }); 
    });
</script>

<div id="dcMain">
    <!-- 当前位置 -->
    <div id="urHere">管理中心<b>></b><strong>栏目分类</strong></div>
    <!--提示消息 开始-->
    <?php if (Yii::$app->session->hasFlash('success')): ?>
        <div class="message success">
            <p><?= Yii::$app->session->getFlash('success') ?></p>
            <div class="close"></div>
        </div>
    <?php endif ?>
    <!--提示消息 结束-->
    <div class="mainBox" style="height:auto!important;height:550px;min-height:550px;">
        <h3><a href="<?= Url::to(['category/list']); ?>" class="actionBtn">分类列表</a>栏目分类</h3>
        <?php
        $form = ActiveForm::begin();
        ?>
        <?= $form->field($model, 'type')->textInput()->hiddenInput()->label(false); ?>
        <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
            <tr>
                <td width="80" align="right">上级分类</td>
                <td colspan="3">
                    <?= $form->field($model, 'parentid')->dropDownList($list)->label(false); ?>
                </td>

            </tr>

            <tr>
                <td align="right">分类名称</td>
                <td>
                    <?= $form->field($model, 'name')->textInput(['class' => 'inpMain', 'size' => 40])->label(false); ?>
                </td>
                <td  width="80" align="right">顶部导航</td>
                <td>
                    <?= $form->field($model, 'status')->radioList(['1' => '是', '2' => '否'])->label(false); ?>
                </td>
            </tr>
            <tr>
                <td align="right">代表图</td>
                <td style="width: 40%;">
                    <div class="fileupload-preview thumbnail">
                        <?php if (!empty($model->thumb)): ?>
                            <img src="<?= $model->thumb ?>" width="200" height="150"/>
                        <?php else: ?>
                            <img src="/assets/backend/images/upload.png"/>
                        <?php endif; ?>
                    </div>
                </td>
                <td colspan="2">
                    <button id="upload-image-thumb" type="button" class="btn">选择图片</button>
                    <?= $form->field($model, 'thumb')->hiddenInput(['id' => 'thumb'])->label(false); ?>
                </td>
            </tr>

            <?php if ($model->type == 3): ?>
                <tr>
                    <td align="right">关联分类ID</td>
                    <td style="width: 40%;">
                        <?= $form->field($model, 'gotoline')->textInput(['class' => 'inpMain', 'size' => 10])->label(false); ?>
                    </td>
                    <td  width="80" align="right">排序</td>
                    <td>
                        <?= $form->field($model, 'displayorder')->textInput(['class' => 'inpMain', 'size' => 5])->label(false); ?>
                    </td>
                </tr>
            <?php endif; ?>

            <?php if (in_array($model->type, [1, 2])): ?>
                <tr>
                    <td align="right">Title</td>
                    <td>
                        <?= $form->field($model, 'title')->textInput(['class' => 'inpMain', 'size' => 50])->label(false); ?>
                    </td>
                    <td align="right">排序</td>
                    <td>
                        <?= $form->field($model, 'displayorder')->textInput(['class' => 'inpMain', 'size' => 5])->label(false); ?>
                    </td>
                </tr>
                <tr>
                    <td align="right">Keywords</td>
                    <td>
                        <?= $form->field($model, 'keywords')->textArea(['rows' => '4', 'cols' => '60', 'class' => 'textArea'])->label(false); ?>
                    </td>
                    <td align="right">Description</td>
                    <td>
                        <?= $form->field($model, 'description')->textArea(['rows' => '4', 'cols' => '60', 'class' => 'textArea'])->label(false); ?>
                    </td>
                </tr>
            <?php endif; ?>

            <?php if ($model->type == 1): ?>
                <tr>
                    <td align="right">列表Template</td>
                    <td>
                        <?= $form->field($model, 'template')->textInput(['class' => 'inpMain', 'size' => 30])->label(false); ?>
                    </td>
                    <td align="right">单页Page</td>
                    <td>
                        <?= $form->field($model, 'page')->textInput(['class' => 'inpMain', 'size' => 30])->label(false); ?>
                    </td>
                </tr>
            <?php endif; ?>

            <?php if ($model->type == 2): ?>
                <tr>
                    <td align="right">单页Page</td>
                    <td colspan="3">
                        <?= $form->field($model, 'page')->textInput(['class' => 'inpMain', 'size' => 30])->label(false); ?>
                    </td>
                </tr>
                <tr>
                    <td align="right" valign="top">单页内容</td>
                    <td colspan="3">
                        <?= $form->field($model, 'mark')->textarea(['id' => 'content', 'class' => 'textArea', 'style' => 'width:100%;height:400px;'])->label(false); ?>
                    </td>
                </tr>
            <?php endif; ?>

            <tr>
                <td></td>
                <td colspan="3">
                    <?= Html::submitButton('提交', ['class' => 'btn']); ?>
                </td>
            </tr>
        </table>
        <?php ActiveForm::end(); ?>
    </div>
</div>