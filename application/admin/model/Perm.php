<?php
namespace app\admin\model;

use think\Model;

class Perm extends Model
{
    protected $autoWriteTimestamp = true;
    protected $resultSetType = 'connection';

    public function parent(){
        return $this->hasOne('Perm','id','pid')->field('id,title');
    }

    public static function getPermByAction($perm){
        //status为显示隐藏，当然是获取显示的
        return self::where('status',1)->whereIn('action',$perm)->field('id,pid,title,action')->select();
    }

    public function getAllPerm(){
        return $this->with('parent')->select();
    }

    public static function getAllPermField(){
        return self::field('id,pid,title,action')->select();
    }

    public static function getPermById($id){
        return self::where('id',$id)->find();
    }

    public static function addPerm($data){
        if(self::create($data)){
            show_json(1,MSG_SUCCESS);
        }else{
            show_json(0,MSG_ERROR);
        }
    }

    public static function updatePerm($data){
        if(self::update($data)){
            show_json(1,MSG_SUCCESS);
        }else{
            show_json(0,MSG_ERROR);
        }
    }
}