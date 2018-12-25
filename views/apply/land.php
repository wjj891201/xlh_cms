<?php

use yii\web\View;
use yii\helpers\Url;

$this->registerCssFile('@web/public/kjd/css/step2.css', ['depends' => ['app\assets\KjdAsset']]);
$this->registerCssFile('@web/public/kjd/css/land.css', ['depends' => ['app\assets\KjdAsset']]);
$this->registerCssFile('@web/public/kjd/css/apply_base.css', ['depends' => ['app\assets\KjdAsset']]);

# layer~~~start
$this->registerJsFile('@web/public/kjd/js/layer/layer.js', ['depends' => ['app\assets\KjdAsset'], 'position' => View::POS_HEAD]);
# layer~~~end

$this->title = '申请介绍';
$this->params['breadcrumbs'][] = $this->title;
$this->registerMetaTag(['name' => 'keywords', 'content' => '']);
$this->registerMetaTag(['name' => 'description', 'content' => ''], 'description');
?>
<div class="wrapper">
    <div class="titleBar mb20">
        <div class="main1200">
            <div class="bannerBg"></div>
        </div>
    </div>
    <!--介绍-->
    <div class="main1200 mb20 pb20">
        <img src="<?= $banner ?>" alt="" >
    </div>
    <!--文字介绍-->
    <div class="main1200 mt20">
        <div class="introBox">
            <h3 id="introTitle">南昌市科技金融支持企业必须具备以下基本条件：</h3>
            <div class="introContent" id="basicCondition">
                <p>1、申报企业为南昌市财政征管范围内注册登记、具有独立法人资格的高新技术企业、科技型中小企业;</p>
                <p>2、具有自主知识产权的技术或产品；拥有自主研发团队或产学研合作团队；资产和股权结构清晰，具备研发投入保障和债务偿还能力；具备实施项目管理的制度及能力; </p>
                <p>3、企业财务制度健全，管理规范;</p>
                <p>4、企业在“南昌市企业监管警示系统”中标示为红色警示的企业不在本次申报对象范围;</p>
                <p><i id="base_condition" class="choiceBtn choiceBtn1"></i>我已具备上述基本条件</p>
            </div>
            <h3>南昌市科技金融支持企业还须同时具备以下项目应具备的条件</h3>
            <div class="introContent" id="specialCondition">
                <p>1、项目符合国家、省、市产业政策，属于本指南明确的投资领域，带动作用大、示范性强;</p>
                <p>2、项目已经完成产品研发，产品和服务具有较强的市场竞争力和成长性，已经形成经营现金流或已取得有效的业务订单;</p>
                <p>3、项目拟申请股权投资及金额已经通过企业董事会或相应决策机构决议;</p>
                <p><i id="other_condition" class="choiceBtn choiceBtn1"></i>我已具备上述特定条件</p>
            </div>
            <div class="btn-group">
                <a href="javascript:void(0);" onclick="return add()" class="applyBtn" style="display: block">立即申请</a>
            </div>
            <div class="applyTip">已经申请过了？<a href="<?= Url::to(['member/enterprise-list']) ?>">查看申请进度</a></div>
        </div>
    </div>
</div>
<script>
    var $basic = $('#basicCondition').find('.choiceBtn');
    var $special = $('#specialCondition').find('.choiceBtn');
    $('.choiceBtn').on('click', function () {
        $(this).toggleClass('choosen');
    });
    function add() {
        if (!$basic.hasClass("choosen")) {
            layer.tips('请阅读并勾选基本条件', '#base_condition', {tips: [1, '#EA2000']});
            return false;
        }
        if (!$special.hasClass("choosen")) {
            layer.tips('请阅读并勾选特定条件', '#other_condition', {tips: [1, '#EA2000']});
            return false;
        }
        $.ajax({
            async: false,
            dateType: "json",
            type: 'post',
            data: {"_csrf": "<?= Yii::$app->request->csrfToken ?>"},
            url: '<?= Url::to(['apply/ajax-apply-check']) ?>',
            success: function (data) {
                switch (data)
                {
                    case '0':
                        // 未提交记录,可以申请
                        window.location.href = "<?= Url::to(['apply/apply-base']) ?>";
                        break;
                    case '1':
                        // 有已提交记录
                        window.location.href = "<?= Url::to(['member/enterprise-list']) ?>";
                        break;
                }
            }
        });
    }
</script>


