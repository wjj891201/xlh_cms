<?php if (Yii::$app->session->hasFlash('success')): ?>
    <div class="message success">
        <p><?= Yii::$app->session->getFlash('success') ?></p>
        <div class="close"></div>
    </div>
<?php endif; ?>

<?php if (Yii::$app->session->hasFlash('error')): ?>
    <div class="message error">
        <p><?= Yii::$app->session->getFlash('error') ?></p>
        <div class="close"></div>
    </div>
<?php endif; ?>