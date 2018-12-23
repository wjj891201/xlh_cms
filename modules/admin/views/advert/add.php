<?php

use yii\web\View;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url; //使用Url类

$this->registerCssFile('@web/public/backend/js/kindeditor/themes/default/default.css', ['depends' => ['app\assets\AdminAsset']]);
$this->registerJsFile('@web/public/backend/js/kindeditor/kindeditor.js', ['depends' => ['app\assets\AdminAsset'], 'position' => View::POS_HEAD]);
$this->registerJsFile('@web/public/backend/js/kindeditor/lang/zh_CN.js', ['depends' => ['app\assets\AdminAsset'], 'position' => View::POS_HEAD]);
?>

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
                <td width="20%" align="right">所属广告位</td>
                <td colspan="2">
                    <?= $form->field($model, 'atid')->dropDownList($list)->label(false); ?>
                </td>
            </tr>
            <tr>
                <td align="right">广告名称</td>
                <td colspan="2">
                    <?= $form->field($model, 'title')->textInput(['class' => 'inpMain', 'size' => 40])->label(false); ?>
                </td>
            </tr>
            <tr>
                <td align="right">跳转目标</td>
                <td colspan="2">
                    <?= $form->field($model, 'islink')->radioList(['2' => '关联内容', '1' => '外网'])->label(false); ?>
                </td>
            </tr>
            <tr class="t_url" <?php if ($model->islink != 1): ?>style='display:none;'<?php endif; ?>>
                <td align="right">广告跳转地址</td>
                <td colspan="2">
                    <?= $form->field($model, 'url')->textInput(['class' => 'inpMain', 'size' => 40])->label(false); ?>
                </td>
            </tr>
            <tr class="t_tar" <?php if ($model->islink != 2): ?>style='display:none;'<?php endif; ?>>
                <td align="right">跳转关联分类ID</td>
                <td colspan="3">
                    <?= $form->field($model, 'gotoid')->textInput(['class' => 'inpMain', 'size' => 5])->label(false); ?>
                </td>
            </tr>
            <tr>
                <td align="right">广告类型</td>
                <td colspan="2">
                    <?= $form->field($model, 'adtype')->dropDownList(['1' => '图片广告', '2' => '文字广告'], ['onchange' => "javascript:selectinfo(this.value)"])->label(false); ?>
                </td>
            </tr>
            <tr id="filenamestr" class="<?php if ($model->adtype == 1): ?>displaytrue<?php else: ?>displaynone<?php endif; ?>">
                <td width="20%" align="right">缩略图</td>
                <td width="45%" align="center">
                    <div class="fileupload-preview filenamenail">
                        <?php if (!empty($model->filename)): ?>
                            <img src="<?= $model->filename ?>" width="200" height="150"/>
                        <?php else: ?>
                            <img src="/public/backend/images/upload.png"/>
                        <?php endif; ?>
                    </div>
                </td>
                <td width="35%">
                    <button id="upload-image-filename" type="button" class="btn">选择图片</button>
                    <?= $form->field($model, 'filename')->hiddenInput(['id' => 'filename'])->label(false); ?>
                </td>
            </tr>
            <tr>
                <td align="right">简单描述</td>
                <td colspan="2">
                    <?= $form->field($model, 'content')->textarea(['class' => 'textArea', 'cols' => '100', 'rows' => '5'])->label(false); ?>
                </td>
            </tr>
            <tr>
                <td align="right">审核状态</td>
                <td colspan="2">
                    <?= $form->field($model, 'isclass')->radioList(['1' => '启用', '0' => '关闭'])->label(false); ?>
                </td>
            </tr>
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


<script>
    
    $(function(){  
        $("input[name='Advert[islink]']").on('change', function() {
            if($(this).val()==1){
                $('.t_url').show();
                $('.t_tar').hide();
            }else{
                $('.t_tar').show();
                $('.t_url').hide();
            }
        });
    });
    
    function selectinfo(val){
        if (val==1){
            $('#filenamestr').removeClass('displaynone').addClass('displaytrue');
        }else if(val==2){
            $('#filenamestr').removeClass('displaytrue').addClass('displaynone');
        }
    }
</script>