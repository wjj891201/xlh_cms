<?php

use yii\web\View;
use yii\helpers\Url;
use app\models\Type;

$this->registerJsFile('@web/public/backend/js/layer/layer.js', ['depends' => ['app\assets\AdminAsset'], 'position' => View::POS_HEAD]);
$this->registerJsFile('@web/public/backend/js/treeTable/jquery.treeTable.js', ['depends' => ['app\assets\AdminAsset'], 'position' => View::POS_HEAD]);
?>

<div id="dcMain">
    <!-- 当前位置 -->
    <div id="urHere">管理中心<b>></b><strong>分类管理</strong></div>
    <div class="mainBox" style="height:auto!important;height:550px;min-height:550px;">
        <?= $this->render('../set/prompt.php'); ?>
        <h3>
            <a href="<?= Url::to(['type/add', 'styleid' => 3]); ?>" class="actionBtn add">添加链接</a>
            <a href="<?= Url::to(['type/add', 'styleid' => 4]); ?>" class="actionBtn add">添加单网页</a>
            <a href="<?= Url::to(['type/add', 'styleid' => 2]); ?>" class="actionBtn add">添加主分类</a>
            分类列表
        </h3>
        <form name="action" method="post" action="<?= Url::to(['type/sort']) ?>">
            <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic" id="treeTable1">
                <tr>
                    <th width="80">ID</th>
                    <th width="40" align="left">排序</th>
                    <th width="350">分类名称</th>
                    <th width="150">类型</th>
                    <th align="center">操作</th>
                </tr>
                <?php foreach ($cates as $key => $vo): ?>
                    <?php if ($vo['upid'] == 0): ?>
                        <?php $p_key = $key + 1; ?>
                    <?php endif; ?>
                    <tr id="<?= $key + 1; ?>" <?php if ($vo['upid'] != 0): ?>pId="<?= $p_key; ?>"<?php endif; ?>>
                        <td align="left"><span <?php if ($vo['upid'] == 0): ?>controller="true"<?php endif; ?>><?= $vo['tid'] ?></span></td>
                        <td><input type="text" name="pid[<?= $vo['tid'] ?>]" class="inpMain" size="2" value="<?= $vo['pid'] ?>"/></td>
                        <td align="left"><?= $vo['typename'] ?></td>
                        <td align="center"><?= Type::getTypeName($vo['styleid']) ?></td>
                        <td align="center">
                            <a class="setedit2" href="<?= Url::to(['type/add', 'styleid' => 2, 'upid' => $vo['tid']]); ?>">添加分类</a>
                            <a class="setedit2" href="<?= Url::to(['type/add', 'styleid' => 4, 'upid' => $vo['tid']]); ?>">添加单页</a>
                            <a class="setedit2" href="<?= Url::to(['type/add', 'styleid' => 3, 'upid' => $vo['tid']]); ?>">添加链接</a>
                            <a class="setedit" href="<?= Url::to(['type/mod', 'tid' => $vo['tid']]); ?>">修改</a>
                            <a class="setedit" href="javascript:;" onclick="typeDel(this,<?= $vo['tid'] ?>)">删除</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
            <div class="action" style="padding-left:104px;">
                <input class="btn" value="排序" type="submit">
            </div>
        </form>
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

    function typeDel(obj, tid) {
        layer.confirm('确认要删除吗？', function () {
            $.ajax({
                type: "GET",
                url: "<?= URL::to(['type/del']); ?>",
                data: {tid: tid},
                dataType: "json",
                success: function (data) {
                    if (data == 404) {
                        layer.msg('sorry，您没有权限！', {icon: 2, time: 1000});
                    }
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