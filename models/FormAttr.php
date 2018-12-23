<?php

namespace app\models;

use yii\db\ActiveRecord;
use Yii;

class FormAttr extends ActiveRecord
{

    public static function tableName()
    {
        return "{{%form_attr}}";
    }

    public function rules()
    {
        return [
            ['typename', 'required', 'message' => '简述文字不能为空', 'on' => ['lower', 'senior', 'e_lower', 'e_senior']],
            ['attrname', 'required', 'message' => '字段名称不能为空', 'on' => ['lower', 'senior', 'e_lower', 'e_senior']],
            ['attrname', 'match', 'pattern' => '/^[a-zA-Z]{2}[a-zA-Z]{1,45}$/', 'message' => '字段名称填写错误，输入长度不能小于4和大于40的英文字符', 'on' => ['lower', 'senior']],
            ['attrname', 'validateAttrname', 'on' => ['lower', 'senior']],
            [['attrsize', 'attrrow'], 'match', 'pattern' => '/^[1-9]{1}[0-9]{0,2}$/', 'message' => '长度填写错误，请填写长度不小于3的整数', 'on' => ['lower', 'senior', 'e_lower', 'e_senior']],
            ['attrvalue', 'required', 'message' => '请所选择的字段类型必须有默认值', 'on' => ['senior', 'e_senior']],
            [['fgid', 'inputtype', 'isvalidate', 'isclass', 'typeremark', 'validatetext'], 'safe']
        ];
    }

    public function validateAttrname()
    {
        if (!$this->hasErrors())
        {
            $data = self::find()->where(['and', ['attrname' => $this->attrname], ['fgid' => $this->fgid]])->one();
            if (!is_null($data))
            {
                $this->addError("attrname", "字段已存在");
            }
        }
    }

    public function add($data)
    {
        $inputtype = $data['FormAttr']['inputtype'];
        if (in_array($inputtype, ['select', 'radio', 'checkbox', 'selectinput']))
        {
            $this->scenario = 'senior';
        }
        else
        {
            $this->scenario = 'lower';
        }

        if ($this->load($data) && $this->validate())
        {
            //在mh_form_attr表中添加新增的字段
            $formType = Yii::$app->params['formType'];
            $key = $this->array_key($formType, $this->inputtype, 'key');
            $attrarray = $formType[$key];
            if (!$attrarray)
            {
                return false;
            }
            $attrlenther = $attrarray['varlong'];
            if ($attrarray['alter'] != 'TEXT')
            {

                $alter = $attrarray['alter'] == 'INT' || $attrarray['alter'] == 'FLOAT' ? $attrarray['alter'] . '(' . $attrarray['varlong'] . ') DEFAULT \'0\'' : $attrarray['alter'] . '(' . $attrarray['varlong'] . ')';
            }
            else
            {
                $alter = $attrarray['alter'];
            }
            //解决字段的重复问题
            $db_where = "fgid<>$this->fgid and attrname='$this->attrname'";
            $num = self::find()->where($db_where)->count();
            if ($num == 0)
            {
                $sql = 'ALTER TABLE {{%form_value}} ADD COLUMN ' . $this->attrname . ' ' . $alter . ' NOT NULL';
                $connection = Yii::$app->db;
                $connection->createCommand($sql)->query();
            }
            $db_field = 'fgid,pid,typename,typeremark,attrname,inputtype,attrvalue,validatetext,attrsize,attrrow,attrlenther,isclass,isvalidate,isline';
            $db_values = "$this->fgid,50,'$this->typename','$this->typeremark','$this->attrname','$this->inputtype','$this->attrvalue','$this->validatetext',$this->attrsize,$this->attrrow,$attrlenther,1,$this->isvalidate,0";
            $sql = 'INSERT INTO {{%form_attr}} (' . $db_field . ') VALUES (' . $db_values . ')';
            $connection = Yii::$app->db;
            $connection->createCommand($sql)->query();
            return true;
        }
        return false;
    }

    public function edit($data)
    {
        $inputtype = $data['FormAttr']['inputtype'];
        if (in_array($inputtype, ['select', 'radio', 'checkbox', 'selectinput']))
        {
            $this->scenario = 'e_senior';
        }
        else
        {
            $this->scenario = 'e_lower';
        }
        if ($this->load($data) && $this->validate())
        {
            $db_set_str = null;
            $db_set_str.= ",attrvalue='$this->attrvalue',validatetext='$this->validatetext'";
            if ($this->attrsize)
            {
                $db_set_str.= ',attrsize=' . $this->attrsize;
            }
            if ($this->attrrow)
            {
                $db_set_str.= ',attrrow=' . $this->attrrow;
            }
            if ($this->isvalidate)
            {
                $db_set_str.= ',isvalidate=' . $this->isvalidate;
            }
            else
            {
                $db_set_str.= ',isvalidate=0';
            }
            $db_where = 'faid=' . $this->faid;
            $db_set = "typename='$this->typename',typeremark='$this->typeremark',isclass=$this->isclass" . $db_set_str;
            $sql = 'UPDATE {{%form_attr}} SET ' . $db_set . ' WHERE ' . $db_where;
            $connection = Yii::$app->db;
            $connection->createCommand($sql)->query();
            return true;
        }
        return false;
    }

    function array_key($array = [], $string = null, $field = null, $refield = null)
    {
        if (!is_array($array) || count($array) < 1)
        {
            return false;
        }
        foreach ($array as $key => $value)
        {
            if ($value[$field] == $string)
            {
                $rkey = $refield ? $value[$refield] : $key;
            }
        }
        return $rkey;
    }

    public static function getOne($where)
    {
        $info = self::find()->where($where)->one();
        return $info;
    }

    public static function getAll($where = '', $columns = '')
    {
        $all = self::find()->where($where)->orderBy($columns)->all();
        return $all;
    }

    /**
     * 根据传入的fgid查出字段
     */
    public static function getFormatt($fgid, $selectedid = true)
    {
        $sql = 'SELECT * FROM {{%form_attr}} WHERE isclass=1 and fgid=' . $fgid . ' ORDER BY pid, faid desc';
        $connection = Yii::$app->db;
        $all = $connection->createCommand($sql)->queryAll();
        foreach ($all as $key => $vo)
        {
            if ($vo['inputtype'] == 'select' || $vo['inputtype'] == 'radio' || $vo['inputtype'] == 'checkbox')
            {
                $forvalue = preg_split("/\n/", $vo['attrvalue']);
                $newvalue = [];
                foreach ($forvalue as $k => $forvalue)
                {
                    if ($k == 0 && $selectedid)
                    {
                        $newvalue[] = ['name' => $forvalue, 'selected' => 'selected'];
                    }
                    else
                    {
                        $newvalue[] = ['name' => $forvalue, 'selected' => ''];
                    }
                }
                $vo['attrvalue'] = $newvalue;
            }
            if ($vo['inputtype'] == 'selectinput')
            {
                $forvalue = preg_split("/\n/", $vo['attrvalue']);
                $selectinputvalue = array();
                foreach ($forvalue as $ke => $value)
                {
                    $selectinputvalue[] = array('name' => $value);
                }
                $vo['selectinputvalue'] = $selectinputvalue;
            }
            $attrread[] = $vo;
        }
        return $attrread;
    }

}