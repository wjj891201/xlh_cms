<?php

use yii\web\View;
use yii\helpers\Url;
use app\models\Type;

$this->registerCssFile('@web/public/backend/js/kindeditor/themes/default/default.css', ['depends' => ['app\assets\AdminAsset']]);
$this->registerJsFile('@web/public/backend/js/form.js', ['depends' => ['app\assets\AdminAsset'], 'position' => View::POS_HEAD]);
$this->registerJsFile('@web/public/backend/js/control.js', ['depends' => ['app\assets\AdminAsset'], 'position' => View::POS_HEAD]);
$this->registerJsFile('@web/public/backend/js/kindeditor/kindeditor.js', ['depends' => ['app\assets\AdminAsset'], 'position' => View::POS_HEAD]);
$this->registerJsFile('@web/public/backend/js/kindeditor/lang/zh_CN.js', ['depends' => ['app\assets\AdminAsset'], 'position' => View::POS_HEAD]);
$this->registerJsFile('@web/public/backend/js/layer/layer.js', ['depends' => ['app\assets\AdminAsset'], 'position' => View::POS_HEAD]);
$this->registerJsFile('@web/public/backend/js/My97DatePicker/WdatePicker.js', ['depends' => ['app\assets\AdminAsset'], 'position' => View::POS_HEAD]);
?>
<script>
    KindEditor.ready(function(K) {
        K.create('#content',{afterBlur: function () { this.sync(); }});
        var editor = K.editor({
            allowFileManager : true  //开启多文件上传
        });
        
        
        
<?php if ($md['isalbum'] == 1): ?>
            var i = 0;
            K('#selectimage').click(function() {
                editor.loadPlugin('multiimage', function() {
                    editor.plugin.multiImageDialog({
                        clickFn : function(list) {
                            if (list && list.length > 0) {
                                for (i in list) {
                                    if (list[i]) {
                                        var html="<li>";
                                        html+="<img src='"+list[i]['url']+"' />";
                                        html+="<span><a href=\"javascript:;\" onclick=\"deletepic(this);\">删除</a></span>";
                                        html+="<input type=\"hidden\" name=\"picfile[]\" value="+list[i]['url']+" />";
                                        html+="</li>";                            
                                        $('.imglist').append(html);
                                        i++;
                                    }
                                }
                                editor.hideDialog();
                            } else {
                                alert('请先选择要上传的图片！');
                            }
                        }
                    });
                });
            });
<?php endif; ?>
        
        
        
<?php foreach ($modelatt as $key => $vo): ?>
    <?php if ($vo['inputtype'] == 'editor' && $vo['attrname'] != 'content'): ?>
                    K.create('#<?= $vo['attrname'] ?>', {
                        resizeType : 1,
                        allowPreviewEmoticons : false,
                        allowImageUpload : false,
                        items : [
                            'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline',
                            'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
                            'insertunorderedlist', '|', 'emoticons', 'image', 'link'],
                        afterBlur: function () { this.sync(); }
                    });
    <?php endif; ?>
    <?php if ($vo['inputtype'] == 'img'): ?>                              
                    $("#upload-image-<?= $vo['attrname'] ?>").click(function() {
                        editor.loadPlugin("image", function() {
                            editor.plugin.imageDialog({
                                showRemote : false,
                                clickFn : function(url) {
                                    $("#<?= $vo['attrname'] ?>").val(url);
                                    $(".fileupload-preview-<?= $vo['attrname'] ?>").html('<img src="'+url+'" style="width:200px;height:150px;"/>');
                                    editor.hideDialog();
                                }
                            });
                        });
                    });              
    <?php endif; ?>                                                                                                                                                                                             
<?php endforeach; ?>
    })
    
    $(document).ready(function(){
        var options = {
            beforeSubmit: formverify,
            success:saveResponse,
            resetForm: false
        };
        $('#newsadd').submit(function() {
            $(this).ajaxSubmit(options);
            return false;
        });
    }); 
    
    function formverify(formData, jqForm, options) {
        var queryString = $.param(formData);
        var get=urlarray(queryString);
<?php foreach ($modelatt as $key => $vo): ?>
    <?php if ($vo['isvalidate'] == 1): ?>
        <?php if ($vo['validatetext'] != ''): ?>
                            if(get['<?= $vo['attrname'] ?>'].match(<?= $vo['validatetext'] ?>)==null) {
                                layer.msg('<?= $vo['typename'] ?>'+'填写错误',{icon:2,time:1000});  
                                $('#<?= $vo['attrname'] ?>').focus();
                                return false;
                            }
        <?php else: ?>  
                            if(get['<?= $vo['attrname'] ?>']==''){
                                layer.msg('<?= $vo['typename'] ?>'+'填写错误',{icon:2,time:1000});  
                                $('#<?= $vo['attrname'] ?>').focus();
                                return false;                                                                  
                            }
        <?php endif; ?>  
    <?php endif; ?>
<?php endforeach; ?>
        if(get['tid']==0){
            layer.msg('所属分类未选择',{icon:2,time:1000});  
            $('#tid').focus();
            return false;
        }
    }
    function saveResponse(options){
        layer.msg(options,{icon:1,time:2000},function(){
            window.location.href="<?= Url::to(['news/list']) ?>"; 
        });  
    }
