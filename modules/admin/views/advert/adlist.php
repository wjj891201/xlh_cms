<?php

use yii\web\View;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->registerJsFile('@web/public/backend/js/layer/layer.js', ['depends' => ['app\assets\AdminAsset'], 'position' => View::POS_HEAD]);
?>
<div id="dcMain">
    <!-- 当前位置 -->
    <div id="urHere">管理中心<b>></b><strong>广告内容管理</strong></div>
    <div class="mainBox" style="height:auto!important;height:550px;min-height:550px;">
        <?= $this->render('../set/prompt.php'); ?>
        <span>
            <h3>
                <a href="<?= Url::to(['advert/add']); ?>" class="actionBtn add">添加广告</a>
                广告内容列表
            </h3>
        </span>
        <div id="list">
            <form name="action" id="thisform" method="post" action="<?= Url::to(['advert/deal']) ?>">
                <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
                    <tr>
                        <th width="40" align="center"><input name='chkall' type='checkbox' id='chkall' onclick='selectcheckbox(this.form)' value='check'></th>
                        <th width="60" align="center">排序</th>
                        <th width="60" align="center">ID</th>
                        <th align="center">广告名称</th>
                        <th width="150" align="center">广告位</th>
                        <th width="150" align="center">类型</th>
                        <th width="80" align="center">启用状态</th>
                        <th width="80" align="center">操作</th>
                    </tr>
                    <?php foreach ($data as $key => $vo): ?>
                        <tr>
                            <td align="center"><input type="checkbox" name="adid[]" value="<?= $vo['adid'] ?>" /></td>
                            <td align="center"><input type="text" name="pid[<?= $vo['adid'] ?>]" class="inpMain" size="2" value="<?= $vo['pid'] ?>"/></td>
                            <td align="center"><?= $vo['adid'] ?></td>
                            <td align="center"><?= $vo['title'] ?></td>
                            <td align="center"><?= $vo['position']['adtypename'] ?></td>
                            <td align="center"><?= $vo['adtype'] == 1 ? '图片广告' : '文字广告'; ?></td>
                            <td align="center" class="infotype">
                                <?php if ($vo['isclass']): ?>
                                    <span class="audit_ok" title="启用"></span>
                                <?php else: ?>
                                    <span class="audit_no" title="关闭"></span>
                                <?php endif; ?>
                            </td>
                            <td align="center">
                                <a class="setedit" href="<?= Url::to(['advert/mod', 'adid' => $vo['adid']]); ?>">修改</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
                <div class="action">
                    <select name="action" id="what-action">
                        <option value="del">删除</option>
                        <option value="sort">排序</option>
                    </select>
                    <input class="btn" onclick="check();" value="执行" type="button">
                </div>
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
<script language="javascript">
    function check()
    {
        var action = $('#what-action').val();
        if (action == 'del') {
            var num = $("input:checkbox:checked").length;
            if (num > 0) {
                layer.confirm('确认删除吗？', {icon: 3}, function () {
                    $('#thisform').submit();
                });
            } else {
                layer.msg('请选择至少一条数据', {icon: 2, time: 1000});
                return false;
            }
        }
        if (action == 'sort') {
            $('#thisform').submit();
        }
    }
</script>