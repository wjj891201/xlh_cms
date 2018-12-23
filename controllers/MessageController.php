<?php

namespace app\controllers;

use yii\web\Controller;
use Yii;
use app\models\FormGroup;
use app\models\FormAttr;

class MessageController extends Controller
{

    public $enableCsrfValidation = false;

    public function actionAdd()
    {
        $fgid = Yii::$app->request->post("fgid");
        $userid = Yii::$app->request->post("userid", 0);
        $addtime = time();
        $form = FormGroup::findOne(['fgid' => $fgid]);
        $formatt = FormAttr::getFormatt($fgid, true);
        $formattarray = array();
        foreach ($formatt as $key => $value)
        {
            if ($value['inputtype'] == 'htmltext')
            {
                $value['accept'] = 'html';
            }
            elseif ($value['inputtype'] == 'checkbox')
            {
                $value['accept'] = 'checkbox';
            }
            elseif ($value['inputtype'] == 'string' || $value['inputtype'] == 'img' || $value['inputtype'] == 'addon' || $value['inputtype'] == 'video' || $value['inputtype'] == 'select' || $value['inputtype'] == 'radio' || $value['inputtype'] == 'selectinput')
            {
                $value['accept'] = 'text';
            }
            elseif ($value['inputtype'] == 'editor' || $value['inputtype'] == 'text')
            {
                $value['accept'] = 'editor';
            }
            elseif ($value['inputtype'] == 'int')
            {
                $value['accept'] = 'int';
            }
            elseif ($value['inputtype'] == 'float' || $value['inputtype'] == 'decimal')
            {
                $value['accept'] = 'float';
            }
            elseif ($value['inputtype'] == 'datetime')
            {
                $value['accept'] = 'data';
            }
            $formattarray[] = $value;
        }
        $sysinstalldb = null;
        $sysinstall = null;

        foreach ($formattarray as $key => $value)
        {
            $sysinstall.=$value['attrname'] . ',';
            if ($value['accept'] == 'int')
            {
                $valuestr = Yii::$app->request->post($value['attrname'], 0);
                $sysinstalldb.="$valuestr,";
            }
            elseif ($value['accept'] == 'float')
            {
                $valuestr = Yii::$app->request->post($value['attrname'], 0);
                $sysinstalldb.="$valuestr,";
            }
            elseif ($value['accept'] == 'html')
            {
                $valuestr = Yii::$app->request->post($value['attrname']);
                $valuestr = empty($valuestr) ? '' : $this->Text2Html($valuestr);
                $sysinstalldb.="'$valuestr',";
            }
            elseif ($value['accept'] == 'editor')
            {
                $valuestr = Yii::$app->request->post($value['attrname']);
                $sysinstalldb.="'$valuestr',";
            }
            elseif ($value['accept'] == 'text')
            {
                $valuestr = Yii::$app->request->post($value['attrname']);
                $sysinstalldb.="'$valuestr',";
            }
            elseif ($value['accept'] == 'data')
            {
                $valuestr = Yii::$app->request->post($value['attrname']);
                $valuestr = empty($valuestr) ? 0 : intval(strtotime($valuestr));
                $sysinstalldb.="$valuestr,";
            }
            elseif ($value['accept'] == 'checkbox')
            {
                $valuestr = Yii::$app->request->post($value['attrname']);
                $valuestr = is_array($valuestr) ? implode(',', $valuestr) : '';
                $sysinstalldb.="'$valuestr',";
            }
        }
        $db_field = $sysinstall . 'fgid,did,userid,addtime,retime,ipadd,isreply,username,recontent';
        $db_values = $sysinstalldb . "$fgid,0,$userid,$addtime,0,'',0,'',''";
        $connection = Yii::$app->db;
        $sql = 'INSERT INTO {{%form_value}} (' . $db_field . ') VALUES (' . $db_values . ')';
        $connection->createCommand($sql)->query();
        return $this->redirect(['call/mess']);
    }

    function Text2Html($txt, $is_preg = true)
    {
        $txt = htmlspecialchars($txt);
        if ($is_preg)
        {
            $txt = preg_replace("/\r\n/isU", "<br/>", $txt);
            $txt = preg_replace("/\r/isU", "<br/>", $txt);
            $txt = preg_replace("/\n/isU", "<br/>", $txt);
        }
        else
        {
            preg_replace("/[\n]{1,}/isU", "<br/>", $txt);
        }
        return $txt;
    }

}