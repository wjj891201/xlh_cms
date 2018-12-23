<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
?>
<div id="dcMain">
    <!-- 当前位置 -->
    <div id="urHere">管理中心<b>></b><strong>广告位管理</strong></div>
    <div class="mainBox" style="height:auto!important;height:550px;min-height:550px;">
        <h3>添加广告位</h3>
        <?php $form = ActiveForm::begin(); ?>
        <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
            <tr>
                <td width="80" align="right">广告位名称</td>
                <td>
                    <?= $form->field($model, 'adtypename')->textInput(['class' => 'inpMain', 'size' => 40])->label(false); ?>
                </td>
            </tr>
            <tr>
                <td align="right">广告位宽</td>
                <td>
                    <?= $form->field($model, 'width')->textInput(['class' => 'inpMain', 'size' => 5])->label(false); ?>
                </td>
            </tr>
            <tr>
                <td align="right">广告位高</td>
                <td>
                    <?= $form->field($model, 'height')->textInput(['class' => 'inpMain', 'size' => 5])->label(false); ?>       
                </td>
            </tr>
            <tr>
                <td align="right">审核状态</td>
                <td><?= $form->field($model, 'isclass')->radioList(['1' => '启用', '0' => '关闭'])->label(false); ?></td>
            </tr>
            <tr>
                <td align="right">广告位说明</td>
                <td>
                    <?= $form->field($model, 'content')->textarea(['id' => 'content', 'class' => 'textArea', 'style' => 'width:60%;height:200px;'])->label(false); ?>
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