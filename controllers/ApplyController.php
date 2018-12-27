<?php

namespace app\controllers;

use app\controllers\CheckController;
use Yii;
use yii\helpers\ArrayHelper;
use app\libs\Tool;
use app\models\EnterpriseBase;
use app\models\EnterpriseFinance;
use app\models\EnterpriseDescribe;
use app\models\EnterpriseLoan;
use app\models\Area;
use app\models\WorkflowGroup;
use app\models\WorkflowNode;
use app\models\Advert;
use app\models\Organization;

class ApplyController extends CheckController
{

    public function actionLand()
    {
        # 着陆页banner
        $banner = Advert::get_one(['atid' => 14]);
        return $this->render('land', ['banner' => $banner]);
    }

    /**
     * 着陆页判断用户是否提交过资料
     */
    public function actionAjaxApplyCheck()
    {
        $info = EnterpriseBase::find()->where(['user_id' => $this->userid])->one();
        if (!empty($info))
        {
            echo 1;
        }
        else
        {
            echo 0;
        }
        exit;
    }

    /**
     * 表单提交第一步
     */
    public function actionApplyBase()
    {
        $model = EnterpriseBase::find()->where(['user_id' => $this->userid])->one();
        if (!$model)
        {
            $model = new EnterpriseBase;
            $enterprise_name = isset($_COOKIE['enterprise_name']) ? $_COOKIE['enterprise_name'] : '';
            $model->enterprise_name = $enterprise_name;
        }
        $request = Yii::$app->request;
        if ($request->isPost)
        {
            $post = $request->post();
            if ($model->add($post))
            {
                $this->redirect(['apply/apply-finance']);
                Yii::$app->end();
            }
        }
        # 区域
        $allArea = Area::getData();
        $allArea = ArrayHelper::toArray($allArea);
        $allArea = ArrayHelper::map($allArea, 'id', 'name');
        $options = ['' => '请选择'];
        foreach ($allArea as $key => $vo)
        {
            $options[$key] = $vo;
        }
        $allArea = $options;
        # 行业
        $industry = Yii::$app->params['industry'];
        $industry = ArrayHelper::map($industry, 'id', 'name');
        $options = ['' => '请选择'];
        foreach ($industry as $key => $vo)
        {
            $options[$key] = $vo;
        }
        $industry = $options;

        return $this->render('apply_base', ['model' => $model, 'allArea' => $allArea, 'industry' => $industry]);
    }

    /**
     * 表单提交第二步
     */
    public function actionApplyFinance()
    {
        $model = EnterpriseFinance::find()->where(['base_id' => EnterpriseBase::getBaseId(), 'user_id' => $this->userid])->one();
        if (!$model)
        {
            $model = new EnterpriseFinance;
        }
        $request = Yii::$app->request;

        # 年份~~~start
        $data = [];
        $now_time = time();
        $cutoff_time = strtotime(date("Y-02-01"));
        if ($now_time >= $cutoff_time)
        {
            $data['before_year'] = date("Y", strtotime("-2 year"));
            $data['last_year'] = date("Y", strtotime("-1 year"));
        }
        else
        {
            $data['before_year'] = date("Y", strtotime("-3 year"));
            $data['last_year'] = date("Y", strtotime("-2 year"));
        }
        # 年份~~~end
        # 查询企业的注册时间
        $register_date = EnterpriseBase::find()->select('register_date')->where(['user_id' => $this->userid])->scalar();
        if ($request->isPost)
        {
            $post = $request->post();
            if ($model->add($post))
            {
                $this->redirect(['apply/apply-describe']);
                Yii::$app->end();
            }
        }
        # 企业适用会计制度
        $system = Yii::$app->params['system'];
        $system = ArrayHelper::map($system, 'id', 'name');
        return $this->render('apply_finance', ['model' => $model, 'data' => $data, 'system' => $system, 'register_date' => $register_date]);
    }

    /**
     * 表单提交第三步
     */
    public function actionApplyDescribe()
    {
        $model = EnterpriseDescribe::find()->where(['base_id' => EnterpriseBase::getBaseId(), 'user_id' => $this->userid])->one();
        if (!$model)
        {
            $model = new EnterpriseDescribe;
        }
        else
        {
            $model->code = 1;
            $model->qualification = 1;
        }
        $request = Yii::$app->request;
        if ($request->isPost)
        {
            $post = $request->post();
            if ($model->add($post))
            {
                $this->redirect(['apply/apply-loan']);
                Yii::$app->end();
            }
        }
        # 企业适用会计制度
//        $enterprise = Yii::$app->params['enterprise'];
//        $enterprise = ArrayHelper::map($enterprise, 'id', 'name');
        return $this->render('apply_describe', ['model' => $model]);
    }

