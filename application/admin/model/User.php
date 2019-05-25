<?php
namespace app\admin\model;
use think\Model;
use traits\model\SoftDelete;//引入软删除功能

class User extends Model{
    use SoftDelete;
    protected static $deleteTime='delete_time';
    protected $auto=['ip','password','repassword'];//数据自动完成
    protected function setIpAttr()
    {
        return request()->ip();//自动将用户ip写入数据库
    }
    protected function setPasswordAttr($value)
    {
        return md5($value);//将密码加密
    }
    protected function setRepasswordAttr($value)
    {
        return md5($value);//将再次输入的密码加密
    }
}