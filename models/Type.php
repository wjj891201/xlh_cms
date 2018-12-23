<?php

namespace app\models;

use yii\db\ActiveRecord;
use Yii;
use yii\helpers\ArrayHelper;

class Type extends ActiveRecord
{

    public static function tableName()
    {
        return "{{%typelist}}";
    }

    public function rules()
    {
        return [
            ['mid', 'required', 'message' => '所属模型未选择', 'on' => ['channel', 'list', 'link', 'page']],
            ['typename', 'required', 'message' => '分类名称不能为空', 'on' => ['channel', 'list', 'link', 'page']],
            ['indextemplates', 'required', 'message' => '频道主页模板不能为空', 'on' => 'channel'],
            ['template', 'required', 'message' => '列表模板不能为空', 'on' => ['channel', 'list']],
            ['readtemplate', 'required', 'message' => '阅读模板不能为空', 'on' => ['channel', 'list', 'page']],
            ['pagemax', 'integer', 'message' => '请填写整数', 'on' => ['channel', 'list']],
            [['upid', 'typepic', 'orther_typepic', 'content', 'headtitle', 'keywords', 'description', 'styleid', 'ismenu', 'isorderby', 'ordertype', 'ispart', 'isline', 'typeurl', 'gotoline'], 'safe']
        ];
    }

    public function add($data, $lang = 'cn')
    {
        $scenario = $data['Type']['styleid'];
        switch ($scenario)
        {
            case 1:
                $this->scenario = "channel";
                break;
            case 2:
                $this->scenario = "list";
                break;
            case 3:
                $this->scenario = "link";
                break;
            case 4:
                $this->scenario = "page";
                break;
            default:
                $this->scenario = "list";
                break;
        }
        $this->lng = $lang;
        if ($this->load($data) && $this->save())
        {
            $tid = Yii::$app->db->getLastInsertID();
            if ($tid)
            {
                //添加
                $r_tid = $tid;
            }
            else
            {
                //编辑
                $r_tid = $this->tid;
            }
            //topid处理
            $topid = self::get_top_id($r_tid);
            $topid = $topid != $r_tid ? $topid : 0;
            self::updateAll(['topid' => $topid], ['tid' => $r_tid]);

            //如果是单网页
            if ($this->styleid == 4)
            {
                $connection = Yii::$app->db;
                if ($tid)
                {
                    //添加   则需要向内容表插入基础内容
                    $time = time();
                    $aid = Yii::$app->session['admin']['id'];
                    $db_field = 'lng,pid,mid,aid,tid,title,longtitle,addtime,uptime,template,isbase';
                    $db_values = "'$lang',50,$this->mid,$aid,$tid,'$this->typename','$this->typename',$time,$time,'$this->readtemplate',1";
                    $sql = 'INSERT INTO {{%news}} (' . $db_field . ') VALUES (' . $db_values . ')';
                    $connection->createCommand($sql)->query();
                    //获取文章的did然后反更新分类表中字段linkid
                    $did = Yii::$app->db->getLastInsertID();
                    self::updateAll(['linkid' => $did], ['tid' => $tid]);
                }
                else
                {
                    //编辑   更新模板
                    $sql = "UPDATE {{%news}} SET template = '$this->readtemplate' WHERE tid = '$this->tid'";
                    $connection->createCommand($sql)->query();
                }
            }
            return true;
        }
        return false;
    }

    public static function getData($where = [])
    {
        $cates = self::find()->where($where)->orderBy(['pid' => SORT_ASC])->all();
        $cates = ArrayHelper::toArray($cates);
        return $cates;
    }

    public static function getTree($cates, $pid = 0)
    {
        $tree = [];
        foreach ($cates as $cate)
        {
            if ($cate['upid'] == $pid)
            {
                $tree[] = $cate;
                $tree = array_merge($tree, self::getTree($cates, $cate['tid']));
            }
        }
        return $tree;
    }

    public static function setPrefix($data, $p = "|----")
    {
        $tree = [];
        $num = 1;
        $prefix = [0 => 1];
        while ($val = current($data))
        {
            $key = key($data);
            if ($key > 0)
            {
                if ($data[$key - 1]['upid'] != $val['upid'])
                {
                    $num++;
                }
            }
            if (array_key_exists($val['upid'], $prefix))
            {
                $num = $prefix[$val['upid']];
            }
            $val['typename'] = str_repeat($p, $num - 1) . $val['typename'];
            $prefix[$val['upid']] = $num;
            $tree[] = $val;
            next($data);
        }
        return $tree;
    }

