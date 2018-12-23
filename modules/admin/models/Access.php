<?php

/**
 * 功能描述
 * ============================================================================
 * * All Rights Reserved by Xinlonghang Network Technology Co,.Ltd of SHANGHAI.
 * 网站地址: http://www.easyrong.com；
 * ============================================================================
 * $Author: wujiepeng $
 */

namespace app\modules\admin\models;

use yii\db\ActiveRecord;
use Yii;

class Access extends ActiveRecord
{

    public static function tableName()
    {
        return "{{%access}}";
    }

    public function rules()
    {
        return [
            ['title', 'required', 'message' => '权限标题不能为空', 'on' => ['add', 'modify']],
            ['sort', 'required', 'message' => '排序不能为空', 'on' => ['add', 'modify']],
            ['sort', 'integer', 'message' => '请填写整数', 'on' => ['add', 'modify']],
            ['urls', 'required', 'message' => 'Urls不能为空！', 'on' => ['add', 'modify']],
            [['pid'], 'safe']
        ];
    }

    public function getData()
    {
        $all_role = self::find()->asArray()->orderBy('sort DESC')->all();
        return $all_role;
    }

    public function add($data)
    {
        $this->scenario = 'add';
        if ($this->load($data) && $this->validate())
        {
            $this->urls = json_encode(explode("\n", $this->urls));
            $this->created_time = date('Y-m-d H:i:s');
            if ($this->save(false))
            {
                return true;
            }
        }
        return false;
    }

    public function modify($data)
    {
        $this->scenario = 'modify';
        if ($this->load($data) && $this->validate())
        {
            $this->urls = json_encode(explode("\n", $this->urls));
            $this->updated_time = date('Y-m-d H:i:s');
            if ($this->save(false))
            {
                return true;
            }
        }
        return false;
    }

    public function getOptions()
    {
        $data = $this->getData();
        $tree = $this->getTree($data);
        $tree = $this->setPrefix($tree);
        $options = ['添加一级权限'];
        foreach ($tree as $v)
        {
            $options[$v['id']] = $v['title'];
        }
        return $options;
    }

    public function getTree($node, $pid = 0)
    {
        $tree = [];
        foreach ($node as $v)
        {
            if ($v['pid'] == $pid)
            {
                $tree[] = $v;
                $tree = array_merge($tree, $this->getTree($node, $v['id']));
            }
        }
        return $tree;
    }

    public function setPrefix($data, $p = "|----")
    {
        $tree = [];
        $num = 1;
        $prefix = [0 => 1];
        while ($val = current($data))
        {
            $key = key($data);
            if ($key > 0)
            {
                if ($data[$key - 1]['pid'] != $val['pid'])
                {
                    $num++;
                }
            }
            if (array_key_exists($val['pid'], $prefix))
            {
                $num = $prefix[$val['pid']];
            }
            $val['title'] = str_repeat($p, $num - 1) . $val['title'];
            $prefix[$val['pid']] = $num;
            $tree[] = $val;
            next($data);
        }
        return $tree;
    }

    public function getTreeList()
    {
        $data = $this->getData();
        $tree = $this->getTree($data);
        return $tree = $this->setPrefix($tree);
    }

    //节点合并
    public function node_merge($node, $pid = 0)
    {
        $arr = array();
        foreach ($node as $v)
        {
            if ($v['pid'] == $pid)
            {
                $v['child'] = self::node_merge($node, $v['id']);
                $arr[] = $v;
            }
        }
        return $arr;
    }

    public function getAccess()
    {
        $data = $this->getData();
        $tree = $this->getTree($data);
        return $tree = $this->node_merge($tree);
    }

}

?>
