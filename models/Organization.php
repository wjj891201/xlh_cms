<?php

namespace app\models;

use yii\db\ActiveRecord;
use Yii;

class Organization extends ActiveRecord
{

    public static function tableName()
    {
        return "{{%organization}}";
    }

    public function attributeLabels()
    {
        return [
            'name' => '机构名称',
            'relation_bank_id' => '分行'
        ];
    }

    public function rules()
    {
        return [
                ['name', 'required', 'message' => '{attribute}不能为空', 'on' => ['zhi', 'orther']],
                ['relation_bank_id', 'required', 'message' => '请选择{attribute}', 'on' => 'zhi'],
                ['add_time', 'default', 'value' => time(), 'on' => ['zhi', 'orther']],
                ['relation_bank_id', 'safe', 'on' => 'orther'],
                [['pid', 'status', 'fixed'], 'safe', 'on' => ['zhi', 'orther']]
        ];
    }

    public function add($data)
    {
        if ($data['Organization']['pid'] == 5)
        {
            $this->scenario = "zhi";
        }
        else
        {
            $this->scenario = "orther";
        }
        if ($this->load($data) && $this->save())
        {
            return true;
        }
        return false;
    }

    public function getTreeList()
    {
        $data = $this->getData();
        $tree = $this->getTree($data);
        return $tree = $this->setPrefix($tree);
    }

    public static function getData($where = [])
    {
        $result = self::find()->where($where)->all();
        return $result;
    }

    public function getOptions()
    {
        $data = $this->getData();
        $tree = $this->getTree($data);
        $tree = $this->setPrefix($tree);
        $options = ['' => '请选择上级机构'];
        foreach ($tree as $v)
        {
            $options[$v['id']] = $v['name'];
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
            $val['name'] = str_repeat($p, $num - 1) . $val['name'];
            $prefix[$val['pid']] = $num;
            $tree[] = $val;
            next($data);
        }
        return $tree;
    }

    /**
     * 获取分行名字
     */
    public function getBank()
    {
        return $this->hasOne(Organization::className(), ['id' => 'relation_bank_id']);
    }

}
