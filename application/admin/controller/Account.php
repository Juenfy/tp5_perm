<?php
namespace app\admin\controller;

use think\Controller;
use app\admin\model\Admin;
use think\Cookie;

class Account extends Controller
{
    /**
     * @return mixed
     * 管理员登录
     */
    public function login(){
        if(request()->isAjax()){
            $data = input('post.');
            Admin::checkLogin($data);
        }
        return $this->fetch();
    }

    public function logout(){
        Cookie::delete('admin');
        $this->redirect('/account/login');
    }

}