<?php

use yii\web\View;
use yii\helpers\Url;

$this->registerCssFile('@web/public/kjd/css/step2.css', ['depends' => ['app\assets\KjdAsset']]);

$this->title = '科技贷申请管理';
$this->params['breadcrumbs'][] = $this->title;
$this->registerMetaTag(['name' => 'keywords', 'content' => '']);
$this->registerMetaTag(['name' => 'description', 'content' => ''], 'description');

# layer~~~start
$this->registerJsFile('@web/public/kjd/js/layer/layer.js', ['depends' => ['app\assets\KjdAsset'], 'position' => View::POS_HEAD]);
# layer~~~end
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
                                                <span class="red">
                                                    <?php if (empty($vo['organization_name'])): ?>
                                                        待银行受理
                                                    <?php else: ?>
                                                        <?php if (empty($vo['result'])): ?>
                                                            待<?= $vo['organization_name'] ?><?= $vo['node_name'] ?>
                                                        <?php else: ?>
                                                            <?= $vo['organization_name'] ?><?= $vo['result_cn'] ?>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                </span>
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
                                    <td class="common">
                                        <?= $vo['bank_name'] ?>
                                        <br/>
                                        <span class="gray">贷款银行</span>
                                    </td>
                                    <td class="last">
                                        <div class="border">
                                            <?php if ($vo['result'] == 'grant'): ?>
                                                <span class="num2"><?= $vo['credit_amount'] ?></span><span class="red2">万</span>
                                                <br/>
                                                <span class="gray">授信金额</span>
                                            <?php elseif ($vo['result'] == 'end'): ?>
                                                <a class="reasonBtn btn" data-log-id="<?= $vo['log_id'] ?>" href="javascript:void(0);">终止原因</a>
                                            <?php elseif ($vo['result'] == 'back'): ?>
                                                <a class="reasonBtn btn" data-log-id="<?= $vo['log_id'] ?>" href="javascript:void(0);">退回原因</a>
                                            <?php else: ?>
                                                <a class="edit btn" href="<?= Url::to(['member/loan-detail', 'base_id' => $vo['base_id']]) ?>">查看资料</a>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>

                                <?php if ($vo['result'] == 'grant'): ?>
                                    <tr>
                                        <td class="first">
                                            <div class="border" style="padding-top: 0">
                                                <table width="100%" border="0">
                                                    <tbody>
                                                        <tr>
                                                            <td><div class="succ"><i></i>授信成功</div></td>
                                                            <td>
                                                                <div class="unfull">
                                                                    <i></i>
                                                                    <?php if (!empty($vo['already_loan_amount']) && !empty($vo['credit_amount']) && $vo['already_loan_amount'] < $vo['credit_amount']): ?>
                                                                        未全额放款
                                                                    <?php elseif ($vo['already_loan_amount'] == $vo['credit_amount']): ?>
                                                                        已全额放款
                                                                    <?php else: ?>
                                                                        待放款
                                                                    <?php endif; ?>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <span class="num2"><?= $vo['credit_amount'] - $vo['already_loan_amount'] ?></span><span class="red2">万</span>
                                                                <br/>
                                                                <span class="gray">可用授信</span>
                                                            </td>
                                                            <td>
                                                                <span class="num2"><?= $vo['already_loan_amount'] ?></span><span class="red2">万</span>
                                                                <br/>
                                                                <span class="gray">已用授信</span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2">
                                                                <div style="padding-top: 20px">
                                                                    <?= $vo['credit_validity'] ?>
                                                                    <br/>
                                                                    <span class="gray">授信有效期</span>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </td>
                                        <td colspan="4">
                                            <?php foreach ($vo['loan_repay'] as $k => $v): ?>
                                                <div class="loanBox">
                                                    <div class="loan">
                                                        <div class="info left">
                                                            <div class="title1">放贷信息<span><?= $k + 1 ?></span></div>
                                                            <p>
                                                                贷款合同号：<?= $v['contract_num'] ?><br/> 
                                                                贷款合同金额：<?= $v['loan_amount_money'] ?>万元<br/> 
                                                                贷款合同开始时间：<?= $v['contract_loan_start_time'] ?><br/> 
                                                                贷款合同截止时间：<?= $v['contract_loan_end_time'] ?><br/> 
                                                                贷款利率：<?= $v['loan_rate'] ?>%
                                                            </p>
                                                        </div>
                                                    </div>

                                                    <?php if (!empty($v['loan_contract_status']) && $v['loan_contract_status'] == 1): ?>
                                                        <div class="status left"><img src="/public/kjd/images/i_paid.png"></div>
                                                    <?php else: ?>
                                                        <div class="status left"><img src="/public/kjd/images/i_paying.png"></div>
                                                    <?php endif; ?>

                                                    <?php if (!empty($v['loan_contract_status']) && $v['loan_contract_status'] == 1): ?>
                                                        <div class="loan" style="float: right;">
                                                            <div class="info right" style="margin-right:60px">
                                                                <div class="title1">还款信息</div>
                                                                <?php $repayment_status_arr = [1 => '按期还款', 2 => '提前还款', 3 => '延期还款', 4 => '已逾期']; ?>
                                                                <p>
                                                                    还款状态：<?= $repayment_status_arr[$v['repayment_status']] ?><br/> 
                                                                    还款开始时间：<?= $v['contract_repayment_start_time'] ?><br/> 
                                                                    还款截止时间：<?= $v['contract_repayment_end_time'] ?><br/> 
                                                                    预计还款天数：<?= $v['repayment_days'] ?> 天<br/> 
                                                                    还款凭证：<a href="<?= Url::to(['member/download-guide-files', 'type' => 2, 'file' => $v['repayment_voucher']]) ?>"><i class="dicon"></i>下载</a>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    <?php endif; ?>

                                                </div>
                                            <?php endforeach; ?>
                                        </td>
                                    </tr>
                                <?php endif; ?>

                            </tbody>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- 贷款列表 end -->
</div>

<div class="reason_detail" style="display: none;">
    <div class="dialog">
        <div class="dcontent info" >
            <div class="reason_list" id="reason"></div>
        </div>
    </div> 
</div>
<script>
    $(function () {
        $(".reasonBtn").click(function () {
            var log_id = $(this).data("log-id");
            var title = $(this).html();
            $.ajax({
                url: '<?= Url::to(['member/get-reason']) ?>',
                async: false,
                dateType: "json",
                type: 'post',
                data: {'_csrf': '<?= Yii::$app->request->csrfToken ?>', 'log_id': log_id},
                success: function (result) {
                    var obj = JSON.parse(result);
                    $('#reason').html(obj.comment);
                }
            });
            aaa = layer.open({
                type: 1,
                title: title,
                skin: 'layui-layer-rim',
                area: ['400px', '290px'],
                content: $('.reason_detail'),
                end: function () {
                    $('#reason').empty();
                }
            });
        });
    });
</script>