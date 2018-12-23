<?php

use yii\web\View;
use yii\helpers\Url;

$this->registerJsFile('@web/public/backend/js/layer/layer.js', ['depends' => ['app\assets\AdminAsset'], 'position' => View::POS_HEAD]);
?>
<div id="dcMain">
    <!-- 当前位置 -->
    <div id="urHere">管理中心<b>></b><strong>自助表单管理</strong></div>   
    <div class="mainBox" style="height:auto!important;height:550px;min-height:550px;">
        <?= $this->render('../set/prompt.php'); ?>
        <h3><a href="<?= Url::to(['formgroup/add']) ?>" class="actionBtn add">添加自助表单</a>表单列表</h3>
        <form action="" method="post">
            <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
                <tr>
                    <th width="10%" align="center">ID</th>
                    <th width="15%" align="center">语言</th>
                    <th align="center">表单名称</th>
                    <th width="10%" align="center">状态</th>
                    <th width="35%" align="center">操作</th>
                </tr>
                <?php foreach ($list as $key => $vo): ?>
                    <tr>
                        <td align="center"><?= $vo['fgid'] ?></td>
                        <td align="center"><?= $vo['lng'] ?></td>
                        <td align="center"><?= $vo['formgroupname'] ?></td>
                        <td align="center" class="infotype">
                            <?php if ($vo['isclass'] == 1): ?>
                                <span class="audit_ok" title="启用"></span>
                            <?php else: ?>
                                <span class="audit_no" title="禁用"></span>
                            <?php endif; ?>
                        </td>
                        <td align="center">
                            <a class="setedit2" href="<?= Url::to(['formgroup/attrlist', 'fgid' => $vo['fgid']]) ?>">字段管理</a>
                            <a class="setedit3" href="<?= Url::to(['formgroup/message', 'fgid' => $vo['fgid']]) ?>">表单留言查看</a>
                            <a class="setedit" href="<?= Url::to(['formgroup/edit', 'fgid' => $vo['fgid']]) ?>">修改</a>
                            <a class="setedit" href="javascript:;" onclick="del(this,<?= $vo['fgid'] ?>)">删除</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </form>
    </div>
</div>
<script>
    function del(obj, id) {
        layer.confirm('此操作将会导致数据删除，请确认该操作！', function (index) {
            $.ajax({
                type: "GET",
                url: "<?= URL::to(['formgroup/del']); ?>",
                data: {fgid: id},
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
