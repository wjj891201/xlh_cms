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
    <div id="urHere">管理中心<b>></b><strong>添加分类</strong></div>
    <div class="mainBox" style="height:auto!important;height:550px;min-height:550px;">
        <?php
        $form = ActiveForm::begin();
        ?>
        <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
            <tr>
                <td align="right">上级分类</td>
                <td colspan="3">
                    <?php echo $form->field($model, 'parent_id')->dropDownList($list)->label(false); ?>
                </td>
            </tr>
            <tr>
                <td width="80" align="right">分类名称</td>
                <td>
                    <?php echo $form->field($model, 'region_name')->textInput(['class' => 'inpMain', 'size' => 40])->label(false); ?>
                </td>
                <td width="80" align="right">别名</td>
                <td>
                    <?php echo $form->field($model, 'alias')->textInput(['class' => 'inpMain', 'size' => 40])->label(false); ?>
                </td>
            </tr>
            <tr>
                <td align="right">地区图片</td>
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
                    <?php echo $form->field($model, 'thumb')->hiddenInput(['id' => 'thumb'])->label(false); ?>
                </td>
            </tr>
            <tr>
                <td align="right">描述</td>
                <td>
                    <?= $form->field($model, 'description')->textArea(['rows' => '4', 'cols' => '60', 'class' => 'textArea'])->label(false); ?>
                </td>
                <td align="right">排序</td>
                <td>
                    <?php echo $form->field($model, 'sort_order')->textInput(['class' => 'inpMain', 'size' => 5])->label(false); ?>
                </td>
            </tr>
            <tr>
                <td align="right">热门</td>
                <td>
                    <?php echo $form->field($model, 'hot')->radioList(['0' => '否', '1' => '是'])->label(false); ?>
                </td>
                <td align="right">是否禁用</td>
                <td>
                    <?php echo $form->field($model, 'closed')->radioList(['0' => '否', '1' => '是'])->label(false); ?>
                </td>
            </tr>
            <tr>
                <td></td>
                <td colspan="3">
                    <?php echo Html::submitButton('提交', ['class' => 'btn']); ?>
                </td>
            </tr>
        </table>
        <?php ActiveForm::end(); ?>
    </div>
</div>