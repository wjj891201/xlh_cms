<?php

namespace app\models;

use yii\db\ActiveRecord;
use Yii;

class EnterpriseFinance extends ActiveRecord
{

    public $s_annual_sales;
    public $s_annual_profit;
    public $s_net_asset;
    public $s_asset_debt_ratio;

    public static function tableName()
    {
        return "{{%enterprise_finance}}";
    }

    public function attributeLabels()
    {
        return [
            'annual_sales' => '年度销售收入',
            'hightec_sales' => '高新技术产品销售收入',
            'annual_profit' => '年度利润总额',
            'research_input' => '研发经费投入',
            'net_asset' => '年度净资产',
            'asset_debt_ratio' => '资产负债率',
            'total_employees_num' => '员工总数',
            'above_college_num' => '大专以上科技人员数',
            'research_num' => '直接从事研发人员数',
            'accounting_system_before' => '企业适用会计制度',
            'accounting_system' => '企业适用会计制度',
            'accounting_system_lastest' => '企业适用会计制度',
            'asset_debt_file_before' => '资产负债表',
            'profit_distribution_file_before' => '利润及利润分配表',
            'asset_debt_file' => '资产负债表',
            'profit_distribution_file' => '利润及利润分配表',
            'asset_debt_file_lastest' => '资产负债表',
            'profit_distribution_file_lastest' => '利润及利润分配表'
        ];
    }

    public function rules()
    {
        return [
                [['hightec_sales', 'research_input', 'total_employees_num', 'above_college_num', 'research_num', 'accounting_system', 'accounting_system_lastest'], 'required', 'message' => '{attribute}必填', 'on' => ['6_q', '6_n', '!6_q', '!6_n']],
                ['accounting_system_before', 'required', 'message' => '{attribute}必填', 'on' => ['6_q', '6_n']],
                [['annual_sales', 'annual_profit', 'net_asset', 'asset_debt_ratio'], 'required', 'message' => '{attribute}必填', 'on' => ['6_q', '!6_q']],
                [['annual_sales', 'hightec_sales', 'annual_profit', 'research_input', 'net_asset', 'asset_debt_ratio'], 'number', 'message' => '{attribute}必须为数字', 'on' => ['6_q', '6_n', '!6_q', '!6_n']],
                [['total_employees_num', 'above_college_num', 'research_num'], 'match', 'pattern' => '/^[1-9]d*|0$/', 'message' => '{attribute}必须为正整数', 'on' => ['6_q', '6_n', '!6_q', '!6_n']],
                [['asset_debt_file_before', 'profit_distribution_file_before'], 'required', 'message' => '请上传{attribute}', 'on' => ['6_q', '6_n']],
                [['asset_debt_file', 'profit_distribution_file', 'asset_debt_file_lastest', 'profit_distribution_file_lastest'], 'required', 'message' => '请上传{attribute}', 'on' => ['6_q', '6_n', '!6_q', '!6_n']],
                ['hightec_sales', 'validateAs', 'on' => ['6_q', '!6_q']],
                ['above_college_num', 'validateAcn', 'on' => ['6_q', '6_n', '!6_q', '!6_n']],
                ['research_num', 'validateAcn', 'on' => ['6_q', '6_n', '!6_q', '!6_n']],
                ['user_id', 'default', 'value' => Yii::$app->session['member']['userid']],
                ['base_id', 'default', 'value' => EnterpriseBase::getBaseId()],
                [['finance_year', 's_annual_sales', 's_annual_profit', 's_net_asset', 's_asset_debt_ratio'], 'safe']
        ];
    }

    /**
     * 自定义验证方法（收入）
     * @param type $attribute
     * @param type $params
     */
    public function validateAs($attribute, $params)
    {
        if (!$this->hasErrors())
        {
            if ($this->$attribute >= $this->annual_sales)
            {
                $this->addError($attribute, "不能大于年度销售收入");
            }
        }
    }

    /**
     * 自定义验证方法（员工）
     * @param type $attribute
     * @param type $params
     */
    public function validateAcn($attribute, $params)
    {
        if (!$this->hasErrors())
        {
            if ($this->$attribute >= $this->total_employees_num)
            {
                $this->addError($attribute, "不能大于员工总数");
            }
        }
    }

    public function add($data)
    {
        $identify = isset($data['EnterpriseFinance']['accounting_system_before']);
        $accounting_system = $data['EnterpriseFinance']['accounting_system'];
        //（有2016年）与（2017年其他）
        if ($identify && $accounting_system == 3)
        {
            $this->scenario = '6_q';
        }
        //（有2016年）与（2017年非其他）
        if ($identify && $accounting_system != 3)
        {
            $this->scenario = '6_n';
        }
        //（无2016年）与（2017年其他）
        if (!$identify && $accounting_system == 3)
        {
            $this->scenario = '!6_q';
        }
        //（无2016年）与（2017年非其他）
        if (!$identify && $accounting_system != 3)
        {
            $this->scenario = '!6_n';
        }
        //报表解析的数据处理
        if (in_array($accounting_system, [1, 2]))
        {
            $s_net_asset = $data['EnterpriseFinance']['s_net_asset'];
            $s_asset_debt_ratio = $data['EnterpriseFinance']['s_asset_debt_ratio'];
            $s_annual_sales = $data['EnterpriseFinance']['s_annual_sales'];
            $s_annual_profit = $data['EnterpriseFinance']['s_annual_profit'];
            $data['EnterpriseFinance']['net_asset'] = !empty($s_net_asset) ? $s_net_asset : '';
            $data['EnterpriseFinance']['asset_debt_ratio'] = !empty($s_asset_debt_ratio) ? $s_asset_debt_ratio : '';
            $data['EnterpriseFinance']['annual_sales'] = !empty($s_annual_sales) ? $s_annual_sales : '';
            $data['EnterpriseFinance']['annual_profit'] = !empty($s_annual_profit) ? $s_annual_profit : '';
            unset($data['EnterpriseFinance']['s_net_asset'], $data['EnterpriseFinance']['s_asset_debt_ratio'], $data['EnterpriseFinance']['s_annual_sales'], $data['EnterpriseFinance']['s_annual_profit']);
        }
        if ($this->load($data) && $this->save())
        {
            return true;
        }
        return false;
    }

}
