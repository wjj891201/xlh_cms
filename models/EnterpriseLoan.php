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
        ];
    }

    public function rules()
    {
        return [
                [['apply_amount', 'period_month', 'loan_purpose'], 'required', 'message' => '{attribute}必填'],
                ['apply_amount', 'number', 'message' => '{attribute}必须为数字'],
                [['apply_amount', 'period_month'], 'match', 'pattern' => '/^[1-9]d*|0$/', 'message' => '{attribute}必须为正整数'],
                ['period_month', 'compare', 'compareValue' => 1, 'operator' => '>=', 'message' => '{attribute}（1-12月）'],
                ['period_month', 'compare', 'compareValue' => 12, 'operator' => '<=', 'message' => '{attribute}（1-12月）'],
                ['user_id', 'default', 'value' => Yii::$app->session['member']['userid']],
                ['base_id', 'default', 'value' => EnterpriseBase::getBaseId()]
        ];
    }

    public function add($data)
    {
        if ($this->load($data) && $this->save())
        {
            return true;
        }
        return false;
    }

}
