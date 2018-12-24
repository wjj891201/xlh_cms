<?php

namespace app\models;

use yii\db\ActiveRecord;
use Yii;

class EnterpriseLoan extends ActiveRecord
{

    public static function tableName()
    {
        return "{{%enterprise_loan}}";
    }

    public function attributeLabels()
    {
        return [
            'apply_amount' => '申请金额',
            'period_month' => '申请期限',
            'loan_purpose' => '贷款用途',

            //授信编辑
            'credit_amount'   => '授信金额', 
            'credit_time'     => '授信时间',
            'credit_validity' => '授信有效期',
        ];
    }

    public function rules()
    {
        return [
                [['apply_amount', 'period_month', 'loan_purpose'], 'required', 'message' => '{attribute}必填', 'on' => 'operate'],
                ['apply_amount', 'number', 'message' => '{attribute}必须为数字', 'on' => 'operate'],
                [['apply_amount', 'period_month'], 'match', 'pattern' => '/^[1-9]d*|0$/', 'message' => '{attribute}必须为正整数', 'on' => 'operate'],
                ['period_month', 'compare', 'compareValue' => 1, 'operator' => '>=', 'message' => '{attribute}（1-12月）', 'on' => 'operate'],
                ['period_month', 'compare', 'compareValue' => 12, 'operator' => '<=', 'message' => '{attribute}（1-12月）', 'on' => 'operate'],
                ['user_id', 'default', 'value' => Yii::$app->session['member']['userid'], 'on' => 'operate'],
                ['base_id', 'default', 'value' => EnterpriseBase::getBaseId(), 'on' => 'operate'],

                [['credit_amount', 'credit_time', 'credit_validity'], 'required', 'message' => '{attribute}必填', 'on' => 'grant_edit'], //授信编辑
                [['credit_time', 'credit_validity'], 'date', 'format'=>'yyyy-mm-dd', 'message' => '{attribute}格式错误', 'on' => 'grant_edit'],
                // ['loan_id'],
        ];
    }

    public function add($data)
    {
        $this->scenario = "operate";
        if ($this->load($data) && $this->save())
        {
            return true;
        }
        return false;
    }

    public function grant_edit($data, $where){
        $this->scenario = "grant_edit";
        $this->setAttributes($data);
        if($this->validate()){
            return self::updateAll($data, $where);
        }else{
            return false;
        }
    }

}
