<?php

use yii\helpers\Url; //使用Url类
use yii\widgets\LinkPager;
?>
<script type="text/javascript" src="/layer/layer.js"></script>
<div id="dcMain">
    <!-- 当前位置 -->
    <div id="urHere">管理中心<b>></b><strong>留言列表</strong> </div>   
    <div class="mainBox" style="height:auto!important;height:550px;min-height:550px;">
        <?= $this->render('../set/prompt.php'); ?>
        <div id="list">
            <form name="action" method="post" action="<?php echo Url::to(['message/batchdel']); ?>"  onsubmit="return toVaild()">
                <input type="hidden" name="_csrf" id='csrf' value="<?= Yii::$app->request->csrfToken ?>">
                <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
                    <tr>
                        <th width="22" align="center"><input type='checkbox' id='chkall' onclick='selectcheckbox(this.form)' value='check'></th>
                        <th align="center">姓名</th>
                        <th width="150" align="center">联系电话</th>
                        <th width="150" align="center">地址</th>
                        <th width="80" align="center">电子邮箱</th>
                        <th width="180" align="center">添加日期</th>
                        <th width="80" align="center">操作</th>
                    </tr>

                    <?php foreach ($data as $key => $vo): ?>
                        <tr>
                            <td align="center"><input type="checkbox" name="chkall[]" value="<?= $vo['id']; ?>" /></td>
                            <td align="center"><?= $vo['name']; ?></td>
                            <td align="center"><?= $vo['telphone']; ?></td>
                            <td align="center"><?= $vo['address']; ?></td>
                            <td align="center"><?= $vo['email']; ?></td>
                            <td align="center"><?= $vo['createtime']; ?></td>
                            <td align="center">
                                <a href="<?php echo Url::to(['message/check', 'id' => $vo['id']]); ?>">查看</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                </table>
                <div class="action">
                    <input class="btn" type="submit" value="批量删除" />
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
    function toVaild() {
        var falg = $("input:checkbox:checked").length;
        if (falg > 0) {
            return true;
        } else {
            layer.msg('请选择信息再进行提交', {icon: 2});
            return false;
        }
    }
</script>