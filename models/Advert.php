<?php

namespace app\models;

use yii\db\ActiveRecord;
use Yii;

class Advert extends ActiveRecord
{

    public static function tableName()
    {
        return "{{%advert}}";
    }

    public function rules()
    {
        return [
            ['atid', 'required', 'message' => '所属广告位不能为空', 'on' => ['p_w', 'p_n', 'n_w', 'n_n']],
            ['title', 'required', 'message' => '广告名称不能为空', 'on' => ['p_w', 'p_n', 'n_w', 'n_n']],
            ['gotoid', 'required', 'message' => '跳转关联分类ID', 'on' => ['p_n', 'n_n']],
            ['gotoid', 'integer', 'message' => '请正确填写ID', 'on' => ['p_n', 'n_n']],
            ['url', 'required', 'message' => '跳转地址不能为空', 'on' => ['p_w', 'n_w']],
            ['url', 'url', 'defaultScheme' => 'http', 'message' => '正确填写跳转地址', 'on' => ['p_w', 'p_w']],
            ['filename', 'required', 'message' => '缩略图不能为空', 'on' => ['p_w', 'p_n']],
            [['islink', 'adtype', 'content', 'isclass', 'addtime'], 'safe'],
        ];
    }

    public function add($data, $lng = 'cn')
    {
        $adtype = $data['Advert']['adtype'];
        $islink = $data['Advert']['islink'];
        if ($adtype == 1 && $islink == 1)
        {
            $this->scenario = 'p_w';
        }
        if ($adtype == 1 && $islink == 2)
        {
            $this->scenario = 'p_n';
        }
        if ($adtype == 2 && $islink == 1)
        {
            $this->scenario = 'n_w';
        }
        if ($adtype == 2 && $islink == 2)
        {
            $this->scenario = 'n_n';
        }
        $this->lng = $lng;
        $this->addtime = time();
        $this->pid = 50;
        if ($this->load($data) && $this->save())
        {
            return true;
        }
        return false;
    }

    public function getPosition()
    {
        return $this->hasOne(AdvertType::className(), ['atid' => 'atid']);
    }

    public static function get_ad($where)
    {
        $ads = self::find()->where($where)->asArray()->orderBy("pid DESC")->all();
        return $ads;
    }

    public static function get_one($where)
    {
        $info = self::find()->where($where)->asArray()->orderBy("pid DESC")->one();
        return $info['filename'];
    }

}
