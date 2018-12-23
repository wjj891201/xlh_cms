<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>
<div class="main-bar changeback">
    <div class="changebox">
        <div class="article2">
            <div class="box3">
                <h3>修改密码</h3>
            </div>
        </div>
        <?php
        $form = ActiveForm::begin([
                    'options' => ['class' => 'changepass'],
                    'fieldConfig' => [
                        'template' => "<li>{label}{input}{error}</li>",
                        'labelOptions' => ['class' => false, 'for' => false],
                        'errorOptions' => ['tag' => 'span', 'class' => 'error_info'],
                    ]
        ]);
        ?>
        <ul>
            <?= $form->field($model, 'oldpass')->passwordInput(['placeholder' => '原始密码']); ?>
            <?= $form->field($model, 'password')->passwordInput(['placeholder' => '密码']); ?>
            <?= $form->field($model, 're_password')->passwordInput(['placeholder' => '确认密码']); ?>
        </ul>
        <?= Html::submitButton('确定', ['class' => 'changepassbtn']); ?>
        <?php ActiveForm::end(); ?>
    </div>
</div>