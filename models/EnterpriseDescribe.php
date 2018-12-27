<?php

namespace app\models;

use yii\db\ActiveRecord;
use Yii;

class EnterpriseDescribe extends ActiveRecord
{

    public $code;
    public $qualification;

    public static function tableName()
    {
        return "{{%enterprise_describe}}";
    }

    public function attributeLabels()
    {
        return [
            'product_tech_desc' => '主要产品及技术领域',
            'equity_num' => '企业拥有知识产权数',
            'code' => '核心管理人员职业经历',
            'qualification' => '企业拥有资质'
        ];
    }

    public function rules()
    {
        return [
                [['product_tech_desc', 'equity_num', 'code', 'qualification'], 'required', 'message' => '{attribute}必填'],
                ['equity_num', 'number', 'message' => '{attribute}必须为数字'],
                ['user_id', 'default', 'value' => Yii::$app->session['member']['userid']],
                ['base_id', 'default', 'value' => EnterpriseBase::getBaseId()],
                [['profession', 'qualification_certificate'], 'safe']
        ];
    }

    public function add($data)
    {
        # 处理核心人员~~~start
        $pro_name = $data['pro_name'];
        $pro_job = $data['pro_job'];
        $pro_exp = $data['pro_exp'];
        if (!empty($pro_name) && !empty($pro_job) && !empty($pro_exp))
        {
            $people = [];
            $count = count($pro_name);
            for ($i = 0; $i < $count; $i++)
            {
                $people[$i]['name'] = $pro_name[$i];
                $people[$i]['position'] = $pro_job[$i];
                $people[$i]['experience'] = $pro_exp[$i];
            }
            $data['EnterpriseDescribe']['profession'] = json_encode($people);
            unset($data['pro_name'], $data['pro_job'], $data['pro_exp']);
        }
        # 处理核心人员~~~end
        # 处理资质~~~start
        $u_zizhi_enterprise = $data['u_zizhi_enterprise'];
        $u_zizhi_china_enterprise = $data['u_zizhi_china_enterprise'];
        $u_zizhi_file = $data['u_zizhi_file'];
        $u_zizhi_file_name = $data['u_zizhi_file_name'];
        if (!empty($u_zizhi_enterprise) && !empty($u_zizhi_file) && !empty($u_zizhi_file_name))
        {
            $arr_qualification = [];
            $count = count($u_zizhi_enterprise);
            for ($i = 0; $i < $count; $i++)
            {
                $arr_qualification[$i]['id'] = $u_zizhi_enterprise[$i];
                $arr_qualification[$i]['name'] = $u_zizhi_china_enterprise[$i];
                $arr_qualification[$i]['file_name'] = $u_zizhi_file_name[$i];
                $arr_qualification[$i]['path'] = $u_zizhi_file[$i];
            }
            $data['EnterpriseDescribe']['qualification_certificate'] = json_encode($arr_qualification);
            unset($data['u_zizhi_enterprise'], $data['u_zizhi_china_enterprise'], $data['u_zizhi_file'], $data['u_zizhi_file_name']);
        }
        # 处理资质~~~end
        if ($this->load($data) && $this->save())
        {
            return true;
        }
        return false;
    }

}