    public static function getOptions($where)
    {
        $data = self::getData($where);
        $tree = self::getTree($data);
        $tree = self::setPrefix($tree);
        $options = [];
        foreach ($tree as $vo)
        {
            $options[$vo['tid']] = $vo['typename'];
        }
        return $options;
    }

    public static function getTreeList($where)
    {
        $data = self::getData($where);
        $tree = self::getTree($data);
        return $tree = self::setPrefix($tree);
    }

    public static function getMenu($where, $tid)
    {
        $top = self::find()->select(['tid', 'typename'])->where($where)->asArray()->orderBy(['pid' => SORT_ASC])->all();
        array_unshift($top, ['tid' => '', 'typename' => '首页']);
        $data = [];
        foreach ((array) $top as $k => $vo)
        {
            if ($vo['tid'])
            {
                $vo['children'] = self::find()->select(['tid', 'typename'])->where("upid = :upid", [":upid" => $vo['tid']])->asArray()->orderBy(['pid' => SORT_ASC])->all();
                $vo['select'] = $vo['tid'] == $tid ? 1 : 0;
            }
            else
            {
                $vo['children'] = [];
                $vo['select'] = $tid == '' ? 1 : 0;
            }
            $data[$k] = $vo;
        }
        return $data;
    }

    public static function getone($where)
    {
        $getone = self::find()->where($where)->one();
        return $getone;
    }

//    public static function get_chind($cid)
//    {
//        $info = self::find()->where(['parentid' => $cid])->orderBy(['displayorder' => SORT_DESC])->asArray()->all();
//        return $info;
//    }

    public static function getCatePath($tid, &$result = [])
    {
        $row = self::getone(['tid' => $tid]);
        if ($row)
        {
            $result[] = $row;
            self::getCatePath($row['upid'], $result);
        }
        krsort($result);
        return $result;
    }

    //得到子分类
    public static function getChild($where)
    {
        $child = self::find()->where($where)->asArray()->all();
        return $child;
    }

    //分类链接
    public static function getUrl($tid)
    {
        $info = self::getone(['tid' => $tid]);
        if (!empty($info))
        {
            switch ($info['styleid'])
            {
                case 1://频道
                    $url = Yii::$app->urlManager->createUrl(['article/channel', 'tid' => $info['tid']]);
                    break;
                case 2://列表
                    $url = Yii::$app->urlManager->createUrl(['article/list', 'tid' => $info['tid']]);
                    break;
                case 4://单页
                    $url = Yii::$app->urlManager->createUrl(['single/detail', 'tid' => $info['tid']]);
                    break;
                case 3://跳转
                    if ($info['isline'] == 0)
                    {
                        //内网跳 
                        $sec = self::getone(['tid' => $info['gotoline']]);
                        switch ($sec['styleid'])
                        {
                            case 1://频道
                                $url = Yii::$app->urlManager->createUrl(['article/channel', 'tid' => $sec['tid']]);
                                break;
                            case 2://列表
                                $url = Yii::$app->urlManager->createUrl(['article/list', 'tid' => $sec['tid']]);
                                break;
                            case 4://单页
                                $url = Yii::$app->urlManager->createUrl(['single/detail', 'tid' => $sec['tid']]);
                                break;
                        }
                    }
                    else
                    {
                        //外网条
                        $url = $info['typeurl'];
                        break;
                    }
            }
        }
        else
        {
            $url = '../';
        }
        return $url;
    }

    /**
     * 根据styleid获取中文名
     */
    public static function getTypeName($styleid)
    {
        $html = '';
        switch ($styleid)
        {
            case 1:
                $html = '<font color="#489D66">频道分类</font>';
                break;
            case 2:
                $html = '列表分类';
                break;
            case 3:
                $html = '<font color="#FF0F0F">跳转链接</font>';
                break;
            case 4:
                $html = '<font color="#2E43E0">单网页</font>';
                break;
            default:
                $html = '列表分类';
                break;
        }
        return $html;
    }

    public static function get_top_id($tid)
    {
        $info = self::getone(['tid' => $tid]);
        if ($info['upid'] != 0)
        {
            return self::get_top_id($info['upid']);
        }
        return $info['tid'];
    }

    //传递一个父级分类id返回所有子分类id
    public static function getChildsid($cate, $upid)
    {
        $arr = [];
        foreach ($cate as $key => $vo)
        {
            if ($vo['upid'] == $upid)
            {
                $arr[] = $vo['tid'];
                $arr = array_merge($arr, self::getChildsid($cate, $vo['tid']));
            }
        }
        return $arr;
    }

}
