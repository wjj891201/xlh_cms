<?php

namespace app\modules\approve\controllers;

use app\modules\approve\controllers\CommonController;
use Yii;
use app\models\WorkflowLog;
use app\models\WorkflowNode;
use app\models\Organization;
use app\models\WorkflowGroup;
use app\models\EnterpriseLoan;
use app\models\EnterpriseBase;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use PHPExcel;


class UniteController extends CommonController
{

    public $group_id;
    public $loan_group_id;

    public function init()
    {
        $this->group_id = WorkflowGroup::find()->select('id')->where(['group_key' => 'material'])->scalar();
        $this->loan_group_id = WorkflowGroup::find()->select('id')->where(['group_key' => 'loan'])->scalar();
    }

    /**
     * 处理具体的审核动作
     */
    public function actionResult()
    {
        if (Yii::$app->request->isGet)
        {
            $workflow_log_id = Yii::$app->request->get('workflow_log_id');
            $action_key = Yii::$app->request->get('action_key');
            $next_node_id = Yii::$app->request->get('next_node_id');
            $data = ['result' => $action_key, 'update_time' => time(), 'is_read' => 1];
        }
        if (Yii::$app->request->isPost)
        {
            $workflow_log_id = Yii::$app->request->post('workflow_log_id');
            $action_key = Yii::$app->request->post('action_key');
            $next_node_id = Yii::$app->request->post('next_node_id');
            $comment = Yii::$app->request->post('comment');
            $data = ['result' => $action_key, 'update_time' => time(), 'comment' => $comment, 'is_read' => 1];
        }
        //当前记录
        $logInfo = WorkflowLog::findOne($workflow_log_id);
        //只有pass、back有下一个节点
        if (in_array($action_key, ['pass', 'back']))
        {
            if ($next_node_id)
            {
                $next_node_info = WorkflowNode::find()->where(['id' => $next_node_id])->asArray()->one();
                if ($next_node_info['approve_user_id'])
                {
                    //有审核用户
                    $user_id = $next_node_info['approve_user_id'];
                }
                else
                {
                    //无审核用户（根据前台选择的来决定）
                    $bank_id = EnterpriseLoan::find()->select('bank_id')->where(['base_id' => $logInfo['app_id']])->scalar();
                    $info = Organization::find()->alias('o')->select(['o.name', 'au.id approve_user_id'])
                                    ->leftJoin('{{%approve_user}} au', 'au.belong=o.id')
                                    ->where(['o.id' => $bank_id])
                                    ->asArray()->one();
                    if (empty($info['approve_user_id']))
                    {
                        echo '<script>alert("机构(' . $info['name'] . ')下没有设置审核用户");</script>';
                        exit;
                    }
                    else
                    {
                        $user_id = $info['approve_user_id'];
                    }
                }
                //生成下一条审核的预信息
                $data2 = [
                    'app_id' => $logInfo['app_id'],
                    'user_id' => $user_id,
                    'group_id' => $logInfo['group_id'],
                    'node_id' => $next_node_id,
                    'operate_user_id' => Yii::$app->approvr_user->identity->id,
                    'create_time' => time()
                ];
                Yii::$app->db->createCommand()->insert("{{%workflow_log}}", $data2)->execute();
            }
        }
        //把审批结果更新一下
        if ($next_node_id || in_array($action_key, ['end', 'defer', 'finish', 'grant']))
        {
            if ($action_key == 'grant')
            {
                //授信
                $grant_data['credit_amount'] = Yii::$app->request->post('credit_amount');
                $grant_data['credit_time'] = Yii::$app->request->post('credit_time');
                $grant_data['credit_validity'] = Yii::$app->request->post('credit_validity');
                $grant_data['loan_id'] = Yii::$app->request->post('loan_id');
                $model = new EnterpriseLoan();
                $res = $model->grant_edit($grant_data, ['loan_id' => $grant_data['loan_id']]);
                $errors = $model->firstErrors;
                if (!$res && !empty($errors))
                {
                    $i = 0;
                    $arr = [];
                    foreach ($errors as $k => $v)
                    {
                        if ($i == 0)
                        {
                            $arr['key'] = $k;
                            $arr['val'] = $v;
                        }
                        $i++;
                    }
                    exit(json_encode(['status' => false, 'msg' => $arr]));
                }
                else
                {
                    WorkflowLog::updateAll($data, ['id' => $workflow_log_id]);
                    exit(json_encode(['status' => true, 'msg' => '授信成功']));
                }
                exit;
            }
            WorkflowLog::updateAll($data, ['id' => $workflow_log_id]);
        }
        else
        {
            //没下一个节点同时满足$action_key为back，则意味着退回到了资料提交者，可以再次编辑
            if ($action_key == 'back')
            {
                $data['is_origin'] = 1;
                WorkflowLog::updateAll($data, ['id' => $workflow_log_id]);
            }
        }
        #如果科技资质认证管理审核结束，那么就进行科技贷申请的流程审核~~~start
        if ($logInfo['group_id'] == $this->group_id && $action_key == 'finish')
        {
            $first_loan_node_info = WorkflowNode::find()->where(['workflow_group_id' => $this->loan_group_id, 'node_key' => 'node_1'])->asArray()->one();
            if ($first_loan_node_info['approve_user_id'])
            {
                //有审核用户
                $user_id = $first_loan_node_info['approve_user_id'];
            }
            else
            {
                //无审核用户（根据前台选择的来决定）
                $bank_id = EnterpriseLoan::find()->select('bank_id')->where(['base_id' => $logInfo['app_id']])->scalar();
                $info = Organization::find()->alias('o')->select(['o.name', 'au.id approve_user_id'])
                                ->leftJoin('{{%approve_user}} au', 'au.belong=o.id')
                                ->where(['o.id' => $bank_id])
                                ->asArray()->one();
                if (empty($info['approve_user_id']))
                {
                    echo '<script>alert("机构(' . $info['name'] . ')下没有审核用户");</script>';
                    exit;
                }
                else
                {
                    $user_id = $info['approve_user_id'];
                }
            }
            //生成贷款审核的预信息
            $data3 = [
                'app_id' => $logInfo['app_id'],
                'user_id' => $user_id,
                'group_id' => $this->loan_group_id,
                'node_id' => $first_loan_node_info['id'],
                'operate_user_id' => Yii::$app->approvr_user->identity->id,
                'create_time' => time()
            ];
            Yii::$app->db->createCommand()->insert("{{%workflow_log}}", $data3)->execute();
        }
        #如果科技资质认证管理审核结束，那么就进行科技贷申请的流程审核~~~end   
        //从哪来回哪去
        $this->goBack(Yii::$app->request->headers['Referer']);
    }

