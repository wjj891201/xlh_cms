<?php

use yii\web\View;
use yii\helpers\Url;

$this->registerJsFile('@web/public/backend/js/layer/layer.js', ['depends' => ['app\assets\AdminAsset'], 'position' => View::POS_HEAD]);
?>
<div id="dcMain">
    <!-- 当前位置 -->
    <div id="urHere">管理中心<b>></b><strong>内容模型管理</strong> </div>  
    <div class="mainBox" style="height:auto!important;height:550px;min-height:550px;">
        <?= $this->render('../set/prompt.php'); ?>
        <h3><a href="<?= Url::to(['model/add']) ?>" class="actionBtn add">添加内容模型</a>内容模型列表</h3>
        <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
            <tr>
                <th width="120" align="center">ID</th>
                <th align="center">模型名称</th>
                <th width="100">状态</th>
                <th width="180" align="center">操作</th>
            </tr>
            <?php foreach ($all as $key => $vo): ?>
                <tr>
                    <td align="center"><?= $vo->id ?></td>
                    <td align="center"><?= $vo->modelname ?></td>
                    <td class="infotype" align="center">
                        <?php if ($vo['lockin'] == 1): ?>
                            <span class="system_ok" title="系统模型"></span>
                        <?php else: ?>
                            <span class="system_no" title="自定义模型"></span>
                        <?php endif; ?>
                        <?php if ($vo['isclass'] == 1): ?>
                            <span class="audit_ok" title="启用"></span>
                        <?php else: ?>
                            <span class="audit_no" title="关闭"></span>
                        <?php endif; ?>
                    </td>
                    <td align="center">
                        <a class="setedit2" href="<?= Url::to(['model/attrlist', 'mid' => $vo->id]) ?>">字段管理</a>
                        <a class="setedit" href="<?= Url::to(['model/edit', 'mid' => $vo->id]) ?>">编辑</a>
                        <?php if ($vo['lockin'] != 1): ?>
                            <a class="setedit" href="javascript:;" onclick="del(this,<?= $vo->id ?>)">删除</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>
<script>
    function del(obj, id) {
        layer.confirm('此操作将会导致数据删除，请确认该操作！', function (index) {
            $.ajax({
                type: "GET",
                url: "<?= URL::to(['model/del']); ?>",
                data: {mid: id},
                dataType: "json",
                success: function (result) {
                    if (result == 404) {
                        layer.msg('sorry，您没有权限！', {icon: 2, time: 1000});
                    }
                    if (result == true) {
                        $(obj).parents("tr").remove();
                        layer.msg('已成功删除!', {icon: 1, time: 1000});
                    }
                }
            });

        });
    }
</script>