    /**
     * 表单提交第四步
     */
    public function actionApplyLoan()
    {
        $model = EnterpriseLoan::find()->where(['base_id' => EnterpriseBase::getBaseId(), 'user_id' => $this->userid])->one();
        if (!$model)
        {
            $model = new EnterpriseLoan;
        }
        $request = Yii::$app->request;
        if ($request->isPost)
        {
            $post = $request->post();
            if ($model->add($post))
            {
                # 生成预审核数据~~~start
                $group_id = WorkflowGroup::find()->select('id')->where(['group_key' => 'material'])->scalar();
                $node_info = WorkflowNode::find()->where(['workflow_group_id' => $group_id, 'node_key' => 'node_1'])->asArray()->one();
                $app_id = EnterpriseBase::getBaseId();
                $data = [
                    'app_id' => $app_id,
                    'user_id' => $node_info['approve_user_id'],
                    'group_id' => $node_info['workflow_group_id'],
                    'node_id' => $node_info['id'],
                    'create_time' => time(),
                    'update_time' => time()
                ];
                Yii::$app->db->createCommand()->insert('{{%workflow_log}}', $data)->execute();
                # 生成预审核数据~~~end
                $this->redirect(['apply/apply-success']);
                Yii::$app->end();
            }
        }
        //查询银行
        $bank_list = Organization::find()->where(['pid' => 4])->asArray()->all();
        $options = ['' => '请选择银行'];
        foreach ($bank_list as $key => $vo)
        {
            $options[$vo['id']] = $vo['name'];
        }
        $bank_list = $options;
        return $this->render('apply_loan', ['model' => $model, 'bank_list' => $bank_list]);
    }

    /**
     * 申请成功页面
     */
    public function actionApplySuccess()
    {
        return $this->render('apply_success');
    }

    /**
     * ajax查询企业
     */
    public function actionAjaxQueryEnterpriseName()
    {
        $enterprise_name = Yii::$app->request->post('name');
        $info = EnterpriseBase::get_enterprise_info_by_name($enterprise_name);
        if (empty($info))
        {
            echo json_encode(['ck' => 0, 'msg' => '企业信息不存在']);
            exit;
        }
        # 判断库里其他人有没有提交过该企业
        $is_have = EnterpriseBase::find()->where(['AND', ['enterprise_name' => trim($enterprise_name)], ['<>', 'user_id', $this->userid]])->one();
        if (!empty($is_have))
        {
            echo json_encode(['ck' => 0, 'msg' => '该企业已有资质在申请中，如有疑问请咨询客服']);
            exit;
        }
        $data = [];
        $data['enterprise_name'] = $enterprise_name;
        $data['start_date'] = isset($info['startDate']) ? $info['startDate'] : '';
        $data['legal_person'] = isset($info['operName']) ? $info['operName'] : '';
        $data['legal_person_phone'] = isset($info['legal_person_phone']) ? $info['legal_person_phone'] : '';
        if (!preg_match('/^(1[34578]{1}\d{9})$/', $data['legal_person_phone']))
        {
            $data['legal_person_phone'] = '';
        }
        $address = isset($info['address']) ? $info['address'] : '';
        $contact_address = isset($info['contactAddress']) ? $info['contactAddress'] : '';
        $data['contact_address'] = !empty($address) ? $address : $contact_address;
        $data['contact_mail'] = isset($info['contactEmail']) ? $info['contactEmail'] : '';
        if (!preg_match('/^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/', $data['contact_mail']))
        {
            $data['contact_mail'] = '';
        }
        $register_info = [
            'register_date' => $data['start_date'],
            'register_capital' => isset($info['registCapi']) ? preg_replace('/[^0-9.]/', '', $info['registCapi']) : '',
            'legal_person' => $data['legal_person'],
            'institution_code' => isset($info['orgNo']) ? $info['orgNo'] : '',
            'credit_code' => isset($info['creditNo']) ? $info['creditNo'] : '',
        ];
        $data['register_info'] = json_encode($register_info);
        echo json_encode(['ck' => 1, 'msg' => '存在企业注册信息!', 'data' => $data]);
        exit;
    }

    public function actionAjaxUploadFiles()
    {
        $system = Yii::$app->request->post('system');
        $type = Yii::$app->request->post('type');
        if (in_array($type, array(1, 2, 3, 4, 5, 6)) && $system)
        {
            $allowed_types = ['mht', 'MHT', 'htm', 'HTM', 'html', 'HTML'];
            if ($system == 3)
            {
                $allowed_types = ['mht', 'MHT', 'htm', 'HTM', 'html', 'HTML', 'pdf', 'PDF', 'xls', 'XLS', 'xlsx', 'XLSX'];
            }
            $max_size = 30720000; //30M
        }
        if ($type == 'license')
        {
            $allowed_types = ['jpg', 'jpeg', 'pdf', 'JPG', 'JPEG', 'PDF', 'PNG', 'png'];
            $max_size = 10240000; //10M
        }
        if ($type == 'zz')
        {
            $allowed_types = ['jpg', 'jpeg', 'pdf', 'JPG', 'JPEG', 'PDF', 'PNG', 'png'];
            $max_size = 10240000; //10M
        }
        $uploan_url = 'upfile/kjd/' . date('Ymd') . '/';
        $result = $this->ajax_upload_do($uploan_url, $type, $allowed_types, $max_size);
        return $result;
    }

