<?php

use yii\helpers\Url; //使用Url类
?>
<script type="text/javascript" src="/layer/layer.js"></script>
<script type="text/javascript" src="/assets/backend/js/treeTable/jquery.treeTable.js"></script>
<div id="dcMain">
    <!-- 当前位置 -->
    <div id="urHere">管理中心<b>></b><strong>栏目分类</strong></div>
    <div class="mainBox" style="height:auto!important;height:550px;min-height:550px;">
        <?= $this->render('../set/prompt.php'); ?>
        <h3>
            <a href="<?php echo Url::to(['category/add', 'type' => 3]); ?>" class="actionBtn add">添加链接</a>
            <a href="<?php echo Url::to(['category/add', 'type' => 2]); ?>" class="actionBtn add">添加单网页</a>
            <a href="<?php echo Url::to(['category/add', 'type' => 1]); ?>" class="actionBtn add">添加列表</a>
            栏目分类
        </h3>

        <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic" id="treeTable1">
            <tr>
                <th width="80" align="left">分类ID</th>
                <th width="200">分类名称</th>
                <th width="80">类型</th>
                <th width="80">导航</th>
                <th align="left">自定义Keywords</th>
                <th width="60" align="center">排序</th>
                <th width="80" align="center">操作</th>
            </tr>

            <?php foreach ($cates as $key => $cate): ?>
                <?php if ($cate['parentid'] == 0): ?>
                    <?php $p_key = $key + 1; ?>
                <?php endif; ?>
                <tr id="<?php echo $key + 1; ?>" <?php if ($cate['parentid'] != 0): ?>pId="<?php echo $p_key; ?>"<?php endif; ?>>
                    <td align="left"><span <?php if ($cate['parentid'] == 0): ?>controller="true"<?php endif; ?>><?php echo $cate['id'] ?></span></td>
                    <td><?php echo $cate['name']; ?></td>
                    <td align="center"><?= $cate['type'] ?></td>
                    <td align="center"><?= $cate['status'] == 1 ? "是" : ""; ?></td>
                    <td><?php echo $cate['keywords']; ?></td>
                    <td align="center"><?php echo $cate['displayorder']; ?></td>
                    <td align="center">
                        <a href="<?php echo Url::to(['category/mod', 'cateid' => $cate['id']]); ?>">编辑</a> | 
                        <a href="javascript:;" onclick="cate_del(this,<?php echo $cate['id'] ?>)">删除</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>

<script type="text/javascript">
    $(function () {
        var option = {
            theme: 'default',
            expandLevel: 2,
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

    function cate_del(obj, id) {
        layer.confirm('确认要删除吗？', function (index) {
            $.ajax({
                type: "GET",
                url: "<?php echo URL::to(['category/del']); ?>",
                data: "id=" + id,
                dataType: "json",
                success: function (data) {
                    if (data == 0) {
                        layer.msg('含有下级分类,禁止删除!', {icon: 2, time: 1000});
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