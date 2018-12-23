<?php

use yii\web\View;
use yii\helpers\Url;

$this->registerCssFile('@web/public/kjd/css/step2.css', ['depends' => ['app\assets\KjdAsset']]);

$this->title = '科技贷申请管理';
$this->params['breadcrumbs'][] = $this->title;
$this->registerMetaTag(['name' => 'keywords', 'content' => '']);
$this->registerMetaTag(['name' => 'description', 'content' => ''], 'description');
?>
<div class="wrapper">
    <div class="titleBar">
        <div class="main1200" style="height:75px"></div>
    </div>
    <!-- 贷款列表 start -->
    <div class="yirong_line"></div>
    <div class="wrapper member">
        <br/>
        <div class="member_crumb w1200"><a href="###">会员中心</a>  &gt;<strong>科技贷申请管理 </strong></div>
        <div class="mainContent">
            <div class="box">
                <div class="titleL">
                    <a class="on" href="javascript:void(0);">科技贷申请管理</a>
                    <a href="<?= Url::to(['member/enterprise-list']) ?>">科技资质认证管理</a>
                </div>
                <div class="tbox">
                    <table width="100%" border="0">
                        <?php foreach ($list as $key => $vo): ?>
                            <tbody>
                                <tr>
                                    <td colspan="5">
                                        <div class="title">
                                            <div class="left"><span class="gray">企业名称：</span>
                                                <span style="font-size: 14px;"><?= $vo['enterprise_name'] ?></span>
                                                <a class="view" href="">
                                                    <div class="viewLoan"><i></i>查看贷款信息</div>
                                                </a>
                                            </div>
                                            <div class="right">
                                                <span class="gray">申请时间：</span><?= $vo['loan_create_time'] ?> &nbsp;&nbsp;&nbsp;&nbsp;
                                                <span class="gray">状态：</span>
                                                <span class="red"><?= $vo['node_name'] ?>-<?= $vo['result_cn'] ?></span>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="first">
                                        <div class="border">
                                            南昌科技金融支持企业
                                            <br/>
                                            <span class="gray">贷款产品</span>
                                        </div>
                                    </td>
                                    <td class="common">
                                        <span class="num"><?= $vo['apply_amount'] ?></span>万
                                        <br/>
                                        <span class="gray">贷款金额</span>
                                    </td>
                                    <td class="common">
                                        <span class="num"><?= $vo['period_month'] ?></span>个月
                                        <br/>
                                        <span class="gray">贷款周期</span>
                                    </td>    
                                    <td class="common">xxx银行分行</td>
                                    <td class="last">
                                        <div class="border">
    <!--                                            <span class="num2">1000</span><span class="red2">万</span>
                                            <br/>
                                            <span class="gray">授信金额</span>-->
                                            <a class="edit btn" href="<?= Url::to(['member/loan-detail', 'base_id' => $vo['base_id']]) ?>">查看资料</a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="first">
                                        <div class="border" style="padding-top: 0">
                                            <table width="100%" border="0">
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <div class="succ"><i></i>授信成功</div>
                                                        </td>
                                                        <td>
                                                            <div class="unfull"><i></i>已全额放款</div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <span class="num2">0</span><span class="red2">万</span>
                                                            <br/>
                                                            <span class="gray">可用授信</span>
                                                        </td>
                                                        <td>
                                                            <span class="num2">1000</span><span class="red2">万</span>
                                                            <br/>
                                                            <span class="gray">已用授信</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div style="padding-top: 20px">
                                                                2018-12-31                                                                                    <br/>
                                                                <span class="gray">授信有效期</span>
                                                            </div>
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </td>
                                    <td colspan="4">
                                        <div class="loanBox">
                                            <div class="loan">
                                                <div class="info left">
                                                    <div class="title1">放贷信息<span>1</span></div>
                                                    <p>
                                                        贷款合同号：1000<br/> 
                                                        贷款合同金额：1000万元<br/> 
                                                        贷款合同开始时间：2018-12-01<br/> 
                                                        贷款合同截止时间：2018-12-31<br/> 
                                                        贷款利率：10%
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="status left">
                                                <img src="/public/kjd/images/i_paid.png">
                                            </div>
                                            <div class="loan" style="float: right;">
                                                <div class="info right" style="margin-right:60px">
                                                    <div class="title1">还款信息</div>
                                                    <p>
                                                        还款状态：按期还款<br/> 
                                                        还款开始时间：2018-12-01<br/> 
                                                        还款截止时间：2018-12-31<br/> 
                                                        预计还款天数：30 天<br/> 
                                                        还款凭证：
                                                        <a href="" download=""><i class="dicon"></i>下载</a>
                                                    </p>
                                                </div>
                                            </div>
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
    <!-- 贷款列表 end -->
</div>