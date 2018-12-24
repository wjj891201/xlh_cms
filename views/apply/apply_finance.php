<?php

use yii\bootstrap\ActiveForm;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;

$this->registerCssFile('@web/public/kjd/css/apply.css', ['depends' => ['app\assets\KjdAsset']]);
$this->registerCssFile('@web/public/kjd/css/apply_base.css', ['depends' => ['app\assets\KjdAsset']]);
$this->registerCssFile('@web/public/kjd/css/apply_style.css', ['depends' => ['app\assets\KjdAsset']]);
$this->registerCssFile('@web/public/kjd/css/easy.css', ['depends' => ['app\assets\KjdAsset']]);

# layer~~~start
$this->registerJsFile('@web/public/kjd/js/layer/layer.js', ['depends' => ['app\assets\KjdAsset'], 'position' => View::POS_HEAD]);
# layer~~~end
$this->title = '认定资料填写-第二步';
$this->params['breadcrumbs'][] = $this->title;
$this->registerMetaTag(['name' => 'keywords', 'content' => '']);
$this->registerMetaTag(['name' => 'description', 'content' => ''], 'description');
?>
<div class="wrapper">
    <div class="titleBar">
        <div class="main1200">
            <a ><img src="/public/kjd/images/edit.jpg" height="80" width="217" alt=""></a>
        </div>
    </div>
    <div class="main1200 steps">
        <img src="/public/kjd/images/s2.png" alt="">
        <ul>
            <li class="first">基本信息</li>
            <li class="second">财务信息</li>
            <li class="third">企业概述</li>
            <li class="last">贷款信息</li>
        </ul>
    </div>
    <div class="main1200 pb5">
        <div class="mainBar pt50 pl100 pr50 pb20 mb20">
            <h3 class="mb15">财务信息</h3>
            <?php $form = ActiveForm::begin(['options' => ['id' => 'step2', 'enctype' => 'multipart/form-data']]); ?>
            <div class="content_form">
                <ul class="step2box">
                    <?= $form->field($model, 'finance_year')->hiddenInput(['value' => $data['last_year']])->label(false); ?>
                    <li class="optional_li" <?php if ($model->accounting_system != 3): ?>style='display:none;'<?php endif; ?>>
                        <label><?= $data['last_year'] ?>年度销售收入：</label>
                        <?= $form->field($model, 'annual_sales', ['template' => "{input} (万元){error}", 'errorOptions' => ['class' => 'msg']])->textInput(['id' => 'annual_sales'])->label(false); ?>
                    </li>
                    <li>
                        <label>高新技术产品销售收入：</label>
                        <?= $form->field($model, 'hightec_sales', ['template' => "{input} (万元){error}", 'errorOptions' => ['class' => 'msg']])->textInput(['id' => 'hightec_sales'])->label(false); ?>
                    </li>
                    <li class="optional_li" <?php if ($model->accounting_system != 3): ?>style='display:none;'<?php endif; ?>>
                        <label><?= $data['last_year'] ?>年度利润总额：</label>
                        <?= $form->field($model, 'annual_profit', ['template' => "{input} (万元){error}", 'errorOptions' => ['class' => 'msg']])->textInput(['id' => 'annual_profit'])->label(false); ?>
                    </li>
                    <li>
                        <label>研发经费投入：</label>
                        <?= $form->field($model, 'research_input', ['template' => "{input} (万元){error}", 'errorOptions' => ['class' => 'msg']])->textInput(['id' => 'research_input'])->label(false); ?>
                    </li>
                    <li class="optional_li" <?php if ($model->accounting_system != 3): ?>style='display:none;'<?php endif; ?>>
                        <label><?= $data['last_year'] ?>年度净资产：</label>
                        <?= $form->field($model, 'net_asset', ['template' => "{input} (万元){error}", 'errorOptions' => ['class' => 'msg']])->textInput(['id' => 'net_asset'])->label(false); ?>
                    </li>
                    <li class="optional_li" <?php if ($model->accounting_system != 3): ?>style='display:none;'<?php endif; ?>>
                        <label><?= $data['last_year'] ?>年度资产负债率：</label>
                        <?= $form->field($model, 'asset_debt_ratio', ['template' => "{input} %{error}", 'errorOptions' => ['class' => 'msg']])->textInput(['id' => 'asset_debt_ratio'])->label(false); ?>
                    </li>
                    <li>
                        <label for="total_employees_num">员工总数：</label>
                        <?= $form->field($model, 'total_employees_num', ['errorOptions' => ['class' => 'msg']])->textInput(['id' => 'total_employees_num'])->label(false); ?>
                    </li>
                    <li>
                        <label for="above_college_num">大专以上科技人员数：</label>
                        <?= $form->field($model, 'above_college_num', ['errorOptions' => ['class' => 'msg']])->textInput(['id' => 'above_college_num'])->label(false); ?>
                    </li>
                    <li>
                        <label for="research_num">直接从事研发人员数：</label>
                        <?= $form->field($model, 'research_num', ['errorOptions' => ['class' => 'msg']])->textInput(['id' => 'research_num'])->label(false); ?>
                    </li>
                    <li class="guide_down">
                        <label>税务报表上传：</label>
                        <a href="<?= Url::to(['member/download-guide-files', 'type' => 1]) ?>" class="guide">下载南昌企业财务报表导出说明</a>
                    </li>
                    <div class="net_error"></div>

                    <?php if (substr($register_date, 0, 4) <= $data['before_year']): ?>
                        <li>
                            <label class="labelT"><?= $data['before_year'] ?>年度企业适用会计制度：</label>
                            <?=
                            $form->field($model, 'accounting_system_before', ['errorOptions' => ['class' => 'msg']])->inline()->radioList($system, [
                                'item' => function($index, $label, $name, $checked, $value) {
                                    $return = '<input style="width:20px;height:auto;" type="radio" name="' . $name . '" value="' . $value . '" ' . ($checked ? "checked" : "") . '>' . $label . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                                    return $return;
                                },
                                'class' => 'radio',
                                'style' => 'line-height:40px;'
                            ])->label(false);
                            ?>
                        </li>
                        <li class="defaultBox">
                            <label class="labelSM" id="up_title_before" data-index="<?= $data['before_year'] ?>">
                                <?= $data['before_year'] ?>年度<span>税务报表：</span>
                                <p style="display: block;font-size:14px;margin-right:8px;">(仅限mht,htm,html类型文件)</p>
                            </label>
                            <div class="ubox">
                                <ul class="editList" data-index="<?= $data['before_year'] ?>">
                                    <li class="report_file">
                                        <label class="file_label">资产负债表</label>
                                        <div class="uploadBtn mt5">
                                            <label for="fileupload5">选择文件</label>
                                            <input type="file" name="mypic" id="fileupload5">
                                        </div>
                                        <?= $form->field($model, 'asset_debt_file_before', ['template' => "{input}<a id=\"dq5\" class=\"uploaded_file\" href=\"javascript:volid(0);\">当前附件：" . basename($model->asset_debt_file_before) . "</a>{error}", 'errorOptions' => ['class' => 'msg']])->hiddenInput(['id' => 'files5', 'class' => 'myfile'])->label(false); ?>
                                    </li>
                                    <li class="report_file">
                                        <label class="file_label">利润及利润分配表</label>
                                        <div class="uploadBtn mt5">
                                            <label for="fileupload6">选择文件</label>
                                            <input type="file" name="mypic" id="fileupload6">
                                        </div>
                                        <?= $form->field($model, 'profit_distribution_file_before', ['template' => "{input}<a id=\"dq6\" class=\"uploaded_file\" href=\"javascript:volid(0);\">当前附件：" . basename($model->profit_distribution_file_before) . "</a>{error}", 'errorOptions' => ['class' => 'msg']])->hiddenInput(['id' => 'files6', 'class' => 'myfile'])->label(false); ?>
                                    </li>
                                </ul>
                            </div>                               
                        </li>
                    <?php endif; ?>

                    <li>
                        <label class="labelT"><?= $data['last_year'] ?>年度企业适用会计制度：</label>
                        <?=
                        $form->field($model, 'accounting_system', ['errorOptions' => ['class' => 'msg']])->inline()->radioList($system, [
                            'item' => function($index, $label, $name, $checked, $value) {
                                $return = '<input style="width:20px;height:auto;" type="radio" name="' . $name . '" value="' . $value . '" ' . ($checked ? "checked" : "") . '>' . $label . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                                return $return;
                            },
                            'class' => 'radio',
                            'style' => 'line-height:40px;'
                        ])->label(false);
                        ?>
                    </li>
                    <li class="defaultBox">
                        <label class="labelSM" id="up_title_last" data-index="<?= $data['last_year'] ?>">
                            <?= $data['last_year'] ?>年度<span>税务报表：</span>
                            <p style="display: block;font-size:14px;margin-right:8px;">
                                (仅限mht,htm,html类型文件)
                            </p>
                        </label>
                        <div class="ubox">
                            <ul class="editList" data-index="<?= $data['last_year'] ?>">
                                <li class="report_file">
                                    <label class="file_label">资产负债表</label>
                                    <div class="uploadBtn mt5">
                                        <label for="fileupload1">选择文件</label>
                                        <input type="file" name="mypic" id="fileupload1">
                                    </div>
                                    <?= $form->field($model, 'asset_debt_file', ['template' => "{input}<a id=\"dq1\" class=\"uploaded_file\" href=\"javascript:volid(0);\">当前附件：" . basename($model->asset_debt_file) . "</a>{error}", 'errorOptions' => ['class' => 'msg']])->hiddenInput(['id' => 'files1', 'class' => 'myfile'])->label(false); ?>
                                </li>
                                <li class="report_file">
                                    <label class="file_label">利润及利润分配表</label>
                                    <div class="uploadBtn mt5">
                                        <label for="fileupload2">选择文件</label>
                                        <input type="file" name="mypic" id="fileupload2">
                                    </div>
                                    <?= $form->field($model, 'profit_distribution_file', ['template' => "{input}<a id=\"dq2\" class=\"uploaded_file\" href=\"javascript:volid(0);\">当前附件：" . basename($model->profit_distribution_file) . "</a>{error}", 'errorOptions' => ['class' => 'msg']])->hiddenInput(['id' => 'files2', 'class' => 'myfile'])->label(false); ?>
                                </li>
                            </ul>
                        </div>                            
                    </li>
                    <li>
                        <label class="labelT">近一期企业适用会计制度：</label>
                        <?=
                        $form->field($model, 'accounting_system_lastest', ['errorOptions' => ['class' => 'msg']])->inline()->radioList($system, [
                            'item' => function($index, $label, $name, $checked, $value) {
                                $return = '<input style="width:20px;height:auto;" type="radio" name="' . $name . '" value="' . $value . '" ' . ($checked ? "checked" : "") . '>' . $label . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                                return $return;
                            },
                            'class' => 'radio',
                            'style' => 'line-height:40px;'
                        ])->label(false);
                        ?>
                    </li>
                    <li class="defaultBox">
                        <label class="labelSM" id="up_title_lastest">
                            近一期<span>税务报表：</span>
                            <p style="display: block;font-size:14px;margin-right:8px;">
                                (仅限mht,htm,html类型文件)
                            </p>
                        </label>
                        <div class="ubox">
                            <ul class="editList" data-index="last">
                                <li class="report_file">
                                    <label class="file_label">资产负债表</label>
                                    <div class="uploadBtn mt5">
                                        <label for="fileupload3">选择文件</label>
                                        <input type="file" name="mypic" id="fileupload3">
                                    </div>
                                    <?= $form->field($model, 'asset_debt_file_lastest', ['template' => "{input}<a id=\"dq3\" class=\"uploaded_file\" href=\"javascript:volid(0);\">当前附件：" . basename($model->asset_debt_file_lastest) . "</a>{error}", 'errorOptions' => ['class' => 'msg']])->hiddenInput(['id' => 'files3', 'class' => 'myfile'])->label(false); ?>
                                </li>
                                <li class="report_file">
                                    <label class="file_label">利润及利润分配表</label>
                                    <div class="uploadBtn mt5">
                                        <label for="fileupload4">选择文件</label>
                                        <input type="file" name="mypic" id="fileupload4">
                                    </div>
                                    <?= $form->field($model, 'profit_distribution_file_lastest', ['template' => "{input}<a id=\"dq4\" class=\"uploaded_file\" href=\"javascript:volid(0);\">当前附件：" . basename($model->profit_distribution_file_lastest) . "</a>{error}", 'errorOptions' => ['class' => 'msg']])->hiddenInput(['id' => 'files4', 'class' => 'myfile'])->label(false); ?>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