</script>
<div id="dcMain">
    <!-- 当前位置 -->
    <div id="urHere">管理中心<b>></b><strong>添加文章</strong> </div>   
    <div class="mainBox" style="height:auto!important;height:550px;min-height:550px;">
        <h3>现在修改的内容为<span style="color:#ff5b0b">{ <?= $read['title'] ?> }{ <?= $md['modelname'] ?> }</span></h3>
        <form action="<?= Url::to(['news/toedit']) ?>" id="newsadd" method="post" enctype="multipart/form-data">
            <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
                <?php foreach ($modelatt as $key => $vo): ?>
                    <tr>
                        <td align="right" <?php if ($vo['isvalidate'] == 1): ?>style="color: #ff6600;"<?php endif; ?>><?= $vo['typename'] ?></td>
                        <?php if ($vo['inputtype'] == 'string' || $vo['inputtype'] == 'int' || $vo['inputtype'] == 'float' || $vo['inputtype'] == 'decimal'): ?>
                            <td colspan="2">
                                <input type="text" name="<?= $vo['attrname'] ?>" size="<?= $vo['attrsize'] ?>" id="<?= $vo['attrname'] ?>" value="<?= $vo['attrvalue'] ?>" maxlength="<?= $vo['attrlenther'] ?>" class="inpMain"/>
                            </td>
                        <?php elseif ($vo['inputtype'] == 'text' || $vo['inputtype'] == 'editor' || $vo['inputtype'] == 'htmltext'): ?>
                            <td colspan="2">
                                <textarea name="<?= $vo['attrname'] ?>" id="<?= $vo['attrname'] ?>"  style="width:99%;height:<?= $vo['attrrow'] ?>px;" class="infoInput"><?= $vo['attrvalue'] ?></textarea>
                            </td>
                        <?php elseif ($vo['inputtype'] == 'img'): ?>
                            <td style="width: 40%;">
                                <div class="fileupload-preview-<?= $vo['attrname'] ?> thumbnail">
                                    <?php if ($vo['attrvalue'] != ''): ?>
                                        <img src="<?= $vo['attrvalue'] ?>" style="width:200px;height:150px; "/>
                                    <?php else: ?>
                                        <img src="/public/backend/images/upload.png"/>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td>
                                <button id="upload-image-<?= $vo['attrname'] ?>" type="button" class="btn">选择图片</button>
                                <input type="hidden" value="<?= $vo['attrvalue'] ?>" name="<?= $vo['attrname'] ?>" id="<?= $vo['attrname'] ?>"/>
                            </td>
                        <?php elseif ($vo['inputtype'] == 'selectinput'): ?>
                            <td colspan="2">
                                <input type="text" name="<?= $vo['attrname'] ?>" size="<?= $vo['attrsize'] ?>" id="<?= $vo['attrname'] ?>" value="<?= $vo['attrvalue'] ?>" maxlength="<?= $vo['attrlenther'] ?>" class="inpMain"/>
                                <select size="1" name="<?= $vo['attrname'] ?>selectinputvalue" onchange="javascript:$('#<?= $vo['attrname'] ?>').val(this.value)">
                                    <option value="">请选择<?= $vo['typename'] ?></option>
                                    <?php foreach ($vo['selectinputvalue'] as $k => $v): ?>
                                        <option value="<?= $v['name'] ?>"><?= $v['name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                        <?php elseif ($vo['inputtype'] == 'datetime'): ?>
                            <td colspan="2">
                                <input type="text" name="<?= $vo['attrname'] ?>" size="<?= $vo['attrsize'] ?>" id="<?= $vo['attrname'] ?>" value="<?= date('Y-m-d H:i:s', $vo['attrvalue']) ?>" maxlength="<?= $vo['attrlenther'] ?>" class="inpMain"/>
                                <a class="datetime" onclick="WdatePicker({el:'<?= $vo['attrname'] ?>',readOnly:true,dateFmt:'yyyy-MM-dd HH:mm:ss'})">选择日期</a>
                            </td>
                        <?php elseif ($vo['inputtype'] == 'select'): ?>
                            <td colspan="2">
                                <select size="1" name="<?= $vo['attrname'] ?>" id="<?= $vo['attrname'] ?>">
                                    <option value="">请选择<?= $vo['typename'] ?></option>
                                    <?php foreach ($vo['attrvalue'] as $k => $v): ?>  
                                        <option <?= $v['selected'] ?> value="<?= trim($v['name']) ?>"><?= trim($v['name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                        <?php elseif ($vo['inputtype'] == 'radio'): ?>
                            <td colspan="2">
                                <?php foreach ($vo['attrvalue'] as $k => $v): ?>
                                    <input type="radio" value="<?= trim($v['name']) ?>" name="<?= $vo['attrname'] ?>" <?php if ($v['selected'] == 'selected'): ?>checked="checked"<?php endif; ?>/> <?= trim($v['name']) ?>&nbsp;
                                <?php endforeach; ?>
                            </td>
                        <?php elseif ($vo['inputtype'] == 'checkbox'): ?>
                            <td colspan="2">
                                <?php foreach ($vo['attrvalue'] as $k => $v): ?>
                                    <input type="checkbox" <?php if ($v['selected'] == 'selected'): ?>checked="checked"<?php endif; ?> value="<?= trim($v['name']) ?>" name="<?= $vo['attrname'] ?>[]"/> <?= trim($v['name']) ?>&nbsp;
                                <?php endforeach; ?>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>

                <tr><th colspan="3" style="background: #92D6E3; text-align: left; ">SEO优化相关设置</th></tr>
                <tr>
                    <td align="right">自定义Title</td>
                    <td colspan="2">
                        <input type="text" name="headtitle" value="<?= $read['headtitle'] ?>" size="120" class="inpMain"/>
                    </td>
                </tr>
                <tr>
                    <td align="right">自定义Keywords</td>
                    <td colspan="2">
                        <input type="text" name="keywords" value="<?= $read['keywords'] ?>" size="120" class="inpMain"/>
                    </td>
                </tr>
                <tr>
                    <td align="right">自定义Description</td>
                    <td colspan="2">
                        <input type="text" name="description" value="<?= $read['description'] ?>" size="120" class="inpMain"/>
                    </td>
                </tr>

                <?php if ($md['isbase'] == 0): ?>
                    <tr><th colspan="3" style="background: #92D6E3; text-align: left; ">其它附加设置</th></tr>
                    <tr>
                        <td align="right">推荐位</td> 
                        <td colspan="2">
                            <?php foreach ($news_label as $key => $vo): ?>
                                <input type="checkbox" value="<?= $vo['dlid'] ?>" <?php if (isset($vo['selected'])): ?><?= $vo['selected'] ?><?php endif; ?> name="recommend[]"/>&nbsp;<?= $vo['labelname'] ?>&nbsp;&nbsp;
                            <?php endforeach; ?>
                        </td>
                    </tr>
                    <tr>
                        <td align="right">所属分类</td>
                        <td colspan="2">
                            <select size="1" name="tid">
                                <option value="">请选择所属分类</option>
                                <?php foreach ($typelist as $key => $vo): ?>
                                    <option <?php if ($tid == $vo['tid']): ?>selected='selected'<?php endif; ?> value="<?= $vo['tid'] ?>"><?= $vo['typename'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td align="right">发布时间</td>
                        <td colspan="2">
                            <input type="text" name="addtime" size="20" maxlength="30" id="addtime" value="<?= date('Y-m-d H:i:s', $read['addtime']) ?>" class="inpMain"/>
                            <a class="datetime" onclick="WdatePicker({el:'addtime',isShowClear:false,readOnly:true,dateFmt:'yyyy-MM-dd HH:mm:ss'})">选择日期</a>
                        </td>
                    </tr>
                    <tr>
                        <td align="right">点击数</td>
                        <td colspan="2">
                            <input name="click" size="5" maxlength="5" id="click" value="<?= $read['click'] ?>" class="inpMain" type="text">
                        </td>
                    </tr>
                    <tr><th colspan="3" style="background: #92D6E3; text-align: left; ">个性化设置</th></tr>
                    <tr>
                        <td align="right">指定模板定义</td>
                        <td colspan="2">
                            <input value="1" name="istemplates" type="radio"> 启用  
                            &nbsp;
                            <input value="0" name="istemplates" checked="checked" type="radio"> 关闭
                        </td>
                    </tr>
                    <tr id="isshow" style="display: none;">
                        <td align="right">模板名</td>
                        <td colspan="2">
                            <input type="text" name="template" value="<?= $read['template'] ?>" size="30" id="template" class="inpMain">
                        </td>
                    </tr>
                <?php else: ?>
                    <tr>
                        <td colspan="3">
                            <input type="hidden" name="tid" value="<?= $read['tid'] ?>" />
                            <input type="hidden" name="addtime" value="<?= date('Y-m-d H:i:s') ?>"/>
                            <input type="hidden" name="click" value="<?= $read['click'] ?>"/>
                        </td>
                    </tr>
                <?php endif; ?>

                <?php if ($md['isalbum'] == 1): ?>
                    <tr><th colspan="3" style="background: #92D6E3; text-align: left; ">图集管理</th></tr>
                    <tr>
                        <td align="right">图集</td>
                        <td colspan="2">
                            <ul class="imglist">
                                <?php foreach ($album as $key => $vo): ?>
                                    <li>
                                        <img src="<?= $vo['picfile'] ?>" />
                                        <span><a href="javascript:;" onclick="deletepic(this);">删除</a></span>
                                        <input type="hidden" name="picfile[]" value="<?= $vo['picfile'] ?>" />
                                    </li>  
                                <?php endforeach; ?>
                            </ul> 
                            <button id="selectimage" type="button" class="btn">上传图集</button>
                        </td>
                    </tr>
                <?php endif; ?>

                <tr>
                    <td></td>
                    <td colspan="2">
                        <input type="hidden" name="mid" value="<?= $md['id'] ?>" />
                        <input type="hidden" name="did" value="<?= $read['did'] ?>" />
                        <input type="hidden" name="isbase" value="<?= $read['isbase'] ?>" />
                        <input type="hidden" name="datid" value="<?= $read['datid'] ?>">
                        <input type="hidden" name="dcid" value="<?= $read['dcid'] ?>">
                        <input name="submit" class="btn" type="submit" value="提交" />
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<script>
    $(function(){  
        $("input[name='istemplates']").on('change', function() {
            if($(this).val()==1){
                $('#isshow').show(500);
            }else{
                $('#isshow').hide(500);
            }
        });
    });
    function deletepic(obj){
        if (confirm("确认要删除？")) {
            var $thisob=$(obj);
            var $liobj=$thisob.parents('li');
            var picurl=$liobj.children('input').val();
            $liobj.remove();
        }
    }
</script>