<?php
namespace app\modules\approve\controllers;
use Yii;
use app\models\EnterpriseLoan;
use app\models\EnterpriseLoanContract;

class AjaxController extends CommonController{
    public function init(){
        parent::init();
    }

    /**
     * [actionGetLoanInfo 银行审批授信 获取贷款信息]
     * @return [html] [html or empty]
     */
    public function actionGetLoanInfo(){
        $get      = Yii::$app->request->get();
        $loan_id  = empty($get['loan_id']) ? 0 : intval($get['loan_id']);
        $type_id  = empty($get['type_id']) ? 0 : intval($get['type_id']);
        $html     = '';
        
        if(!empty($loan_id)){
            $loan_row = EnterpriseLoan::find()->alias("a")
                        ->select('a.apply_amount,a.period_month,a.credit_amount,a.already_loan_amount,b.enterprise_name')
                        ->leftJoin('{{%enterprise_base}} b', 'b.base_id=a.base_id')
                        ->where(['a.loan_id' => $loan_id])->asArray()->one(); 
            
            if(!empty($loan_row)){
                $html .= '<li><label>贷款企业名称：</label><span>'. $loan_row['enterprise_name'] .'</span></li>';
                $html .= '<li><label>期望贷款金额：</label><span>'. $loan_row['apply_amount'] .'万元</span></li>';
                $html .= '<li><label>期望贷款周期：</label><span>'. $loan_row['period_month'] .'个月</span></li>';
                if($type_id == 1){
                    $amount_money = round($loan_row['credit_amount']-$loan_row['already_loan_amount'], 6);
                    $html .= '<li><label>可用授信金额：</label><span>'. $amount_money .'</span>万</li>';
                }
            }
        }     
        echo $html;
    }

    public function actionGetLoanList(){
        $get       = Yii::$app->request->get();
        $loan_id   = empty($get['loan_id']) ? 0 : intval($get['loan_id']);
        $type_id   = empty($get['type_id']) ? 0 : intval($get['type_id']);

        $html = '';
        if($loan_id){
            $list = EnterpriseLoanContract::find()->alias('a')
                    ->select(['c.enterprise_name', 'b.apply_amount', 'b.period_month', 'a.loan_create_time', 'a.contract_num', 'a.loan_amount_money', 'a.contract_loan_start_time', 'a.contract_loan_end_time', 'a.loan_day', 'a.loan_rate', 'a.loan_benchmark_rate', 'a.repayment_mode', 'a.loan_voucher'])
                    ->leftJoin('{{%enterprise_loan}} b', 'b.loan_id=a.loan_id')
                    ->leftJoin('{{%enterprise_base}} c', 'b.base_id=b.base_id')
                    ->where(['a.loan_id'=>$loan_id])->asArray()->all();

            $repayment_mode = Yii::$app->params['repayment_mode']; //还款方式
            
            if(!empty($list)){
                foreach($list as $v){
                    $html .= '<ul>';
                    $html .= '<li><label>贷款录入时间：</label><p>'. $v['loan_create_time'] .'</p></li>';
                    $html .= '<li><label>贷款企业名称：</label><p>'. $v['enterprise_name'] .'</p></li>';
                    $html .= '<li><label>期望贷款金额：</label><p>'. $v['apply_amount'] .'万</p></li>';
                    $html .= '<li><label>期望贷款周期：</label><p>'. $v['period_month'] .'月</p></li>';
                    $html .= '<li><label>贷款合同号：</label><p>'. $v['contract_num'] .'</p></li>';
                    $html .= '<li><label>实际放贷金额：</label><p>'. $v['loan_amount_money'] .'万</p></li>';
                    $html .= '<li><label>贷款开始时间：</label><p>'. $v['contract_loan_start_time'] .'</p></li>';
                    $html .= '<li><label>贷款结束时间：</label><p>'. $v['contract_loan_end_time'] .'</p></li>';
                    $html .= '<li><label>贷款周期：</label><p>'. $v['loan_day'] .'天</p></li>';
                    $html .= '<li><label>贷款利率：</label><p>'. $v['loan_rate'] .'%</p></li>';
                    $html .= '<li><label>基准利率：</label><p>'. $v['loan_benchmark_rate'] .'%</p></li>';
                    
                    $repayment_mode_info = isset($repayment_mode[$v['repayment_mode']]) ? $repayment_mode[$v['repayment_mode']] : '其他';

                    $html .= '<li><label>还款方式：</label><p>'. $repayment_mode_info .'</p></li>';
                    $html .= '<li><label>放款凭证：</label><p><a onclick="download_pz(\''. $v['loan_voucher'] .'\')" style = "cursor:pointer;color:#4479cf">下载</a></p></li>';
                    $html .= '</ul>';
                }
            }
        }
        echo $html;
    }

