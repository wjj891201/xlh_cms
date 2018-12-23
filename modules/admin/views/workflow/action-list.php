<?php

use yii\web\View;
use yii\helpers\Url;

$this->registerJsFile('@web/public/backend/js/layer/layer.js', ['depends' => ['app\assets\AdminAsset'], 'position' => View::POS_HEAD]);
?>
<div id="dcMain">
    <div id="urHere">管理中心<b>></b><strong>动作列表</strong> </div>   
    <div id="manager" class="mainBox" style="height:auto!important;height:550px;min-height:550px;">
        <?= $this->render('../set/prompt.php'); ?>
        <h3><a href="<?= Url::to(['workflow/action-add', 'node_id' => $nodeInfo['id']]); ?>" class="actionBtn">添加动作</a>{<?= $nodeInfo['node_name'] ?>}动作列表</h3>
        <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
            <tr>
                <th width="10%" align="center">编号</th>
                <th align="left">动作名称</th>
                <th align="center">动作标识</th>
                <th align="center">是否删除</th>
                <th align="center">下一个节点</th>
                <th width="20%" align="center">操作</th>
            </tr>
            <?php foreach ($list as $key => $vo): ?>
                <tr>
                    <td align="center"><?= $key + 1 ?></td>
                    <td><?= $vo['action_name'] ?></td>
                    <td align="center"><?= $vo['action_key'] ?></td>
                    <td align="center">
                        <?php if ($vo['is_deleted'] == 0): ?>
                            <font class="colorthree strong">否</font>
                        <?php else: ?>
                            <font class="colorgreg strong">是</font>
                        <?php endif; ?>
                    </td>
                    <td align="center"><?= $vo['node_name'] ?></td>
                    <td align="center">
                        <a class="setedit" href="<?= Url::to(['workflow/action-edit', 'action_id' => $vo['id']]) ?>">编辑</a>
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
            location.href = '/admin/workflow/action-del?action_id=' + data_id;
        });
    });
</script>