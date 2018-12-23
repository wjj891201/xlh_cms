<?php

/**
 * 功能描述(图片处理类)
 * ============================================================================
 * * All Rights Reserved by Xinlonghang Network Technology Co,.Ltd of SHANGHAI.
 * 网站地址: http://www.easyrong.com；
 * ============================================================================
 * $Author: wujiepeng $
 */

namespace app\libs;

class Image
{

    /**
     * @function 根据尺寸生成图片地址
     * @param $src
     * @param string $width
     * @param string $height
     * @return mixed|string
     */
    public static function img($src, $width = '', $height = '')
    {
        $cfg_m_img_url = "http://" . $_SERVER['HTTP_HOST'];
        if (stripos($src, 'http://') !== false && stripos($src, rtrim($cfg_m_img_url, '/')) === false)
        {
            return $src;
        }

        if (!empty($width) && !empty($height) && !empty($src) && !preg_match('/_\d+X\d+\.(jpg|jpeg|png|gif)$/is', $src))
        {
            if (strpos($src, 'upfile') !== false)
            {
                $src = preg_replace('/(\.(?:jpg|jpeg|png|gif))$/is', "_{$width}x{$height}$1", $src);
                return strpos($src, 'http://') === false ? $cfg_m_img_url . $src : $src;
            }
            else
            {
                return $src;
            }
        }
        else if (empty($src))
        {
            $nopic = self::nopic();
            if ($width != '' || $height != '')
            {
                $nopic = preg_replace('/(\.(?:jpg|jpeg|png|gif))$/is', "_{$width}x{$height}$1", $nopic);
                return strpos($nopic, 'http://') === false ? $cfg_m_img_url . $nopic : $nopic;
            }
            return $nopic; //无图返回
        }
        else
        {
            return strpos($src, 'http://') === false ? $cfg_m_img_url . $src : $src;
        }
    }

    /**
     * @function 获取默认图片
     * @return string
     */
    public static function nopic()
    {
        $cfg_public_url = "http://" . $_SERVER['HTTP_HOST'];
        return $cfg_public_url . 'upfile/nopicture.jpg';
    }

}

?>
