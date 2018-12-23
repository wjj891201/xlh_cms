<?php

namespace app\models;

use yii\db\ActiveRecord;
use Yii;
use yii\helpers\ArrayHelper;

class Region extends ActiveRecord
{

    public static function tableName()
    {
        return "{{%region}}";
    }

    public function rules()
    {
        return [
            ['parent_id', 'required', 'message' => '上级分类不能为空'],
            ['region_name', 'required', 'message' => '地区名称不能为空'],
            ['alias', 'required', 'message' => '别名不能为空'],
            ['alias', 'unique', 'message' => '别名已被使用'],
            ['sort_order', 'required', 'message' => '排序不能为空'],
            ['sort_order', 'integer', 'message' => '请填写整数'],
            [['description', 'hot', 'closed', 'thumb'], 'safe']
        ];
    }

    public function add($data)
    {
        if ($this->load($data) && $this->save())
        {
            return true;
        }
        return false;
    }

    public function getData()
    {
        $cates = self::find()->orderBy("sort_order DESC")->all();
        $cates = ArrayHelper::toArray($cates);
        return $cates;
    }

    public function getTree($cates, $pid = 2)
    {
        $tree = [];
        foreach ($cates as $cate)
        {
            if ($cate['parent_id'] == $pid)
            {
                $tree[] = $cate;
                $tree = array_merge($tree, $this->getTree($cates, $cate['region_id']));
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
                if ($data[$key - 1]['parent_id'] != $val['parent_id'])
                {
                    $num++;
                }
            }
            if (array_key_exists($val['parent_id'], $prefix))
            {
                $num = $prefix[$val['parent_id']];
            }
            $val['region_name'] = str_repeat($p, $num) . $val['region_name'];
            $prefix[$val['parent_id']] = $num;
            $tree[] = $val;
            next($data);
        }
        return $tree;
    }

    public function getOptions()
    {
        $data = $this->getData();
        $tree = $this->getTree($data);
        $tree = $this->setPrefix($tree);
        $controller = Yii::$app->controller->id;
        //在招商信息添加页面不需要
        if ($controller != 'news')
        {
            $options = ['2' => '添加顶级分类'];
        }
        foreach ($tree as $cate)
        {
            $options[$cate['region_id']] = $cate['region_name'];
        }
        return $options;
    }

    public function getTreeList()
    {
        $data = $this->getData();
        $tree = $this->getTree($data);
        return $tree = $this->setPrefix($tree);
    }

    public static function getMenu()
    {
        $top = self::find()->where('parent_id = :pid', [":pid" => 0])->limit(11)->asArray()->all();
        $data = [];
        foreach ((array) $top as $k => $cate)
        {
            $cate['children'] = self::find()->where("parent_id = :pid", [":pid" => $cate['region_id']])->limit(10)->asArray()->all();
            $data[$k] = $cate;
        }
        return $data;
    }

    public static function getone($where)
    {
        $detail = self::find()->select(['region_id', 'alias', 'thumb', 'region_name', 'parent_id'])->where($where)->asArray()->one();
        return $detail;
    }

    public static function getall($where)
    {
        $getall = self::find()->select(['region_id', 'alias', 'region_name', 'parent_id'])->where($where)->asArray()->all();
        return $getall;
    }

}
