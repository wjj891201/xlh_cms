<div id="dcMain">
    <!-- 当前位置 -->
    <div id="urHere">管理中心<b>></b><strong>留言查看</strong> </div>   
    <div class="mainBox" style="height:auto!important;height:550px;min-height:550px;">
        <div class="idTabs">
            <div class="items">
                <div id="main">
                    <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
                        <tr>
                            <td align="right" width="131">姓名</td>
                            <td width="35%"><?= $detail['name'] ?></td>
                            <td align="right" width="131">联系电话</td>
                            <td width="35%"><?= $detail['telphone'] ?></td>
                        </tr>
                        <tr>
                            <td align="right">地址</td>
                            <td colspan="3"><?= $detail['address'] ?></td>
                        </tr>
                        <tr>
                            <td align="right">电子邮箱</td>
                            <td><?= $detail['email'] ?></td>
                            <td align="right">添加日期</td>
                            <td><?= $detail['createtime'] ?></td>
                        </tr>
                        <tr>
                            <td align="right">意见或建议</td>
                            <td colspan="3"><?= $detail['mark'] ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>