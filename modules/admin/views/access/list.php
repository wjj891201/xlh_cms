<?php

use yii\web\View;
use yii\helpers\Url;

$this->registerJsFile('@web/public/backend/js/layer/layer.js', ['depends' => ['app\assets\AdminAsset'], 'position' => View::POS_HEAD]);
$this->registerJsFile('@web/public/backend/js/treeTable/jquery.treeTable.js', ['depends' => ['app\assets\AdminAsset'], 'position' => View::POS_HEAD]);
?>
<div id="dcMain">
    <!-- 当前位置 -->
    <div id="urHere">管理中心<b>></b><strong>权限列表</strong> </div>
    <div class="mainBox" style="height:auto!important;height:550px;min-height:550px;">
        <?= $this->render('../set/prompt.php'); ?>
        <div class="filter">
            <span>
                <h3><a href="<?= Url::to(['access/add']); ?>" class="actionBtn add">添加权限</a></h3>
            </span>
        </div>
        <div id="list">
            <form name="action" method="post" action="">
                <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic" id="treeTable1">
                    <tr>
                        <th width="50" align="center">ID</th>
                        <th align="left">权限标题</th>
                        <th width="250" align="center">Urls</th>
                        <th width="200" align="center">创建时间</th>
                        <th width="80" align="center">排序</th>
                        <th width="120" align="center">操作</th>
                    </tr>
                    <?php foreach ($access as $key => $vo): ?>
                        <?php if ($vo['pid'] == 0): ?>
                            <?php $p_key = $key + 1; ?>
                        <?php endif; ?>
                        <tr id="<?= $key + 1; ?>" <?php if ($vo['pid'] != 0): ?>pId="<?= $p_key; ?>"<?php endif; ?>>                
                            <td align="center"><?= $key + 1 ?></td>
                            <td><?= $vo['title'] ?></td>
                            <td align="center">
                                <?php
                                $tmp_urls = @json_decode($vo['urls'], true);
                                $tmp_urls = $tmp_urls ? $tmp_urls : [];
                                ?>
                                <?= implode("<br/>", $tmp_urls); ?>
                            </td>
                            <td align="center"><?= $vo['created_time'] ?></td>
                            <td align="center"><?= $vo['sort'] ?></td>
                            <td align="center">
                                <a class="setedit" href= "<?= Url::to(['access/mod', 'id' => $vo['id']]); ?>" >编辑 </a >
                                <a class="setedit" href="javascript:;" onclick="access_del(this,<?= $vo['id'] ?>)">删除</a >
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
    $(function () {
        var option = {
            theme: 'default',
            expandLevel: 1,
            beforeExpand: function ($treeTable, id) {
                //判断id是否已经有了孩子节点，如果有了就不再加载，这样就可以起到缓存的作用
                if ($('.' + id, $treeTable).length) {
                    return;
                }
                $treeTable.addChilds(html);
            },
            onSelect: function ($treeTable, id) {
                window.console && console.log('onSelect:' + id);
            }
        };
        $('#treeTable1').treeTable(option);
    });

    function access_del(obj, id) {
        layer.confirm('确认要删除吗？', function (index) {
            $.ajax({
                type: "GET",
                url: "<?= URL::to(['access/del']); ?>",
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