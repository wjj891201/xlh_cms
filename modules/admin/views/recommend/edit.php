<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
?>
<div id="dcMain">
    <!-- 当前位置 -->
    <div id="urHere">管理中心<b>></b><strong>推荐位管理</strong> </div>
    <div class="mainBox" style="height:auto!important;height:550px;min-height:550px;">
        <h3>推荐位编辑</h3>
        <?php $form = ActiveForm::begin(); ?>
        <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
            <tr>
                <td width="40%" align="right">所属模型</td>
                <td>
                    <?= $form->field($model, 'mid')->dropDownList($allmodle, ['style' => 'width:150px;', 'disabled' => 'true'])->label(false); ?>
                </td>
            </tr>
            <tr>
                <td align="right">推荐属性名称</td>
                <td>
                    <?= $form->field($model, 'labelname')->textInput(['class' => 'inpMain', 'size' => 20])->label(false); ?>
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