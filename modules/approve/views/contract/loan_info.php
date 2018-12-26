<style type="text/css">
ul, li, ol {list-style:none;list-style-type:none;zoom:1;}
.dialog_box {width:100%;margin:0 auto;font-size:13px;}
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

.zzsc{ width:100%;margin:0px auto;}
.zzsc .tab{ overflow:hidden; background:#ccc;}
.zzsc .tab a{ display:block; padding:10px 20px; float:left; text-decoration:none; color:#333;}
/*.zzsc .tab a:hover{ background:#E64E3F; color:#fff; text-decoration:none;}*/
.zzsc .tab a.on{ background:#E64E3F; color:#fff; text-decoration:none;}
.zzsc .content{ overflow:hidden; padding:10px;}
</style>

<div class="zzsc" id="loan_info_block" style="display:none;">
    <div class="tab">
        <a href="javascript:;" class="on">历史放款信息</a>
        <a href="javascript:;">填写放款信息</a>
    </div>
    <div class="content">
        <ul>
            <li class="show" style="display:block;">
                <div class="dialog_box loan_add_list">
                    <ul>
                        <li><label>贷款录入时间：</label><p>2018-10-10 10:15:59</p></li>
                        <li><label>贷款企业名称：</label><p>贸易有限公司</p></li>
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
            </li>
            <li class="show" style="display:none;">
                <div class="dialog_box">
                    <form class="form loan_add_from">
                        <ul style="border:0px;" class="loan_add_from_head">
                            <li><label>贷款企业名称：</label> <span>1</span></li>
                            <li><label>期望贷款金额：</label> <span>2</span>万 </li>
                            <li><label>期望贷款周期：</label> <span>3</span>个月</li>
                            <li><label>可用授信金额：</label> <span>4</span>万</li>
                        </ul>
                        <ul style="border:0px;">
                            <li>
                                <label>贷款合同号：</label>
                                <input type="text" name="contract_num" class="contract_num" placeholder="请输入合同编号">
                            </li>
                            <li>
                                <label>实际放贷金额：</label>
                                <input type="number" name="loan_amount_money" class="loan_amount_money" placeholder="请输入金额">万
                            </li>
                            <li>
                                <label>贷款开始时间：</label>
                                <input type="text" name="contract_loan_start_time" class="datepicker contract_loan_start_time" id="start_time" lay-key="1" readonly="readonly">
                            </li>
                            <li>
                                <label>贷款结束时间：</label>
                                <input type="text" name="contract_loan_end_time" class="datepicker contract_loan_end_time" id="end_time" lay-key="2" readonly="readonly">
                            </li>
                            <li>
                                <label>贷款周期：</label>
                                <input type="number" name="loan_day" class="loan_day" id="count_days" readonly="readonly"> 天
                            </li>
                            <li>
                                <label>贷款利率：</label>
                                <input type="number" name="loan_rate" class="loan_rate">  %
                            </li>
                            <li>
                                <label>基准利率：</label>
                                <input type="number" name="loan_benchmark_rate" class="loan_benchmark_rate"> %
                            </li>
                            <li>
                                <label>还款方式：</label>
                                <select name="repayment_mode" class="repayment_mode">
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
                                <input type="file" class="loan_voucher" id="loan_voucher_uploads" style="width: 184px;" onchange="set_loan_uploads(this);">
                                <input type="hidden" name="loan_voucher" id="loan_voucher">
                            </li>
                        </ul>
                        <input type="hidden" name="loan_id" id="loan_id">
                    </form>
                    <div class="btn"> <a class="loan_add" onclick="loan_add()">确认提交</a> </div>
                </div>

            </li>
        </ul>
    </div>
</div>

<script type="text/javascript">
// 添加放款信息
function loan_add(){
    $.ajaxSettings.async = false;
    $.post('/approve/contract/add-loan-info', $(".loan_add_from").serialize(), function(data){
        var code   = data.code;
        var msg    = data.msg;
        if(code == 200){
            layer.msg(msg, {icon: 1, time: 1500}, function(){
                window.location.reload();
            });
        }else if(code == 201){
            layer.msg(msg, {icon: 2, time: 1500});
            return false;
        }else if(code == 202){
            var key = data.msg.key;
            var val = data.msg.val;
            layer.tips(val, '.loan_add_from .'+key, {tips: [3, 'red'], time:2000});
            return false;
        }
    }, 'json'); 
   return false;
}

$(function(){
    // tab切换 mouseover
    $("#loan_info_block .tab a").click(function(){
        $(this).addClass('on').siblings().removeClass('on');
        var index = $(this).index();
        number = index;
        $('#loan_info_block .content .show').hide();
        $('#loan_info_block .content .show:eq('+index+')').show();
    });

    var loan_id = 0;
    $(".loan_info").click(function(){
        $("#loan_info_block").css('display', 'block');
        
        loan_id = $(this).data('loan_id');
        
        $(".loan_add_from")[0].reset();

        $.get('/approve/ajax/get-loan-info?loan_id='+loan_id+'&type_id=1', function(data){
            $(".loan_add_from_head").empty().html(data);
        }, 'html');
        
        $.get('/approve/ajax/get-loan-list?loan_id='+loan_id+'&type_id=1', function(data){
            $(".loan_add_list").empty().html(data);
        }, 'html');

        $(".loan_add_from #loan_id").val(loan_id);
        
        layer.open({
            type: 1,
            title: '放款信息',
            area: ['550px', '700px'],
            content: $("#loan_info_block"),
            success: function(){
                laydate.render({
                    elem: "#start_time",
                    done: function(value, date, endDate){ $('#start_time').change(); }
                });
                laydate.render({
                    "elem": "#end_time",
                    done: function(value, date, endDate){ $('#end_time').change(); }
                });
            }
        });

    });
});

// 监控时间日期选择
$(document).on('change', '#start_time', function(){
    set_count_days();
});

$(document).on('change', '#end_time', function(){
    set_count_days();
});

$(document).on('click', '#count_days', function(){
    set_count_days();
});

// 设置天数
function set_count_days(){
    var start_time = $("#start_time").val();
    var end_time   = $("#end_time").val();
    if(start_time !== '' && end_time !== ''){
        // console.log( start_time +' '+end_time);
        if(start_time > end_time){
            $("#start_time").val('');
            $("#count_days").val('');
            layer.tips('贷款结束时间不能大于开始时间', '#start_time', {tips: [3, 'red'], time:2000});
            return false;
        }
        $("#count_days").val(DateDiff(start_time, end_time));
        return true;
    }
    return false;
}

// 计算两个时间的天数
function DateDiff(sDate1, sDate2) {
    var  iDays;
    iDays = parseInt(Math.abs((new Date(sDate1)) - (new Date(sDate2))) / 1000 / 60 / 60 / 24);
    return iDays;
}

// 上传附件
function set_loan_uploads(obj){
    var formData = new FormData();
    formData.append("file", $("#loan_voucher_uploads")[0].files[0]);  
    $.ajax({
        url : '/approve/ajax/uploads',
        type : "POST",
        data : formData,
        dataType : "text",
        contentType : false,
        processData : false,
        success: function (data) {
            if(data !== ''){
                $("#loan_voucher").val(data);
            }
        }
    });
}
</script>