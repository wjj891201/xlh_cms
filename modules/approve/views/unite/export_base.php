<?php
use yii\helpers\ArrayHelper;
$type = Yii::$app->request->get('type', 'base');
$info = (!empty($type) && $type == 'loan') ? '企业贷款申请表' : ((!empty($type) && $type == 'base') ? '企业入库申请表' : '其他');
?>
<style>
    table {font-family:微软雅黑; width:100% border-collapse:collapse; font-size:12px; border-color:#000000;}
    td {padding: 10px; line-height:35px;}
    p {text-align: left; margin-left:50px;}
    strong {text-align:center;}
</style>
<p align="center" style="font-size:20px;margin:0px 0px 10px 0px;"><strong><?= $info; ?></strong></p>
<table border="1" cellspacing="0">
    <tr>
        <td width="30" rowspan="14"><strong> 基本信息 </strong></td>
        <td width="170"><strong> 企业名称 </strong></td>
        <td width="440"><p> <?= $base['enterprise_name'] ?> </p></td>
    </tr>
    <tr>
        <td width="170"><strong> 所属区域 </strong></td>
        <?php $industry_arr = Yii::$app->params['industry']; ?>
        <?php $industry_arr = ArrayHelper::index($industry_arr, 'id'); ?>
        <td width="440"><p> <?= $base['district'] ?>-<?= $base['town']['name'] ?> </p></td>
    </tr>    
    <tr>
        <td width="170"><strong> 注册时间 </strong></td>
        <td width="440"><p> <?= $base['register_date'] ?> </p></td>
    </tr>
    <tr>
        <td width="170"><strong> 注册资本 </strong></td>
        <td width="440"><p> <?= $base['register_capital'] ?>（万元） </p></td>
    </tr>
    <tr>
        <td width="170"><strong> 法定代表人 </strong></td>
        <td width="440"><p> <?= $base['legal_person'] ?> </p></td>
    </tr>
    <tr>
        <td width="170"><strong> 法人联系方式 </strong></td>
        <td width="440"><p> <?= $base['legal_person_phone'] ?> </p></td>
    </tr>
    <tr>
        <td width="170"><strong> 组织机构代码 </strong></td>
        <td width="440"><p> <?= $base['institution_code'] ?> </p></td>
    </tr>
    <tr>
        <td width="170"><strong> 统一社会信用代码 </strong></td>
        <td width="440"><p> <?= $base['credit_code'] ?> </p></td>
    </tr>
    <tr>
        <td width="170"><strong> 通讯地址 </strong></td>
        <td width="440"><p> <?= $base['contact_address'] ?> </p></td>
    </tr>
    <tr>
        <td width="170"><strong> 联系人 </strong></td>
        <td width="440"><p> <?= $base['contact_person_man'] ?> </p></td>
    </tr>
    <tr>
        <td width="170"><strong> 联系电话 </strong></td>
        <td width="440"><p> <?= $base['contact_person_phone'] ?> </p></td>
    </tr>
    <tr>
        <td width="170"><strong> 电子邮箱 </strong></td>
        <td width="440"><p> <?= $base['contact_mail'] ?> </p></td>
    </tr>
    <tr>
        <td width="170"><strong> 行业 </strong></td>
        <td width="440"><p> <?= $industry_arr[$base['industry_id']]['name'] ?> </p></td>
    </tr>
    <tr>
        <td width="170"><strong> 企业简介 </strong></td>
        <td width="440"><p> <?= $base['enterprise_info'] ?> </p></td>
    </tr>
    <?php
        $finance_year     = $base['finance']['finance_year'];
        $previous_year    = !empty($finance_year) ? $finance_year - 1 : date('Y') - 2; //前年
        $before_last_year = !empty($finance_year) ? $finance_year : date('Y') - 1; //去年
        $last_year        = !empty($finance_year) ? $finance_year + 1 : date('Y'); //近一期
    ?>
    <tr>
        <td width="30" rowspan="9"><strong> 财务信息 </strong></td>
        <td width="170"><strong> <?= $finance_year ?>年销售收入 </strong></td>
        <td width="440"><p> <?= $base['finance']['annual_sales'] ?>（万元） </p></td>
    </tr>
    <tr>
        <td width="170"><strong> <?= $finance_year ?>年高新技术产品销售收入 </strong></td>
        <td width="440"><p> <?= $base['finance']['hightec_sales'] ?>（万元） </p></td>
    </tr>
    <tr>
        <td width="170"><strong> <?= $finance_year ?>年利润总额 </strong></td>
        <td width="440"><p> <?= $base['finance']['annual_profit'] ?>（万元） </p></td>
    </tr>
    <tr>
        <td width="170"><strong> <?= $finance_year ?>年研发经费投入 </strong></td>
        <td width="440"><p> <?= $base['finance']['research_input'] ?>（万元） </p></td>
    </tr>
    <tr>
        <td width="170"><strong> <?= $finance_year ?>年净资产 </strong></td>
        <td width="440"><p> <?= $base['finance']['net_asset'] ?>（万元） </p></td>
    </tr>
    <tr>
        <td width="170"><strong> <?= $finance_year ?>年资产负债率 </strong></td>
        <td width="440"><p> <?= $base['finance']['asset_debt_ratio'] ?>% </p></td>
    </tr>
    <tr>
        <td width="170"><strong> 员工总数 </strong></td>
        <td width="440"><p> <?= $base['finance']['total_employees_num'] ?>人 </p></td>
    </tr>
    <tr>
        <td width="170"><strong> 大专以上科技人员数 </strong></td>
        <td width="440"><p> <?= $base['finance']['above_college_num'] ?>人 </p></td>
    </tr>
    <tr>
        <td width="170"><strong> 直接从事研发人员数 </strong></td>
        <td width="440"><p> <?= $base['finance']['research_num'] ?>人 </p></td>
    </tr>

    <tr>
        <td width="30" rowspan="3"><strong> 企业概述 </strong></td>
        <td width="170"><strong> 主要产品及技术领域 </strong></td>
        <td width="440"><?= $base['describe']['product_tech_desc']; ?></td>
    </tr>
    <tr>
        <td width="170"><strong> 企业拥有自主知识产权数量 </strong></td>
        <td width="440"><?= $base['describe']['equity_num']; ?></td>
    </tr>
    <tr>
        <td width="170"><strong> 企业核心管理人员职业经历 </strong></td>
        <td width="440">
            <table>
                <?php $profession = !empty($base['describe']['profession']) ? json_decode($base['describe']['profession'],true) :[]; ?>
                <?php if(!empty($profession)):?>
                    <?php foreach($profession as $p=>$pv) :?>
                        <tr><td width="15%" align="right">姓名：</td><td width="85%" align="left"><?php echo $pv['name'] ? $pv['name'] : ''; ?></td></tr>
                        <tr><td width="15%" align="right">职位：</td><td width="85%" align="left"><?php echo $pv['position'] ? $pv['position'] : ''; ?></td></tr>
                        <tr><td width="15%" align="right">经历：</td><td width="85%" align="left"><?php echo $pv['experience'] ? $pv['experience'] : ''; ?></td></tr>
                    <?php endforeach;?>
                <?php endif;?>
            </table>
         </td>
    </tr>

    <?php if(!empty($type) && $type == 'loan'): ?>
    <tr>
        <td width="30" rowspan="3"><strong> 融资信息 </strong></td>
        <td width="170"><strong> 贷款金额 </strong></td>
        <td width="440"><?= $base['loan']['apply_amount']; ?></td>
    </tr>
    <tr>
        <td width="170"><strong> 贷款期限 </strong></td>
        <td width="440"><?= $base['loan']['period_month']; ?></td>
    </tr>
    <tr>
        <td width="170"><strong> 贷款用途 </strong></td>
        <td width="440"><?= $base['loan']['loan_purpose']; ?></td>
    </tr>

    <tr>
        <td width="30" rowspan="4"><strong> 银行批复信息 </strong></td>
        <td width="170"><strong> 授信金额 </strong></td>
        <td width="440"><?= $base['loan']['credit_amount'] . '万'; ?></td>
    </tr>
    <tr>
        <td width="170"><strong> 授信开始时间 </strong></td>
        <td width="440"><?= $base['loan']['credit_time']; ?></td>
    </tr>
    <tr>
        <td width="170"><strong> 授信截止时间 </strong></td>
        <td width="440"><?= $base['loan']['credit_validity']; ?></td>
    </tr>
    <tr>
        <td width="170"><strong> 已放款金额 </strong></td>
        <td width="440"><?= $base['loan']['already_loan_amount'] . '万'; ?></td>
    </tr>
    <?php endif; ?>
</table>