    /**
     * ajax上传函数
     * @param string $folder 上传到文件夹下
     * @param int $pid 产品ID
     * @param array $allowed_types 允许的文件类型
     * @param int $max_size 允许上传文件的最大值，默认为1M（1024000bytes）
     * @return json数据
     */
    function ajax_upload_do($folder, $pid = 0, $allowed_types = ['gif', 'jpg', 'png'], $max_size = 2024000)
    {
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
        $arr = [
            'code' => '20000',
            'success' => [
                'name' => $files,
                'type' => $pid,
                'date' => $filedate,
                'size' => $size,
                'url' => $file_path
            ]
        ];
        return json_encode($arr);
    }

    /**
     * 获取文件扩展名
     * @param String $filename 要获取文件名的文件
     * @return string
     */
    function getFileExt($filename)
    {
        $info = pathinfo($filename);
        return $info["extension"];
    }

    /**
     * 验证财务报表格式
     */
    public function actionAjaxCheckReprtFormat()
    {
        $info = [];
        $enterprise_type = Yii::$app->request->post('type');
        $upload_id = Yii::$app->request->post('upload_id');
        $year = Yii::$app->request->post('year');
        $filename = Yii::$app->request->post('fileName');
        if (in_array($upload_id, [1, 3, 5]))
        {
            $file_type = "balance";
        }
        else if (in_array($upload_id, [2, 4, 6]))
        {
            $file_type = "profit";
        }
        $result = Tool::check_report_format_by_php($enterprise_type, $file_type, $filename, $year, 'JS');
        $res_asset = $file_type == "balance" ? $result : [];
        $res_profit = $file_type == "profit" ? $result : [];
        if (!empty($result['data']))
        {
            $endTime = isset($result['data']['endTime']) ? $result['data']['endTime'] : '';
            if ($year == 'last')
            {
                // 近一期
                $last_three_start = strtotime(date("Y-m-01", strtotime("-3 month")));
                $last_three_end = strtotime(date("Y-m-01"));
                if (strtotime($endTime) >= $last_three_start && strtotime($endTime) < $last_three_end)
                {
                    echo json_encode(['ck' => 1, 'msg' => '解析通过', 'info' => $info, 'endTime' => $endTime]);
                    exit;
                }
            }
            else
            {
                //年度报表
                $begin_time = isset($result['data']['beginTime']) ? $result['data']['beginTime'] : '';
                if ($endTime == $year . '-12' && (empty($begin_time) || substr($begin_time, 0, 4) == $year))
                {
                    //年销售收入
                    $businessIncomeYear = !empty($res_profit['data']['businessIncomeYear']) ? $res_profit['data']['businessIncomeYear'] : 0;
                    //年利润总额
                    $totalProfitYear = !empty($res_profit['data']['totalProfitYear']) ? $res_profit['data']['totalProfitYear'] : 0;
                    //净资产
                    $totalOwnerEquityEnd = !empty($res_asset['data']['totalOwnerEquityEnd']) ? $res_asset['data']['totalOwnerEquityEnd'] : 0;
                    //资产负债率
                    $totalLiabilitiesEnd = !empty($res_asset['data']['totalLiabilitiesEnd']) ? $res_asset['data']['totalLiabilitiesEnd'] : 0; //负债合计
                    $totalAssetsEnd = !empty($res_asset['data']['totalAssetsEnd']) ? $res_asset['data']['totalAssetsEnd'] : 0; //资产合计
                    $ratio = empty($totalAssetsEnd) ? 0 : $totalLiabilitiesEnd / $totalAssetsEnd;

                    $info['annual_profit'] = round($totalProfitYear / 10000, 6); //年利润总额
                    $info['net_asset'] = round($totalOwnerEquityEnd / 10000, 6); //净资产

                    $info['annual_sales'] = round($businessIncomeYear / 10000, 6); //年销售收入
                    $info['asset_debt_ratio'] = $ratio ? sprintf("%.2f", 100 * $ratio) : 0; //资产负债率

                    echo json_encode(['ck' => 1, 'msg' => '解析通过', 'info' => $info, 'endTime' => $endTime, 'operate_info' => $file_type]);
                    exit;
                }
            }
            echo json_encode(['ck' => -4, 'msg' => '解析通过，报表年份不符', 'info' => $info, 'endTime' => $endTime]);
            exit;
        }
        echo json_encode(['ck' => 0, 'msg' => '格式不正确', 'info' => $info]);
        exit;
    }

}
