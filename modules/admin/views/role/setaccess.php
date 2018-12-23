<?php

use yii\helpers\Html;
use yii\helpers\Url; //使用Url类
?>
<div id="dcMain">
    <!-- 当前位置 -->
    <div id="urHere">管理中心<b>></b><strong>设置权限</strong> </div>   
    <div id="manager" class="mainBox" style="height:auto!important;height:550px;min-height:550px;">
        <h3>为 {<?= $info['name'] ?>} 设置权限</h3>
        <form action="<?= Url::to(['role/setaccess']); ?>" method="post">
            <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
                <tr>
                    <td width="100" align="right">角色名</td>
                    <td>
                        <?= $info['name'] ?>
                        <input type="hidden" name="id" value="<?= $info['id'] ?>"/>
                        <input type="hidden" name="_csrf" id='csrf' value="<?= Yii::$app->request->csrfToken ?>"> 
                    </td>
                </tr>
                <tr>
                    <td width="100" align="right">权限</td>
                    <td>
                        <div class="permission">
                            <?php foreach ($access_list as $key => $vo): ?>
                                <dl class="app <?php if ($key % 2 == 0): ?>fl<?php else: ?>fr<?php endif; ?>">
                                    <dt>
                                    <input name="access_ids[]" type="checkbox" value="<?= $vo['id'] ?>" level="1" <?php if (in_array($vo['id'], $have_access)): ?>checked="checked"<?php endif; ?> />&nbsp;
                                    <label><?= $vo['title'] ?></label>
                                    </dt>
                                    <?php if (!empty($vo['child'])): ?>
                                        <dd>
                                            <?php foreach ($vo['child'] as $key => $v): ?>
                                                <input name="access_ids[]" type="checkbox" value="<?= $v['id'] ?>" level="2" <?php if (in_array($v['id'], $have_access)): ?>checked="checked"<?php endif; ?>/>&nbsp;<label><?= $v['title'] ?></label>
                                            <?php endforeach; ?>
                                        </dd>
                                    <?php endif; ?>
                                </dl>
                            <?php endforeach; ?>
                        </div>
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

<script>
    $(function(){
        $('input[level=1]').click(function(){
            var inputs=$(this).parents('.app').find('input');
            for (i = 0; i < inputs.length; i++) {
                if(this != inputs[i])
                {
                    inputs[i].checked=this.checked;     
                }
            }
        });
        $('input[level=2]').click(function(){
            var inputs=$(this).parents('dd').find('input');
            var arrParent=$(this).parents('.app').find('input[level=1]');
            if(this.checked)
            {
                if(arrParent.length >0)
                {
                    arrParent[0].checked= true;
                }
            }
            else
            {
                var isChecked = false;
                for (i = 0; i < inputs.length; i++) {
                    if(inputs[i] != this)
                    {
                        if(inputs[i].checked)
                        {
                            isChecked=true;
                            break;
                        }
                    }
                }
                if(!isChecked)
                {
                    if(arrParent.length >0)
                    {
                        arrParent[0].checked=false;
                    }
                }
            }
        });		
    })
</script>