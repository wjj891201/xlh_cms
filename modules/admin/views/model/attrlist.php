<?php

use yii\web\View;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->registerJsFile('@web/public/backend/js/layer/layer.js', ['depends' => ['app\assets\AdminAsset'], 'position' => View::POS_HEAD]);
?>
<div id="dcMain">
    <!-- 当前位置 -->
    <div id="urHere">管理中心<b>></b><strong>添加模型字段</strong> </div>   
    <div class="mainBox" style="height:auto!important;height:550px;min-height:550px;">
        <?= $this->render('../set/prompt.php'); ?>
        <h3><a href="<?= Url::to(['model/attradd', 'mid' => $info->id]) ?>" class="actionBtn add">添加模型字段</a>{<?= $info->modelname ?>}字段列表</h3>
        <div id="list">
            <form name="action" id="thisform" method="post" action="<?= Url::to(['model/deal']) ?>">
                <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
                    <tr>
                        <th width="22" align="center"><input type='checkbox' id='chkall' onclick='selectcheckbox(this.form)' value='check'></th>
                        <th width="40" align="center">排序</th>
                        <th align="center">字段简述</th>
                        <th align="center">字段名</th>
                        <th align="center">类型</th>
                        <th align="center">验证</th>
                        <th align="center">系统字段</th>
                        <th width="150" align="center">显示状态</th>
                        <th width="80" align="center">操作</th>
                    </tr>
                    <?php foreach ($data as $key => $vo): ?>
                        <tr>
                            <td align="center">
                                <?php if ($vo['islockin'] == 1): ?>
                                    <input type="checkbox" name="id[]" value="<?= $vo['id'] ?>" />
                                <?php endif; ?>
                            </td>
                            <td align="center">
                                <input type="text" name="pid[<?= $vo['id'] ?>]" class="inpMain" size="2" value="<?= $vo['pid'] ?>"/>
                            </td>
                            <td align="center"><?= $vo['typename'] ?></td>
                            <td align="center"><?= $vo['attrname'] ?></td>
                            <td align="center"><?= $vo['inputtype'] ?></td>
                            <td class="infotype" align="center">
                                <?php if ($vo['isvalidate'] == 1): ?>
                                    <span class="select_ok" title="启用"></span>
                                <?php else: ?>
                                    <span class="select_no" title="关闭"></span>
                                <?php endif; ?>
                            </td>
                            <td class="infotype" align="center">
                                <?php if ($vo['islockin'] == 1): ?>
                                    <span class="select_no" title="关闭"></span>
                                <?php else: ?>
                                    <span class="select_ok" title="启用"></span>
                                <?php endif; ?>
                            </td>
                            <td class="infotype" align="center">
                                <?php if ($vo['isclass'] == 1): ?>
                                    <span class="audit_ok" title="启用"></span>
                                <?php else: ?>
                                    <span class="audit_no" title="关闭"></span>
                                <?php endif; ?>
                            </td>
                            <td align="center">
                                <a class="setedit" href="<?= Url::to(['model/attredit', 'mid' => $info['id'], 'aid' => $vo['id']]) ?>">修改</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
                <div class="action">
                    <select name="action" id="what-action">
                        <option value="del">删除</option>
                        <option value="sort">排序</option>
                    </select>
                    <input type="hidden" name="mid" value="<?= $info->id ?>"/>
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
<script>
    function check()
    {
        var action = $('#what-action').val();
        if (action == 'del') {
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