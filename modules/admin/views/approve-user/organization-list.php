<?php

use yii\web\View;
use yii\helpers\Url;

$this->registerJsFile('@web/public/backend/js/layer/layer.js', ['depends' => ['app\assets\AdminAsset'], 'position' => View::POS_HEAD]);
$this->registerJsFile('@web/public/backend/js/treeTable/jquery.treeTable.js', ['depends' => ['app\assets\AdminAsset'], 'position' => View::POS_HEAD]);
?>
<div id="dcMain">
    <!-- 当前位置 -->
    <div id="urHere">管理中心<b>></b><strong>机构列表</strong> </div>
    <div class="mainBox" style="height:auto!important;height:550px;min-height:550px;">   
        <?= $this->render('../set/prompt.php'); ?>
        <div class="filter">
            <span>
                <h3><a href="<?= Url::to(['approve-user/organization-add']); ?>" class="actionBtn add">添加机构</a></h3>
            </span>
        </div>
        <div id="list">
            <form name="action" method="post" action="">
                <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic" id="treeTable1">
                    <tr>
                        <th width="8%" align="center">ID</th>
                        <th width="30%" align="left">机构名称</th>
                        <th align="center">是否有效</th>
                        <th align="center">固定机构</th>
                        <th align="center">所属分行</th>
                        <th align="center">添加时间</th>
                        <th width="15%" align="center">操作</th>
                    </tr>
                    <?php foreach ($list as $key => $vo): ?>
                        <?php if ($vo['pid'] == 0): ?>
                            <?php $p_key = $key + 1; ?>
                        <?php endif; ?>
                        <tr id="<?= $key + 1; ?>" <?php if ($vo['pid'] != 0): ?>pId="<?= $p_key; ?>"<?php endif; ?>>                
                            <td align="left"><?= $key + 1 ?></td>
                            <td align="left"><?= $vo['name'] ?></td>
                            <td class="infotype" align="center">
                                <?php if ($vo['status'] == 1): ?>
                                    <span class="select_ok" title="有效"></span>
                                <?php else: ?>
                                    <span class="select_no" title="无效"></span>
                                <?php endif; ?>
                            </td>
                            <td class="infotype" align="center">
                                <?php if ($vo['fixed'] == 1): ?>
                                    <span class="select_ok" title="是"></span>
                                <?php else: ?>
                                    <span class="select_no" title="否"></span>
                                <?php endif; ?>
                            </td>
                            <td align="center"><?= $vo['bank']['name'] ?></td>
                            <td align="center"><?= date('Y-m-d', $vo['add_time']) ?></td>
                            <td align="center">
                                <a class="setedit" href="<?= Url::to(['approve-user/organization-edit', 'id' => $vo['id']]) ?>">编辑</a>
                                <?php if ($vo['fixed'] != 1): ?>
                                    <a class="setedit delete" data_id="<?= $vo['id'] ?>" href="javascript:void(0);">删除</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </form>
        </div>
        <div class="clear"></div>   
    </div>
</div>
<script>
    $(function () {
        var option = {
            theme: 'default',
            expandLevel: 2,
            beforeExpand: function ($treeTable, id) {
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

        //删除
        $('.delete').click(function () {
            var data_id = this.getAttribute('data_id');
            layer.confirm('确认删除', {icon: 3, fix: true}, function (index) {
                location.href = '/admin/approve-user/organization-del?id=' + data_id;
            });
        });
    });
</script>