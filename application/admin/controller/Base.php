<?php
namespace app\admin\controller;
use think\Controller;

class Base extends Controller
{
    public function _initialize()//防止未登录即进入后台
    {
        if(!session('name')){//判断session中有没有name属性
            $this->error('请先登录','Index/login');
        }
    }

}