<?php
namespace app\admin\controller;
use app\admin\model\Admin as AdminModel;
use app\admin\model\Role;
class Admin extends Basic
{
    public function list(){
        $adminModel = new AdminModel();
        $adminList = $adminModel->getAdminPage(10);
        $roleList = Role::getRole();
        return $this->fetch('',[
            'adminList' => $adminList,
            'roleList' => $roleList
        ]);
    }

    public function detail(){
        $id = request()->param('id');
        if(request()->isAjax()){
            $data = input('post.');
            AdminModel::checkRegster($data);
        }
        if($id){
            $admin = AdminModel::getAdminById($id);
            $this->assign('adminer',$admin);
        }
        $roleList = Role::getRole();
        return $this->fetch('',[
            'roleList' => $roleList
        ]);
    }


    public function status(){
        if(request()->isAjax()){
            $data = input('post.');
            AdminModel::updateAdmin($data);
        }else{
            show_json(0,'非法请求');
        }
    }

}