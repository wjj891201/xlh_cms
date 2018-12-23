<?php

namespace app\models;

use yii\db\ActiveRecord;
use Yii;

//use app\models\Type;
//use app\models\NewsContent;
//use app\models\NewsAttr;

class News extends ActiveRecord
{

    public $column;

    public static function tableName()
    {
        return "{{%news}}";
    }

    public function rules()
    {
        return [
            ['name', 'required', 'message' => '名称不能为空'],
            ['category', 'required', 'message' => '分类不能为空'],
            ['summary', 'required', 'message' => '简要概述不能为空'],
            ['content', 'required', 'message' => '描述不能为空'],
            ['displayorder', 'required', 'message' => '排序不能为空'],
            ['displayorder', 'integer', 'message' => '请填写整数'],
            [['thumb', 'status', 'title', 'keywords', 'description', 'createtime'], 'safe']
        ];
    }

    public function add($data)
    {
        $this->createtime = date('Y-m-d H:i:s');
        if ($this->load($data) && $this->save())
        {
            $id = Yii::$app->db->getLastInsertID(); //获取最后添加的id
            if (isset($data['thumb_url']) && !empty($data['thumb_url']))
            {
                $this->updateAll(['thumb_url' => json_encode($data['thumb_url'])], ['id' => $id]);
            }
            return true;
        }
        return false;
    }

    public function modify($data)
    {
        if ($this->load($data) && $this->save())
        {
            $id = $this->id; //获取该条数据的id
            if (isset($data['thumb_url']) && !empty($data['thumb_url']))
            {
                $this->updateAll(['thumb_url' => json_encode($data['thumb_url'])], ['id' => $id]);
            }
            else
            {
                $this->updateAll(['thumb_url' => ""], ['id' => $id]);
            }
            return true;
        }
        return false;
    }

    //新闻统一获取方法
    public static function getNews($para)
    {
        $mid = isset($para['mid']) ? $para['mid'] : '';
        $tid = isset($para['tid']) ? $para['tid'] : '';
        $limit = isset($para['max']) ? $para['max'] : '20';
        $lng = isset($para['lng']) ? $para['lng'] : 'cn';
        $recommend = isset($para['dlid']) ? $para['dlid'] : '';
        $where = 'isclass=1';
        if (!empty($mid))
        {
            $where.=" AND mid=$mid";
        }
        if (!empty($recommend))
        {
            $where.=" AND FIND_IN_SET('$recommend',recommend)";
        }
        if (!empty($tid) && !empty($mid))
        {
            $cate = Type::getData(['lng' => $lng]);
            $tids = Type::getChildsid($cate, $tid);
            array_unshift($tids, (string) $tid);
            $where.=" AND tid IN (" . implode(',', $tids) . ")";
        }
        if (!empty($lng))
        {
            $where.=" AND lng='$lng'";
        }
        $news = self::find()->select(['did', 'tid', 'title', 'pic', 'summary', 'addtime'])->where($where)->limit($limit)->orderBy(['pid' => SORT_DESC, 'addtime' => SORT_DESC])->all();
        return $news;
    }

    public function getCate()
    {
        return $this->hasOne(Type::className(), ['id' => 'category']);
    }

    public function getContent()
    {
        return $this->hasOne(NewsContent::className(), ['did' => 'did']);
    }

    public function getAttr()
    {
        return $this->hasOne(NewsAttr::className(), ['did' => 'did']);
    }

    public function getAlbum()
    {
        return $this->hasMany(NewsAlbum::className(), ['did' => 'did']);
    }

    /**
     * 获取内容详情
     */
    public static function get_news($did, $returnname = null)
    {
        if (empty($did))
        {
            return false;
        }
        $db_sql = "SELECT c.*,b.*,a.* FROM {{%news}} AS a LEFT JOIN {{%news_content}} AS b ON a.did = b.did LEFT JOIN {{%news_attr}} AS c ON a.did = c.did WHERE a.did = $did";
        $connection = Yii::$app->db;
        $all = $connection->createCommand($db_sql)->queryAll();
        return $all[0];
    }

    /**
     * 获取单页
     */
    public static function getOne($where = [])
    {
        $info = self::find()->where($where)->one();
        return $info;
    }

}
