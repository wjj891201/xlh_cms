<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>
<div id="dcMain">
    <!-- 当前位置 -->
    <div id="urHere">管理中心<b>></b><strong>添加机构</strong> </div>
    <div class="mainBox" style="height:auto!important;height:550px;min-height:550px;">
        <?php $form = ActiveForm::begin(); ?>
        <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
            <tr>
                <td width="30%" align="right">上级机构</td>
                <td colspan="2">
                    <?= $form->field($model, 'pid')->dropDownList($list, ['style' => 'width:218px;'])->label(false); ?>
                </td>
            </tr>
            <tr class="branch" <?php if ($model->pid != 5): ?>style="display: none;"<?php endif; ?>>
                <td width="30%" align="right">分行</td>
                <td colspan="2">
                    <?= $form->field($model, 'relation_bank_id')->dropDownList($branch, ['style' => 'width:218px;'])->label(false); ?>
                </td>
            </tr>
            <tr>
                <td align="right">机构名称</td>
                <td colspan="2">
                    <?= $form->field($model, 'name')->textInput(['class' => 'inpMain', 'size' => '30'])->label(false); ?>
                </td>
            </tr>
            <tr>
                <td align="right">是否有效</td>
                <td colspan="2">
                    <?= $form->field($model, 'status')->radioList(['1' => '有效', '0' => '无效'])->label(false); ?>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <?= Html::submitButton('提交', ['class' => 'btn']); ?>
                </td>
            </tr>
        </table>
        <?php ActiveForm::end(); ?>
    </div>
</div>
<script>
    $("select[name='Organization[pid]']").on('change', function () {
        var pid = $(this).val();
        if (pid == 5) {
            $('.branch').show();
        } else {
            $('.branch').hide();
        }
    });
</script>