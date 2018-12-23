<?php

use yii\web\View;
use yii\helpers\Url;

$this->registerJsFile('@web/public/backend/js/layer/layer.js', ['depends' => ['app\assets\AdminAsset'], 'position' => View::POS_HEAD]);
?>
<div id="dcMain">
    <div id="urHere">管理中心<b>></b><strong>流程组</strong> </div>   
    <div id="manager" class="mainBox" style="height:auto!important;height:550px;min-height:550px;">
        <?= $this->render('../set/prompt.php'); ?>
        <h3><a href="<?= Url::to(['workflow/group-add']); ?>" class="actionBtn">添加流程组</a>流程组列表</h3>
        <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
            <tr>
                <th width="10%" align="center">编号</th>
                <th align="left">流程组名称</th>
                <th align="center">流程组标识</th>
                <th align="center">是否可用</th>
                <th width="30%" align="center">操作</th>
            </tr>
            <?php foreach ($list as $key => $vo): ?>
                <tr>
                    <td align="center"><?= $vo['id'] ?></td>
                    <td><?= $vo['group_name'] ?></td>
                    <td align="center"><?= $vo['group_key'] ?></td>
                    <td align="center">
                        <?php if ($vo['enable'] == 1): ?>
                            <font class="colorthree strong">可用</font>
                        <?php else: ?>
                            <font class="colorgreg strong">不可用</font>
                        <?php endif; ?>
                    </td>
                    <td align="center">
                        <a class="setedit2" href="<?= Url::to(['workflow/node-list', 'group_id' => $vo['id']]) ?>">节点管理</a>
                        <a class="setedit2 delete" data_id="<?= $vo['id'] ?>" href="javascript:void(0);">删除流程</a>
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
            location.href = '/admin/workflow/group-del?group_id=' + data_id;
        });
    });
</script>