<?php

use yii\helpers\Url; //使用Url类
?>
<script type="text/javascript" src="/layer/layer.js"></script>
<script type="text/javascript" src="/assets/backend/js/treeTable/jquery.treeTable.js"></script>
<div id="dcMain">
    <!-- 当前位置 -->
    <div id="urHere">管理中心<b>></b><strong>地区分类</strong></div>
    <div class="mainBox" style="height:auto!important;height:550px;min-height:550px;">
        <?= $this->render('../set/prompt.php'); ?>
        <div class="filter">
            <span>
                <h3><a href="<?php echo Url::to(['region/add']); ?>" class="actionBtn add">添加地区</a></h3>
            </span>
        </div>
        <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic" id="treeTable1">
            <tr>
                <th width="120" align="left">地区ID</th>
                <th width="280">地区名称</th>
                <th width="60">是否关闭</th>
                <th align="left">地区描述</th>
                <th width="60" align="center">排序</th>
                <th width="80" align="center">操作</th>
            </tr>

            <?php foreach ($region as $key => $vo): ?>
                <?php if ($vo['parent_id'] == 2): ?>
                    <?php $p_key = $key + 1; ?>
                <?php endif; ?>
                <tr id="<?php echo $key + 1; ?>" <?php if ($vo['parent_id'] != 2): ?>pId="<?php echo $p_key; ?>"<?php endif; ?>>
                    <td align="left"><span <?php if ($vo['parent_id'] == 2): ?>controller="true"<?php endif; ?>><?php echo $vo['region_id'] ?></span></td>
                    <td><?php echo $vo['region_name']; ?></td>
                    <td align="center" style="color: red;"><?php echo $vo['closed'] == 1 ? '关闭' : ''; ?></td>
                    <td><?php echo $vo['description']; ?></td>
                    <td align="center"><?php echo $vo['sort_order']; ?></td>
                    <td align="center">
                        <a href="<?php echo Url::to(['region/mod', 'id' => $vo['region_id']]); ?>">编辑</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>

<script type="text/javascript">
    $(function () {
        var option = {
            theme: 'vsStyle',
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
</script>