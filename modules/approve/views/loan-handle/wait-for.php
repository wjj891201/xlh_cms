<?php

use yii\helpers\Url;
use yii\widgets\LinkPager;
?>
<div class="main-bar">
    <div class="library-box">
        <div class="article2">
            <div class="tablebox">
                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper no-footer">
                    <table class="table4 dataTable no-footer" width="100%" border="0" cellspacing="0" cellpadding="0" id="DataTables_Table_0" role="grid" style="width: 100%;text-align: center;">
                        <thead>
                            <tr class="title table_thread" role="row">
                                <td class="sorting_disabled">序号</td>
                                <td class="sorting_disabled">企业名称</td>
                                <td class="sorting_disabled">企业法人</td>
                                <td class="sorting_disabled">联系方式</td>
                                <td class="sorting_disabled">注册时间</td>
                                <td class="sorting_disabled">操作</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data as $key => $vo): ?>
                                <tr>
                                    <td><?= $key + 1 ?></td>
                                    <td><?= $vo['enterprise_name'] ?></td>
                                    <td><?= $vo['legal_person'] ?></td>
                                    <td><?= $vo['legal_person_phone'] ?></td>
                                    <td><?= $vo['register_date'] ?></td>
                                    <td class="table_btn">
                                        <a href="javascript:void(0);">查看</a>
                                        <?php if ($vo['is_read'] != 1): ?>
                                            <?php foreach ($vo['actionList'] as $k => $v): ?>
                                                <a href="javascript:void(0);" data-workflow_log_id="<?= $vo['workflow_log_id'] ?>" data-action_key="<?= $v['action_key'] ?>" data-next_node_id="<?= $v['next_node_id'] ?>" class="<?= $v['action_key'] ?>"><?= $v['action_name'] ?></a>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="page">
                <?=
                LinkPager::widget([
                    'pagination' => $pages,
                    'prevPageLabel' => '上一页',
                    'nextPageLabel' => '下一页'
                ]);
                ?>
            </div>
        </div>
    </div>
</div>

<div class="dialog dialog_retract">
    <div class="dcontent">
        <form action="<?= Url::to(['unite/result']) ?>" method="post" class="form form_reason" onsubmit="return validate(this)">
            <ul>
                <li></li>
                <li>
                    <textarea name="comment" id="comment" class="retract_con" placeholder="请输入5~50字以内的原因"></textarea>
                </li>
            </ul>
            <div class="dbtn" style="padding-top: 10px;">
                <input name="_csrf" type="hidden" id="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
                <input type="hidden" name="workflow_log_id" value=""/>
                <input type="hidden" name="action_key" value=""/>
                <input type="hidden" name="next_node_id" value=""/>
                <button type="submit" class="dokay">确定</button> 
            </div>
        </form>
    </div>
</div>

<script>
    $(function () {
        $('.pass,.end,.back,.defer,.finish,.grant').click(function () {
            var attribute = $(this).attr('class');
            var workflow_log_id = $(this).data('workflow_log_id');
            var action_key = $(this).data('action_key');
            var next_node_id = $(this).data('next_node_id');
            var operate = $(this).html();
            if (attribute == 'pass' || attribute == 'finish') {
                layer.confirm('确认要通过吗？', {icon: 3, title: '提示', offset: '200px'}, function (index) {
                    if (next_node_id) {
                        location.href = "/approve/unite/result?workflow_log_id=" + workflow_log_id + "&action_key=" + action_key + "&next_node_id=" + next_node_id;
                    } else {
                        location.href = "/approve/unite/result?workflow_log_id=" + workflow_log_id + "&action_key=" + action_key;
                    }
                });
            } else {
                $('input[name=workflow_log_id]').attr('value', workflow_log_id);
                $('input[name=action_key]').attr('value', action_key);
                $('input[name=next_node_id]').attr('value', next_node_id);
                layer.open({
                    type: 1,
                    title: operate,
                    skin: 'layui-layer-rim',
                    area: ['500px', '265px'], //宽高
                    content: $('.dialog_retract').html(),
                    cancel: function (index, layero) {
                        $('#warn').empty();
                        layer.close(index);
                        return false;
                    }
                });
            }
        });
    });
    function validate(form) {
        if (form.comment.value == '') {
            layer.msg('请填写内容', {icon: 2, time: 1000});
            return false;
        }
    }
</script>