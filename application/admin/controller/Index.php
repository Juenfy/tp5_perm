<?php
namespace app\admin\controller;

use think\Controller;

class Index extends Basic
{
    public function index()
    {
        return $this->fetch();
    }
}
