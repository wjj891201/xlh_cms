<?php

use yii\web\View;
use yii\helpers\Url;

$this->registerJsFile('@web/public/backend/js/layer/layer.js', ['depends' => ['app\assets\AdminAsset'], 'position' => View::POS_HEAD]);
?>
<div id="dcMain">
    <!-- 当前位置 -->
    <div id="urHere">管理中心<b>></b><strong>节点列表</strong> </div>
    <div id="manager" class="mainBox" style="height:auto!important;height:550px;min-height:550px;">
        <?= $this->render('../set/prompt.php'); ?>
        <h3><a href="<?= Url::to(['workflow/node-add', 'group_id' => $groupInfo['id']]) ?>" class="actionBtn">添加节点</a>{<?= $groupInfo['group_name'] ?>}节点列表</h3>
        <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
            <tr>
                <th width="10%" align="center">编号</th>
                <th align="left">节点名</th>
                <th align="center">节点标识</th>
                <th align="center">所属机构</th>
                <th align="center">审核员</th>
                <th width="30%" align="center">操作</th>
            </tr>
            <?php foreach ($list as $key => $vo): ?>
                <tr>
                    <td align="center"><?= $key + 1 ?></td>
                    <td><?= $vo['node_name'] ?></td>
                    <td align="center"><?= $vo['node_key'] ?></td>
                    <td align="center"><?= $vo['organization']['name'] ?></td>
                    <td align="center"><?= $vo['approveUser']['username'] ?></td>
                    <td align="center">
                        <a class="setedit3" href="<?= Url::to(['workflow/action-list', 'node_id' => $vo['id']]) ?>">动作管理</a>
                        <a class="setedit" href="<?= Url::to(['workflow/node-edit', 'node_id' => $vo['id']]) ?>">编辑</a>
                        <a class="setedit delete" data_id="<?= $vo['id'] ?>" href="javascript:void(0);">删除</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>
<script>
    //删除
    $('.delete').click(function () {
        var data_id = this.getAttribute('data_id');
        layer.confirm('确认删除', {icon: 3, fix: true}, function (index) {
            location.href = '/admin/workflow/node-del?node_id=' + data_id;
        });
    });
</script>