<?php
namespace app\admin\validate;
use think\Validate;

class User extends Validate{
    protected $rule=[//为用户信息定义一些约束
        'name|用户名'=>'require|min:3',
        'password|密码' => 'require|min:6|confirm:repassword',
        'email|邮箱' => 'require',
    ];

    protected $message = [//提示信息
        'name.require' => '用户名不能为空',
        'name.min' => '用户名长度不能小于3',
        'password.require' => '密码不能为空',
        'password.confirm' => '两次密码不一致',
        'email.require' => '邮箱不能为空'
    ];

}