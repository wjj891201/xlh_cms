<?php

use yii\web\View;
use yii\helpers\Url;

$this->registerJsFile('@web/public/backend/js/layer/layer.js', ['depends' => ['app\assets\AdminAsset'], 'position' => View::POS_HEAD]);
?>
<div id="dcMain">
    <div id="urHere">管理中心<b>></b><strong>网站主题</strong></div>
    <div class="mainBox" style="height:auto!important;height:550px;min-height:550px;">
        <?= $this->render('../set/prompt.php'); ?>
        <h3><a href="<?= Url::to(['skin/add']) ?>" class="actionBtn add">添加主题</a>主题列表</h3>
        <div id="list">
            <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
                <tr>
                    <th width="40" align="center">编号</th>
                    <th align="center">主题名称</th>
                    <th width="150" align="center">主题标识</th>
                    <th width="180" align="center">系统模板</th>
                    <th width="180" align="center">启用状态</th>
                    <th width="180" align="center">操作</th>
                </tr>
                <?php foreach ($all as $key => $vo): ?>
                    <tr>
                        <td align="center"><?= $vo['skid'] ?></td>
                        <td align="center"><?= $vo['name'] ?></td>
                        <td align="center"><?= $vo['code'] ?></td>
                        <td align="center" class="infotype">
                            <?php if ($vo['lockin'] == 1): ?>
                                <span class="select_ok"></span>
                            <?php else: ?>
                                <span class="select_no"></span>
                            <?php endif; ?>
                        </td>
                        <td align="center" class="infotype">
                            <?php if ($vo['isclass'] == 1): ?>
                                <span class="select_ok"></span>
                            <?php else: ?>
                                <span class="select_no"></span>
                            <?php endif; ?>
                        </td>
                        <td align="center">
                            <?php if ($vo['isclass'] != 1): ?>
                                <a class="setedit" href="javascript:void(0);" onclick="layer.confirm('确认启用', {icon: 3, fix: true}, function (index) {
                                                    layer.close(index);
                                                    location.href = '<?= Url::to(['skin/open', 'skid' => $vo['skid']]) ?>';
                                                });">启用</a>
                            <?php else: ?>
                                <a class="setedit2" href="javascript:void(0);">已启用</a>
                            <?php endif; ?>
                            <?php if ($vo['lockin'] != 1): ?>
                                <a class="setedit" href="javascript:void(0);" onclick="layer.confirm('确认删除', {icon: 3, fix: true}, function (index) {
                                                    layer.close(index);
                                                    location.href = '<?= Url::to(['skin/del', 'skid' => $vo['skid']]) ?>';
                                                });">删除</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <div class="clear"></div>
    </div>
</div>
