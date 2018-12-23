<?php

use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>
<div id="dcMain">
    <!-- 当前位置 -->
    <div id="urHere">管理中心<b>></b><strong>节点管理</strong> </div>   
    <div class="mainBox" style="height:auto!important;height:550px;min-height:550px;">
        <h3>{<?= $groupInfo['group_name'] ?>}节点</h3>
        <?php $form = ActiveForm::begin(); ?>
        <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
            <tr>
                <td width="30%" align="right">节点名称</td>
                <td>
                    <?= $form->field($model, 'node_name')->textInput(['class' => 'inpMain', 'size' => 30])->label(false); ?>
                </td>
            </tr>
            <tr>
                <td align="right">节点标识</td>
                <td>
                    <?= $form->field($model, 'node_key')->textInput(['class' => 'inpMain', 'size' => 30])->label(false); ?>
                </td>
            </tr>
            <tr>
                <td align="right">所属机构</td>
                <td>
                    <?= $form->field($model, 'organization_id')->dropDownList($allOrganization, ['style' => 'width:218px;'])->label(false); ?>
                </td>
            </tr>
            <tr>
                <td align="right">选择审核员</td>
                <td>
                    <?= $form->field($model, 'approve_user_id')->dropDownList($approveUser, ['style' => 'width:218px;'])->label(false); ?>
                </td>
            </tr>
            <tr>
                <td align="right">是否删除</td>
                <td><?= $form->field($model, 'is_deleted')->radioList(['0' => '否', '1' => '是'])->label(false); ?></td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <?= $form->field($model, 'workflow_group_id')->textInput()->hiddenInput()->label(false); ?>
                    <?= Html::submitButton('提交', ['class' => 'btn']); ?>
                </td>
            </tr>
        </table>
        <?php ActiveForm::end(); ?>
    </div>
</div>
<script>
    $(function () {
        $("select[name='WorkflowNode[organization_id]']").on('change', function () {
            $.ajax({
                url: "<?= Url::to(['workflow/ajax-get-user']) ?>",
                type: "POST",
                data: {'organization_id': $(this).val(), '_csrf': '<?= Yii::$app->request->csrfToken ?>'},
                dataType: 'json',
                beforeSend: function (XMLHttpRequest) {
                    $('#workflownode-approve_user_id').empty();
                },
                success: function (result) {
                    var html = '<option value="">请选择审核员</option>';
                    $.each(result, function (index, item) {
                        html += '<option value=' + item.id + '>' + item.username + '</option>';
                    });
                    $('#workflownode-approve_user_id').append(html);
                },
                error: function (responseStr) {
                    console.log(responseStr);
                }
            });
        });
    });
</script>
