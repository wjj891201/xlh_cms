<?php

namespace app\modules\admin\controllers;

use app\modules\admin\controllers\CommonController;

/**
 * Default controller for the `admin` module
 */
class DefaultController extends CommonController
{

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $this->layout = "main";

        return $this->render('index');
    }

}
