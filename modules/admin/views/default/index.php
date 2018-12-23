<div id="dcMain"> 
    <!-- 当前位置 -->
    <div id="urHere">管理中心</div>  
    <div id="index" class="mainBox" style="padding-top:18px;height:auto!important;height:550px;min-height:550px;">
        <div class="indexBox">
            <div class="boxTitle">服务器信息</div>
            <ul>
                <table width="100%" border="0" cellspacing="0" cellpadding="7" class="tableBasic">
                    <tr>
                        <td width="120" valign="top">PHP 版本：</td>
                        <td valign="top"> <?= PHP_VERSION ?> </td>
                        <td width="100" valign="top">MySQL 版本：</td>
                        <td valign="top"> 5.0.11 </td>
                        <td width="100" valign="top">服务器操作系统：</td>
                        <td valign="top"> <?= php_uname('s')?> </td>
                    </tr>
                    <tr>
                        <td valign="top">文件上传限制：</td>
                        <td valign="top">2M</td>
                        <td valign="top">GD 库支持：</td>
                        <td valign="top"><?php if(function_exists('imagecreate')):?>支持<?php else:?>不支持<?php endif;?></td>
                        <td valign="top">Web 服务器：</td>
                        <td valign="top"></td>
                    </tr>
                </table>
            </ul>
        </div>
        <div class="indexBox">
            <div class="boxTitle">系统开发</div>
            <ul>
                <table width="100%" border="0" cellspacing="0" cellpadding="7" class="tableBasic">
                    <tr>
                        <td width="120"> 信隆行： </td>
                        <td><a href="http://www.easyrong.com/" target="_blank">http://www.easyrong.com/</a></td>
                    </tr>
                    <tr>
                        <td> 开发者： </td>
                        <td> 上海信隆行信息科技股份有限公司</td>
                    </tr>
                    <tr>
                        <td> 系统使用协议： </td>
                        <td><em>企业定制开发</em></td>
                    </tr>
                </table>
            </ul>
        </div>
    </div>
</div>