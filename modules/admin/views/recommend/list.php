<?php

use yii\web\View;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url; //使用Url类

$this->registerJsFile('@web/public/backend/js/layer/layer.js', ['depends' => ['app\assets\AdminAsset'], 'position' => View::POS_HEAD]);
?>

<div id="dcMain">
    <!-- 当前位置 -->
    <div id="urHere">管理中心<b>></b><strong>推荐位管理</strong> </div>  
    <div class="mainBox imgModule">
        <?= $this->render('../set/prompt.php'); ?>
        <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
            <tr>
                <th>添加推荐位</th>
                <th>推荐位列表</th>
            </tr>
            <tr>
                <td width="400" valign="top">
                    <?php $form = ActiveForm::begin(); ?>
                    <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableOnebor">
                        <tr>
                            <td width="30%" align="right">所属模型：</td>
                            <td>
                                <?= $form->field($model, 'mid')->dropDownList($allmodle, ['style' => 'width:150px;'])->label(false); ?>
                            </td>
                        </tr>
                        <tr>
                            <td align="right">推荐属性名称：</td>
                            <td>
                                <?= $form->field($model, 'labelname')->textInput(['class' => 'inpMain', 'size' => 20])->label(false); ?>
                            </td>
                        </tr>
                        <tr>
                            <td align="right" colspan="2">
                                <?= Html::submitButton('提交', ['class' => 'btn']); ?>
                            </td>
                        </tr>
                    </table>
                    <?php ActiveForm::end(); ?>
                </td>
                <td valign="top">
                    <form action="<?= Url::to(['recommend/del']) ?>" id="thisform" method="post">
                        <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableOnebor">
                            <tr>
                                <td width="30" align="center">
                                    <input type='checkbox' id='chkall' onclick='selectcheckbox(this.form)' value='check'/>
                                </td>
                                <td align="center">ID</td>
                                <td align="center">推荐属性名称</td>
                                <td align="center">语言</td>
                                <td align="center">模型</td>
                                <td width="80" align="center">操作</td>
                            </tr>
                            <?php foreach ($all as $key => $vo): ?>
                                <tr class="c_o">
                                    <td align="center">
                                        <input type="checkbox" name="dlid[]" value="<?= $vo['dlid'] ?>" />
                                    </td>
                                    <td align="center"><?= $vo['dlid'] ?></td>
                                    <td align="center"><?= $vo['labelname'] ?></td>
                                    <td align="center"><?= $vo['lng'] ?></td>
                                    <td align="center"><?= $vo['mname']['modelname'] ?></td>
                                    <td align="center">
                                        <a class="setedit" href="<?= Url::to(['recommend/edit', 'dlid' => $vo['dlid']]) ?>">修改</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                        <div class="action">
                            <input class="btn" onclick="check();" value="删除" type="button">
                        </div>
                    </form>
                </td>
            </tr>
        </table>
    </div>
</div>
<script>
    function check()
    {
        var num = $("input:checkbox:checked").length;
        if (num > 0) {
            layer.confirm('确认删除吗？', function () {
                $('#thisform').submit();
            });
        } else {
            layer.msg('请选择至少一条数据', {icon: 2, time: 1000});
            return false;
        }
    }
</script>