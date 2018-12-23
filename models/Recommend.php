<?php

namespace app\models;

use yii\db\ActiveRecord;
use Yii;

class Recommend extends ActiveRecord
{

    public static function tableName()
    {
        return "{{%news_label}}";
    }

    public function rules()
    {
        return [
            ['mid', 'required', 'message' => '必选'],
            ['labelname', 'required', 'message' => '必填'],
        ];
    }

    public function add($data, $lang = 'cn')
    {
        $this->lng = $lang;
        if ($this->load($data) && $this->save())
        {
            return true;
        }
        return false;
    }

    public static function getData($where = [])
    {
        $all = self::find()->where($where)->all();
        return $all;
    }

    public function getMname()
    {
        return $this->hasOne(Model::className(), ['id' => 'mid']);
    }

    public static function get_news_label_array($dlid = 0, $mid = 0, $lng = 'cn')
    {
        $db_where = "lng='$lng'";
        if ($mid > 0)
        {
            $db_where.=' AND mid=' . $mid;
        }
        $chacherray = self::find()->select(['dlid', 'mid', 'labelname'])->where($db_where)->orderBy(['dlid' => SORT_DESC])->asArray()->all();
        $arrayList = array();
        if (!empty($dlid))
        {
            $dlid = str_replace(' ', '', $dlid);
            $dlidarray = explode(',', $dlid);
        }
        $i = count($chacherray);
        if (!empty($dlid) && is_array($chacherray))
        {
            foreach ($chacherray as $key => $value)
            {
                $chacherray[$key]['selected'] = (in_array($value['dlid'], $dlidarray)) ? 'CHECKED' : '';
            }
        }
        $arrayList['num'] = $i;
        $arrayList['list'] = $chacherray;
        return $arrayList;
    }

}
