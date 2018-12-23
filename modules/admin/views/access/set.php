<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>
<div id="dcMain">
    <!-- 当前位置 -->
    <div id="urHere">管理中心<b>></b><strong>添加权限</strong> </div>
    <div class="mainBox" style="height:auto!important;height:550px;min-height:550px;">
        <?php
        $form = ActiveForm::begin();
        ?>
        <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
            <tr>
                <td width="80" align="right">上级权限</td>
                <td colspan="2">
                    <?= $form->field($model, 'pid')->dropDownList($list)->label(false); ?>
                </td>
            </tr>
            <tr>
                <td align="right">排序</td>
                <td>
                    <?= $form->field($model, 'sort')->textInput(['class' => 'inpMain', 'size' => '10'])->label(false); ?>
                </td>
            </tr>
            <tr>
                <td align="right">权限标题</td>
                <td>
                    <?= $form->field($model, 'title')->textInput(['maxlength' => true, 'class' => 'inpMain', 'size' => 83])->label(false); ?>
                </td>
            </tr>
            <tr>
                <td align="right">Urls</td>
                <td>
                    <?= $form->field($model, 'urls')->textarea(['rows' => 8, 'cols' => 82, 'class' => 'textArea'])->label(false); ?>
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