<?php

use yii\web\View;
use yii\helpers\Url;

$this->registerCssFile('@web/public/backend/js/kindeditor/themes/default/default.css', ['depends' => ['app\assets\AdminAsset']]);
$this->registerJsFile('@web/public/backend/js/jquery.tab.js', ['depends' => ['app\assets\AdminAsset'], 'position' => View::POS_HEAD]);
$this->registerJsFile('@web/public/backend/js/kindeditor/kindeditor.js', ['depends' => ['app\assets\AdminAsset'], 'position' => View::POS_HEAD]);
$this->registerJsFile('@web/public/backend/js/kindeditor/lang/zh_CN.js', ['depends' => ['app\assets\AdminAsset'], 'position' => View::POS_HEAD]);
$this->registerJsFile('@web/public/backend/js/jquery.validate.js', ['depends' => ['app\assets\AdminAsset'], 'position' => View::POS_HEAD]);
?>
<script>
    KindEditor.ready(function (K) {
        var editor = K.editor();
        $("#upload-image-logo").click(function () {
            editor.loadPlugin("image", function () {
                editor.plugin.imageDialog({
                    showRemote: false,
                    clickFn: function (url) {
                        $("#logo").val(url);
                        $(".fileupload-preview").html('<img src="' + url + '" style="width:200px;height:150px;"/>');
                        editor.hideDialog();
                    }
                });
            });
        });
    });
</script>
<div id="dcMain">
    <div id="urHere">管理中心<b>></b><strong>系统设置</strong></div>
    <div class="mainBox" style="height:auto!important;height:550px;min-height:550px;">
        <?= $this->render('../set/prompt.php'); ?>
        <div class="idTabs">
            <ul class="tab">
                <li><a href="#main">常规设置</a></li>
            </ul>
            <div class="items">
                <form action="<?= Url::to(['system/todo']) ?>" id="thisConfig" method="post" enctype="multipart/form-data">
                    <div id="main">
                        <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
                            <tr>
                                <th width="20%">名称</th>
                                <th colspan="2">内容</th>
                            </tr>
                            <tr>
                                <td align="right">网站名称</td>
                                <td colspan="2">
                                    <input type="text" name="sitename" value="<?= !empty($info['sitename']) ? $info['sitename'] : '' ?>" size="80" class="inpMain" />
                                </td>
                            </tr>
                            <tr>
                                <td align="right">关键字</td>
                                <td colspan="2">
                                    <input type="text" name="keyword" value="<?= !empty($info['keyword']) ? $info['keyword'] : '' ?>" size="80" class="inpMain" />
                                </td>
                            </tr>
                            <tr>
                                <td align="right">网站简介</td>
                                <td colspan="2">
                                    <input type="text" name="description" value="<?= !empty($info['description']) ? $info['description'] : '' ?>" size="80" class="inpMain" />
                                </td>
                            </tr>
                            <tr>
                                <td align="right">ICP备案</td>
                                <td colspan="2">
                                    <input type="text" name="icpbeian" value="<?= !empty($info['icpbeian']) ? $info['icpbeian'] : '' ?>" size="80" class="inpMain" />
                                </td>
                            </tr>
                            <tr>
                                <td align="right">Logo图片</td>
                                <td style="width: 40%;">
                                    <div class="fileupload-preview thumbnail">
                                        <?php if (empty($info['logo'])): ?>
                                            <img src="/public/backend/images/upload.png"/>
                                        <?php else: ?>
                                            <img src="<?= $info['logo'] ?>" width="200" height="150"/>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td>
                                    <button id="upload-image-logo" type="button" class="btn">选择图片</button>
                                    <input type="hidden" value="<?= !empty($info['logo']) ? $info['logo'] : '' ?>" id="logo" name="logo"/>
                                </td>
                            </tr>
                            <tr>
                                <td align="right">是否关闭网站</td>
                                <td colspan="2">
                                    <label for="site_closed_0">
                                        <input type="radio" name="site_closed" id="site_closed_0" value="1" checked="true"> 开启
                                    </label>
                                    &nbsp;&nbsp;&nbsp;
                                    <label for="site_closed_1">
                                        <input type="radio" name="site_closed" id="site_closed_1" value="0"> 关闭
                                    </label>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
                        <tr>
                            <td width="20%"></td>
                            <td>
                                <input class="btn" type="submit" value="提交" />
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        $(".idTabs").idTabs();
        $('#thisConfig').validate({
            ignore: [],
            rules: {
                sitename: 'required',
                keyword: 'required',
                description: 'required',
                icpbeian: 'required',
                thumb: 'required'
            },
            messages: {
                sitename: '网站名称必填',
                keyword: '关键字必填',
                description: '网站简介必填',
                icpbeian: 'ICP备案必填',
                thumb: 'Logo图片必填'
            }
        });
    });
</script>
