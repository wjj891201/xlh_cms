<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url; //使用Url类
?>
<script type="text/javascript" src="/layer/layer.js"></script>
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
                <td width="350" valign="top">
                    <?php
                    $form = ActiveForm::begin();
                    ?>
                    <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableOnebor">
                        <tr>
                            <td>
                                <b>推荐属性名称</b>
                                <?php echo $form->field($model, 'labelname')->textInput(['class' => 'inpMain', 'size' => 20])->label(false); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo Html::submitButton('提交', ['class' => 'btn']); ?>
                            </td>
                        </tr>
                    </table>
                    <?php ActiveForm::end(); ?>
                </td>
                <td valign="top">
                    <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableOnebor">
                        <tr>
                            <td>推荐属性名称</td>
                            <td width="80" align="center">操作</td>
                        </tr>
                        <?php foreach ($all_label as $key => $vo): ?>
                            <tr class="c_o">
                                <td><?= $vo['labelname'] ?></td>
                                <td align="center">
                                    <a href="javascript:;" onclick="column_del(this,<?php echo $vo['id'] ?>)">删除</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </td>
            </tr>
        </table>
    </div>
</div>
<script type="text/javascript">
    function column_del(obj, id) {
        layer.confirm('确认要删除该推荐位吗？', function (index) {
            $.ajax({
                type: "GET",
                url: "<?php echo URL::to(['column/del']); ?>",
                data: "id=" + id,
                dataType: "json",
                success: function (data) {
                    if (data == 404) {
                        layer.msg('sorry，您没有权限！', {icon: 2, time: 1000});
                    }
                    if (data == 1) {
                        $(obj).parents(".c_o").remove();
                        layer.msg('已成功删除!', {icon: 1, time: 1000});
                    }
                }
            });
        });
    }
</script>