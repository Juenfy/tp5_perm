<?php
namespace app\admin\controller;
use think\Controller;
use app\admin\model\Role;
use app\admin\model\Perm;
use app\util\PHPTree;
/**
 * Class Basic
 * @package app\admin\controller
 * 后台基类
 */
class Basic extends Controller
{
    protected $perm = '';//当前管理员所拥有的权限
    public function _initialize()
    {
        //parent::_initialize(); // TODO: Change the autogenerated stub
        $this->checkLogin();
        $this->checkPerm();
        $this->initNav();
    }

    /**
     * 登录检测
     */
    public function checkLogin(){
        //获取管理员cookie并解码
        $admin = json_decode(base64_decode(cookie('admin')));
        if($admin){
            /**
             * 我们这里定一个规则
             * 管理员的角色id如果为0的时候是超级管理员，拥有所有权限
             * 其他均为后台添加的操作员
             *
             */
            $role_id = $admin->role_id;
            if($role_id){
                //操作员，获取其对应的角色，从而获取他的权限
                $role = Role::getRoleById($role_id);
                $this->perm = $role['en_perm'];
            }else{
                //超级管理员，初始化perm权限为*，即所有权限
                $this->perm = '*';
            }
        }else{
            //没登陆,重定向到登录
            return $this->redirect('/account/login');
        }
    }

    /**
     * 检测当前登录管理员权限
     */
    public function checkPerm(){
        $controller = strtolower(request()->controller());
        $action = strtolower(request()->action());
        if($this->perm != '*'){
            //判断当前管理员请求控制器/方法是否存在其权限当中
            if(strpos(strtolower($this->perm),$controller.'/'.$action)){

            }else{
                return $this->error('没有权限操作');
            }
        }
        //dump($controller.'/'.$action);
        //exit;
        //有权限
        $this->assign('action',$controller.'/'.$action);
    }

    /**
     * 初始化导航栏
     * 这里的话很简单
     * 查找管理员权限perm中所存在表perm中action就行
     */
    public function initNav(){
        if($this->perm == '*'){
            $navs = Perm::getAllPermField();
        }else{
            $navs = Perm::getPermByAction($this->perm);
        }
        //这里的话需要用到一个树辅助类，因为我们的数组要转成树形结构，有父权限节点和子权限节点
        if($navs){
            $navList = PHPTree::makeTree($navs);
        }else{
            $navList = $navs;
        }
        unset($navs);
        $this->assign('navList',$navList);
    }
}