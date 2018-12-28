<?php 
use yii\web\View;
use yii\helpers\Url;
use yii\widgets\LinkPager;
$this->registerCssFile('@web/public/approve/css/data.css', ['depends'=>['app\assets\ApproveAsset'], 'position'=>View::POS_HEAD]);
?>
    <div class="mbox">
        <div class="article2">
            <!-- 修改内容 -->
            <div class="box3" style="border: none">
                <h3>选择需要导出的数据项</h3>
            </div>
            <div class="moreSelectContent">
                <div class="reportContent">
                    <input type="hidden" name="report_type" id="report_type" value="">
                    <input type="hidden" name="report_create" id="report_create" value="0">
                    <?php
                        $result = array();
                        foreach($column_name as $val) $result[$val['cate']][] = $val;
                        $lunm = array(1=>'注册信息', 2=>'基本情况', 3=>'财务数据', 4=>'服务数据');
                    ?>
                    <?php foreach($result as $key => $val): ?>
                    <div class="report_wr">
                        <span class="report_title_left"><span class="report_word"><?php echo $lunm[$key]; ?></span></span>
                        <div class="report_title_right">
                            <div class="shortcut">
                                <label class="shortcut_all"><i data-value="0"></i>全选</label>
                                <label class="shortcut_reverse"><i data-value="0"></i>反选</label>
                            </div>
                            <div class="click_area">
                                <?php foreach($val as $k => $v): ?>
                                <label <?php if(in_array($v['id'], $default_column_name)): ?>class="dontcheck"<?php endif; ?>>
                                    <i id="report_type_<?php echo $v['id']; ?>" data-value="<?php echo $v['id']; ?>" <?php if(in_array($v['id'], $default_column_name)): ?>class="myreportchecked"<?php endif; ?>></i>
                                    <?php echo $v['title']?>
                                </label> 
                                <?php endforeach; ?>    
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <div class="buttons_div">
                    <div class="btn_u">
                        <a href="javascript:void(0)" class="reportbutton">生成所选内容</a>
                        <a href="javascript:void(0)" class="export_excel">导出所选内容</a>
                        <a class="resert_checkbox">重置条件</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="main-bar">
        <div class="library-box">
            <div class="article2">
                <div class="tablebox table_style">
                    <div class="table_overflow" style="width: 100%;overflow-x: auto;border: 1px solid #eee;min-height: 413px;">
                        <table cellspacing="0" cellpadding="0" style="min-width: 1100px;width: 100%;font-size:14px;">
                            <thead>
                                <tr class="title">
                                <?php if(!empty($table)): ?>
                                    <?php foreach($table as $key => $v): ?>
                                    <td style="min-width: 100px;"><?php echo $v; ?></td>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($data)):?>
                                    <?php foreach($data as $key => $val): ?>
                                        <tr role="row">
                                            <?php foreach($name as $field): ?>
                                            <td style="min-width: 100px;"><?php echo $val[$field]; ?></td>
                                            <?php endforeach; ?>
                                        </tr>
                                    <?php endforeach;?>
                                <?php endif;?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="page">
                    <?=
                    LinkPager::widget([
                        'pagination' => $pages,
                        'prevPageLabel' => '上一页',
                        'nextPageLabel' => '下一页'
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>

<script>
$('.moreSelectContent label').on('click', function() {
    var $I = $(this).children('i'),
        data_value = $I.attr('data-value');
    $I.toggleClass('myreportchecked');
});

$('.resert_checkbox').on('click',function(){
    $('.moreSelectContent label').not('.dontcheck').each(function(){

        $(this).find('i').removeClass('reportchecked');
        $(this).find('i').removeClass('myreportchecked');
    });
    $(".moreSelectContent").trigger('click');
});
$('.mtable tbody tr:eq(0)').css('border-top','none');
$('.moreSelectContent .dontcheck').unbind('click');
$('.moreSelectContent .dontcheck >i').addClass('reportchecked');

function getParm(name){
    var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
    var r = window.location.search.substr(1).match(reg);
    if(r!=null)return unescape(r[2]); return null;
}

var column = getParm('column');
if(column){
    var arr = column.split(",");
    for(i in arr){
        $("#report_type_"+arr[i]).addClass('myreportchecked');
    }
}


var arr = [];
$(".reportchecked").each(function(i,n){
    arr.push($(this).attr('data-value'));
});
$(".myreportchecked").each(function(i,n){
    arr.push($(this).attr('data-value'));
});


$(".reportbutton").click(function(){
    var arr = [];
    $(".reportchecked").each(function(i,n){
        arr.push($(this).attr('data-value'));
    });
    $(".myreportchecked").each(function(i,n){
        arr.push($(this).attr('data-value'));
    });
    $("#report_create").val(1);
    window.location.href="<?= Url::to(['unite/base-data-info']); ?>?column="+arr.join(",");
});

$(".export_excel").click(function(){
    var arr = [];
    $(".reportchecked").each(function(i,n){
        arr.push($(this).attr('data-value'));
    });
    $(".myreportchecked").each(function(i,n){
        arr.push($(this).attr('data-value'));
    });

    $("#report_create").val(1);

    window.location.href="<?= Url::to(['unite/base-data-info', 'export'=>'execl']); ?>&column="+arr.join(",");
});

// 全选
$(document).on('click', '.shortcut .shortcut_all', function() {
    $('.shortcut .shortcut_reverse').find("i").removeClass('myreportchecked');
    var click_area = $(this).parents('.report_title_right').find('.click_area label').not('.dontcheck'),
        status = $(this).children('i').attr('class').toLocaleLowerCase();
    if (status == 'myreportchecked') {
        click_area.each(function(i, n) {
            $(this).children('i').addClass('myreportchecked');
        });
    } else {
        click_area.each(function(i, n) {
            $(this).children('i').removeClass('myreportchecked');
        });
    }
});
//反选
$(document).on('click', '.shortcut .shortcut_reverse', function() {
    $('.shortcut .shortcut_all').find("i").removeClass('myreportchecked');
    var click_area = $(this).parents('.report_title_right').find('.click_area label').not('.dontcheck'),
        status = $(this).children('i').attr('class').toLocaleLowerCase();
    click_area.each(function(i, n) {
        $(this).children('i').toggleClass('myreportchecked');
    });

});
//重置结果
$('.resert_checkbox').on('click', function() {
    $('.moreSelectContent label').not('.dontcheck').each(function() {
        $(this).find('i').removeClass('myreportchecked');
    });
});
</script>