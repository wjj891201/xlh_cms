<?php

use yii\helpers\Url;
?>
<div id="special_here" style="display: none;">
    <div class="main-bar" style="margin: 0px; padding: 10px 0;background: none;">
        <div class="tablebox">
            <table class="table4 dataTable no-footer" width="100%">
                <thead>
                    <tr class="table_thread" role="row">
                        <td class="sorting_disabled" style="width: 25%;">审核机构</td>
                        <td class="sorting_disabled" style="width: 25%;">审核结果</td>
                        <td class="sorting_disabled" style="width: 25%;">原因</td>
                        <td class="sorting_disabled" style="width: 25%;">操作时间</td>
                    </tr>
                </thead>
                <tbody id="put_here"></tbody>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        $(".stream").click(function () {
            var app_id = $(this).data("app_id");
            var group_id = $(this).data("group_id");
            $.ajax({
                url: '<?= Url::to(['ajax/get-stream']) ?>',
                async: false,
                dateType: "json",
                type: 'post',
                data: {'_csrf': '<?= Yii::$app->request->csrfToken ?>', 'app_id': app_id, 'group_id': group_id},
                success: function (result) {
                    var obj = JSON.parse(result);
                    var html = '';
                    $.each(obj, function (index, item) {
                        html += '<tr>';
                        html += '<td align="center">' + item.organization_name + '</td>';
                        html += '<td align="center">' + item.node_name + item.result_ch + '</td>';
                        html += '<td align="center" style="color:#E30011;">' + item.comment + '</td>';
                        html += '<td align="center">' + item.create_time + '</td>';
                        html += '</tr>';
                    });
                    $('#put_here').append(html);
                }
            });
            layer.open({
                type: 1,
                title: '审核记录',
                area: ['800px', '300px'],
                content: $("#special_here"),
                end: function () {
                    $('#put_here').empty();
                }
            });
        });
    });
</script>