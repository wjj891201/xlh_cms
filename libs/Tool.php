<?php

/**
 * 功能描述(公共函数处理类)
 * $Author: wujiepeng $
 */

namespace app\libs;

class Tool
{

    /**
     * curl
     * @param type $url
     * @param type $fields
     * @return type
     */
    public static function curlGet($url, $fields)
    {
        $fields = json_encode($fields);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('content-type: application/json;charset=UTF-8', 'Content-Length: ' . strlen($fields)));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

    /**
     * 产生随机短信码
     * @param type $length
     * @return type
     */
    public static function getNonceStr($length = 6)
    {
        $chars = "0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++)
        {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }

    /**
     * 文件下载
     * */
    public static function downloadFile($true_file, $downloads_filename = '')
    {
        $pathinfo = pathinfo($true_file);
        $downloads_filename = !empty($downloads_filename) ? $downloads_filename : $pathinfo['basename'];
        $file_name = $true_file;
        $down_name = $pathinfo['dirname'] . '/_' . $downloads_filename;
        $down_name = trim(rtrim(strrchr($down_name, '_'), '_'), '_');
        $mime = 'application/force-download';
        $ua = $_SERVER["HTTP_USER_AGENT"];
        if (strpos($ua, 'MSIE') !== false || strpos($ua, 'rv:11.0') || strpos($ua, 'rv:12.0'))
        {
            $down_name = urlencode($down_name);
            $down_name = str_replace("+", "%20", $down_name);
            $down_name = iconv('UTF-8', 'GBK//IGNORE', $down_name);
        }
        header('Content-Disposition: attachment; filename="' . $down_name . '"');
        header('Content-Type: ' . $mime);
        ob_clean();
        flush();
        readfile($file_name);
        exit();
    }

    /**
     * 短信接口Java版
     * @param string type 00：验证 01：通知 02：营销
     * @param string|array $mobile 手机号
     * @param string $content 短信内容
     * @param sting switch 模拟开关器 on打开  off关闭
     * @return array array('status'=>true|false,'msg'=>'')
     * 
     */
    public static function send_sms_java_api($type, $mobile, $content, $switch = 'off')
    {
        $url = "http://sms.easyrong.dev:8080/api/sms/send";
        $requset = ['spType' => $type, 'mobile' => $mobile, 'content' => $content, 'simulatorSwitch' => $switch];
        $requset = json_encode($requset);
        $json = ['content-type: application/json;charset=UTF-8', 'Content-Length:' . strlen($requset) . ''];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $json);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $requset);
        $result = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($result, true);

        if (isset($result['status']))
        {
            if ($result['status'] == 1)
            {
                return ['status' => true, 'msg' => $result['result']];
            }
            else
            {
                return ['status' => false, 'msg' => $result['result']];
            }
        }
        else
        {
            return ['status' => false, 'msg' => '接口异常'];
        }
    }

}
