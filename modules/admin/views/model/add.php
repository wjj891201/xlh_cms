<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>
<div id="dcMain">
    <!-- 当前位置 -->
    <div id="urHere">管理中心<b>></b><strong>添加模型</strong> </div>   
    <div class="mainBox" style="height:auto!important;height:550px;min-height:550px;">
        <h3>添加模型</h3>
        <?php $form = ActiveForm::begin(); ?>
        <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
            <tr>
                <td width="80" align="right">模型名称</td>
                <td>
                    <?= $form->field($model, 'modelname')->textInput(['class' => 'inpMain', 'size' => 40])->label(false); ?>
                </td>
            </tr>
            <tr>
                <td align="right">每页显示数</td>
                <td>
                    <?= $form->field($model, 'pagemax')->textInput(['class' => 'inpMain', 'size' => 40])->label(false); ?>
                </td>
            </tr>
            <tr>
                <td align="right">单页发布模型</td>
                <td>
                    <?= $form->field($model, 'isbase')->radioList(['1' => '启用', '0' => '禁用'])->label(false); ?>
                </td>
            </tr>
            <tr>
                <td align="right">图集功能</td>
                <td>
                    <?= $form->field($model, 'isalbum')->radioList(['1' => '启用', '0' => '禁用'])->label(false); ?>
                </td>
            </tr>
            <tr>
                <td align="right">是否开启</td>
                <td>
                    <?= $form->field($model, 'isclass')->radioList(['1' => '启用', '0' => '禁用'])->label(false); ?>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <?= $form->field($model, 'lockin')->textInput()->hiddenInput()->label(false); ?>
                    <?= Html::submitButton('提交', ['class' => 'btn']); ?>
                </td>
            </tr>
        </table>
        <?php ActiveForm::end(); ?>
    </div>
</div>
