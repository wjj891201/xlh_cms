<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url; //使用Url类
?>
<link rel="stylesheet" href="/assets/backend/js/kindeditor/themes/default/default.css" />
<script charset="utf-8" src="/assets/backend/js/kindeditor/kindeditor.js"></script>
<script charset="utf-8" src="/assets/backend/js/kindeditor/lang/zh_CN.js"></script>
<script>
    KindEditor.ready(function(K) {        
        var editor = K.editor({
            allowFileManager : true  //开启多文件上传
        });
        $("#upload-image-filename").click(function() {
            editor.loadPlugin("image", function() {
                editor.plugin.imageDialog({
                    showRemote : false,
                    clickFn : function(url) {
                        $("#filename").val(url);
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
    <div id="urHere">管理中心<b>></b><strong>添加广告</strong> </div>   
    <div class="mainBox" style="height:auto!important;height:550px;min-height:550px;">
        <?php
        $form = ActiveForm::begin();
        ?>
        <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
            <tr>
                <td align="right">所属广告位</td>
                <td>
                    <?php echo $form->field($model, 'atid')->dropDownList($position)->label(false); ?>
                </td>
                <td width="80" align="right">广告名称</td>
                <td width="400">
                    <?php echo $form->field($model, 'title')->textInput(['class' => 'inpMain', 'size' => 40])->label(false); ?>
                </td>
            </tr>
            <tr>
                <td align="right">广告跳转地址</td>
                <td>
                    <?php echo $form->field($model, 'url')->textInput(['class' => 'inpMain', 'size' => 40])->label(false); ?>
                </td>
                <td align="right">广告类型</td>
                <td>
                    <?php echo $form->field($model, 'adtype')->dropDownList(['1' => '图片广告', '2' => '文字广告'], ['onchange' => "javascript:selectinfo(this.value)"])->label(false); ?>
                </td>
            </tr>
            <tr id="filenamestr" class="<?php if ($model->adtype == 1): ?>displaytrue<?php else: ?>displaynone<?php endif; ?>">
                <td align="right">缩略图</td>
                <td>
                    <div class="fileupload-preview filenamenail">
                        <?php if (!empty($model->filename)): ?>
                            <img src="<?= $model->filename ?>" width="200" height="150"/>
                        <?php else: ?>
                            <img src="/assets/backend/images/upload.png"/>
                        <?php endif; ?>
                    </div>
                </td>
                <td colspan="2">
                    <button id="upload-image-filename" type="button" class="btn">选择图片</button>
                    <?php echo $form->field($model, 'filename')->hiddenInput(['id' => 'filename'])->label(false); ?>
                </td>
            </tr>
            <tr>
                <td align="right">简单描述</td>
                <td>
                    <?= $form->field($model, 'content')->textarea(['class' => 'textArea', 'cols' => '60', 'rows' => '5'])->label(false); ?>
                </td>
                <td align="right">排序</td>
                <td>
                    <?php echo $form->field($model, 'sort')->textInput(['class' => 'inpMain', 'size' => 5])->label(false); ?>
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


<script>
    function selectinfo(val){
        if (val==1){
            $('#filenamestr').removeClass('displaynone').addClass('displaytrue');
        }else if(val==2){
            $('#filenamestr').removeClass('displaytrue').addClass('displaynone');
        }
    }
</script>