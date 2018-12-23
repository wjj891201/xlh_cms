<?php

namespace app\models;

use yii\db\ActiveRecord;
use Yii;
use app\libs\Tool;

class EnterpriseBase extends ActiveRecord
{

    public static function tableName()
    {
        return "{{%enterprise_base}}";
    }

    public function attributeLabels()
    {
        return [
            'enterprise_name' => '企业名称',
            'town_id' => '所属区域',
            'legal_person' => '法定代表人',
            'legal_person_phone' => '法人手机',
            'contact_address' => '通讯地址',
            'contact_person_man' => '企业联系人',
            'contact_person_phone' => '联系人手机',
            'contact_mail' => '电子邮箱',
            'industry_id' => '行业',
            'enterprise_info' => '企业简介',
            'business_licence' => '营业执照'
        ];
    }

    public function rules()
    {
        return [
                [['enterprise_name', 'town_id', 'legal_person', 'legal_person_phone', 'contact_address', 'contact_person_man', 'contact_person_phone', 'contact_mail', 'industry_id', 'enterprise_info', 'business_licence'], 'required', 'message' => '{attribute}必填'],
                [['legal_person_phone', 'contact_person_phone'], 'match', 'pattern' => '/^[1][358][0-9]{9}$/', 'message' => '{attribute}号码格式错误'],
                ['contact_mail', 'email', 'message' => '{attribute}格式错误'],
                ['user_id', 'default', 'value' => Yii::$app->session['member']['userid']],
                ['district', 'default', 'value' => '江西省-南昌市'],
                ['base_create_time', 'default', 'value' => date('Y-m-d H:i:s')],
                ['base_update_time', 'default', 'value' => date('Y-m-d H:i:s')],
                [['register_info', 'institution_code', 'credit_code', 'register_date', 'register_capital'], 'safe']
        ];
    }

    public function add($data)
    {
        $json_register = json_decode($data['EnterpriseBase']['register_info'], true);
        $this->institution_code = $json_register['institution_code']; //组织机构代码
        $this->credit_code = $json_register['credit_code']; //信用代码
        $this->register_date = $json_register['register_date']; //注册日期
        $this->register_capital = $json_register['register_capital']; //注册资本
        if ($this->load($data) && $this->save())
        {
            return true;
        }
        return false;
    }

    /**
     * 通过企业名称精确获取企业信息（启信宝数据）
     * @param string $name  企业名称
     * @return array
     */
    public static function get_enterprise_info_by_name($name)
    {
        $url = 'http://crm.easyrong.com/api/qxbCheckName';
        $sign = md5($name . "b3af409bb8423187c75e6c7f5b683908");
        $url = $url . '?key=' . urlencode($name) . '&sign=' . $sign;
        $fields = [];
        $result = json_decode(Tool::curlGet($url, $fields), true);
        if (!empty($result['data']) && is_array($result['data']))
        {
            return $result['data'];
        }
        return [];
    }

    /**
     * 获取基础表的主键id
     */
    public static function getBaseId()
    {
        $base_id = self::find()->select('base_id')->where(['user_id' => Yii::$app->session['member']['userid']])->scalar();
        return $base_id;
    }

    /**
     * 获取地区
     */
    public function getTown()
    {
        return $this->hasOne(Area::className(), ['id' => 'town_id']);
    }

    /**
     * 获取mh_enterprise_finance详情
     */
    public function getFinance()
    {
        return $this->hasOne(EnterpriseFinance::className(), ['base_id' => 'base_id']);
    }

    /**
     * 获取mh_enterprise_describe详情
     */
    public function getDescribe()
    {
        return $this->hasOne(EnterpriseDescribe::className(), ['base_id' => 'base_id']);
    }

    /**
     * 获取mh_enterprise_loan详情
     */
    public function getLoan()
    {
        return $this->hasOne(EnterpriseLoan::className(), ['base_id' => 'base_id']);
    }

    /**
     * （首页）企业申请总数相关
     */
    public static function apply_all_statistics($where = [])
    {
        return EnterpriseBase::find()->where($where)->count();
    }

    /**
     * （首页）企业申请总数相关
     */
    public static function apply_in_statistics($where = [])
    {
        return EnterpriseBase::find()->alias('eb')->leftJoin('{{%workflow_log}} wl', 'eb.base_id=wl.app_id')->where($where)->count();
    }

}
