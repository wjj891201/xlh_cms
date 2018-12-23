<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>
<div id="dcMain">
    <!-- 当前位置 -->
    <div id="urHere">管理中心<b>></b><strong>动作管理</strong> </div>   
    <div class="mainBox" style="height:auto!important;height:550px;min-height:550px;">
        <h3>{<?= $nodeInfo['node_name'] ?>}动作</h3>
        <?php $form = ActiveForm::begin(); ?>
        <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
            <tr>
                <td width="30%" align="right">动作名称</td>
                <td>
                    <?= $form->field($model, 'action_name')->textInput(['class' => 'inpMain', 'size' => 40])->label(false); ?>
                </td>
            </tr>
            <tr>
                <td align="right">动作标识</td>
                <td>
                    <?= $form->field($model, 'action_key')->dropDownList($action_key_list, ['style' => 'width:150px;'])->label(false); ?>
                </td>
            </tr>
            <tr>
                <td align="right">是否删除</td>
                <td><?= $form->field($model, 'is_deleted')->radioList(['0' => '否', '1' => '是'])->label(false); ?></td>
            </tr>
            <tr>
                <td align="right">下一个节点</td>
                <td>
                    <?= $form->field($model, 'next_node_id')->dropDownList($allNode, ['style' => 'width:150px;'])->label(false); ?>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <?= $form->field($model, 'workflow_node_id')->textInput()->hiddenInput()->label(false); ?>
                    <?= Html::submitButton('提交', ['class' => 'btn']); ?>
                </td>
            </tr>
        </table>
        <?php ActiveForm::end(); ?>
    </div>
</div>
