<?php

use yii\web\View;
use yii\helpers\Url; //使用Url类
use yii\widgets\LinkPager;

$this->registerJsFile('@web/public/backend/js/layer/layer.js', ['depends' => ['app\assets\AdminAsset'], 'position' => View::POS_HEAD]);
?>
<style>
    .tableOnebor a:hover{color: #FF6600;} 
</style>
<div id="dcMain">
    <!-- 当前位置 -->
    <div id="urHere">管理中心<b>></b><strong>内容列表</strong> </div>   
    <div class="mainBox imgModule">
        <?= $this->render('../set/prompt.php'); ?>
        <h3>内容列表</h3>
        <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
            <tr>
                <th>分类</th>
                <th>内容列表</th>
            </tr>
            <tr>
                <td width="350" valign="top">

                    <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableOnebor">
                        <tr>
                            <td width="100">分类名称</td>
                            <td width="50" align="center">文章内容</td>
                        </tr>
                        <?php foreach ($cates as $key => $vo): ?>
                            <tr>
                                <td>
                                    <?php if ($vo['upid'] == 0): ?>
                                        <b>
                                            <?php if (in_array($vo['styleid'], [1, 2])): ?>
                                                <a href="<?= Url::to(['news/list', 'tid' => $vo['tid']]) ?>"><?= $vo['typename'] ?></a>
                                            <?php else: ?>
                                                <?= $vo['typename'] ?>
                                            <?php endif; ?>
                                        </b>
                                    <?php else: ?>
                                        <?php if (in_array($vo['styleid'], [1, 2])): ?>
                                            <a href="<?= Url::to(['news/list', 'tid' => $vo['tid']]) ?>"><?= $vo['typename'] ?></a>
                                        <?php else: ?>
                                            <?= $vo['typename'] ?>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </td>
                                <td align="center">
                                    <?php if ($vo['styleid'] != 3): ?>
                                        <?php if ($vo['styleid'] == 4): ?>
                                            <a class="setedit" href="<?= Url::to(['news/edit', 'mid' => $vo['mid'], 'tid' => $vo['tid'], 'did' => $vo['linkid']]) ?>" style="color: #F00;">编辑</a>
                                        <?php else: ?>
                                            <a class="setedit" href="<?= Url::to(['news/add', 'mid' => $vo['mid'], 'tid' => $vo['tid']]) ?>">添加</a>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>

                </td>
                <td valign="top">
                    <form action="<?= Url::to(['news/deal']) ?>" id="thisform" method="post">
                        <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableOnebor">
                            <tr>
                                <td width="22" align="center">
                                    <input type='checkbox' id='chkall' onclick='selectcheckbox(this.form)' value='check'/>
                                </td>
                                <td width="50" align="center">排序</td>
                                <td>内容标题</td>
                                <td width="100">分类</td>
                                <td width="80" align="center">操作</td>
                            </tr>
                            <?php foreach ($data as $key => $vo): ?>
                                <tr>
                                    <td align="center">
                                        <input type="checkbox" name="did[]" value="<?= $vo['did'] ?>" />
                                    </td>
                                    <td align="center"><input type="text" name="pid[<?= $vo['did'] ?>]" class="inpMain" size="2" value="<?= $vo['pid'] ?>"/></td>
                                    <td><?= $vo['title'] ?></td>
                                    <td><?= $vo['typename'] ?></td>
                                    <td align="center">
                                        <a class="setedit" href="<?= Url::to(['news/edit', 'mid' => $vo['mid'], 'tid' => $vo['tid'], 'did' => $vo['did']]) ?>">编辑</a>
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
                </td>
            </tr>
        </table>
    </div>
</div>

<script language="javascript">
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