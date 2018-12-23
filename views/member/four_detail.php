<?php

use yii\web\View;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

$this->registerCssFile('@web/public/kjd/css/step2.css', ['depends' => ['app\assets\KjdAsset']]);

$this->title = '资质详情';
$this->params['breadcrumbs'][] = $this->title;
$this->registerMetaTag(['name' => 'keywords', 'content' => '']);
$this->registerMetaTag(['name' => 'description', 'content' => ''], 'description');
?>
<div class="wrapper">
    <div class="titleBar">
        <div class="main1200" style="height: 80px;"></div>
    </div>
    <!-- 贷款列表 start -->
    <div class="yirong_line"></div>
    <div class="wrapper member">
        <br>
        <?php $title = $this->context->action->id == 'base-detail' ? '入库资料管理' : '科技贷资料管理'; ?>
        <?php $url = $this->context->action->id == 'base-detail' ? Url::to(['member/enterprise-list']) : Url::to(['member/loan-list']); ?>
        <div class="member_crumb w1200">
            <a href="">会员中心</a>  &gt;<strong><?= $title ?></strong>
        </div>
        <div class="mainContent">
            <div class="box">
                <div class="titleL">
                    <a class="on" href="<?= $url ?>"><?= $title ?></a>
                </div>
                <div class="infoArea">
                    <div class="mainBar p4025">
                        <h3 class="mb15">基本信息</h3>
                        <ul>
                            <?php $industry_arr = Yii::$app->params['industry']; ?>
                            <?php $industry_arr = ArrayHelper::index($industry_arr, 'id'); ?>
                            <li><label>企业名称：</label><?= $base['enterprise_name'] ?></li>
                            <li><label>所属区域：</label><?= $base['district'] ?>-<?= $base['town']['name'] ?></li>
                            <li><label>注册时间：</label><?= $base['register_date'] ?></li>
                            <li><label>注册资本：</label><?= $base['register_capital'] ?>（万元）</li>
                            <li><label>法定代表人：</label><?= $base['legal_person'] ?></li>
                            <li><label>法人联系方式：</label><?= $base['legal_person_phone'] ?></li>
                            <li><label>组织机构代码：</label><?= $base['institution_code'] ?></li>
                            <li><label>统一社会信用代码：</label><?= $base['credit_code'] ?></li>
                            <li><label>通讯地址：</label><?= $base['contact_address'] ?></li>
                            <li><label>联系人：</label><?= $base['contact_person_man'] ?></li>
                            <li><label>联系电话：</label><?= $base['contact_person_phone'] ?></li>
                            <li><label>电子邮箱：</label><?= $base['contact_mail'] ?></li>
                            <li><label>行业：</label><?= $industry_arr[$base['industry_id']]['name'] ?></li>
                            <li><label>企业简介：</label><div class="inforight lin30"><?= $base['enterprise_info'] ?></div></li>
                            <li>
                                <label class="labelM">营业执照：</label>
                                <div class="inforight">
                                    <ul class="attach">
                                        <li><a href="<?= Url::to(['member/download-guide-files', 'type' => 2, 'file' => $base['business_licence']]) ?>"><i class="ficon"></i>营业执照文件</a></li>
                                    </ul>
                                </div>
                            </li>
                        </ul>     
                    </div>
                    <div class="mainBar p4025 ">
                        <h3 class="mb15">财务信息</h3>
                        <ul>
                            <?php
                            $finance_year = $base['finance']['finance_year'];
                            $previous_year = !empty($finance_year) ? $finance_year - 1 : date('Y') - 2; //前年
                            $before_last_year = !empty($finance_year) ? $finance_year : date('Y') - 1; //去年
                            $last_year = !empty($finance_year) ? $finance_year + 1 : date('Y'); //近一期
                            ?>
                            <li><label><?= $finance_year ?>年销售收入：</label><?= $base['finance']['annual_sales'] ?>（万元）</li>
                            <li><label><?= $finance_year ?>年高新技术产品销售收入：</label><?= $base['finance']['hightec_sales'] ?>（万元）</li>
                            <li><label><?= $finance_year ?>年利润总额：</label><?= $base['finance']['annual_profit'] ?>（万元）</li>
                            <li><label><?= $finance_year ?>年研发经费投入：</label><?= $base['finance']['research_input'] ?>（万元）</li>
                            <li><label><?= $finance_year ?>年净资产：</label><?= $base['finance']['net_asset'] ?>（万元）</li>
                            <li><label><?= $finance_year ?>年资产负债率：</label><?= $base['finance']['asset_debt_ratio'] ?>%</li>
                            <li><label>员工总数：</label><?= $base['finance']['total_employees_num'] ?>人</li>
                            <li><label>大专以上科技人员数：</label> <?= $base['finance']['above_college_num'] ?>人</li>
                            <li><label>直接从事研发人员数：</label> <?= $base['finance']['research_num'] ?>人 </li>
                        </ul>
                    </div>
                    <div class="mainBar p4025">
                        <h3 class="mb15">企业概述</h3>
                        <ul>
                            <li><label>主要产品及技术领域：</label><div class="inforight lin30"><?= $base['describe']['product_tech_desc'] ?></div></li>
                            <li><label>企业拥有自主知识产权数量：</label><?= $base['describe']['equity_num'] ?></li>
                            <li>
                                <label>企业核心管理人员：</label>
                                <?php $profession = json_decode($base['describe']['profession'], true); ?>
                                <div class="ribor labelM">
                                    <?php foreach ($profession as $key => $vo): ?>
                                        <ul class="experlist" style="border-bottom:none;">
                                            <li><label style="width:80px">姓名：</label><?= $vo['name'] ?></li>
                                            <li><label style="width:80px">职位：</label><?= $vo['position'] ?></li>
                                            <li><label style="width:80px">经历：</label><?= $vo['experience'] ?></li>
                                        </ul>
                                    <?php endforeach; ?>
                                    <div style="clear:both"></div>
                                </div>
                            </li>
                            <li>
                                <label>企业拥有资质：</label>
                                <?php $qualification_certificate = json_decode($base['describe']['qualification_certificate'], true); ?>
                                <div class="inforight">
                                    <ul class="attach">
                                        <?php foreach ($qualification_certificate as $key => $vo): ?>
                                            <li><a href="<?= Url::to(['member/download-guide-files', 'type' => 2, 'file' => $vo['path']]) ?>"><i class="ficon"></i><?= $vo['name'] ?></a></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <?php if ($this->context->action->id == 'loan-detail'): ?>
                        <div class="mainBar p4025">
                            <h3 class="mb15">融资信息</h3>
                            <ul>
                                <li>
                                    <label>贷款申请信息：</label>
                                    <div class="ribor labelM">
                                        <ul class="experlist" style="border-bottom:none">
                                            <li><label style="width:120px">申请金额：</label><?= $base['loan']['apply_amount'] ?>万 </li>
                                            <li><label style="width:120px">申请期限：</label><?= $base['loan']['period_month'] ?>个月 </li>
                                            <li><label style="width:120px">贷款用途：</label><?= $base['loan']['loan_purpose'] ?></li>
                                        </ul>
                                    </div>
                                </li>     
                            </ul>
                        </div>
                    <?php endif; ?>
                    <div class="mainBar p4025 " style="border:none">
                        <h3 class="mb15">相关附件</h3>
                        <?php $system = Yii::$app->params['system']; ?>
                        <?php $system = ArrayHelper::index($system, 'id'); ?>
                        <ul>
                            <?php if (substr($base['register_date'], 0, 4) <= $previous_year): ?>
                                <li><label><?= $previous_year ?>年度企业适用会计制度：</label><?= $system[$base['finance']['accounting_system_before']]['name'] ?></li>
                                <li>
                                    <label class="labelM"><?= $previous_year ?>年度税务报表：</label>
                                    <div class="inforight">
                                        <ul class="attach">
                                            <li><a href="<?= Url::to(['member/download-guide-files', 'type' => 2, 'file' => $base['finance']['asset_debt_file_before']]) ?>"><i class="ficon"></i>资产负债表</a></li>
                                            <li><a href="<?= Url::to(['member/download-guide-files', 'type' => 2, 'file' => $base['finance']['profit_distribution_file_before']]) ?>"><i class="ficon"></i>利润及利润分配表</a></li>
                                        </ul>
                                    </div>
                                </li>
                            <?php endif; ?>
                            <li><label><?= $before_last_year ?>年度企业适用会计制度：</label><?= $system[$base['finance']['accounting_system']]['name'] ?></li>
                            <li>
                                <label class="labelM"><?= $before_last_year ?>年度税务报表：</label>
                                <div class="inforight">
                                    <ul class="attach">
                                        <li><a href="<?= Url::to(['member/download-guide-files', 'type' => 2, 'file' => $base['finance']['asset_debt_file']]) ?>"><i class="ficon"></i>资产负债表</a></li>
                                        <li><a href="<?= Url::to(['member/download-guide-files', 'type' => 2, 'file' => $base['finance']['profit_distribution_file']]) ?>"><i class="ficon"></i>利润及利润分配表</a></li>
                                    </ul>
                                </div>
                            </li>
                            <li><label>近一期企业适用会计制度：</label><?= $system[$base['finance']['accounting_system_lastest']]['name'] ?></li>
                            <li>
                                <label class="labelM">近一期税务报表：</label>
                                <div class="inforight">
                                    <ul class="attach">
                                        <li><a href="<?= Url::to(['member/download-guide-files', 'type' => 2, 'file' => $base['finance']['asset_debt_file_lastest']]) ?>"><i class="ficon"></i>资产负债表</a></li>
                                        <li><a href="<?= Url::to(['member/download-guide-files', 'type' => 2, 'file' => $base['finance']['profit_distribution_file_lastest']]) ?>"><i class="ficon"></i>利润及利润分配表</a></li>
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