<?php
namespace app\admin\controller;
use app\admin\model\Role as RoleModel;
use app\admin\model\Perm;
use app\util\PHPTree;
class Role extends Basic
{
    public function list(){
        $roleList = RoleModel::getRolePage(10);
        return $this->fetch('',[
            'roleList' => $roleList
        ]);
    }

    public function detail(){
        $id = request()->param('id');
        if(request()->isAjax()){
            $data = input('post.');
            if($id){
                //修改
                RoleModel::updateRole($data);
            }else{
                //添加
                RoleModel::addRole($data);
            }
        }
        $permList = Perm::getAllPermField();
        if($permList){
            $permList = PHPTree::makeTree($permList);
        }
        if($id){
            $role = RoleModel::getRoleById($id);
            $this->assign('role',$role);
            if($permList){
                foreach ($permList as &$perm){
                    if(strpos($role['en_perm'],$perm['action'])){
                        $perm['checked'] = true;
                    }
                    if(isset($perm['children'])){
                        foreach ($perm['children'] as &$child){
                            if(strpos($role['en_perm'],$child['action'])){
                                $child['checked'] = true;
                            }
                        }
                        unset($child);
                    }
                }
                unset($perm);
            }
        }
        return $this->fetch('',[
            'permsJson' => json_encode($permList)
        ]);
    }

    public function status(){
        if(request()->isAjax()){
            $data = input('post.');
            RoleModel::updateRole($data);
        }else{
            show_json(0,'非法请求');
        }
    }
}