    /**
     * 查看申请资料
     */
    public function actionGetInfo()
    {
        $base_id = Yii::$app->request->get('base_id');
        $base    = EnterpriseBase::findOne(['base_id' => $base_id]);

        $export  = Yii::$app->request->get('export');
        if(!empty($export) && $export=='export'){
            $type = Yii::$app->request->get('type', 'base');
            $this->pdf_title = (!empty($type) && $type == 'loan') ? '企业贷款申请表' : ((!empty($type) && $type == 'base') ? '企业入库申请表' : '企业申请详情');
            $html = $this->renderPartial("export_base", ['base'=>$base], true);
            $this->pdf($html);
            exit;
        }

        return $this->render("get_info", ['base' => $base]);
    }

    public $default_column_name_base = [1,2,4,9,10,20,23];
    public $column_name_base = [
        1=>['id'=>1, 'title'=>'企业名称', 'name'=>'enterprise_name', 'cate'=>1],
        2=>['id'=>2, 'title'=>'所属区域', 'name'=>'town_name', 'cate'=>1],
        3=>['id'=>3, 'title'=>'注册时间', 'name'=>'register_date', 'cate'=>1],
        4=>['id'=>4, 'title'=>'注册资本', 'name'=>'register_capital', 'cate'=>1],
        5=>['id'=>5, 'title'=>'法定代表人', 'name'=>'legal_person', 'cate'=>1],
        6=>['id'=>6, 'title'=>'法人手机', 'name'=>'legal_person_phone', 'cate'=>1],
        7=>['id'=>7, 'title'=>'统一社会信用代码', 'name'=>'credit_code', 'cate'=>1],
        8=>['id'=>8, 'title'=>'组织机构代码', 'name'=>'institution_code', 'cate'=>1],
        9=>['id'=>9, 'title'=>'联系人', 'name'=>'contact_person_man', 'cate'=>1],
        10=>['id'=>10, 'title'=>'联系人手机', 'name'=>'contact_person_phone', 'cate'=>1],
        11=>['id'=>11, 'title'=>'电子邮箱', 'name'=>'contact_mail', 'cate'=>1],  
        13=>['id'=>13, 'title'=>'企业类型', 'name'=>'enterprise_type', 'cate'=>2],
        14=>['id'=>14, 'title'=>'拥有知识产权数', 'name'=>'equity_num', 'cate'=>2],
        15=>['id'=>15, 'title'=>'员工总数', 'name'=>'total_employees_num', 'cate'=>2],
        16=>['id'=>16, 'title'=>'大专以上科技人员数', 'name'=>'above_college_num', 'cate'=>2],
        17=>['id'=>17, 'title'=>'直接从事研发人员数', 'name'=>'research_num', 'cate'=>2],
        18=>['id'=>18, 'title'=>'高新技术产品销售收入', 'name'=>'hightec_sales', 'cate'=>3],
        19=>['id'=>19, 'title'=>'研发经费投入', 'name'=>'research_input', 'cate'=>3],
        20=>['id'=>20, 'title'=>'净资产', 'name'=>'net_asset', 'cate'=>3],
        21=>['id'=>21, 'title'=>'资产负债率', 'name'=>'asset_debt_ratio', 'cate'=>3],
        23=>['id'=>23, 'title'=>'资质申请时间', 'name'=>'base_create_time', 'cate'=>4],
        23=>['id'=>23, 'title'=>'资质审批状态', 'name'=>'base_status', 'cate'=>4],
        24=>['id'=>24, 'title'=>'资质通过时间', 'name'=>'base_update_time', 'cate'=>4],
    ];

