<?php

use yii\web\View;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->registerJsFile('@web/public/backend/js/layer/layer.js', ['depends' => ['app\assets\AdminAsset'], 'position' => View::POS_HEAD]);
?>
<div id="dcMain">
    <!-- 当前位置 -->
    <div id="urHere">管理中心<b>></b><strong>自助表单管理</strong></div>   
    <div class="mainBox" style="height:auto!important;height:550px;min-height:550px;">
        <?= $this->render('../set/prompt.php'); ?>
        <h3>留言列表</h3>
        <form id="thisform" action="<?= Url::to(['formgroup/delmess']) ?>" method="post">
            <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
                <tr>
                    <th width="5%" align="center">
                        <input type='checkbox' id='chkall' onclick='selectcheckbox(this.form)' value='check'/>
                    </th>
                    <th width="10%" align="center">ID</th>
                    <th width="65%" align="center">留言时间</th>
                    <th width="20%" align="center">操作</th>
                </tr>
                <?php foreach ($data as $key => $vo): ?>
                    <tr>
                        <td align="center">
                            <input type="checkbox" name="fvid[]" value="<?= $vo['fvid'] ?>" />
                        </td>
                        <td align="center"><?= $vo['fvid'] ?></td>
                        <td align="center"><?= date('Y-m-d H:i:s', $vo['addtime']) ?></td>
                        <td align="center">
                            <a class="setedit" href="<?= Url::to(['formgroup/check', 'fvid' => $vo['fvid']]) ?>">查看</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
            <div class="action">
                <input type="hidden" name="fgid" value="<?= $fgid ?>"/>
                <input class="btn" onclick="check();" value="删除" type="button">
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
</div>
<script>
    function check()
    {
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
</script>
