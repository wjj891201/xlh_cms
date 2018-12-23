<?php

use yii\helpers\Html;
use yii\helpers\Url; //使用Url类
?>
<div id="dcMain">
    <!-- 当前位置 -->
    <div id="urHere">管理中心<b>></b><strong>分配角色</strong> </div>   
    <div id="manager" class="mainBox" style="height:auto!important;height:550px;min-height:550px;">
        <div class="filter">
            <span>
                <h3><a href="<?= Url::to(['manage/list']); ?>" class="actionBtn">返回列表</a></h3>
            </span>
        </div>
        <form action="<?= Url::to(['manage/make']); ?>" method="post">
            <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
                <tr>
                    <td width="100" align="right">管理员名称</td>
                    <td>
                        <?= $userDetail->name ?>
                        <input type="hidden" name="uid" value="<?= $userDetail->id ?>"/>
                        <input type="hidden" name="_csrf" id='csrf' value="<?= Yii::$app->request->csrfToken ?>"> 
                    </td>
                </tr>
                <tr>
                    <td width="100" align="right">角色</td>
                    <td>
                        <?php foreach ($role as $key => $vo): ?>
                            <input name="role_id[]" value="<?= $vo['id'] ?>" type="checkbox" <?php if (in_array($vo['id'], $have_role)): ?>checked="checked"<?php endif; ?>/>&nbsp;&nbsp;<?= $vo['name'] ?><br/><br/>
                        <?php endforeach; ?>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <?= Html::submitButton('提交', ['class' => 'btn']); ?>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>