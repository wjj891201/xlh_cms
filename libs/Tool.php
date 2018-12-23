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

}
