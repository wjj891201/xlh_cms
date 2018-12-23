<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>
<div id="dcMain">
    <!-- 当前位置 -->
    <div id="urHere">管理中心<b>></b><strong>添加审批员</strong> </div>
    <div class="mainBox" style="height:auto!important;height:550px;min-height:550px;">
        <?php
        $form = ActiveForm::begin(['id' => 'form-signup']);
        ?>
        <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
            <tr>
                <td width="30%" align="right">账号</td>
                <td colspan="2">
                    <?= $form->field($model, 'username')->textInput(['class' => 'inpMain', 'size' => '30'])->label(false); ?>
                </td>
            </tr>
            <tr>
                <td width="80" align="right">所属机构</td>
                <td colspan="2">
                    <?= $form->field($model, 'belong')->dropDownList($allOrganization, ['style' => 'width:218px;'])->label(false); ?>
                </td>
            </tr>
            <tr>
                <td align="right">邮箱</td>
                <td>
                    <?= $form->field($model, 'email')->textInput(['class' => 'inpMain', 'size' => '30'])->label(false); ?>
                </td>
            </tr>
            <tr>
                <td align="right">电话</td>
                <td>
                    <?= $form->field($model, 'telphone')->textInput(['class' => 'inpMain', 'size' => '30'])->label(false); ?>
                </td>
            </tr>
            <tr>
                <td align="right">密码</td>
                <td>
                    <?= $form->field($model, 'password')->passwordInput(['class' => 'inpMain', 'size' => '30'])->label(false); ?>
                </td>
            </tr>
            <tr>
                <td align="right">确认密码</td>
                <td>
                    <?= $form->field($model, 're_password')->passwordInput(['class' => 'inpMain', 'size' => '30'])->label(false); ?>
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