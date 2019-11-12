<?php
namespace app\admin\model;

use think\Model;

class Role extends Model
{
    protected $autoWriteTimestamp = true;//设置存储时间为int类型
    protected $resultSetType = 'connection';

    public static function getRoleById($id){
        return self::where('id',$id)->find();
    }

    public static function getRolePage($listRow){
        return self::paginate($listRow);
    }

    public static function addRole($data){
        if(self::create($data)){
            show_json(1,MSG_SUCCESS);
        }else{
            show_json(0,MSG_ERROR);
        }
    }
    public static function getRole(){
        return self::where('status',1)->select();
    }
    public static function updateRole($data){
        if(self::update($data)){
            show_json(1,MSG_SUCCESS);
        }else{
            show_json(0,MSG_ERROR);
        }
    }
}