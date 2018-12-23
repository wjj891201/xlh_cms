<?php

use yii\web\View;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->registerJsFile('@web/public/backend/js/layer/layer.js', ['depends' => ['app\assets\AdminAsset'], 'position' => View::POS_HEAD]);
$this->registerJsFile('@web/public/backend/js/treeTable/jquery.treeTable.js', ['depends' => ['app\assets\AdminAsset'], 'position' => View::POS_HEAD]);
?>
<div id="dcMain">
    <!-- 当前位置 -->
    <div id="urHere">管理中心<b>></b><strong>审批员列表</strong> </div>
    <div class="mainBox" style="height:auto!important;height:550px;min-height:550px;">
        <?= $this->render('../set/prompt.php'); ?>
        <div class="filter">
            <span>
                <h3><a href="<?= Url::to(['approve-user/add']); ?>" class="actionBtn add">添加审批员</a></h3>
            </span>
        </div>
        <div id="list">
            <form name="action" method="post" action="">
                <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic" id="treeTable1">
                    <tr>
                        <th width="10%" align="center">ID</th>
                        <th align="left">账号</th>
                        <th width="10%">账号隶属机构</th>
                        <th width="20%" align="center">邮箱</th>
                        <th width="10%" align="center">电话</th>
                        <th width="20%" align="center">创建时间</th>
                        <th width="20%" align="center">操作</th>
                    </tr>
                    <?php foreach ($data as $key => $vo): ?>
                        <tr id="<?= $key + 1; ?>">                
                            <td align="center"><?= $key + 1 ?></td>
                            <td><?= $vo['username'] ?></td>
                            <td align="center"><?= $vo['organization']['name'] ?></td>
                            <td align="center"><?= $vo['email'] ?></td>
                            <td align="center"><?= $vo['telphone'] ?></td>
                            <td align="center"><?= date('Y-m-d', $vo['created_at']) ?></td>
                            <td align="center">
                                <a class="setedit" href="<?= Url::to(['approve-user/edit', 'id' => $vo['id']]) ?>">编辑</a>
                                <a class="setedit delete" data_id="<?= $vo['id'] ?>" href="javascript:void(0);">删除</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </form>
            <div class="pager">
                <?=
                LinkPager::widget([
                    'pagination' => $pages,
                ]);
                ?>
            </div>
        </div>
        <div class="clear"></div>   
    </div>
</div>
<script>
    $(function () {
        $('.delete').click(function () {
            var data_id = this.getAttribute('data_id');
            layer.confirm('确认删除', {icon: 3, fix: true}, function (index) {
                layer.close(index);
                location.href = '/admin/approve-user/user-del?id=' + data_id;
            });
        });
    });
</script>