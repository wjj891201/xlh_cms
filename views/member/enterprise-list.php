<?php

use yii\web\View;
use yii\helpers\Url;

$this->registerCssFile('@web/public/kjd/css/step2.css', ['depends' => ['app\assets\KjdAsset']]);

$this->title = '科技资质认证管理';
$this->params['breadcrumbs'][] = $this->title;
$this->registerMetaTag(['name' => 'keywords', 'content' => '']);
$this->registerMetaTag(['name' => 'description', 'content' => ''], 'description');
?>
<div class="wrapper">
    <div class="titleBar ">
        <div class="main1200" style="height:75px"></div>
    </div>
    <!-- 资质列表 start -->
    <div class="yirong_line"></div>
    <div class="wrapper member">
        <br/>
        <div class="member_crumb w1200"><a href="###">会员中心</a>  &gt;<strong>科技资质认证管理</strong></div>
        <div class="mainContent">
            <div class="box">
                <div class="titleL">
                    <a href="<?= Url::to(['member/loan-list']) ?>">科技贷申请管理</a>
                    <a class="on" href="javascript:void(0);">科技资质认证管理</a>
                </div>
                <div class="tbox">
                    <table width="100%" border="0">

                        <?php foreach ($list as $key => $vo): ?>
                            <tbody>
                                <tr>
                                    <td colspan="5">
                                        <div class="title">
                                            <div class="left">
                                                <span class="gray">企业名称：</span>
                                                <span style="font-size: 14px;"><?= $vo['enterprise_name'] ?></span>
                                                <a class="view" href="">
                                                    <div class="viewLoan "><i></i>查看资质信息</div>
                                                </a>
                                            </div>
                                            <div class="right">
                                                <span class="gray">申请时间：</span><?= $vo['base_create_time'] ?> &nbsp;&nbsp;&nbsp;&nbsp;
                                                <span class="gray">状态：</span>
                                                <span class="red"><?= $vo['node_name'] ?>-<?= $vo['result_cn'] ?></span>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="first">
                                        <div class="border">南昌科技金融支持企业</div>
                                    </td>
                                    <td class="common">
                                        <span><?= $vo['district'] ?>-<?= $vo['town_name'] ?></span>
                                        <br/>
                                        <span class="gray">所属区域</span>
                                    </td>
                                    <td class="common">
                                        <?= $vo['base_update_time'] ?>        
                                        <br/>
                                        <span class="gray">更新时间</span>
                                    </td>
                                    <td class="common">
                                        <span><?= $vo['legal_person_phone'] ?></span>
                                        <br/>
                                        <span class="gray">联系方式</span>
                                    </td>
                                    <td class="last">
                                        <div class="border">
                                            <a class="edit btn" href="<?= Url::to(['member/base-detail', 'base_id' => $vo['base_id']]) ?>">查看资料</a>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        <?php endforeach; ?>

                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- 资质列表 end -->
</div>