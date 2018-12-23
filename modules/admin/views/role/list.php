<?php

use yii\web\View;
use yii\helpers\Url;

$this->registerJsFile('@web/public/backend/js/layer/layer.js', ['depends' => ['app\assets\AdminAsset'], 'position' => View::POS_HEAD]);
?>

<div id="dcMain">
    <!-- 当前位置 -->
    <div id="urHere">管理中心<b>></b><strong>角色列表</strong> </div>
    <div class="mainBox" style="height:auto!important;height:550px;min-height:550px;">
        <?= $this->render('../set/prompt.php'); ?>
        <div class="filter">
            <span>
                <h3><a href="<?= Url::to(['role/add']); ?>" class="actionBtn add">创建角色</a></h3>
            </span>
        </div>
        <div id="list">
            <form name="action" method="post" action="">
                <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
                    <tr>
                        <th width="40" align="center">ID</th>
                        <th align="left">角色名</th>
                        <th width="250" align="center">更新时间</th>
                        <th width="250" align="center">创建时间</th>
                        <th width="250" align="center">操作</th>
                    </tr>
                    <?php foreach ($all_role as $key => $vo): ?>
                        <tr>                
                            <td align="center"><?= $key + 1 ?></td>
                            <td><?= $vo['name'] ?></td>
                            <td align="center"><?= $vo['updated_time'] ?></td>
                            <td align="center"><?= $vo['created_time'] ?></td>
                            <td align="center">
                                <a class="setedit" href= "<?= Url::to(['role/mod', 'id' => $vo['id']]); ?>" >编辑 </a>
                                <a class="setedit" href="javascript:;" onclick="role_del(this,<?= $vo['id'] ?>)">删除</a>
                                <a class="setedit2" href= "<?= Url::to(['role/setaccess', 'id' => $vo['id']]); ?>" >设置权限 </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </form>
        </div>
        <div class="clear"></div>   
    </div>
</div>

<script type="text/javascript">
    function role_del(obj, id) {
        layer.confirm('确认要删除吗？', function (index) {
            $.ajax({
                type: "GET",
                url: "<?= URL::to(['role/del']); ?>",
                data: "id=" + id,
                dataType: "json",
                success: function (data) {
                    if (data == 404) {
                        layer.msg('sorry，您没有权限！', {icon: 2, time: 1000});
                    }
                    if (data == 1) {
                        $(obj).parents("tr").remove();
                        layer.msg('已成功删除!', {icon: 1, time: 1000});
                    }
                }
            });
        });
    }
</script>