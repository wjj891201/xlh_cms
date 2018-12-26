<style type="text/css">
ul, li, ol {list-style:none;list-style-type:none;zoom:1;}
.dialog_box {width:100%;margin:0 auto;font-size:13px;}
.dialog_box ul {border-top:2px solid #EEEEEE;margin-bottom:20px;margin-top:10px;}
.dialog_box li {margin-bottom:10px;}
.dialog_box li label {width:181px;text-align:right;display:inline-block;color:#666;vertical-align:top;}
.dialog_box li p {display:inline-block;vertical-align:top;width:250px;color:#666;}
.dialog_box li a {cursor:pointer;color:#4479cf;}

.contract{ width:100%;margin:0px auto;}
.contract .tab{ overflow:hidden; background:#ccc;}
.contract .tab a{ display:block; padding:10px 20px; float:left; text-decoration:none; color:#333;}
/*.zzsc .tab a:hover{ background:#E64E3F; color:#fff; text-decoration:none;}*/
.contract .tab a.on{ background:#E64E3F; color:#fff; text-decoration:none;}
.contract .content{ overflow:hidden; padding:10px;}
</style>

<div class="contract" style="display:none;">
    <div class="tab">
        <a href="javascript:;" class="on">历史放款信息</a>
        <a href="javascript:;">历史还款信息</a>
    </div>
    <div class="content">
        <ul>
            <li class="show" style="display:block;">
                <div class="dialog_box contract_loan"></div>
            </li>
            <li class="show" style="display:none;">
                <div class="dialog_box contract_repayment"></div>
            </li>
        </ul>
    </div>
</div>
<script type="text/javascript">
$(function(){
    // tab切换 mouseover
    $(".contract .tab a").click(function(){
        $(this).addClass('on').siblings().removeClass('on');
        var index = $(this).index();
        $('.contract .content .show').hide();
        $('.contract .content .show:eq('+index+')').show();
    });

    $(".contract_info").click(function(){
        var loan_id = $(this).data('loan_id');

        $(".contract_repayment").empty();
        $(".contract_loan").empty();
        $(".contract").css('display', 'block');
        
        $.get('/approve/ajax/get-repayment-list?loan_id='+loan_id+'&type_id=1', function(data){
            $(".contract_repayment").empty().html(data);
        }, 'html');
        
        $.get('/approve/ajax/get-loan-list?loan_id='+loan_id+'&type_id=1', function(data){
            $(".contract_loan").empty().html(data);
        }, 'html');
        
        layer.open({
            type: 1,
            title: '放款信息',
            area: ['550px', '700px'],
            content: $(".contract"),
        });
    });
});
</script>