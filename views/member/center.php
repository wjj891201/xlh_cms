<?php

use yii\helpers\Url;

$this->title = '个人中心-账号管理';
$this->params['breadcrumbs'][] = $this->title;
$this->registerMetaTag(['name' => 'keywords', 'content' => '']);
$this->registerMetaTag(['name' => 'description', 'content' => ''], 'description');
?>
<div class="gbox" style="padding-top: 20px">
    <div class="wrapper member">
        <div class="member_crumb w1200"><a href="###">会员中心</a> &gt;<a href="###">设置</a> &gt;<strong>账号管理</strong></div>
        <div class="mainContent">
            <div class="box">
                <div class="tab">
                    <div class="nav titleL">
                        <ul>
                            <li class="current"><a class="on" href="javascript:void(0);">账号管理</a></li>
                            <li><a href="<?= Url::to(['member/psw'])?>">密码管理</a></li>
                        </ul>
                    </div>
                    <div class="content">
                        <ul>
                            <li>
                                <div class="forget_password" style="margin-left: 345px;margin-top: 0">
                                    <ul>
                                        <li>
                                            <label>注册类型：</label>企业
                                        </li>
                                        <li>
                                            <label>注册手机号码：</label>
                                            <?= substr_replace(Yii::$app->session['member']['username'], '****', 3, 4); ?>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

