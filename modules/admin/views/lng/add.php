<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

?>
<div id="dcMain">
    <!-- 当前位置 -->
    <div id="urHere">管理中心<b>></b><strong>多语言管理</strong> </div>   
    <div class="mainBox" style="height:auto!important;height:550px;min-height:550px;">
        <h3>添加多语言</h3>
        <?php $form = ActiveForm::begin(); ?>
        <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
            <tr>
                <td width="30%" align="right">语言标识符</td>
                <td>
                    <?= $form->field($model, 'lng')->textInput(['class' => 'inpMain', 'size' => 40])->label(false); ?>
                </td>
            </tr>
            <tr>
                <td align="right">语言名称</td>
                <td>
                    <?= $form->field($model, 'lngtitle')->textInput(['class' => 'inpMain', 'size' => 40])->label(false); ?>
                </td>
            </tr>
            <tr>
                <td align="right">审核状态</td>
                <td><?= $form->field($model, 'isopen')->radioList(['1' => '启用', '0' => '关闭'])->label(false); ?></td>
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
