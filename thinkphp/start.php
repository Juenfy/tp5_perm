<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

namespace think;
use think\Route;
use think\Request;
// ThinkPHP 引导文件
// 1. 加载基础文件
require __DIR__ . '/base.php';
$module = '';
$host = Request::instance()->host();
/**
 * 全局设置错误报告级别
 */
error_reporting(E_ERROR | E_WARNING | E_PARSE);
define('MSG_SUCCESS','操作成功！');
define('MSG_ERROR','操作失败！');
switch ($host){
    case 'admin.tp5demo.com':
        $module = 'admin';
        break;
    default:
        $module = 'index';
        break;
}
Route::bind($module);
// 2. 执行应用
App::run()->send();
