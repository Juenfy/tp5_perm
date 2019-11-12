<?php
namespace app\admin\model;

use think\Model;
use think\Validate;
class Admin extends Model
{
    protected $autoWriteTimestamp  = true;
    protected $resultSetType = 'connection';

    public function role(){
        return $this->hasOne('Role','id','role_id')->field('id,name');
    }
    /**
     * 登录校验
     * 这里可以用tp的验证器
     */
    public static function checkLogin($data){
        //验证规则，这里的key要对应传进来data的key
        $rule = [
            'account' => 'require|min:6',
            'password' => 'require|min:6',
            'captcha_code' => 'require'
        ];
        //对应的消息
        $msg = [
            'account.min' => '账号不能少于6位',
            'password.require' => '密码不能为空',
            'password.min' => '密码不能少于6位',
            'captcha_code.require' => '验证码不能为空',
        ];
        $validate = new Validate($rule,$msg);
        if($validate->batch()->check($data)){
            //因为是异步登录，所以需要返回json数据，这里我要用到一个专门处理json数据返回的函数
            //初步验证成功，验证验证码
            if(!captcha_check($data['captcha_code'])){
                show_json(0,'验证码有误');
            }
            $admin = self::where('account',$data['account'])
                ->where('password',md5($data['password']))
                ->field('id,role_id,account,nickname,avatar,status')
                ->find();
            if($admin){
                if($admin['status']){
                    $adminCookie = base64_encode(json_encode($admin));
                    cookie('admin',$adminCookie);
                    show_json(1,[
                       'message' => '登陆成功',
                        'data' => $adminCookie
                    ]);
                }else{
                    show_json(0,'账户已被禁用');
                }
            }else{
                show_json(0,'账号或密码错误！');
            }
        }else{
            //验证失败
            show_json(0,implode('<br/>',$validate->getError()));
        }

    }

    public static function checkRegster($data){
        //验证规则，这里的key要对应传进来data的key
        $rule = [
            'account' => 'min:6',
            'password' => 'min:6',
            'password_confirm' => 'min:6'
        ];
        //对应的消息
        $msg = [
            'account.min' => '账号不能少于6位',
            'password.min' => '密码不能少于6位',
            'password_confirm.min' => '确认密码不能少于6位',
        ];
        $validate = new Validate($rule,$msg);
        if($validate->batch()->check($data)){
            if($data['password'] != $data['password_confirm']){
                show_json(0,'两次密码不一致');
            }
            $admin = self::where('account',$data['account'])->find();
            if($admin){
                show_json(0,'账户已存在!');
            }else{
                $data['password'] = md5($data['password']);
                unset($data['password_confirm']);
                if(empty($data['id'])){
                    $data['avatar'] = '/static/admin/image/avatar/admin.jpg';
                }
                if($res = $data['id']?self::update($data):self::create($data)){
                    show_json(1,MSG_SUCCESS);
                }else{
                    show_json(0,MSG_ERROR);
                }
            }
        }else{
            //验证失败
            show_json(0,implode('<br/>',$validate->getError()));
        }
    }
    public function getAdminPage($listRow){
        return $this->with('role')->paginate($listRow);
    }
    public static function updateAdmin($data){
        if(self::update($data)){
            show_json(1,MSG_SUCCESS);
        }else{
            show_json(0,MSG_ERROR);
        }
    }
    public static function getAdminById($id){
        return self::where('id',$id)->find();
    }

}