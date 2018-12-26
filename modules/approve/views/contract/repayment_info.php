<div class="zzsc" id="repayment_info_block" style="display:none;">
    <div class="tab">
        <a href="javascript:;" class="on">历史还款信息</a>
        <a href="javascript:;">填写还款信息</a>
    </div>
    <div class="content">
        <ul>
            <li class="show" style="display:block;">
                <div class="dialog_box repayment_add_list"></div>
            </li>
            <li class="show" style="display:none;">
                <div class="dialog_box">
                    <form class="form repayment_add_from">
                        <ul style="border:none;">
                            <li>
                                <label>贷款合同号：</label>
                                <select id="contract_id" name="contract_id">
                                    <option value="">请选择</option>
                                </select>
                            </li>
                            <li>
                                <label>还款状态：</label>
                                <select id="repayment_status" name="repayment_status">
                                    <option value="">请选择</option>
                                    <option value="1">按期还款</option>
                                    <option value="2">提前还款</option>
                                    <option value="3">延期还款</option>
                                    <option value="4">已逾期</option>
                                </select>
                            </li>
                            <li>
                                <label>还款开始时间：</label>
                                <input id="contract_repayment_start_time" name="contract_repayment_start_time" type="text" class="datepicker" readonly="readonly">
                            </li>
                            <li>
                                <label>还款截止时间：</label>
                                <input id="contract_repayment_end_time" name="contract_repayment_end_time" type="text" class="datepicker" readonly="readonly">
                            </li>
                            <li>
                                <label>预计还款天数：</label>
                                <input id="repayment_days" name="repayment_days" type="number" readonly="true" readonly="readonly"> 天
                            </li>
                            <li>
                                <label>请上传还款凭证：</label>
                                <input id="repayment_voucher" type="file" style="width: 184px;" onchange="set_repayment_uploads();">
                                <input id="hidden_repayment_voucher" name="repayment_voucher" type="hidden">
                            </li>
                        </ul>
                        <input type="hidden" name="loan_id" id="loan_id">
                    </form>
                    <div class="btn"> <a class="loan_add" onclick="repayment_add()">确认提交</a> </div>
                </div>

            </li>
        </ul>
    </div>
</div>

<script type="text/javascript">
// 添加放款信息
    function repayment_add() {
        $.ajaxSettings.async = false;
        $.post('/approve/contract/add-repayment-info', $(".repayment_add_from").serialize(), function (data) {
            var code = data.code;
            var msg = data.msg;
            if (code == 200) {
                layer.msg(msg, {icon: 1, time: 1500}, function () {
                    window.location.reload();
                });
            } else if (code == 201) {
                layer.msg(msg, {icon: 2, time: 1500});
                return false;
            } else if (code == 202) {
                var key = data.msg.key;
                var val = data.msg.val;
                layer.tips(val, '.repayment_add_from #' + key, {tips: [3, 'red'], time: 2000});
                return false;
            }
        }, 'json');
        return false;
    }

    $(function () {
        // tab切换 mouseover
        $("#repayment_info_block .tab a").click(function () {
            $(this).addClass('on').siblings().removeClass('on');
            var index = $(this).index();
            number = index;
            $('#repayment_info_block .content .show').hide();
            $('#repayment_info_block .content .show:eq(' + index + ')').show();
        });

        var loan_id = 0;
        $(".repayment_info").click(function () {
            $("#contract_id").empty();
            $(".repayment_add_list").empty();
            $("#repayment_info_block").css('display', 'block');

            loan_id = $(this).data('loan_id');

            $(".repayment_add_from")[0].reset();

            $.get('/approve/ajax/get-repayment-info?loan_id=' + loan_id + '&type_id=1', function (data) {
                $("#contract_id").empty().html(data);
            }, 'html');

            $.get('/approve/ajax/get-repayment-list?loan_id=' + loan_id + '&type_id=1', function (data) {
                $(".repayment_add_list").empty().html(data);
            }, 'html');

            $(".repayment_add_from #loan_id").val(loan_id);

            layer.open({
                type: 1,
                title: '放款信息',
                area: ['550px', '700px'],
                content: $("#repayment_info_block"),
                success: function () {
                    laydate.render({
                        elem: "#contract_repayment_start_time",
                        done: function (value, date, endDate) {
                            $('#contract_repayment_start_time').change();
                        }
                    });
                    laydate.render({
                        "elem": "#contract_repayment_end_time",
                        done: function (value, date, endDate) {
                            $('#contract_repayment_end_time').change();
                        }
                    });
                }
            });

        });

        // 监控时间日期选择
        $('#contract_repayment_start_time,#contract_repayment_end_time').change(function () {
            set_repayment_days();
        });

    });

// 设置天数
    function set_repayment_days() {
        var start_time = $("#contract_repayment_start_time").val();
        var end_time = $("#contract_repayment_end_time").val();
        if (start_time !== '' && end_time !== '') {
            // console.log( start_time +' '+end_time);
            if (start_time > end_time) {
                $("#contract_repayment_start_time").val('');
                $("#repayment_days").val('');
                layer.tips('贷款结束时间不能大于开始时间', '#start_time', {tips: [3, 'red'], time: 2000});
                return false;
            }
            $("#repayment_days").val(repaymentDateDiff(start_time, end_time));
            return true;
        }
        return false;
    }

// 计算两个时间的天数
    function repaymentDateDiff(sDate1, sDate2) {
        var iDays;
        iDays = parseInt(Math.abs((new Date(sDate1)) - (new Date(sDate2))) / 1000 / 60 / 60 / 24);
        return iDays;
    }

// 上传附件
    function set_repayment_uploads(obj) {
        var formData = new FormData();
        formData.append("file", $("#repayment_voucher")[0].files[0]);
        $.ajax({
            url: '/approve/ajax/uploads',
            type: "POST",
            data: formData,
            dataType: "text",
            contentType: false,
            processData: false,
            success: function (data) {
                if (data !== '') {
                    $("#hidden_repayment_voucher").val(data);
                }
            }
        });
    }
</script>