<?php

use yii\web\View;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
?>
<div id="dcMain">
    <!-- 当前位置 -->
    <div id="urHere">管理中心<b>></b><strong>自助表单管理</strong> </div> 
    <?= $this->render('../set/prompt.php'); ?>
    <div class="mainBox" style="height:auto!important;height:550px;min-height:550px;">
        <h3>添加表单</h3>
        <?php $form = ActiveForm::begin(); ?>
        <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
            <tr>
                <td width="25%" align="right">表单名称</td>
                <td>
                    <?= $form->field($model, 'formgroupname')->textInput(['class' => 'inpMain', 'size' => 40])->label(false); ?>
                </td>
            </tr>
            <tr>
                <td align="right">表单模板</td>
                <td>
                    <?= $form->field($model, 'template')->textInput(['class' => 'inpMain', 'size' => 40])->label(false); ?>
                </td>
            </tr>
            <tr>
                <td align="right">表单说明显示文字</td>
                <td>
                    <?= $form->field($model, 'content')->textarea(['class' => 'textArea', 'cols' => '60', 'rows' => 4])->label(false); ?>
                </td>
            </tr>
            <tr>
                <td align="right">提交成功显示文字</td>
                <td>
                    <?= $form->field($model, 'successtext')->textarea(['class' => 'textArea', 'cols' => '60', 'rows' => 4])->label(false); ?>
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
