<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url; //使用Url类
?>
<script type="text/javascript" src="/layer/layer.js"></script>
<div id="dcMain">
    <!-- 当前位置 -->
    <div id="urHere">管理中心<b>></b><strong>广告位管理</strong> </div>  
    <!--提示消息 开始-->
    <?php if (Yii::$app->session->hasFlash('success')): ?>
        <div class="message success">
            <p><?= Yii::$app->session->getFlash('success') ?></p>
            <div class="close"></div>
        </div>
    <?php endif ?>
    <!--提示消息 结束-->
    <div class="mainBox imgModule">
        <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
            <tr>
                <th>添加广告位</th>
                <th>广告位列表</th>
            </tr>
            <tr>
                <td width="350" valign="top">
                    <?php
                    $form = ActiveForm::begin();
                    ?>
                    <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableOnebor">
                        <tr>
                            <td>
                                <b>广告位名称</b>
                                <?php echo $form->field($model, 'labelname')->textInput(['class' => 'inpMain', 'size' => 20])->label(false); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo Html::submitButton('提交', ['class' => 'btn']); ?>
                            </td>
                        </tr>
                    </table>
                    <?php ActiveForm::end(); ?>
                </td>
                <td valign="top">
                    <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableOnebor">
                        <tr>
                            <td>广告位名称</td>
                            <td width="80" align="center">操作</td>
                        </tr>
                        <?php foreach ($all_label as $key => $vo): ?>
                            <tr class="c_o">
                                <td><?= $vo['labelname'] ?></td>
                                <td align="center">
                                    <a href="<?php echo Url::to(['advert/adlist', 'type' => $vo['id']]); ?>">查看</a> |
                                    <a href="javascript:;" onclick="column_del(this,<?php echo $vo['id'] ?>)">删除</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </td>
            </tr>
        </table>
    </div>
</div>
<script type="text/javascript">
    function column_del(obj,id){
        layer.confirm('确认要删除该广告位吗？',function(index){
            $.ajax({
                type: "GET",
                url: "<?php echo URL::to(['column/del']); ?>",
                data: "id="+id,
                dataType: "json",
                success: function(data){
                    if(data==1){
                        $(obj).parents(".c_o").remove();
                        layer.msg('已成功删除!',{icon:1,time:1000});  
                    }
                }
            });
        });
    }
</script>