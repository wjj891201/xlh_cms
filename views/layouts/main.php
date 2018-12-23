<?php

use app\assets\KjdAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\Type;
use app\models\Advert;

KjdAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>

    <body>
        <?php $this->beginBody() ?>
        <!--header-->
        <div class="top1">
            <div class="box1">
                <div class="logo1">
                    <a href="../"><img src="<?= $this->params['config']['logo'] ?>" style="margin-top:40px"></a>
                </div>
                <?php if ($this->context->action->id == 'login'): ?>
                    <p class="header_title">欢迎登录</p>
                <?php endif; ?>
                <div class="nav1"></div>
                <div class="user1_logedin">
                    <img src="/public/kjd/images/top2.png"/>
                    <ul>
                        <a href="<?= Url::to(['member/loan-list']) ?>"><li><i class="icon1"></i>会员中心<i class="arrow1"></i></li></a>
                        <a href="<?= Url::to(['member/center']) ?>"><li><i class="icon2"></i>设置<i class="arrow1"></i></li></a>
                        <?php if (Yii::$app->session['member']['isLogin'] == 1): ?>
                            <a href="<?= Url::to(['public/logout']) ?>"><li><i class="icon3"></i>退出登录<i class="arrow1"></i></li></a>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="clear"></div>
        <!--content-->
        <div style="min-height: 600px;">
            <?= $content ?>
        </div>
        <!--footer-->
        <div class="footer1 bottom0">
            <div class="wraper1">
                主办单位：南昌市科学技术局&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;技术支持：上海信隆行信息科技股份有限公司（一融网）
            </div>
        </div> 
        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
