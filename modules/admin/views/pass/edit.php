<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>
<div id="dcMain">
    <!-- 当前位置 -->
    <div id="urHere">管理中心<b>></b><strong>密码修改</strong></div>   
    <?= $this->render('../set/prompt.php'); ?>
    <div id="manager" class="mainBox" style="height:auto!important;height:550px;min-height:550px;">
        <h3>密码修改</h3>
        <?php
        $form = ActiveForm::begin();
        ?>
        <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
            <tr>
                <td width="30%" align="right">密码</td>
                <td>
                    <?= $form->field($model, 'password')->passwordInput(['class' => 'inpMain', 'size' => '40'])->label(false); ?>
                </td>
            </tr>
            <tr>
                <td align="right">确认密码</td>
                <td>
                    <?= $form->field($model, 'repass')->passwordInput(['class' => 'inpMain', 'size' => '40'])->label(false); ?>
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