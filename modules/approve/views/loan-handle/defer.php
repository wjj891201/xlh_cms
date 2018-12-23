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
                                        <?php if (Yii::$app->approvr_user->identity->id == $vo['approve_user_id']): ?>
                                            <?php foreach ($actionList as $k => $v): ?>
                                                <?php if ($v['action_key'] != 'defer'): ?>
                                                    <a href="<?= Url::to(['handle/result', 'workflow_log_id' => $vo['workflow_log_id'], 'action_key' => $v['action_key'], 'next_node_id' => $v['next_node_id']]) ?>"><?= $v['action_name'] ?></a>
                                                <?php endif; ?>
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