<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
?>
<div id="dcMain">
    <!-- 当前位置 -->
    <div id="urHere">管理中心<b>></b><strong>添加模型字段</strong> </div>   
    <div class="mainBox" style="height:auto!important;height:550px;min-height:550px;">
        <h3><a href="" class="actionBtn">文章列表</a>编辑{<?= $info->modelname ?>}模型字段</h3>
        <?php $form = ActiveForm::begin(); ?>
        <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
            <tr>
                <td width="90" align="right">字段名称</td>
                <td>
                    <?= $model->attrname ?>
                </td>
            </tr>
            <tr>
                <td align="right">字段类型</td>
                <td>
                    <?= $form->field($model, 'inputtype')->dropDownList($typelist, ['disabled' => ''])->label(false); ?>
                </td>
            </tr>
            <tr>
                <td align="right">简述文字</td>
                <td>
                    <?= $form->field($model, 'typename')->textInput(['class' => 'inpMain', 'size' => 80])->label(false); ?>
                </td>
            </tr>
            <tr>
                <td align="right">提示文字</td>
                <td>
                    <?= $form->field($model, 'typeremark')->textInput(['class' => 'inpMain', 'size' => 50])->label(false); ?>
                </td>
            </tr>
            <tr>
                <td align="right">默认值</td>
                <td>
                    <?= $form->field($model, 'attrvalue')->textarea(['class' => 'textArea', 'cols' => '83', 'rows' => '4'])->label(false); ?>
                </td>
            </tr>
            <tr>
                <td align="right">字段验证</td>
                <td>
                    <?= $form->field($model, 'isvalidate')->radioList(['1' => '启用', '0' => '关闭'])->label(false); ?>
                </td>
            </tr>
            <tr id="isshow" <?php if ($model->isvalidate != 1): ?>style="display: none;"<?php endif; ?>>
                <td align="right">验证正则</td>
                <td>
                    <?= $form->field($model, 'validatetext')->textInput(['class' => 'inpMain', 'id' => 'validatetext', 'readonly' => 'readonly', 'size' => 30])->label(false); ?>
                    <select name="validatetext_select" onchange="javascript:$('#validatetext').val(this.value)">
                        <option value="">选择预定正则</option>
                        <option value="/^[0-9.-]+$/">数字</option>
                        <option value="/^[0-9-]+$/">整数</option>
                        <option value="/^[a-z]+$/i">字母</option>
                        <option value="/^[0-9a-z]+$/i">数字+字母</option>
                        <option value="/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/">E-mail</option>
                        <option value="/^[0-9]{5,20}$/">QQ</option>
                        <option value="/^http:\/\//">超级链接</option>
                        <option value="/^(1)[0-9]{10}$/">手机号码</option>
                        <option value="/^[0-9-]{6,13}$/">电话号码</option>
                        <option value="/^[0-9]{6}$/">邮政编码</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td align="right">输入框长度</td>
                <td>
                    <?= $form->field($model, 'attrsize')->textInput(['class' => 'inpMain', 'size' => 10])->label(false); ?>
                </td>
            </tr>
            <tr>
                <td align="right">本文框高度</td>
                <td>
                    <?= $form->field($model, 'attrrow')->textInput(['class' => 'inpMain', 'size' => 10])->label(false); ?>
                </td>
            </tr>
            <tr>
                <td align="right">显示状态</td>
                <td>
                    <?= $form->field($model, 'isclass')->radioList(['1' => '启用', '0' => '关闭'])->label(false); ?>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <?= $form->field($model, 'id')->textInput()->hiddenInput()->label(false); ?>
                    <?= $form->field($model, 'lockin')->textInput()->hiddenInput()->label(false); ?>
                    <?= $form->field($model, 'mid')->textInput()->hiddenInput()->label(false); ?>
                    <?= $form->field($model, 'smid')->textInput()->hiddenInput()->label(false); ?>
                    <?= $form->field($model, 'inputtype')->textInput()->hiddenInput()->label(false); ?>
                    <?= $form->field($model, 'attrname')->textInput()->hiddenInput()->label(false); ?>
                    <?= Html::submitButton('提交', ['class' => 'btn']); ?>
                </td>
            </tr>
        </table>
        <?php ActiveForm::end(); ?>
    </div>
</div>
<script>
    $(function(){  
        $("input[name='ModelAtt[isvalidate]']").on('change', function() {
            if($(this).val()==1){
                $('#isshow').show(500);
            }else{
                $('#isshow').hide(500);
            }
        });
    });
</script>