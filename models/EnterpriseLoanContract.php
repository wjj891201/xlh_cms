<?php 
namespace app\models;

use yii\db\ActiveRecord;
use Yii;

class EnterpriseLoanContract extends ActiveRecord{

    public static function tableName(){
        return "{{%enterprise_loan_contract}}";
    }

    public function attributeLabels(){
        return [
            'contract_num'             => '贷款合同号',
            'loan_amount_money'        => '实际放贷金额',
            'contract_loan_start_time' => '贷款开始时间',
            'contract_loan_end_time'   => '贷款结束时间',
            'loan_day'                 => '贷款周期',
            'loan_rate'                => '贷款利率',
            'loan_benchmark_rate'      => '基准利率',
            'repayment_mode'           => '还款方式',
            'loan_voucher'             => '请上传放款凭证',
        ];
    }

    public function rules(){
        return [
            [['contract_num','loan_amount_money','contract_loan_start_time','contract_loan_end_time','loan_day','loan_rate','loan_benchmark_rate','repayment_mode','loan_voucher'], 'required', 'message' => '{attribute}必填', 'on' => 'add_loan_info'],
            ['loan_id', 'match', 'pattern' => '/^[1-9]d*$/', 'message'=>'贷款信息未找到', 'on'=>'add_loan_info'],   
            ['repayment_mode', 'in', 'range'=>[1,2,3,4,5,6,7], 'message'=>'请选择还款方式', 'on'=>'add_loan_info'], 

            // ['apply_amount', 'number', 'message' => '{attribute}必须为数字'],
            // [['apply_amount', 'period_month'], 'match', 'pattern' => '/^[1-9]d*|0$/', 'message' => '{attribute}必须为正整数'],
            // ['period_month', 'compare', 'compareValue' => 1, 'operator' => '>=', 'message' => '{attribute}（1-12月）'],
            // ['period_month', 'compare', 'compareValue' => 12, 'operator' => '<=', 'message' => '{attribute}（1-12月）'],
            // ['user_id', 'default', 'value' => Yii::$app->session['member']['userid']],
            // ['base_id', 'default', 'value' => EnterpriseBase::getBaseId()]
        ];
    }

    // public function add($data){
    //     $this->scenario = "add_loan_info";
    //     $this->setAttributes($data);
    //     return ($this->validate() && $this->save(false)) ? true : false;
    // }
}