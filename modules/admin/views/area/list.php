<?php

use yii\web\View;
use yii\helpers\Url;

$this->registerJsFile('@web/public/backend/js/layer/layer.js', ['depends' => ['app\assets\AdminAsset'], 'position' => View::POS_HEAD]);
?>
<div id="dcMain">
    <!-- 当前位置 -->
    <div id="urHere">管理中心<b>></b><strong>地区管理</strong></div>   
    <div class="mainBox" style="height:auto!important;height:550px;min-height:550px;">
        <?= $this->render('../set/prompt.php'); ?>
        <h3><a href="<?= Url::to(['area/add']) ?>" class="actionBtn add">添加地区</a>地区列表</h3>
        <div id="list">
            <form name="action" id="thisform" method="post" action="<?= Url::to(['area/deal']) ?>">
                <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
                    <tr>
                        <th width="10%" align="center"><input name='chkall' type='checkbox' id='chkall' onclick='selectcheckbox(this.form)' value='check'></th>
                        <th width="20%" align="center">排序</th>
                        <th align="center">地区名</th>
                        <th width="10%" align="center">状态</th>
                        <th width="20%" align="center">添加时间</th>
                        <th width="10%" align="center">操作</th>
                    </tr>
                    <?php foreach ($list as $key => $vo): ?>
                        <tr>
                            <td align="center">
                                <input type="checkbox" name="id[]" value="<?= $vo['id'] ?>" />
                            </td>
                            <td align="center"><input type="text" name="sort[<?= $vo['id'] ?>]" class="inpMain" size="4" value="<?= $vo['sort'] ?>"/></td>                            
                            <td align="center"><?= $vo['name'] ?></td>
                            <td align="center">
                                <?php if ($vo['status'] == 1): ?>
                                    <font class="colorthree strong">可用</font>
                                <?php else: ?>
                                    <font class="colorgreg strong">不可用</font>
                                <?php endif; ?>
                            </td>
                            <td align="center"><?= $vo['create_time'] ?></td>
                            <td align="center">
                                <a class="setedit" href="<?= Url::to(['area/edit', 'id' => $vo['id']]) ?>">编辑</a>
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
        </div>
        <div class="clear"></div>           
    </div>
</div>

<script language="javascript">
    function check()
    {
        var action = $('#what-action').val();
        if (action === 'del') {
            var num = $("input:checkbox:checked").length;
            if (num > 0) {
                layer.confirm('确认删除吗？', function () {
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