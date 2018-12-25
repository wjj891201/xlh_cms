<?php

use yii\web\View;
use yii\widgets\LinkPager;
use yii\helpers\Url;

$this->registerJsFile('@web/public/backend/js/layer/layer.js', ['depends' => ['app\assets\AdminAsset'], 'position' => View::POS_HEAD]);
?>
<div id="dcMain">
    <!-- 当前位置 -->
    <div id="urHere">管理中心<b>></b><strong>网站管理员</strong></div> 
    <div id="manager" class="mainBox" style="height:auto!important;height:550px;min-height:550px;">
        <?= $this->render('../set/prompt.php'); ?>
        <div class="filter">
            <span>
                <h3><a href="<?= Url::to(['manage/reg']); ?>" class="actionBtn add">添加管理员</a></h3>
            </span>
        </div>
        <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
            <tr>
                <th width="30" align="center">编号</th>
                <th width="150" align="left">管理员名称</th>
                <th width="200" align="center">E-mail地址</th>
                <th align="center">添加时间</th>
                <th align="center">最后登录时间</th>
                <th align="center">操作</th>
            </tr>
            <?php foreach ($list as $key => $vo): ?>
                <tr>
                    <td align="center"><?= $vo['id'] ?></td>
                    <td><?= $vo['name'] ?></td>
                    <td align="center"><?= $vo['email'] ?></td>
                    <td align="center"><?= $vo['created_time'] ?></td>
                    <td align="center"><?= $vo['updated_time'] ?></td>
                    <td align="center">
                        <?php if ($vo['is_admin'] != 1): ?>
                            <a class="setedit2" href="<?= Url::to(['manage/mod', 'id' => $vo['id']]); ?>">修改密码</a>
                            <a class="setedit" href="javascript:void(0);" onclick="layer.confirm('确认要删除该用户吗?', {icon: 3, fix: true}, function (index) {
                                                layer.close(index);
                                                location.href = '<?= Url::to(['manage/del', 'id' => $vo['id']]) ?>';
                                            });">删除</a>
                            <a class="setedit2" href="<?= Url::to(['manage/make', 'id' => $vo['id']]); ?>">分配角色</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
        <div class="pager">
            <?=
            LinkPager::widget([
                'pagination' => $pages,
            ]);
            ?>
        </div>
        <div class="clear"></div>
    </div>
</div>