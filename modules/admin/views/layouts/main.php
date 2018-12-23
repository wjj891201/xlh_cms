<?php

use app\assets\AdminAsset;
use yii\helpers\Url; //使用Url类

AdminAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>后台管理首页</title>
        <?php $this->head() ?>
    </head>
    <body>
        <?php $this->beginBody() ?>
        <div id="dcWrap"> 
            <div id="dcHead">
                <div id="head">
                    <div class="logo"><a href="javascript:void(0);"><img src="/public/backend/images/dclogo.gif" alt="logo"></a></div>
                    <div class="nav">
                        <ul>
                            <li><a href="<?= Url::to(['system/config']) ?>">系统设置</a></li>
                            <li><a href="<?= Url::to(['pass/edit']) ?>">密码修改</a></li>
                        </ul>
                        <ul class="navRight">
                            <li class="M noLeft">
                                <a href="JavaScript:void(0);">您好，<?= Yii::$app->session['admin']['name']; ?></a>
                                <div class="drop mUser">
                                    <?php foreach ($this->params['all_lng'] as $key => $vo): ?>
                                        <a href="<?= Url::to(['setcookie/deal', 'lang' => $vo['lng']]); ?>"><?= $vo['lngtitle'] ?></a>
                                    <?php endforeach; ?>
                                </div>
                            </li>
                            <li class="noRight"><a href="<?= Url::to(['public/logout']); ?>">退出</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- dcHead 结束 --> 
            <div id="dcLeft">
                <div id="menu">
                    <ul class="top">
                        <li><a href="<?= Url::to(['default/index']); ?>"><i class="home"></i><em>管理首页</em></a></li>
                    </ul>
                    <ul>
                        <li><a href="<?= Url::to(['model/list']); ?>"><i class="caseCat"></i><em>内容模型管理</em></a></li>
                        <li><a href="<?= Url::to(['type/list']); ?>"><i class="articleCat"></i><em>分类管理</em></a></li>
                        <li><a href="<?= Url::to(['recommend/list']); ?>"><i class="nav"></i><em>推荐位管理</em></a></li>
                        <li><a href="<?= Url::to(['news/list']); ?>"><i class="product"></i><em>内容管理</em></a></li>
                    </ul>
                    <ul>
                        <li><a href="<?= Url::to(['adverttype/list']); ?>"><i class="theme"></i><em>广告位管理</em></a></li>
                        <li><a href="<?= Url::to(['advert/adlist']); ?>"><i class="show"></i><em>广告内容管理</em></a></li> 
                    </ul>
                    <!--<ul>
                            <li><a href="<? Url::to(['lng/list']); ?>"><i class="plugin"></i><em>多语言管理</em></a></li>
                        </ul>
                        <ul>
                            <li><a href="<? Url::to(['skin/list']); ?>"><i class="managerLog"></i><em>网站主题</em></a></li>
                        </ul>
                       <ul>
                            <li><a href="<? Url::to(['formgroup/list']); ?>"><i class="article"></i><em>自助表单管理</em></a></li>
                        </ul>-->
                    <ul>
                        <li><a href="<?= Url::to(['manage/list']); ?>"><i class="manager"></i><em>后台管理员</em></a></li>
                        <li><a href="<?= Url::to(['role/list']); ?>"><i class="system"></i><em>角色管理</em></a></li>
                        <li><a href="<?= Url::to(['access/list']); ?>"><i class="page"></i><em>权限管理</em></a></li>
                    </ul>
                    <ul>
                        <li><a href="<?= Url::to(['workflow/group-list']); ?>"><i class="backup"></i><em>流程组</em></a></li>       
                        <li><a href="<?= Url::to(['approve-user/organization-list']); ?>"><i class="order"></i><em>机构管理</em></a></li>
                        <li><a href="<?= Url::to(['approve-user/list']); ?>"><i class="downloadCat"></i><em>审批员</em></a></li>
                        <li><a href="<?= Url::to(['area/list']); ?>"><i class="guestbook"></i><em>地区管理</em></a></li>
                    </ul>
                </div>
            </div>

            <?= $content; ?>

            <div class="clear"></div>
            <div id="dcFooter">
                <div id="footer">
                    <div class="line"></div>
                    <ul>版权所有 © 2018 上海信隆行信息科技股份有限公司，并保留所有权利。</ul>
                </div>
            </div><!-- dcFooter 结束 -->
            <div class="clear"></div> 
        </div>
        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>