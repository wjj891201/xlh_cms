<?php

namespace app\modules\admin\controllers;

use app\modules\admin\controllers\CommonController;
use Yii;
use yii\db\Query;
use yii\data\Pagination;
use app\models\News;
use app\models\NewsAlbum;
use app\models\NewsAttr;
use app\models\NewsContent;
use app\models\Type;
use app\models\Model;
use app\models\ModelAtt;
use app\models\Recommend;

class NewsController extends CommonController
{

    public function actionList()
    {
        $model = new Type;
        //获取非跳转链接的分类
        //$cates = $model->getTreeList(['and', ['lng' => $this->lang], ['NOT', ['styleid' => 3]]]);

        $tid = Yii::$app->request->get("tid");
        if (!empty($tid))
        {
            $cate = Type::getData(['lng' => $this->lang]);
            $tids = Type::getChildsid($cate, $tid);
            array_unshift($tids, (string) $tid);
            $where = ['AND', ['n.lng' => $this->lang, 'n.isbase' => 0], ['IN', 'n.tid', $tids]];
        }
        else
        {
            $where = ['n.lng' => $this->lang, 'n.isbase' => 0];
        }



        $cates = $model->getTreeList(['lng' => $this->lang]);
        //获取新闻列表
        $query = new Query;
        $pageSize = 20;
        $all = $query->select('n.did,n.pid,n.mid,n.tid,n.title,t.typename')
                ->from('{{%news}} as n')
                ->leftJoin('{{%typelist}} as t', 'n.tid=t.tid')
                ->where($where)
                ->orderBy(['n.addtime' => SORT_DESC]);
        $countQuery = clone $all;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => $pageSize]);
        $data = $query->offset($pages->offset)->limit($pages->limit)->all();
        return $this->render("list", ['cates' => $cates, 'data' => $data, 'pages' => $pages]);
    }

    public function actionAdd()
    {
        $mid = Yii::$app->request->get("mid", 0);
        $tid = Yii::$app->request->get("tid", 0);
        $md = Model::getOne(['id' => $mid]);
        $modelatt = ModelAtt::getModelattArray($mid);
        //获取相同模型号mid和频道或者列表的分类
        $model = new Type;
        $typelist = $model->getTreeList(['lng' => $this->lang]);
        foreach ($typelist as $key => $vo)
        {
            if (!in_array($vo['styleid'], [1, 2]) || $vo['mid'] != $mid)
            {
                unset($typelist[$key]);
            }
        }
        //获取推荐位
        $news_label = Recommend::get_news_label_array(0, $mid, $this->lang);
        return $this->render('add', ['md' => $md, 'modelatt' => $modelatt, 'tid' => $tid, 'typelist' => $typelist, 'news_label' => $news_label['list']]);
    }

    /**
     * 去添加
     */
    public function actionToadd()
    {
        $mid = Yii::$app->request->post("mid", 0);
        $tid = Yii::$app->request->post("tid", 0);
        $headtitle = Yii::$app->request->post("headtitle");
        $keywords = Yii::$app->request->post("keywords");
        $description = Yii::$app->request->post("description");
        $recommend = Yii::$app->request->post("recommend");
        if (!empty($recommend))
        {
            $recommend = implode(',', $recommend);
        }
        $addtime = Yii::$app->request->post("addtime");
        $addtime = empty($addtime) ? time() : strtotime($addtime);
        $click = Yii::$app->request->post("click");
        $istemplates = Yii::$app->request->post("istemplates", 0);
        $template = Yii::$app->request->post("template", 0);
        $typeview = Type::getone(['tid' => $tid]);
        $template = ($istemplates) ? $template : $typeview['readtemplate']; //最终的新闻详细页模板
        $picfile = Yii::$app->request->post("picfile"); //图集
        $uptime = time(); //更新时间
        $aid = Yii::$app->session['admin']['id'];

        $modelatt = ModelAtt::getModelattArray($mid);
        $modelarray = [];
        $modelsysarray = [];
        foreach ($modelatt as $key => $value)
        {

            if ($value['inputtype'] == 'htmltext')
            {
                $value['accept'] = 'html';
            }
            elseif ($value['inputtype'] == 'checkbox')
            {
                $value['accept'] = 'checkbox';
            }
            elseif ($value['inputtype'] == 'string' || $value['inputtype'] == 'img' || $value['inputtype'] == 'addon' || $value['inputtype'] == 'video' || $value['inputtype'] == 'select' || $value['inputtype'] == 'radio' || $value['inputtype'] == 'selectinput')
            {
                $value['accept'] = 'text';
            }
            elseif ($value['inputtype'] == 'editor' || $value['inputtype'] == 'text')
            {
                $value['accept'] = 'editor';
            }
            elseif ($value['inputtype'] == 'int' || $value['inputtype'] == 'float' || $value['inputtype'] == 'decimal')
            {
                $value['accept'] = 'int';
            }
            elseif ($value['inputtype'] == 'datetime')
            {
                $value['accept'] = 'data';
            }
            if (!$value['lockin'] && !$value['issys'])
            {
                $modelarray[] = $value;
            }
            else
            {
                $modelsysarray[] = $value;
            }
        }
        $sysinstall = null;
        $sysinstalldb = null;
        $conent = null;
        foreach ($modelsysarray as $key => $value)
        {
            if ($value['attrname'] == 'content')
            {
                continue;
            }
            $sysinstall.=$value['attrname'] . ',';
            if ($value['accept'] == 'int')
            {
                $valuestr = Yii::$app->request->post($value['attrname'], 0);
                $sysinstalldb.="$valuestr,";
            }
            elseif ($value['accept'] == 'html')
            {
                $valuestr = Yii::$app->request->post($value['attrname']);
                $valuestr = empty($valuestr) ? '' : $this->Text2Html($valuestr);
                $sysinstalldb.="'$valuestr',";
            }
            elseif ($value['accept'] == 'editor' || $value['accept'] == 'text')
            {
                $valuestr = Yii::$app->request->post($value['attrname']);
                $sysinstalldb.="'$valuestr',";
            }
            elseif ($value['accept'] == 'data')
            {
                $valuestr = Yii::$app->request->post($value['attrname']);
                $valuestr = empty($valuestr) ? 0 : strtotime($valuestr);
                $sysinstalldb.="$valuestr,";
            }
        }


        $userinstall = null;
        $userinstalldb = null;
        $userupdatedb = null;
        foreach ($modelarray as $key => $value)
        {
            $userinstall.=$value['attrname'] . ',';
            if ($value['accept'] == 'int')
            {
                $valuestr = Yii::$app->request->post($value['attrname'], 0);
                $userinstalldb.="$valuestr,";
                $userupdatedb.=$value['attrname'] . "=$valuestr,";
            }
            elseif ($value['accept'] == 'html')
            {
                $valuestr = Yii::$app->request->post($value['attrname']);
                $valuestr = empty($valuestr) ? '' : $this->Text2Html($valuestr);
                $userinstalldb.="'$valuestr',";
                $userupdatedb.=$value['attrname'] . "='$valuestr',";
            }
            elseif ($value['accept'] == 'editor' || $value['accept'] == 'text')
            {
                $valuestr = Yii::$app->request->post($value['attrname']);
                $userinstalldb.="'$valuestr',";
                $userupdatedb.=$value['attrname'] . "='$valuestr',";
            }
            elseif ($value['accept'] == 'data')
            {
                $valuestr = Yii::$app->request->post($value['attrname']);
                $valuestr = empty($valuestr) ? 0 : strtotime($valuestr);
                $userinstalldb.="$valuestr,";
                $userupdatedb.=$value['attrname'] . "='$valuestr',";
            }
            elseif ($value['accept'] == 'checkbox')
            {
                $valuestr = Yii::$app->request->post($value['attrname']);
                $valuestr = is_array($valuestr) ? implode(',', $valuestr) : '';
                $userinstalldb.="'$valuestr',";
                $userupdatedb.=$value['attrname'] . "='$valuestr',";
            }
        }
        $content = Yii::$app->request->post("content");

//        $db_field = $sysinstall . 'lng,pid,mid,aid,tid,extid,sid,fgid,linkdid,isclass,islink,ishtml,ismess,isorder,ktid,purview,istemplates,isbase,recommend,tsn,color,tags,headtitle,keywords,description,link,click,addtime,uptime,template,filename';
//        $db_values = $sysinstalldb . "'cn',50,$mid,$aid,$tid,'','','','','','','','','',0,'','',0,'','','','','$headtitle','$keywords','$description','',$click,$addtime,$uptime,'$template',''";

        $db_field = $sysinstall . 'lng,pid,mid,aid,tid,ktid,istemplates,isbase,recommend,headtitle,keywords,description,click,addtime,uptime,template';
        $db_values = $sysinstalldb . "'$this->lang',50,$mid,$aid,$tid,0,$istemplates,0,'$recommend','$headtitle','$keywords','$description',$click,$addtime,$uptime,'$template'";
        $connection = Yii::$app->db;
        $sql = 'INSERT INTO {{%news}} (' . $db_field . ') VALUES (' . $db_values . ')';
        $connection->createCommand($sql)->query();
        $insert_id = Yii::$app->db->getLastInsertID(); //获取插入的did
        //插入内容
        if (!empty($content))
        {
            $db_field = 'did,content';
            $db_values = "$insert_id,'$content'";
            $sql = 'INSERT INTO {{%news_content}} (' . $db_field . ') VALUES (' . $db_values . ')';
            $connection->createCommand($sql)->query();
        }

        if ($userinstall && $userinstalldb)
        {
            $db_field = $userinstall . 'did';
            $db_values = $userinstalldb . $insert_id;
            $sql = 'INSERT INTO {{%news_attr}} (' . $db_field . ') VALUES (' . $db_values . ')';
            $connection->createCommand($sql)->query();
        }

        //添加图集
        if (!empty($picfile))
        {
            NewsAlbum::install_pic($insert_id, $picfile, false);
        }
        exit('添加成功！');
    }

    public function actionEdit()
    {
        $did = Yii::$app->request->get('did');
        $mid = Yii::$app->request->get('mid', 0);
        $tid = Yii::$app->request->get('tid', 0);

        //获取相同模型号mid和频道或者列表的分类
        $model = new Type;
        $typelist = $model->getTreeList(['lng' => $this->lang]);
        foreach ($typelist as $key => $vo)
        {
            if (!in_array($vo['styleid'], [1, 2]) || $vo['mid'] != $mid)
            {
                unset($typelist[$key]);
            }
        }

        $read = News::get_news($did);
        $md = Model::getOne(['id' => $mid]);
        $modelatt = ModelAtt::getModelattArray($mid, false);
        if (is_array($modelatt))
        {
            foreach ($modelatt as $key => $value)
            {
                if ($value['inputtype'] == 'select' || $value['inputtype'] == 'radio')
                {
                    foreach ($value['attrvalue'] as $key2 => $value2)
                    {
                        if (trim($read[$value['attrname']]) == trim($value2['name']))
                        {
                            $modelatt[$key]['attrvalue'][$key2]['selected'] = 'selected';
                        }
                    }
                }
                elseif ($value['inputtype'] == 'checkbox')
                {
                    $expvale = explode(',', $read[$value['attrname']]);
                    foreach ($value['attrvalue'] as $key2 => $value2)
                    {
                        if (in_array(trim($value2['name']), $expvale))
                        {
                            $modelatt[$key]['attrvalue'][$key2]['selected'] = 'selected';
                        }
                    }
                }
                else
                {
                    $modelatt[$key]['attrvalue'] = $read[$value['attrname']];
                }
            }
        }

        //获取推荐位
        $news_label = Recommend::get_news_label_array($read['recommend'], $mid, $this->lang);
        //获取图集
        $album = NewsAlbum::getAll(['did' => $did]);
        return $this->render('edit', ['md' => $md, 'modelatt' => $modelatt, 'read' => $read, 'typelist' => $typelist, 'tid' => $tid, 'news_label' => $news_label['list'], 'album' => $album]);
    }

    /**
     * 去编辑
     */
    public function actionToedit()
    {
        $mid = Yii::$app->request->post("mid", 0);
        $tid = Yii::$app->request->post("tid", 0);
        $did = Yii::$app->request->post("did");
        $isbase = Yii::$app->request->post("isbase", 0);
        $datid = Yii::$app->request->post("datid");
        $dcid = Yii::$app->request->post("dcid");

        $headtitle = Yii::$app->request->post("headtitle");
        $keywords = Yii::$app->request->post("keywords");
        $description = Yii::$app->request->post("description");
        $recommend = Yii::$app->request->post("recommend");
        if (!empty($recommend))
        {
            $recommend = implode(',', $recommend);
        }
        $addtime = Yii::$app->request->post("addtime");
        $addtime = empty($addtime) ? time() : strtotime($addtime);
        $click = Yii::$app->request->post("click");
        $istemplates = Yii::$app->request->post("istemplates", 0);
        $template = Yii::$app->request->post("template");
        $typeview = Type::getone(['tid' => $tid]);
        $template = ($istemplates) ? $template : $typeview['readtemplate']; //最终的新闻详细页模板
        $picfile = Yii::$app->request->post("picfile"); //图集
        $uptime = time(); //更新时间
        $aid = Yii::$app->session['admin']['id'];

        $modelatt = ModelAtt::getModelattArray($mid);
        $modelarray = [];
        $modelsysarray = [];
        foreach ($modelatt as $key => $value)
        {
            if ($value['inputtype'] == 'htmltext')
            {
                $value['accept'] = 'html';
            }
            elseif ($value['inputtype'] == 'checkbox')
            {
                $value['accept'] = 'checkbox';
            }
            elseif ($value['inputtype'] == 'string' || $value['inputtype'] == 'img' || $value['inputtype'] == 'addon' || $value['inputtype'] == 'video' || $value['inputtype'] == 'select' || $value['inputtype'] == 'radio' || $value['inputtype'] == 'selectinput')
            {
                $value['accept'] = 'text';
            }
            elseif ($value['inputtype'] == 'editor' || $value['inputtype'] == 'text')
            {
                $value['accept'] = 'editor';
            }
            elseif ($value['inputtype'] == 'int' || $value['inputtype'] == 'float' || $value['inputtype'] == 'decimal')
            {
                $value['accept'] = 'int';
            }
            elseif ($value['inputtype'] == 'datetime')
            {
                $value['accept'] = 'data';
            }
            if (!$value['lockin'] && !$value['issys'])
            {
                $modelarray[] = $value;
            }
            else
            {
                $modelsysarray[] = $value;
            }
        }
        $sysinstall = null;
        $sysinstalldb = null;
//        $conent = null;

        foreach ($modelsysarray as $key => $value)
        {
            if ($value['attrname'] == 'content')
            {
                continue;
            }
            if ($value['accept'] == 'int')
            {
                $valuestr = Yii::$app->request->post($value['attrname'], 0);
                $sysinstalldb.=$value['attrname'] . "=$valuestr,";
            }
            elseif ($value['accept'] == 'html')
            {
                $valuestr = Yii::$app->request->post($value['attrname']);
                $valuestr = empty($valuestr) ? '' : $this->Text2Html($valuestr);
                $sysinstalldb.=$value['attrname'] . "='$valuestr',";
            }
            elseif ($value['accept'] == 'editor' || $value['accept'] == 'text')
            {
                $valuestr = Yii::$app->request->post($value['attrname']);
                $sysinstalldb.=$value['attrname'] . "='$valuestr',";
            }
            elseif ($value['accept'] == 'data')
            {
                $valuestr = Yii::$app->request->post($value['attrname']);
                $valuestr = empty($valuestr) ? 0 : strtotime($valuestr);
                $sysinstalldb.=$value['attrname'] . "=$valuestr,";
            }
        }

        $userinstall = null;
        $userinstalldb = null;
        $userupdatedb = null;
        foreach ($modelarray as $key => $value)
        {
            $userinstall.=$value['attrname'] . ',';
            if ($value['accept'] == 'int')
            {
                $valuestr = Yii::$app->request->post($value['attrname'], 0);
                $userinstalldb.="$valuestr,";
                $userupdatedb.=$value['attrname'] . "=$valuestr,";
            }
            elseif ($value['accept'] == 'html')
            {
                $valuestr = Yii::$app->request->post($value['attrname']);
                $valuestr = empty($valuestr) ? '' : $this->Text2Html($valuestr);
                $userinstalldb.="'$valuestr',";
                $userupdatedb.=$value['attrname'] . "='$valuestr',";
            }
            elseif ($value['accept'] == 'editor' || $value['accept'] == 'text')
            {
                $valuestr = Yii::$app->request->post($value['attrname']);
                $userinstalldb.="'$valuestr',";
                $userupdatedb.=$value['attrname'] . "='$valuestr',";
            }
            elseif ($value['accept'] == 'data')
            {
                $valuestr = Yii::$app->request->post($value['attrname']);
                $valuestr = empty($valuestr) ? 0 : strtotime($valuestr);
                $userinstalldb.="$valuestr,";
                $userupdatedb.=$value['attrname'] . "='$valuestr',";
            }
            elseif ($value['accept'] == 'checkbox')
            {
                $valuestr = Yii::$app->request->post($value['attrname']);
                $valuestr = is_array($valuestr) ? implode(',', $valuestr) : '';
                $userinstalldb.="'$valuestr',";
                $userupdatedb.=$value['attrname'] . "='$valuestr',";
            }
        }
        $content = Yii::$app->request->post("content");

        $db_where = 'did=' . $did;
        $db_set = $sysinstalldb . "aid=$aid,tid=$tid,istemplates=$istemplates,recommend='$recommend',headtitle='$headtitle',keywords='$keywords',description='$description',click=$click,addtime=$addtime,uptime=$uptime,template='$template'";
        $connection = Yii::$app->db;
        $sql = 'UPDATE {{%news}} SET ' . $db_set . ' WHERE ' . $db_where;
        $connection->createCommand($sql)->query();

        if (!empty($content))
        {
            if ($dcid)
            {
                $db_where = 'did=' . $did . ' AND dcid=' . $dcid;
                $db_set = "content='$content'";
                $sql = 'UPDATE {{%news_content}} SET ' . $db_set . ' WHERE ' . $db_where;
            }
            else
            {
                $db_field = 'did,content';
                $db_values = "$did,'$content'";
                $sql = 'INSERT INTO {{%news_content}} (' . $db_field . ') VALUES (' . $db_values . ')';
            }
            $connection->createCommand($sql)->query();
        }

        if ($userinstalldb)
        {
            if ($datid)
            {
                $db_where = 'did=' . $did . ' AND datid=' . $datid;
                $db_values = substr($userupdatedb, 0, strlen($userupdatedb) - 1);
                $sql = 'UPDATE {{%news_attr}} SET ' . $db_values . ' WHERE ' . $db_where;
            }
            else
            {
                $db_field = $userinstall . 'did';
                $db_values = $userinstalldb . $did;
                $sql = 'INSERT INTO {{%news_attr}} (' . $db_field . ') VALUES (' . $db_values . ')';
            }
            $connection->createCommand($sql)->query();
        }
        //编辑图集
        if (!empty($picfile))
        {
            NewsAlbum::install_pic($did, $picfile);
        }
        exit('编辑成功！');
    }

    /**
     * 处理新闻的批量删除和排序
     */
    public function actionDeal()
    {
        $post = Yii::$app->request->post();
        if ($post['action'] == 'del')
        {
            foreach ($post['did'] as $vo)
            {
                NewsAttr::deleteAll('did = :did', [":did" => $vo]);
                NewsAlbum::deleteAll('did = :did', [":did" => $vo]);
                NewsContent::deleteAll('did = :did', [":did" => $vo]);
                News::deleteAll('did = :did', [":did" => $vo]);
            }
            Yii::$app->session->setFlash("success", "删除成功");
        }
        if ($post['action'] == 'sort')
        {
            foreach ($post['pid'] as $key => $vo)
            {
                if (is_numeric($vo))
                {
                    News::updateAll(['pid' => $vo], ['did' => $key]);
                }
                else
                {
                    break;
                }
            }
            Yii::$app->session->setFlash("success", "排序成功");
        }
        return $this->redirect(['news/list']);
    }

    function Text2Html($txt, $is_preg = true)
    {
        $txt = htmlspecialchars($txt);
        if ($is_preg)
        {
            $txt = preg_replace("/\r\n/isU", "<br/>", $txt);
            $txt = preg_replace("/\r/isU", "<br/>", $txt);
            $txt = preg_replace("/\n/isU", "<br/>", $txt);
        }
        else
        {
            preg_replace("/[\n]{1,}/isU", "<br/>", $txt);
        }
        return $txt;
    }

}