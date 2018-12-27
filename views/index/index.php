<?php

use yii\helpers\Url;
?>
<!doctype html>
<html>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <meta name="format-detection" content="telephone=no">
        <title>南昌科技贷系统</title>
        <link href="/public/kjd/css/easy.css" rel="stylesheet" type="text/css">
        <link href="/public/kjd/css/style.css" rel="stylesheet" type="text/css">
    </head>

    <body>
        <div class="bg"></div>
        <div class="tbg"></div>
        <div class="top">
            <div class="topTitle">
                <img src="<?= $logo ?>" width="1088" alt="" />
            </div>
            <div class="nav wrap">
                <ul>
                    <li class="n1 rotate">
                        <div class="circle"></div>
                        <div class="loading">
                            <div class="num"><?= $one_num ?></div>
                            <div class="text">企业申请总数</div>
                            <div class="show_01 show"></div>
                            <div class="show_02 show"></div>
                            <div class="img hide"><img src="/public/kjd/images/ie1.png" /></div>
                        </div>
                    </li>
                    <li class="n2 rotate">
                        <div class="circle"></div>
                        <div class="loading">
                            <div class="num"><?= $two_num ?></div>
                            <div class="text">企业入库总数</div>
                            <div class="show_01 show"></div>
                            <div class="show_02 show"></div>
                            <div class="img hide"><img src="/public/kjd/images/ie2.png" /></div>
                        </div>
                    </li>
                    <li class="n3 rotate">
                        <div class="circle"></div>
                        <div class="loading">
                            <div class="num"><?= $three_num ?></div>
                            <div class="text">金融需求总数</div>
                            <div class="show_01 show"></div>
                            <div class="show_02 show"></div>
                            <div class="img hide"><img src="/public/kjd/images/ie3.png" /></div>
                        </div>
                    </li>
                    <li class="n4 rotate">
                        <div class="circle"></div>
                        <div class="loading">
                            <div class="num"><?= $four_num ?></div>
                            <div class="text">金融受理总数</div>
                            <div class="show_01 show"></div>
                            <div class="show_02 show"></div>
                            <div class="img hide"><img src="/public/kjd/images/ie4.png" /></div>
                        </div>
                    </li>
                </ul>
                <div class="cbg"></div>
                <div class="tip" style="display: block;"><div class="close"></div></div>
            </div>
        </div>
        <div class="bottom">
            <div class="bbg"></div>
            <div class="wrap">
                <div class="detail">
                    <ul>
                        <!-- 11111111 -->
                        <li>
                            <div class="centerwrpper" style="height: 600px;">
                                <div class="tab">
                                    <div class="nav">
                                        <ul>
                                            <li class="current first">
                                                <div class="liwrap"><i class="linkicon linkicon1"></i><span>区域分布</span></div>
                                            </li>
                                            <li>
                                                <div class="liwrap"><i class="linkicon linkicon3"></i><span>科技企业类型</span></div>
                                            </li>
                                            <li>
                                                <div class="liwrap"><i class="linkicon linkicon2"></i><span>行业分布</span></div>
                                            </li>
                                            <li class="last">
                                                <div class="liwrap"><i class="linkicon linkicon4"></i><span>入库年度</span></div>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="content">
                                        <ul>
                                            <!-- 区域分布 -->
                                            <li style="display:block" class="showContent">
                                                <div class="show1">
                                                    <div class="linkheader">
                                                        <ul><li><a href="#">区域分布</a></li></ul>
                                                    </div>
                                                    <div class="linkcontent">
                                                        <div class="slider" style="width:890px;">
                                                            <ul class="canslider">
                                                                <li class="areaul">
                                                                    <?php foreach ($one_town_list as $key => $vo): ?>
                                                                        <?php if ($key <= 7): ?>
                                                                            <div>
                                                                                <span><?= $vo['name'] ?></span><p><?= $vo['count'] ?></p>
                                                                                <a>查看名单</a>
                                                                            </div>
                                                                            <?php if ($key % 4 == 3): ?>
                                                                                <span class="areaulbor"></span>
                                                                            <?php endif; ?>
                                                                        <?php endif; ?>
                                                                    <?php endforeach; ?>
                                                                </li>
                                                                <li class="areaul">
                                                                    <?php foreach ($one_town_list as $key => $vo): ?>
                                                                        <?php if ($key > 7 && $key <= 15): ?>
                                                                            <div>
                                                                                <span><?= $vo['name'] ?></span><p><?= $vo['count'] ?></p>
                                                                                <a>查看名单</a>
                                                                            </div>
                                                                            <?php if ($key % 4 == 3): ?>
                                                                                <span class="areaulbor"></span>
                                                                            <?php endif; ?>
                                                                        <?php endif; ?>
                                                                    <?php endforeach; ?>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>

                                            <!-- 科技企业类型 -->
                                            <li class="showContent">
                                                <div class="show1">
                                                    <div class="linkheader"><ul><li><a href="#">科技企业类型</a></li></ul></div>
                                                    <div class="linkcontent">
                                                        <div class="slider" style="width:890px;">
                                                            <ul class="canslider">
                                                                <li class="areaul">   
                                                                    <?php foreach ($one_enterprise as $key => $vo): ?>
                                                                        <div>
                                                                            <span><?= $vo['name'] ?></span>
                                                                            <p><?= $vo['count'] ?></p>
                                                                            <a>查看名单</a>
                                                                        </div>
                                                                    <?php endforeach; ?>
                                                                    <span class="areaulbor"></span>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>

                                            <!-- 行业分布 -->
                                            <li class="showContent">
                                                <div class="show1">
                                                    <div class="linkheader">
                                                        <ul><li><a href="#">行业分布</a></li></ul>
                                                    </div>
                                                    <div class="linkcontent">
                                                        <div class="slider" style="width:890px;">
                                                            <ul class="canslider" > 
                                                                <li class="areaul">
                                                                    <?php foreach ($one_industry as $key => $vo): ?>
                                                                        <?php if ($key <= 7): ?>
                                                                            <div>
                                                                                <span><?= $vo['name'] ?></span><p><?= $vo['count'] ?></p>
                                                                                <a>查看名单</a>
                                                                            </div>
                                                                            <?php if ($key % 4 == 3): ?>
                                                                                <span class="areaulbor"></span>
                                                                            <?php endif; ?>
                                                                        <?php endif; ?>
                                                                    <?php endforeach; ?>
                                                                </li>
                                                                <li class="areaul">
                                                                    <?php foreach ($one_industry as $key => $vo): ?>
                                                                        <?php if ($key > 7 && $key < 15): ?>
                                                                            <div>
                                                                                <span><?= $vo['name'] ?></span><p><?= $vo['count'] ?></p>
                                                                                <a>查看名单</a>
                                                                            </div>
                                                                            <?php if ($key % 4 == 3): ?>
                                                                                <span class="areaulbor"></span>
                                                                            <?php endif; ?>
                                                                        <?php endif; ?>
                                                                    <?php endforeach; ?>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>                                    
                                            <!-- 入库年度 -->
                                            <li>
                                                <div class="linkheader">
                                                    <ul><li><a href="#">入库年度</a></li></ul>
                                                </div>
                                                <div class="linkcontent">
                                                    <div class="contwrap">
                                                        <ul>
                                                            <?php foreach ($one_company as $key => $vo): ?>
                                                                <?php if ($key <= 9): ?>
                                                                    <li><?= $key + 1 ?> <?= $vo['enterprise_name'] ?></li>
                                                                <?php endif; ?>
                                                            <?php endforeach; ?>
                                                        </ul>
                                                    </div>
                                                    <div class="contwrap">
                                                        <ul>
                                                            <?php foreach ($one_company as $key => $vo): ?>
                                                                <?php if ($key > 9 && $key <= 9): ?>
                                                                    <li><?= $key + 1 ?> <?= $vo['enterprise_name'] ?></li>
                                                                <?php endif; ?>
                                                            <?php endforeach; ?>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <!-- 22222222 -->
                        <li>
                            <div class="centerwrpper" style="height: 600px;">
                                <div class="tab">
                                    <div class="nav">
                                        <ul>
                                            <li class="current first">
                                                <div class="liwrap"><i class="linkicon linkicon1"></i><span>区域分布</span></div>
                                            </li>
                                            <li>
                                                <div class="liwrap"><i class="linkicon linkicon3"></i><span>科技企业类型</span></div>
                                            </li>
                                            <li>
                                                <div class="liwrap"><i class="linkicon linkicon2"></i><span>行业分布</span></div>
                                            </li>
                                            <li class="last">
                                                <div class="liwrap"><i class="linkicon linkicon4"></i><span>入库年度</span></div>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="content">
                                        <ul>
                                            <!-- 区域分布 -->
                                            <li style="display:block" class="showContent">
                                                <div class="show1">
                                                    <div class="linkheader">
                                                        <ul><li><a href="#">区域分布</a></li></ul>
                                                    </div>
                                                    <div class="linkcontent">
                                                        <div class="slider" style="width:890px;">
                                                            <ul class="canslider">
                                                                <li class="areaul">
                                                                    <?php foreach ($two_town_list as $key => $vo): ?>
                                                                        <?php if ($key <= 7): ?>
                                                                            <div>
                                                                                <span><?= $vo['name'] ?></span><p><?= $vo['count'] ?></p>
                                                                                <a>查看名单</a>
                                                                            </div>
                                                                            <?php if ($key % 4 == 3): ?>
                                                                                <span class="areaulbor"></span>
                                                                            <?php endif; ?>
                                                                        <?php endif; ?>
                                                                    <?php endforeach; ?>
                                                                </li>
                                                                <li class="areaul">
                                                                    <?php foreach ($two_town_list as $key => $vo): ?>
                                                                        <?php if ($key > 7 && $key <= 15): ?>
                                                                            <div>
                                                                                <span><?= $vo['name'] ?></span><p><?= $vo['count'] ?></p>
                                                                                <a>查看名单</a>
                                                                            </div>
                                                                            <?php if ($key % 4 == 3): ?>
                                                                                <span class="areaulbor"></span>
                                                                            <?php endif; ?>
                                                                        <?php endif; ?>
                                                                    <?php endforeach; ?>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>

                                            <!-- 科技企业类型 -->
                                            <li class="showContent">
                                                <div class="show1">
                                                    <div class="linkheader"><ul><li><a href="#">科技企业类型</a></li></ul></div>
                                                    <div class="linkcontent">
                                                        <div class="slider" style="width:890px;">
                                                            <ul class="canslider">
                                                                <li class="areaul">   
                                                                    <?php foreach ($two_enterprise as $key => $vo): ?>
                                                                        <div>
                                                                            <span><?= $vo['name'] ?></span>
                                                                            <p><?= $vo['count'] ?></p>
                                                                            <a>查看名单</a>
                                                                        </div>
                                                                    <?php endforeach; ?>
                                                                    <span class="areaulbor"></span>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>

                                            <!-- 行业分布 -->
                                            <li class="showContent">
                                                <div class="show1">
                                                    <div class="linkheader">
                                                        <ul><li><a href="#">行业分布</a></li></ul>
                                                    </div>
                                                    <div class="linkcontent">
                                                        <div class="slider" style="width:890px;">
                                                            <ul class="canslider" > 
                                                                <li class="areaul">
                                                                    <?php foreach ($two_industry as $key => $vo): ?>
                                                                        <?php if ($key <= 7): ?>
                                                                            <div>
                                                                                <span><?= $vo['name'] ?></span><p><?= $vo['count'] ?></p>
                                                                                <a>查看名单</a>
                                                                            </div>
                                                                            <?php if ($key % 4 == 3): ?>
                                                                                <span class="areaulbor"></span>
                                                                            <?php endif; ?>
                                                                        <?php endif; ?>
                                                                    <?php endforeach; ?>
                                                                </li>
                                                                <li class="areaul">
                                                                    <?php foreach ($two_industry as $key => $vo): ?>
                                                                        <?php if ($key > 7 && $key < 15): ?>
                                                                            <div>
                                                                                <span><?= $vo['name'] ?></span><p><?= $vo['count'] ?></p>
                                                                                <a>查看名单</a>
                                                                            </div>
                                                                            <?php if ($key % 4 == 3): ?>
                                                                                <span class="areaulbor"></span>
                                                                            <?php endif; ?>
                                                                        <?php endif; ?>
                                                                    <?php endforeach; ?>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <!-- 入库年度 -->
                                            <li>
                                                <div class="linkheader">
                                                    <ul><li><a href="#">入库年度</a></li></ul>
                                                </div>
                                                <div class="linkcontent">
                                                    <div class="contwrap">
                                                        <ul>
                                                            <?php foreach ($two_company as $key => $vo): ?>
                                                                <?php if ($key <= 9): ?>
                                                                    <li><?= $key + 1 ?> <?= $vo['enterprise_name'] ?></li>
                                                                <?php endif; ?>
                                                            <?php endforeach; ?>
                                                        </ul>
                                                    </div>
                                                    <div class="contwrap">
                                                        <ul>
                                                            <?php foreach ($two_company as $key => $vo): ?>
                                                                <?php if ($key > 9 && $key <= 9): ?>
                                                                    <li><?= $key + 1 ?> <?= $vo['enterprise_name'] ?></li>
                                                                <?php endif; ?>
                                                            <?php endforeach; ?>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <!-- 33333333 -->
                        <li>
                            <div class="centerwrpper">
                                <div class="tab">
                                    <div class="nav">
                                        <ul>
                                            <li class="current first">
                                                <div class="liwrap"><i class="linkicon n31"></i><span>金融需求</span></div>
                                            </li>
                                            <li class="last">
                                                <div class="liwrap"><i class="linkicon n32"></i><span>科技银行贷款</span></div>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="content">
                                        <ul>
                                            <li style="display:block">
                                                <div class="linkheader">
                                                    <ul>
                                                        <li><a href="#">金融需求</a></li>
                                                    </ul>
                                                </div>
                                                <div class="linkcontent">
                                                    <div class="nbox">
                                                        <div class="t1">科技银行贷款
                                                            <div class="line"></div>
                                                        </div>
                                                        <ul>
                                                            <li>
                                                                <div class="box">
                                                                    <div class="c nc1">需求</div>
                                                                    <div class="text">
                                                                        <div class="text1">691<span>家</span></div>
                                                                        <div class="text2">￥5000<span>万</span></div>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="box">
                                                                    <div class="c nc2">受理</div>
                                                                    <div class="text">
                                                                        <div class="text1">691<span>家</span></div>
                                                                        <div class="text2">￥5000<span>万</span></div>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="box">
                                                                    <div class="c nc3">授信</div>
                                                                    <div class="text">
                                                                        <div class="text1">691<span>家</span></div>
                                                                        <div class="text2">￥5000<span>万</span></div>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="box noborder">
                                                                    <div class="c nc4">发放</div>
                                                                    <div class="text">
                                                                        <div class="text1">691<span>家</span></div>
                                                                        <div class="text2">￥5000<span>万</span></div>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="linkheader">
                                                    <ul>
                                                        <li><a href="#">科技贷</a></li>
                                                    </ul>
                                                </div>
                                                <div class="linkcontent">
                                                    <div class="xbox">
                                                        <ul>
                                                            <li>
                                                                <div class="bank"><img src="/public/kjd/images/b1.jpg">嘉兴银行</div>
                                                                <div class="bdata">
                                                                    <div class="text">
                                                                        <ul>
                                                                            <li>
                                                                                <div class="text1">691<span>家</span></div>
                                                                                <div class="text2">￥5000<span>万</span></div>
                                                                            </li>
                                                                            <li>
                                                                                <div class="text1">691<span>家</span></div>
                                                                                <div class="text2">￥5000<span>万</span></div>
                                                                            </li>
                                                                            <li>
                                                                                <div class="text1">691<span>家</span></div>
                                                                                <div class="text2">￥5000<span>万</span></div>
                                                                            </li>
                                                                            <li>
                                                                                <div class="text1">691<span>家</span></div>
                                                                                <div class="text2">￥5000<span>万</span></div>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                                <div class="clear"></div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <!-- 4444444 -->
                        <li>
                            <div class="centerwrpper">
                                <div class="tab">
                                    <div class="nav">
                                        <ul>
                                            <li class="current first">
                                                <div class="liwrap"><i class="linkicon n31"></i><span>金融需求</span></div>
                                            </li>
                                            <li class="last">
                                                <div class="liwrap"><i class="linkicon n32"></i><span>科技银行贷款</span></div>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="content">
                                        <ul>
                                            <li style="display:block">
                                                <div class="linkheader">
                                                    <ul>
                                                        <li><a href="#">金融需求</a></li>
                                                    </ul>
                                                </div>
                                                <div class="linkcontent">
                                                    <div class="nbox">
                                                        <div class="t1">科技银行贷款
                                                            <div class="line"></div>
                                                        </div>
                                                        <ul>
                                                            <li>
                                                                <div class="box">
                                                                    <div class="c nc1">需求</div>
                                                                    <div class="text">
                                                                        <div class="text1">691<span>家</span></div>
                                                                        <div class="text2">￥5000<span>万</span></div>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="box">
                                                                    <div class="c nc2">受理</div>
                                                                    <div class="text">
                                                                        <div class="text1">691<span>家</span></div>
                                                                        <div class="text2">￥5000<span>万</span></div>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="box noborder">
                                                                    <div class="c nc3">发放</div>
                                                                    <div class="text">
                                                                        <div class="text1">691<span>家</span></div>
                                                                        <div class="text2">￥5000<span>万</span></div>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="linkheader">
                                                    <ul>
                                                        <li><a href="#">科技贷</a></li>
                                                    </ul>
                                                </div>
                                                <div class="linkcontent">
                                                    <div class="xbox">
                                                        <ul>
                                                            <li>
                                                                <div class="bank"><img src="/public/kjd/images/b1.jpg">嘉兴银行</div>
                                                                <div class="bdata">
                                                                    <div class="text">
                                                                        <ul>
                                                                            <li>
                                                                                <div class="text1">691<span>家</span></div>
                                                                                <div class="text2">￥5000<span>万</span></div>
                                                                            </li>
                                                                            <li>
                                                                                <div class="text1">691<span>家</span></div>
                                                                                <div class="text2">￥5000<span>万</span></div>
                                                                            </li>
                                                                            <li>
                                                                                <div class="text1">691<span>家</span></div>
                                                                                <div class="text2">￥5000<span>万</span></div>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                                <div class="clear"></div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="content" style="margin-top:-49px">
                    <div class="belowwrapper">
                        <div class="belowbox below1ul">
                            <div class="zi">
                                <div class="titleborder">
                                    <h3>企业入口</h3>
                                </div>
                                <ul>
                                    <li>
                                        <div class="bussback bussback1"><span class="wave"></span></div>
                                        <a class="buss buss1" href="<?= Url::to(['apply/land']) ?>"><i></i><span>科技贷款申请</span></a>
                                    </li>
                                    <li>
                                        <div class="bussback bussback2"><span class="wave"></span></div>
                                        <a class="buss buss2" href="<?= Url::to(['member/enterprise-list']) ?>"><i></i><span>申请进度查询</span></a>
                                    </li>
                                    <li>
                                        <div class="bussback bussback3"><span class="wave"></span></div>
                                        <a class="buss buss3" href=""><i></i><span>补贴申请</span></a>
                                    </li>
                                </ul>
                            </div>
                            <div class="be1"></div>
                        </div>
                        <div class="belowbox belowmain">
                            <div class="bcenter " style="margin-bottom: 19px;">
                                <div class="zi">
                                    <img src="/public/kjd/images/below3.png">
                                    <div class="cenbtnbox">
                                        <div class="cir cir1"><span class="circlet"></span></div>
                                        <div class="cbg2"></div>
                                        <div class="cbg1"></div>
                                        <a class="bcbtn bcbtn1" href="#">管理员入口</a>
                                    </div>
                                </div>
                                <div class="c1"></div>
                            </div>
                            <div class="bcenter ">
                                <div class="zi">
                                    <img src="/public/kjd/images/below4.png">
                                    <div class="cenbtnbox">
                                        <div class="cir cir2"><span class="circlet"></span></div>
                                        <div class="cbg2"></div>
                                        <div class="cbg1"></div>
                                        <a class="bcbtn bcbtn2" href="#">金融机构入口</a>
                                    </div>
                                </div>
                                <div class="c1"></div>
                            </div>
                        </div>
                        <div class="belowbox below2ul">
                            <div class="zi">
                                <div class="titleborder">
                                    <h3>公告</h3>
                                </div>
                                <ul>
                                    <?php foreach ($news as $key => $vo): ?>
                                        <li>
                                            <i class="wdot"></i>
                                            <a href="<?= Url::to(['article/detail', 'did' => $vo['did']]) ?>"><?= $vo['title'] ?></a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                                <div class="morebtnbox">
                                    <div class="morebtnback morebtnback1"><span class="morewave "></span></div>
                                    <a class="morebtn" href="#">更多</a>
                                </div>
                            </div>
                            <div class="be1"></div>
                        </div>
                    </div>
                    <div class="info">
                        <img src="/public/kjd/images/i1.png" width="32" height="28" alt="" />
                        如有问题，请联系南昌科技金融服务平台&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;电话：0573-82609931
                    </div>
                </div>
            </div>
        </div>
        <script src="/public/kjd/js/jquery.js"></script>
        <script src="/public/kjd/js/easy.js"></script>
        <script src="/public/kjd/js/jquery.easing.1.3.js"></script>
        <script src="/public/kjd/js/jquery.fitvids.js"></script>
        <script src="/public/kjd/js/slider.js"></script>
        <script src="/public/kjd/js/js.js"></script>
    </body>
</html>