<?php

namespace app\modules\approve\controllers;

use yii\web\Controller;
use Yii;
use app\models\Organization;

class CommonController extends Controller
{

    public function beforeAction($action)
    {
        //1.0 先验证是否已经登录
        if (Yii::$app->approvr_user->isGuest)
        {
            $this->redirect(['/approve/login/login']);
            Yii::$app->end();
        }
        else
        {
            $organizationName = Organization::find()->select('name')->where(['id' => Yii::$app->approvr_user->identity->belong])->scalar();
            $this->view->params['organizationName'] = $organizationName;
        }
        return true;
    }

    /**
     * ajax上传函数
     * @param string $folder 上传到文件夹下
     * @param int $pid 产品ID
     * @param array $allowed_types 允许的文件类型
     * @param int $max_size 允许上传文件的最大值，默认为1M（1024000bytes）
     * @return json数据
     */
    public function ajax_upload_do($folder, $pid = 0, $allowed_types = ['gif', 'jpg', 'png'], $max_size = 2024000){
        set_time_limit(0);
        file_exists($folder) OR mkdir($folder, 0755, TRUE);
        if (empty($_FILES['file']))
        {
            $arr = ['code' => '20001', 'error' => '文件加载异常,上传失败!'];
            return json_encode($arr);
        }
        $filename = $_FILES['file']['name']; //文件名
        $filesize = $_FILES['file']['size']; //文件大小
        $filedate = date('Y-m-d', time());
        if ($filename != "")
        {
            if ($filesize > $max_size)
            {
                $arr = ['code' => '20001', 'error' => '您上传的附件大小超出限制请重新上传!'];
                return json_encode($arr);
            }
            $upload_filetype = $this->getFileExt($filename); //获取文件类型名
            if (empty($upload_filetype) || !in_array($upload_filetype, $allowed_types))
            {
                $arr = ['code' => '20001', 'error' => '您上传的附件不符合格式请重新上传！'];
                return json_encode($arr);
            }
        }
        $files = $pid . '_' . time() . '.' . $upload_filetype;
        //上传路径
        $file_path = $folder . $files;
        move_uploaded_file($_FILES['file']['tmp_name'], iconv("UTF-8", "gb2312", $file_path));
        @chmod($file_path, 0777);
        $size = round($filesize / 1024, 2);
        $arr  = [
            'code' => '20000',
            'success' => [
                'name' => $files,
                'type' => $pid,
                'date' => $filedate,
                'size' => $size,
                'url'  => $file_path
            ]
        ];
        return json_encode($arr);
    }

    /**
     * 获取文件扩展名
     * @param String $filename 要获取文件名的文件
     * @return string
     */
    public function getFileExt($filename){
        $info = pathinfo($filename);
        return $info["extension"];
    }
}
