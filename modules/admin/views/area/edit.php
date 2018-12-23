<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>
<div id="dcMain">
    <!-- 当前位置 -->
    <div id="urHere">管理中心<b>></b><strong>地区管理</strong> </div>   
    <div class="mainBox" style="height:auto!important;height:550px;min-height:550px;">
        <h3>添加地区</h3>
        <?php $form = ActiveForm::begin(); ?>
        <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
            <tr>
                <td width="30%" align="right">地区名</td>
                <td>
                    <?= $form->field($model, 'name')->textInput(['class' => 'inpMain', 'size' => 40])->label(false); ?>
                </td>
            </tr>
            <tr>
                <td align="right">排序</td>
                <td>
                    <?= $form->field($model, 'sort')->textInput(['class' => 'inpMain', 'size' => 40])->label(false); ?>
                </td>
            </tr>
            <tr>
                <td align="right">状态</td>
                <td><?= $form->field($model, 'status')->radioList(['1' => '可用', '2' => '不可用'])->label(false); ?></td>
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
