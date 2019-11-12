<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
/**
 * 返回JSON格式数据
 * @param type $status
 * @param type $return
 */
function show_json($status = 1, $return = null, $flag = true)
{
    $ret = array(
        'status' => $status,
        'result' => $status == 1 ? array('url' => request()->url()) : array()
    );

    if (!is_array($return)) {
        if ($return) {
            $ret['result']['message'] = $return;
        }
        die(json_encode($ret));
    } else {
        $ret['result'] = $return;
    }

    if (isset($return['url'])) {
        $ret['result']['url'] = $return['url'];
    } else if ($status == 1) {
        $ret['result']['url'] = request()->url();
    }
    die(json_encode($ret));
}