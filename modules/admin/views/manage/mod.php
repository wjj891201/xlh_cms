<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url; //使用Url类
?>
<div id="dcMain">
    <!-- 当前位置 -->
    <div id="urHere">管理中心<b>></b><strong>修改密码</strong> </div>   
    <div id="manager" class="mainBox" style="height:auto!important;height:550px;min-height:550px;">
        <?php
        $form = ActiveForm::begin();
        ?>
        <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
            <tr>
                <td width="100" align="right">管理员名称</td>
                <td>
                    <?= $model->name ?>
                    <?= $form->field($model, 'id')->hiddenInput()->label(false); ?>
                </td>
            </tr>
            <tr>
                <td width="100" align="right">E-mail</td>
                <td>
                    <?= $model->email ?>
                </td>
            </tr>
            <tr>
                <td align="right">密码</td>
                <td>
                    <?php echo $form->field($model, 'password')->passwordInput(['class' => 'inpMain', 'size' => '40'])->label(false); ?>
                </td>
            </tr>
            <tr>
                <td align="right">确认密码</td>
                <td>
                    <?php echo $form->field($model, 'repass')->passwordInput(['class' => 'inpMain', 'size' => '40'])->label(false); ?>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <?php echo Html::submitButton('提交', ['class' => 'btn']); ?>
                </td>
            </tr>
        </table>
        <?php ActiveForm::end(); ?>
    </div>
</div>