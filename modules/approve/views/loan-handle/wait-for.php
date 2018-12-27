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
                                <td>序号</td>
                                <td>企业名称</td>
                                <td>区域名称</td>
                                <td>科技企业类型</td>
                                <td>贷款金额</td>
                                <td>贷款周期</td>
                                <td>受理银行</td>
                                <td>联系人</td>
                                <td>联系电话</td>
                                <td>申请资料</td>
                                <td>申请时间</td>
                                <td>操作</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data as $key => $vo): ?>
                                <tr>
                                    <td><?= $key + 1 ?></td>
                                    <td><?= $vo['enterprise_name'] ?></td>
                                    <td><?= $vo['town_name'] ?></td>
                                    <td>
                                        <?php $qualification = json_decode($vo['qualification_certificate'], true); ?>
                                        <?php foreach ($qualification as $k => $v): ?>
                                            【<?= $v['name'] ?>】
                                        <?php endforeach; ?>
                                    </td>
                                    <td><?= $vo['apply_amount'] ?></td>
                                    <td><?= $vo['period_month'] ?></td>
                                    <td><?= $vo['bank_name'] ?></td>
                                    <td><?= $vo['contact_person_man'] ?></td>
                                    <td><?= $vo['contact_person_phone'] ?></td>
                                    <td><a href="<?= Url::to(['unite/get-info', 'base_id' => $vo['base_id'], 'type' => 'loan']) ?>">详情</a></td>
                                    <td><?= $vo['base_create_time'] ?></td>
                                    <td class="table_btn">
                                        <a class="stream" data-app_id="<?= $vo['app_id'] ?>" data-group_id="<?= $vo['group_id'] ?>" href="javascript:void(0);">查看</a>
                                        <?php if ($vo['is_read'] != 1): ?>
                                            <?php foreach ($vo['actionList'] as $k => $v): ?>
                                                <a href="javascript:void(0);" data-loan_id="<?= $vo['loan_id']; ?>" data-workflow_log_id="<?= $vo['workflow_log_id'] ?>" data-action_key="<?= $v['action_key'] ?>" data-next_node_id="<?= $v['next_node_id'] ?>" class="<?= $v['action_key'] ?>"><?= $v['action_name'] ?></a>
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

<style type="text/css">
    ul, li, ol {list-style:none;list-style-type:none;}
    .grant_form {width:500px;margin:0 auto;}
    .grant_form ul li {height:30px;width:auto;margin-bottom:15px;margin-bottom:10px;}
    .grant_form ul label {display:inline-block;width:35%;text-align:right;height:30px;float:left;margin-right:7px;line-height:30px;}
    .grant_form ul li span {line-height: 30px;}
</style>
<div class="dialog dialog_grant">
    <div class="dcontent">
        <form action="<?= Url::to(['unite/result']) ?>" method="post" class="form form_reason grant_form">
            <ul id="grant_head_info">
                <li><label>贷款企业名称</label><span>1</span></li>
                <li><label>期望贷款金额</label><span>2万元</span></li>
                <li><label>期望贷款周期</label><span>3个月</span></li>
            </ul> 
            <ul>
                <li><label>授信金额</label><span><input type="text" name="credit_amount" class="credit_amount"></span>万元</li>
                <li><label>授信时间</label><span><input type="text" name="credit_time" id="start_time" class="datepicker credit_time"></span></li>
                <li><label>授信有效期</label><span><input type="text" name="credit_validity" id="end_time" class="datepicker credit_validity"></span></li>
            </ul>
            <div class="clear"></div>

            <div class="dbtn" style="padding-top: 10px;">
                <input name="_csrf" type="hidden" id="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
                <input type="hidden" name="workflow_log_id" value="" class="workflow_log_id" />
                <input type="hidden" name="action_key" value="" class="action_key"/>
                <input type="hidden" name="next_node_id" value="" class="next_node_id"/>
                <input type="hidden" name="loan_id" value="" class="loan_id"/>
                <button type="submit" class="dokay">确定</button> 
            </div>
        </form>
    </div>
</div>
<?= $this->render('/contract/stream'); ?>

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
            } else if (attribute == 'grant') {
                var loan_id = $(this).data('loan_id');
                $(".grant_form .loan_id").val(loan_id);

                $(".grant_form .workflow_log_id").val(workflow_log_id);
                $(".grant_form .action_key").val(action_key);
                $(".grant_form .next_node_id").val(next_node_id);

                $.get('/approve/ajax/get-loan-info?loan_id=' + loan_id, function (data) {
                    $("#grant_head_info").empty().html(data);
                }, 'html');

                layer.open({
                    type: 1,
                    title: operate,
                    skin: 'layui-layer-rim',
                    area: ['500px', '380px'],
                    content: $('.dialog_grant'),
                    cancel: function (index, layero) {
                        $('#warn').empty();
                        layer.close(index);
                        return false;
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
                    area: ['500px', '280px'], //宽高
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
    // 选择时间
    laydate.render({
        elem: '#start_time'
    });
    laydate.render({
        elem: '#end_time'
    });

    $(".grant_form .dokay").click(function () {
        $.ajaxSettings.async = false;
        $.post("<?= Url::to(['unite/result']) ?>", $(".grant_form").serialize(), function (data) {
            var status = data.status;
            var msg = data.msg
            if (status) {
                layer.msg(msg, {icon: 1, time: 1500}, function () {
                    window.location.reload();
                });
            } else {
                layer.tips(msg.val, '.grant_form .' + msg.key, {tips: [3, 'red'], time: 2000});
                return false;
            }
        }, "json");
        return false;
    });
</script>