    /**
     * [actionUploads Ajax上传]
     * @return [string] [保存图片路径]
     */
    public function actionUploads(){
        // p($_FILES, 1);
        $allowed_types = ['gif', 'jpg', 'jpeg', 'png', 'pdf', 'GIF', 'JPG', 'JPEG', 'PNG', 'PDF'];
        $max_size      = 10240000; //10M

        $uploan_url    = 'upfile/loan/' . date('Ymd') . '/';
        $result        = $this->ajax_upload_do($uploan_url, 0, $allowed_types, $max_size);
        $result        = json_decode($result, true);
        $file_path = '';
        if($result['code'] == 20000){
            $file_path =  $result['success']['url'];
        }
        echo $file_path;
    }
    

    /**
     * [do_download 下载]
     * @return [void] 
     */
    public function actionDownload(){
        $filename = Yii::$app->request->get('filename');
        $filename = trim($filename,'/');
        if(@is_file($filename)){
            $this->force_download(trim($filename,'/'), NULL);
        }else{
            echo "文件不存在！";
        }
    }


    /**
     * Force Download
     *
     * Generates headers that force a download to happen
     *
     * @param   string  filename
     * @param   mixed   the data to be downloaded
     * @param   bool    whether to try and send the actual file MIME type
     * @return  void
     */
    private function force_download($filename = '', $data = '', $set_mime = FALSE){
        if ($filename === '' OR $data === ''){
            return;
        }elseif ($data === NULL){
            if (@is_file($filename) && ($filesize = @filesize($filename)) !== FALSE){
                $filepath = $filename;
                $filename = explode('/', str_replace(DIRECTORY_SEPARATOR, '/', $filename));
                $filename = end($filename);
            }else{
                return;
            }
        }else{
            $filesize = strlen($data);
        }

        // Set the default MIME type to send
        $mime = 'application/octet-stream';

        $x = explode('.', $filename);
        $extension = end($x);

        if ($set_mime === TRUE){
            if (count($x) === 1 OR $extension === ''){
                /* If we're going to detect the MIME type,
                 * we'll need a file extension.
                 */
                return;
            }

            // Load the mime types
            $mimes = Yii::$app->params['mimes'];

            // Only change the default MIME if we can find one
            if (isset($mimes[$extension])){
                $mime = is_array($mimes[$extension]) ? $mimes[$extension][0] : $mimes[$extension];
            }
        }

        /* It was reported that browsers on Android 2.1 (and possibly older as well)
         * need to have the filename extension upper-cased in order to be able to
         * download it.
         *
         * Reference: http://digiblog.de/2011/04/19/android-and-the-download-file-headers/
         */
        if (count($x) !== 1 && isset($_SERVER['HTTP_USER_AGENT']) && preg_match('/Android\s(1|2\.[01])/', $_SERVER['HTTP_USER_AGENT'])){
            $x[count($x) - 1] = strtoupper($extension);
            $filename = implode('.', $x);
        }

        if ($data === NULL && ($fp = @fopen($filepath, 'rb')) === FALSE){
            return;
        }

        // Clean output buffer
        if (ob_get_level() !== 0 && @ob_end_clean() === FALSE){
            @ob_clean();
        }

        // Generate the server headers
        header('Content-Type: '.$mime);
        header('Content-Disposition: attachment; filename="'.$filename.'"');
        header('Expires: 0');
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: '.$filesize);

        // Internet Explorer-specific headers
        if (isset($_SERVER['HTTP_USER_AGENT']) && strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== FALSE){
            header('Cache-Control: no-cache, no-store, must-revalidate');
        }

        header('Pragma: no-cache');

        // If we have raw data - just dump it
        if ($data !== NULL){
            exit($data);
        }

        // Flush 1MB chunks of data
        while ( ! feof($fp) && ($data = fread($fp, 1048576)) !== FALSE){
            echo $data;
        }

        fclose($fp);
        exit;
    }
}