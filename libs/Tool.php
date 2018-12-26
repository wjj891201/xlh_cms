<?php

/**
 * 功能描述(公共函数处理类)
 * $Author: wujiepeng $
 */

namespace app\libs;

use Simple_html_dom;

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
     */
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

    /**
     * 检查上传文件中数据的格式 BY-PHP
     * @param $enterprise_type  // 企业会计制度
     * @param $file_type        // 上传文件类型
     * @param $filename         // 文件名称
     * @param $year             // 文件年份
     * @param $city             // 对应城市缩写
     * @return string
     */
    public static function check_report_format_by_php($enterprise_type, $file_type, $filename, $year, $city = '')
    {

        // 一般企业、小企业需要解析，其他不需要解析
        if ($enterprise_type == 3)
        {
            return '';
        }
        $result = [
            'data' => [
                'endTime' => '',
                'beginTime' => '',
                'businessIncomeYear' => '',
                'totalProfitYear' => '',
                'totalOwnerEquityEnd' => '',
                'totalLiabilitiesEnd' => '',
                'totalAssetsEnd' => '',
            ]
        ];
//        $this->load->library('simple_html_dom');
//        $file_path = dirname(dirname(dirname(__DIR__))) . '/uploadfile/hefei_kjd/report/' . $filename;
        $file_path = dirname(__DIR__) . '/web/' . $filename;

        # 获取文件后缀~~~start
        $file_arr = pathinfo($file_path);
        $extension = $file_arr['extension'];
        # 获取文件后缀~~~end
        $html = new Simple_html_dom();
        $html->load_file($file_path);

        //一般企业
        if ($enterprise_type == 1)
        {
            //处理时间
            $table = $html->find('table', 0);
            $time_tr = $table->find('tr', 6);
            $time = trim($time_tr->find('td', 10)->innertext());
            if ($year == 'last')
            {
                $endTime = str_replace("年", "-", $time);
                if (strstr($endTime, '日'))
                {
                    $endTime = str_replace("月", "-", $endTime);
                }
                else
                {
                    $endTime = str_replace("月", "", $endTime);
                }
                $endTime = str_replace("日", "", $endTime);
            }
            else
            {
                $endTime = substr($time, 0, 4) . '-12';
            }

            $result['data']['endTime'] = $endTime;
            $beginTime = '';
            $result['data']['beginTime'] = $beginTime;
            //获取类型
            $type_tr = $table->find('tr', 5);
            $type = $type_tr->find('td', 4)->innertext();
            if (strstr($type, '一般企业'))
            {
                $symbol = 'yiban';
            }
            else
            {
                return '';
            }
            //获取表名
            $title_tr = $table->find('tr', 4);
            $title = $title_tr->find('td', 4)->innertext();
        }

        //小企业(负债)
        if ($file_type == 'balance' && $enterprise_type == 2)
        {
            //处理时间
            $table = $html->find('table', 0);
            $time_tr = $table->find('tr', 7);
            $time = trim($time_tr->find('td', 8)->innertext());
            if ($year == 'last')
            {
                $endTime = str_replace("年", "-", $time);
                if (strstr($endTime, '日'))
                {
                    $endTime = str_replace("月", "-", $endTime);
                }
                else
                {
                    $endTime = str_replace("月", "", $endTime);
                }
                $endTime = str_replace("日", "", $endTime);
            }
            else
            {
                $endTime = substr($time, 0, 4) . '-12';
            }

            $result['data']['endTime'] = $endTime;
            $beginTime = '';
            $result['data']['beginTime'] = $beginTime;
            //获取类型
            $type_tr = $table->find('tr', 6);
            $type = $type_tr->find('td', 3)->innertext();
            if (strstr($type, '小企业'))
            {
                $symbol = 'xiao';
            }
            else
            {
                return '';
            }
            //获取表名
            $title_tr = $table->find('tr', 3);
            $title = $title_tr->find('td', 3)->innertext();
        }

        //小企业(利润)
        if ($file_type == 'profit' && $enterprise_type == 2)
        {
            //处理时间
            $table = $html->find('table', 0);
            $time_tr = $table->find('tr', 6);
            $time = trim($time_tr->find('td', 8)->innertext());
            if ($year == 'last')
            {
                $endTime = str_replace("年", "-", $time);
                if (strstr($endTime, '日'))
                {
                    $endTime = str_replace("月", "-", $endTime);
                }
                else
                {
                    $endTime = str_replace("月", "", $endTime);
                }
                $endTime = str_replace("日", "", $endTime);
            }
            else
            {
                $endTime = substr($time, 0, 4) . '-12';
            }

            $result['data']['endTime'] = $endTime;
            $beginTime = '';
            $result['data']['beginTime'] = $beginTime;
            //获取类型
            $type_tr = $table->find('tr', 5);
            $type = $type_tr->find('td', 2)->innertext();
            if (strstr($type, '小企业'))
            {
                $symbol = 'xiao';
            }
            else
            {
                return '';
            }
            //获取表名
            $title_tr = $table->find('tr', 3);
            $title = $title_tr->find('td', 2)->innertext();
        }

        // 资产负债表(一般企业)
        if ($file_type == 'balance' && $enterprise_type == 1)
        {
            if ($title != '资产负债表')
            {
                return '';
            }
            if ($symbol != 'yiban')
            {
                return '';
            }
            #净资产
            $tr_1 = $table->find('tr', 41);
            $totalOwnerEquityEnd = trim($tr_1->find('td', 10)->innertext());
            $result['data']['totalOwnerEquityEnd'] = str_replace(',', '', $totalOwnerEquityEnd);
            #负债合计
            $tr_2 = $table->find('tr', 33);
            $totalLiabilitiesEnd = trim($tr_2->find('td', 10)->innertext());
            $result['data']['totalLiabilitiesEnd'] = str_replace(',', '', $totalLiabilitiesEnd);
            #资产合计
            $tr_3 = $table->find('tr', 41);
            $totalAssetsEnd = trim($tr_3->find('td', 6)->innertext());
            $result['data']['totalAssetsEnd'] = str_replace(',', '', $totalAssetsEnd);
        }
        // 资产负债表(小企业)
        if ($file_type == 'balance' && $enterprise_type == 2)
        {
            if ($title != '资产负债表')
            {
                return '';
            }
            if ($symbol != 'xiao')
            {
                return '';
            }
            #净资产
            $tr_1 = $table->find('tr', 40);
            $totalOwnerEquityEnd = trim($tr_1->find('td', 9)->innertext());
            $result['data']['totalOwnerEquityEnd'] = str_replace(',', '', $totalOwnerEquityEnd);
            #负债合计
            $tr_2 = $table->find('tr', 28);
            $totalLiabilitiesEnd = trim($tr_2->find('td', 9)->innertext());
            $result['data']['totalLiabilitiesEnd'] = str_replace(',', '', $totalLiabilitiesEnd);
            #资产合计
            $tr_3 = $table->find('tr', 41);
            $totalAssetsEnd = trim($tr_3->find('td', 5)->innertext());
            $result['data']['totalAssetsEnd'] = str_replace(',', '', $totalAssetsEnd);
        }
        //利润及利润分配表(一般企业)
        if ($file_type == 'profit' && $enterprise_type == 1)
        {
            if ((($title == '利润表' || $title == '损益表')))
            {
                if ($symbol != 'yiban')
                {
                    return '';
                }
                #年销售收入
                $tr_4 = $table->find('tr', 9);
                $businessIncomeYear = trim($tr_4->find('td', 6)->innertext());
                $result['data']['businessIncomeYear'] = str_replace(',', '', $businessIncomeYear);
                #年利润总额
                $tr_5 = $table->find('tr', 24);
                $totalProfitYear = trim($tr_5->find('td', 6)->innertext());
                $result['data']['totalProfitYear'] = str_replace(',', '', $totalProfitYear);
            }
            else
            {
                return '';
            }
        }
        //利润及利润分配表(小企业)
        if ($file_type == 'profit' && $enterprise_type == 2)
        {
            if ((($title == '利润表' || $title == '损益表')))
            {
                if ($symbol != 'xiao')
                {
                    return '';
                }
                #年销售收入
                $tr_4 = $table->find('tr', 10);
                $businessIncomeYear = trim($tr_4->find('td', 4)->innertext());
                $result['data']['businessIncomeYear'] = str_replace(',', '', $businessIncomeYear);
                #年利润总额
                $tr_5 = $table->find('tr', 39);
                $totalProfitYear = trim($tr_5->find('td', 4)->innertext());
                $result['data']['totalProfitYear'] = str_replace(',', '', $totalProfitYear);
            }
            else
            {
                return '';
            }
        }
        return $result;
    }

}