<!--            <input type="hidden" name="s_annual_sales" id="s_annual_sales" value=""/>
            <input type="hidden" name="s_annual_profit" id="s_annual_profit" value=""/>
            <input type="hidden" name="s_net_asset" id="s_net_asset" value=""/>
            <input type="hidden" name="s_asset_debt_ratio" id="s_asset_debt_ratio" value=""/>-->
            <div class="save_btn">
                <a href="<?= Url::to(['apply/apply-base']) ?>" class="left_btn">上一步</a>
                <?= Html::submitButton('下一步', ['class' => 'nextbtn right_btn grey']); ?>
            </div>
            <?php ActiveForm::end(); ?>    
        </div>
    </div>
</div>
<script>
    $(function () {
        // input框显隐
        $("input[name='EnterpriseFinance[accounting_system]']").on('change', function () {
            if ($(this).val() == 3) {
                $('.optional_li').show();
            } else {
                $('.optional_li').hide();
            }
        });
        // 点击上传报表前判断会计制度
        $(".editList .report_file").click(function () {
            var number = $(this).parents('.defaultBox').prev().find('input[type="radio"]:checked').val();
            if (typeof (number) === "undefined") {
                layer.msg('请选择对应企业适用会计制度', {icon: 2, time: 2000});
                return false;
            }
        });
        // 选择会计制度(清空对应税务报表数据)
        $('.radio input').click(function () {
            var file_li = $(this).parents('li').next('li');
            file_li.find('.report_file input[type="file"]').val('');
            file_li.find('.report_file input[type="hidden"]').val('');
            file_li.find('.report_file a').text('当前附件：');
            //为了让yii2框架的验证生效
            file_li.find('.report_file input[type="hidden"]').focus();
            file_li.find('.report_file input[type="hidden"]').blur();
        });
        // 上传税务报表
        $.each([1, 2, 3, 4, 5, 6], function (i, n) {
            $(".editList").delegate("#fileupload" + n, 'change', function () {
                ajaxupload('apply/ajax-upload-files', n);
            });
        });
        // ajax上传
        function ajaxupload(upload_url, fileupload_id) {
            var number = $('#fileupload' + fileupload_id).parents('.defaultBox').prev().find('input[type="radio"]:checked').val();
            var file_year = $('#fileupload' + fileupload_id).closest('ul').data('index');
            var formData = new FormData();
            formData.append("_csrf", "<?= Yii::$app->request->csrfToken ?>");
            formData.append("system", number);
            formData.append("type", fileupload_id);
            formData.append("file", $('#fileupload' + fileupload_id)[0].files[0]);
            $.ajax({
                url: "<?= Url::to(['apply/ajax-upload-files']) ?>",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function () {
                    //可以做一些正在上传的效果
                },
                success: function (data) {
                    var obj = JSON.parse(data);
                    if (obj.code == 20000) {
                        if (number == 3) {
                            var result = 1;
                        } else {
                            var result = check_report_format(fileupload_id, obj.success.url, file_year, number);
                        }
                        if (result > 0) {
                            $("#dq" + obj.success.type).append(obj.success.name);
                            $("#files" + obj.success.type).val(obj.success.url);
                            //为了让yii2框架的验证生效
                            $("#files" + obj.success.type).focus();
                            $("#files" + obj.success.type).blur();
                        } else {
                            var err_msg = '格式内容有误，详情下载教程';
                            if (result == -4) {
                                err_msg = '报表年份错误，请重新提交';
                            }
                            layer.tips(err_msg, '.field-files' + fileupload_id, {tips: [4, '#EA2000']});
                            return false;
                        }
                    }
                    if (obj.code == 20001) {
                        layer.msg(obj.error, {icon: 2, time: 2000});
                    }
                },
                error: function (responseStr) {
                    console.log(responseStr);
                }
            });
        }
        // 验证财务报表格式
        function check_report_format(upload_id, fileName, year, accounting_system) {
            var result_wmc = 0;
            $.ajax({
                url: "<?= Url::to(['apply/ajax-check-reprt-format']) ?>",
                async: false,
                dataType: 'json',
                data: {'_csrf': '<?= Yii::$app->request->csrfToken ?>', 'upload_id': upload_id, 'fileName': fileName, 'year': year, 'type': accounting_system},
                type: 'post',
                success: function (data) {
                    result_wmc = data.ck;
                    var info = data.info;
                    if (result_wmc == 1 && info.annual_sales != undefined && data.endTime >= '2017-01')
                    {
                        if (data.operate_info != undefined && data.operate_info == "balance")
                        {
                            // 资产负债表
                            $('#s_net_asset').val(info.net_asset);//净资产
                            $('#s_asset_debt_ratio').val(info.asset_debt_ratio);//资产负债率
                        }
                        if (data.operate_info != undefined && data.operate_info == "profit")
                        {
                            // 利润表
                            $('#s_annual_sales').val(info.annual_sales);//年销售收入
                            $('#s_annual_profit').val(info.annual_profit);//年利润总额
                        }
                    }
                }
            });
            return result_wmc;
        }
    });
</script>
