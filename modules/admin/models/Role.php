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

class Role extends ActiveRecord
{

    public static function tableName()
    {
        return "{{%role}}";
    }

    public function rules()
    {
        return [
            ['name', 'required', 'message' => '角色名不能为空！', 'on' => ['add', 'modify']],
            ['name', 'unique', 'message' => '角色名已存在', 'on' => ['add', 'modify']],
        ];
    }

    public function getData()
    {
        $all_role = self::find()->asArray()->all();
        return $all_role;
    }

    public function add($data)
    {
        $this->scenario = 'add';
        $this->created_time = date('Y-m-d H:i:s');
        if ($this->load($data) && $this->save())
        {
            return true;
        }
        return false;
    }

    public function modify($data)
    {
        $this->scenario = 'modify';
        $this->updated_time = date('Y-m-d H:i:s');
        if ($this->load($data) && $this->save())
        {
            return true;
        }
        return false;
    }

}

?>
