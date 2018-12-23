<?php

namespace app\modules\approve;

use Yii;

/**
 * approve module definition class
 */
class approve extends \yii\base\Module
{

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\approve\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->layout = 'main';
        Yii::configure($this, require(__DIR__ . '/config/web.php'));
        // custom initialization code goes here
    }

}
