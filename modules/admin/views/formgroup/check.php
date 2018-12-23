<div id="dcMain"> <!-- 当前位置 -->
    <div id="urHere">管理中心</div>  
    <div id="index" class="mainBox" style="padding-top:18px;height:auto!important;height:550px;min-height:550px;">
        <div class="indexBox">
            <div class="boxTitle">留言查看</div>
            <ul>
                <table width="100%" border="0" cellspacing="0" cellpadding="7" class="tableBasic">
                    <?php foreach ($attlist as $key => $vo): ?>
                        <tr>
                            <td width="120"> <?= $vo['typename'] ?>： </td>
                            <td>
                                <?php if ($vo['inputtype'] == 'select' || $vo['inputtype'] == 'radio' || $vo['inputtype'] == 'checkbox'): ?>
                                    <?php foreach ($vo['attrvalue'] as $k => $v): ?>
                                        <?php if ($v['selected'] == 'selected'): ?><?= $v['name'] ?><?php endif; ?>
                                    <?php endforeach; ?>
                                <?php elseif ($vo['inputtype'] == 'datetime'): ?>
                                    <?= date('Y-m-d H:i:s', $vo['attrvalue']) ?>
                                <?php elseif ($vo['inputtype'] == 'img'): ?>
                                    <a href="<?= $vo['attrvalue'] ?>" style="color: #f00;">下载</a>
                                <?php else: ?>
                                    <?= $vo['attrvalue'] ?>
                                <?php endif ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </ul>
        </div>
    </div>
</div>