    /**
     * [actionBaseDataInfo 资质报表导出]
     * @return [array] 
     */
    public function actionBaseDataInfo(){
        $export      = Yii::$app->request->get('export');
        $column      = Yii::$app->request->get('column');
        $column_data = $this->set_table_field((empty($column) ? [] : explode(',', $column)), $this->column_name_base, $this->default_column_name_base);
        $table       = array_column($column_data, 'title'); //table头部
        $name        = array_column($column_data, 'name'); //name

        $query  =   EnterpriseBase::find()->alias('a')
                    ->select(['a.*', 'b.*', 'c.*', 'd.*', 'e.name town_name'])
                    ->innerJoin('{{%enterprise_describe}} b', 'b.base_id=a.base_id')
                    ->innerJoin('{{%enterprise_finance}} c', 'c.base_id=a.base_id')
                    ->innerJoin('{{%enterprise_loan}} d', 'd.base_id=a.base_id')
                    ->innerJoin('{{%town_list}} e', 'e.id=a.town_id')
                    ->innerJoin('{{%workflow_log}} f', 'f.app_id=a.base_id')
                    ->where(['f.group_id'=>$this->loan_group_id, 'f.result'=>'finish']);
        // echo getLastSql($query);

        $countQuery = clone $query;
        $pages      = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 10]);
        $list       = $query->offset($pages->offset)->limit($pages->limit)->asArray()->all();

        $data   = [];
        if(!empty($list)){
            foreach($list as $k => $v){
                foreach($v as $ko => $vo){
                    if(in_array($ko, $name)){
                        $data[$k][$ko] = $vo;
                    }
                }
            }
            $data = $this->set_field_name($data);
            if(!empty($export) && $export=='execl'){
                $this->data_execl($data, $column_data);
                exit;
            }
        }

        $assign['data']                = $data;
        $assign['pages']               = $pages;
        $assign['name']                = $name; 
        $assign['table']               = $table; 
        $assign['column_name']         = $this->column_name_base; 
        $assign['default_column_name'] = $this->default_column_name_base;        
        return $this->render("base_data_info", $assign);
    }

    public $default_column_name_loan = [1,2,4,9,10,17,27];
    public $column_name_loan = [
        1=>['id'=>1, 'title'=>'企业名称', 'name'=>'enterprise_name',   'cate'=>1],
        2=>['id'=>2, 'title'=>'所属区域', 'name'=>'town_name',  'cate'=>1],
        3=>['id'=>3, 'title'=>'注册时间', 'name'=>'register_date', 'cate'=>1],
        4=>['id'=>4, 'title'=>'注册资本', 'name'=>'register_capital', 'cate'=>1],
        5=>['id'=>5, 'title'=>'法定代表人', 'name'=>'legal_person', 'cate'=>1],
        6=>['id'=>6, 'title'=>'法人手机', 'name'=>'legal_person_phone', 'cate'=>1],
        7=>['id'=>7, 'title'=>'统一社会信用代码', 'name'=>'credit_code', 'cate'=>1],
        8=>['id'=>8, 'title'=>'组织机构代码', 'name'=>'institution_code', 'cate'=>1],
        9=>['id'=>9, 'title'=>'联系人', 'name'=>'contact_person_man', 'cate'=>1],
        10=>['id'=>10, 'title'=>'联系人手机', 'name'=>'contact_person_phone', 'cate'=>1],
        11=>['id'=>11, 'title'=>'电子邮箱', 'name'=>'contact_mail', 'cate'=>1],
        12=>['id'=>12, 'title'=>'所属行业', 'name'=>'industry_id', 'cate'=>1] ,   
        13=>['id'=>13, 'title'=>'企业类型', 'name'=>'enterprise_type', 'cate'=>2],
        14=>['id'=>14, 'title'=>'拥有知识产权数', 'name'=>'equity_num', 'cate'=>2] ,    
        15=>['id'=>15, 'title'=>'大专以上科技人员数', 'name'=>'above_college_num', 'cate'=>2],
        16=>['id'=>16, 'title'=>'直接从事研发人员数', 'name'=>'research_num', 'cate'=>2],
        17=>['id'=>17, 'title'=>'年销售收入', 'name'=>'annual_sales', 'cate'=>3],
        18=>['id'=>18, 'title'=>'高新技术产品销售收入', 'name'=>'hightec_sales', 'cate'=>3],
        19=>['id'=>19, 'title'=>'年利润总额',  'name'=>'annual_profit', 'cate'=>3],
        20=>['id'=>20, 'title'=>'研发经费投入', 'name'=>'research_input', 'cate'=>3],
        21=>['id'=>21, 'title'=>'净资产', 'name'=>'net_asset', 'cate'=>3],
        22=>['id'=>22, 'title'=>'资产负债率', 'name'=>'asset_debt_ratio', 'cate'=>3],
        23=>['id'=>23, 'title'=>'贷款申请时间', 'name'=>'loan_create_time', 'cate'=>4],
        24=>['id'=>24, 'title'=>'贷款申请金额', 'name'=>'apply_amount', 'cate'=>4],
        25=>['id'=>25, 'title'=>'贷款申请期限', 'name'=>'period_month', 'cate'=>4],
        26=>['id'=>26, 'title'=>'受理银行', 'name'=>'bank_name', 'cate'=>4],
        27=>['id'=>27, 'title'=>'贷款审批状态', 'name'=>'loan_status',  'cate'=>4],
        28=>['id'=>28, 'title'=>'授信金额', 'name'=>'credit_amount', 'cate'=>4],
        29=>['id'=>29, 'title'=>'放款金额', 'name'=>'already_loan_amount', 'cate'=>4],
        30=>['id'=>30, 'title'=>'授信时间', 'name'=>'credit_time', 'cate'=>4],
    ];

    /**
     * [actionLoanDataInfo 贷款报表导出]
     * @return [array] 
     */
    public function actionLoanDataInfo(){
        $belong      = Yii::$app->approvr_user->identity->belong;

        $export      = Yii::$app->request->get('export');
        $column      = Yii::$app->request->get('column');
        $column_data = $this->set_table_field((empty($column) ? [] : explode(',', $column)), $this->column_name_loan, $this->default_column_name_loan);
        $table       = array_column($column_data, 'title'); //table头部
        $name        = array_column($column_data, 'name'); //name

        $query       =  EnterpriseLoan::find()->alias('a')
                        ->select(['a.*', 'b.*', 'c.*', 'd.*', 'e.name town_name', 'f.name bank_name'])
                        ->innerJoin('{{%enterprise_base}} b', 'b.base_id=a.base_id')
                        ->innerJoin('{{%enterprise_finance}} c', 'c.base_id=a.base_id')
                        ->innerJoin('{{%enterprise_describe}} d', 'd.base_id=a.base_id')
                        ->innerJoin('{{%town_list}} e', 'e.id=b.town_id')
                        ->innerJoin('{{%organization}} f', 'f.id=a.bank_id')
                        ->innerJoin('{{%workflow_log}} g', 'g.app_id=a.base_id')
                        ->where(['a.bank_id'=>$belong, 'g.group_id'=>$this->loan_group_id, 'g.result'=>'grant']);
        
        // echo getLastSql($query);

        $countQuery = clone $query;
        $pages      = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 10]);
        $list       = $query->offset($pages->offset)->limit($pages->limit)->asArray()->all();

        $data   = [];
        if(!empty($list)){
            foreach($list as $k => $v){
                foreach($v as $ko => $vo){
                    if(in_array($ko, $name)){
                        $data[$k][$ko] = $vo;
                    }
                }
            }
            $data = $this->set_field_name($data);
            if(!empty($export) && $export=='execl'){
                $this->data_execl($data, $column_data);
                exit;
            }
        }

        $assign['data']                = $data;
        $assign['pages']               = $pages;
        $assign['name']                = $name; 
        $assign['table']               = $table; 
        $assign['column_name']         = $this->column_name_loan; 
        $assign['default_column_name'] = $this->default_column_name_loan;        
        return $this->render("loan_data_info", $assign);
    }

    /**
     * [data_execl execl导出]
     * @param  [array] $data        [导入的数据]
     * @param  [array] $column_data [头部信息和字段名]
     * @return [execl]              [execl]
     */
    private function data_execl($data=[], $column_data=[]){
        $table = array_column($column_data, 'title'); //table头部
        $name  = array_column($column_data, 'name');

        $first = $second = $third = $forth = 0;
        foreach($column_data as $v){
            if($v['cate'] == 1){
                $first += 1;
            }elseif($v['cate'] == 2){
                $second += 1;
            }elseif($v['cate'] == 3){
                $third += 1;
            }elseif($v['cate'] == 4){
                $forth += 1;
            }
        }

        $lateral_mark = $this->get_lateral_mark(); //获取横向表

        // 填充头部分类
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        if($first>0){
            $objPHPExcel->getActiveSheet()->mergeCells('A1:'.$lateral_mark[$first-1].'1');
            $objPHPExcel->getActiveSheet()->setCellValue("A1","注册信息");
        }
        if($second>0){
            $objPHPExcel->getActiveSheet()->mergeCells($lateral_mark[$first].'1:'.$lateral_mark[$first+$second-1].'1');
            $objPHPExcel->getActiveSheet()->setCellValue($lateral_mark[$first].'1',"基本情况");           
        }
        if($third>0){
            $objPHPExcel->getActiveSheet()->mergeCells($lateral_mark[$first+$second].'1:'.$lateral_mark[$first+$second+$third-1].'1');
            $objPHPExcel->getActiveSheet()->setCellValue($lateral_mark[$first+$second].'1',"财务数据");
        }
        if($forth>0){
            $objPHPExcel->getActiveSheet()->mergeCells($lateral_mark[$first+$second+$third].'1:'.$lateral_mark[$first+$second+$third+$forth-1].'1');
            $objPHPExcel->getActiveSheet()->setCellValue($lateral_mark[$first+$second+$third].'1',"服务数据");
        }

        // 填充表头信息
        foreach($table as $k => $v){
            $objPHPExcel->getActiveSheet()->setCellValue("{$lateral_mark[$k]}2", "{$v}");
        }

        // 填充内容
        if(!empty($data)){
            $column = 3;
            foreach($data as $rows){  //行写入
                $span = 0;
                foreach($name as $key){
                    $value = $rows[$key]; //列写入
                    $objPHPExcel->getActiveSheet()->setCellValue($lateral_mark[$span].$column, (empty($value) ? '' : $value));
                    $span++;
                }
                $column++;
            }
        }

        $write = new \PHPExcel_Writer_Excel5($objPHPExcel);
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
        header("Content-Type:application/force-download");
        header("Content-Type:application/vnd.ms-execl");
        header("Content-Type:application/octet-stream");
        header("Content-Type:application/download");;
        header('Content-Disposition:attachment;filename="'. date('YmdHis') .'.xls"');
        header("Content-Transfer-Encoding:binary");
        $write->save('php://output');
    }


    /**
     * [set_field_name 特殊字段处理]
     * @param [array] $data []
     */
    private function set_field_name($data){
        $enterprise = Yii::$app->params['enterprise'];
        $enterprise = ArrayHelper::map($enterprise, 'id','name');

        $industry   = Yii::$app->params['industry'];
        $industry   = ArrayHelper::map($industry, 'id','name');
        if(!empty($data)){
            foreach($data as $k => $v){
                if(isset($data[$k]['register_capital']))    $data[$k]['register_capital']     = $v['register_capital'] . '万元';
                if(isset($data[$k]['equity_num']))          $data[$k]['equity_num']           = (int) $v['equity_num'] . '人';
                if(isset($data[$k]['total_employees_num'])) $data[$k]['total_employees_num']  = (int) $v['total_employees_num'] . '人';
                if(isset($data[$k]['above_college_num']))   $data[$k]['above_college_num']    = (int) $v['above_college_num'] . '人';
                if(isset($data[$k]['research_num']))        $data[$k]['research_num']         = (int) $v['research_num'] . '人';
                if(isset($data[$k]['hightec_sales']))       $data[$k]['hightec_sales']        = $v['hightec_sales'] . '万元';
                if(isset($data[$k]['research_input']))      $data[$k]['research_input']       = $v['research_input'] . '万元';
                if(isset($data[$k]['net_asset']))           $data[$k]['net_asset']            = $v['net_asset'] . '万元';
                if(isset($data[$k]['asset_debt_ratio']))    $data[$k]['asset_debt_ratio']     = $v['asset_debt_ratio'] . '%';
                if(isset($data[$k]['register_date']))       $data[$k]['register_date']        = substr($v['register_date'], 0, 10);
                if(isset($data[$k]['industry_id']))         $data[$k]['industry_id']          = $industry[$v['industry_id']];
                if(isset($data[$k]['annual_profit']))       $data[$k]['annual_profit']        = $v['annual_profit'] . '万元';
                if(isset($data[$k]['apply_amount']))        $data[$k]['apply_amount']         = $v['apply_amount'] . '万元';
                if(isset($data[$k]['period_month']))        $data[$k]['period_month']         = $v['period_month'] . '个月';
                if(isset($data[$k]['credit_amount']))       $data[$k]['credit_amount']        = $v['credit_amount'] . '万元';
                if(isset($data[$k]['already_loan_amount'])) $data[$k]['already_loan_amount']  = $v['already_loan_amount'] . '万元';
                if(isset($data[$k]['annual_sales']))        $data[$k]['annual_sales']         = $v['annual_sales'] . '万元';
                if(isset($data[$k]['enterprise_type'])){
                    $enterprise_type = explode(',', $v['enterprise_type']);
                    $str = '';
                    foreach($enterprise_type  as $j){
                        $str .= $enterprise[$j] . ',';
                    }
                    $data[$k]['enterprise_type']     = rtrim($str, ',');
                }
                $data[$k]['loan_status'] = '审批通过';
                $data[$k]['base_status'] = '审批通过';
            }   
        }
        return $data;
    }

    /**
     * [setTableField 组装字段]
     * @param [array] $column      [要显示的字段]
     * @param [array] $column_data [所有字段]
     * @param [arra]  $default     [自定义显示字段]
     */
    private function set_table_field($column, $column_data, $default){
        $column = empty($column) ? $default : $column; //接收参数 或 默认显示字段
        $column_array = array_unique($column); //接收参数ID
        asort($column_array); //排序
        
        $arr = [];
        if(!empty($column_array)){
            foreach($column_array as $v){
                if($v>0 && isset($column_data[$v])){
                    $arr[] = $column_data[$v];
                }
            }
        }
        return $arr;
    }

    /**
     * 获取横向标识
     * @param  integer $num [description]
     * @return [type]       [description]
     */
    private function get_lateral_mark($num=78){
        $range = range('A', 'Z');
        $arr = array();
        for ($i=0; $i<=$num; $i++) {
            $y = ($i / 26);
            if ($y >= 1) {
                $y  = intval($y);
                $aa = chr($y+64).chr($i-$y*26 + 65);
                array_push($arr, $aa);
            }
        }
        return array_merge($range, $arr);
    }
}
