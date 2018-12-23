<style type="text/css">
ul, li, ol {list-style:none;list-style-type:none;zoom:1;}
.dialog_box {width:90%;margin:0 auto;font-size:13px;}
.dialog_box ul {border-top:2px solid #EEEEEE;margin-bottom:20px;margin-top:10px;}
.dialog_box li {margin-bottom:10px;}
.dialog_box li label {width:181px;text-align:right;display:inline-block;color:#666;vertical-align:top;}
.dialog_box li p {display:inline-block;vertical-align:top;width:250px;color:#666;}
.dialog_box li a {cursor:pointer;color:#4479cf;}

.form input[type='text'], 
.form input[type='number'], 
.form select, 
.form file{border:none;background:none;border:1px solid #ccc;height:30px;line-height:30px;width:200px;text-indent:10px;margin-right:6px;}
.btn {padding-top:15px;text-align:center;}
.btn a {background:#419be9;font-size: 16px;width: 120px;height:40px;line-height:40px;margin-right:15px;border-radius:3px;color:#fff;border:none;cursor:pointer;display:inline-block;bottom:0;margin:10px auto;
}
</style>
<div class="dialog dialog_loan_list">
    <div class="dialog_box">
        <ul>
            <li><label>贷款录入时间：</label><p>2018-10-10 10:15:59</p></li>
            <li><label>贷款企业名称：</label><p>上海方正拓康贸易有限公司</p></li>
            <li><label>期望贷款金额：</label><p>100万</p></li>
            <li><label>期望贷款周期：</label><p>12月</p></li>
            <li><label>贷款合同号：</label><p>213221</p></li>
            <li><label>实际放贷金额：</label><p>52.57万</p></li>
            <li><label>贷款开始时间：</label><p>2018-10-01</p></li>
            <li><label>贷款结束时间：</label><p>2019-10-01</p></li>
            <li><label>贷款周期：</label><p>365天</p></li>
            <li><label>贷款利率：</label><p>3%</p></li>
            <li><label>基准利率：</label><p>3%</p></li>
            <li><label>还款方式：</label><p>等本等息</p></li>
            <li><label>受理银行：</label><p>农业银行</p></li>
        </ul>
    </div>
</div>
<div class="dialog dialog_loan_form">
    <div class="dialog_box">
        <form class="form loan_add_from">
            <ul>
                <li>
                    <label>贷款企业名称：</label>
                    <span id="enterprise_name">三川智慧科技股份有限公司</span></li>
                <li>
                    <label>期望贷款金额：</label>
                    <span id="apply_amount">110</span>万 </li>
                <li>
                    <label>期望贷款周期：</label>
                    <span id="period_month">2</span>个月</li>
                <li>
                    <label>可用授信金额：</label>
                    <span id="already_loan_amount">110</span>万</li>
                <li>
                    <label>受理银行：</label>
                    <span id="bank_name">徽商银行支行</span>
                </li>
                <li>
                    <label>贷款合同号：</label>
                    <input type="text" name="contract_num" placeholder="请输入合同编号">
                </li>
                <li>
                    <label>实际放贷金额：</label>
                    <input type="number" name="loan_amount_money" placeholder="请输入金额">万
                </li>
                <li>
                    <label>贷款开始时间：</label>
                    <input type="text" name="contract_loan_start_time" class="datepicker hasDatepicker">
                </li>
                <li>
                    <label>贷款结束时间：</label>
                    <input type="text" name="contract_loan_end_time">
                </li>
                <li>
                    <label>贷款周期：</label>
                    <input type="number" name="loan_day"> 天
                </li>
                <li>
                    <label>贷款利率：</label>
                    <input type="number" name="loan_rate">
                </li>
                <li>
                    <label>基准利率：</label>
                    <input type="number" name="loan_benchmark_rate"> %
                </li>
                <li>
                    <label>还款方式：</label>
                    <select name="repayment_mode">
                        <option value="0">请选择</option>
                        <option value="1">先息后本</option>
                        <option value="2">等额本息</option>
                        <option value="3">等额本金</option>
                        <option value="4">等本等息</option>
                        <option value="5">灵活还款</option>
                        <option value="6">随借随还</option>
                        <option value="7">一次性还本付息</option>
                    </select>
                </li>
                <li>
                    <label>请上传放款凭证：</label>
                    <input type="file" name="loan_voucher" style="width: 184px;">
                </li>
            </ul>
        </form>
        <div class="btn"> <a class="loan_add"">确认提交</a> </div>
    </div>
</div>

<script type="text/javascript">
$(function(){
    var loan_id = 0;
    $(".loan_info").click(function(){
        loan_id = $(this).data('loan_id');

        layer.tab({
            area:['500px', '700px'],
            tab:[
                {title: '历史放款信息',content: $(".dialog_loan_list").html()},
                {title: '填写放款信息',content: $(".dialog_loan_form").html()}
            ]
        });
    });

    
});


$(".loan_add").click(function(){
    alert('ddddd');
});
</script>