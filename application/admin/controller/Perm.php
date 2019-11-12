<?php
namespace app\admin\controller;
use app\admin\model\Perm as PermModel;
use app\util\PHPTree;
class Perm extends Basic
{
    public function list(){
        $permModel = new PermModel();
        $permList = $permModel->getAllPerm();
        if($permList){
            $permList = PHPTree::makeTree($permList);
        }
        return $this->fetch('',[
           'permList' => $permList
        ]);
    }

    public function detail(){
        $id = request()->param('id');
        if(request()->isAjax()){
            $data = input('post.');
            if($id){
                //修改
                PermModel::updatePerm($data);
            }else{
                //添加
                //show_json(0,$data);
                PermModel::addPerm($data);
            }
        }
        if($id){

            $perm = PermModel::getPermById($id);
            $this->assign('perm',$perm);
        }
        $permList = PermModel::getAllPermField();
        if($permList){
            $permList = PHPTree::makeTree($permList);
        }
        return $this->fetch('',[
            //'perm' => $perm,
            'permList' => $permList
        ]);
    }

    public function status(){
        if(request()->isAjax()){
            $data = input('post.');
            PermModel::updatePerm($data);
        }else{
            show_json(0,'非法请求');
        }
    }
}