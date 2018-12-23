<?php

namespace app\modules\admin\controllers;

use yii\web\Controller;
use app\modules\admin\models\User;
use app\modules\admin\models\UserRoleRelation;
use app\modules\admin\models\RoleAccessRelation;
use app\modules\admin\models\Access;
use app\models\Lng;
use Yii;

class CommonController extends Controller
{

    public $privilege_urls = []; //保存全部的权限链接
    public $lang;

    public function init()
    {
        //获取当前语言---begin
        $cookies = Yii::$app->request->cookies;
        $this->lang = $cookies->getValue('lang');
        //获取当前语言---end
        $result = Lng::getData(['isopen' => 1]);
        $this->view->params['all_lng'] = $result;
    }

    public function beforeAction($action)
    {
        //1.0 先验证是否已经登录
        if (Yii::$app->session['admin']['isLogin'] != 1)
        {
            return $this->redirect(['/admin/public/login']);
        }
        //2.0再验证权限
        if (!$this->checkPrivilege($action->getUniqueId()))
        {
            if (Yii::$app->request->isAjax)
            {
                exit('404');
            }
            else
            {
                $this->redirect(['/admin/error/forbidden']);
            }
            return false;
        }
        return true;
    }

    //检查是否有访问指定链接的权限
    public function checkPrivilege($url)
    {
        $userName = Yii::$app->session['admin']['name'];
        //如果是超级管理员 也不需要权限判断
        $uDetail = User::find()->where(['name' => $userName])->one();
        if ($uDetail && $uDetail['is_admin'])
        {
            return true;
        }
        return in_array($url, $this->getRolePrivilege($uDetail['id']));
    }

    /*
     * 获取某用户的所有权限
     * 取出指定用户的所属角色，
     * 在通过角色 取出 所属 权限关系
     * 在权限表中取出所有的权限链接
     */

    public function getRolePrivilege($uid = 0)
    {
        if (!$this->privilege_urls)
        {
            $role_ids = UserRoleRelation::find()->where([ 'uid' => $uid])->select('role_id')->asArray()->column();
            if ($role_ids)
            {
                //在通过角色 取出 所属 权限关系
                $access_ids = RoleAccessRelation::find()->where([ 'role_id' => $role_ids])->select('access_id')->asArray()->column();
                //在权限表中取出所有的权限链接
                $list = Access::find()->where([ 'id' => $access_ids])->asArray()->all();
                if ($list)
                {
                    foreach ($list as $_item)
                    {
                        $tmp_urls = @json_decode($_item['urls'], true);
                        //解决多个数据换行带来的问题
                        foreach ($tmp_urls as $k => $vo)
                        {
                            $tmp_urls[$k] = str_replace(["\r\n", "\r", "\n"], '', $vo);
                        }
                        $this->privilege_urls = array_merge($this->privilege_urls, $tmp_urls);
                    }
                }
            }
        }
        return $this->privilege_urls;
    }

}
