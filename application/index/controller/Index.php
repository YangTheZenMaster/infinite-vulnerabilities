<?php
namespace app\index\controller;
//use think\console\command\make\Controller;
use think\Request;
use think\Controller;
use app\index\model\Person as PersonModel;
use app\index\validate\Person as PersonValidate;

class Index extends Controller
{
    public function index()
    {
        return $this->fetch();
    }
    /*这里要去掉吗？
    public function login()
    {
        return $this->fetch();
    }
    public function register()
    {
        return $this->fetch();
    }
    public function add()//接收表单数据
    {
        $data=input('post.');
        $val=new PersonValidate();
        if(!$val->check($data)) {
            $this->error($val->getError());//验证失败
            exit;
        }
        $user=new PersonModel($data);
        if(!captcha_check($data['code'])) {
            $this->error('验证码错误');
            exit;
        }
        $ret=$user->allowField(true)->save();//接收用户信息传输到数据库的结果
        if($ret)
        {
            $this->success('注册成功','Index/index');//跳转到新的页面
        }else{
            $this->error('注册失败');
        }
    }
    public function check()//检验用户名、密码
    {
        $data=input('post.');
        $person=new PersonModel();
        $result=$person->where('name',$data['name'])->find();
        if($result){
            if($result['password']===$data['password']){
                session('name',$data['name']);
            }else{
                $this->error('密码不正确');
                exit;
            }
        }else{
            $this->error('用户名不存在');
            exit;
        }
        if(captcha_check($data['code'])){
            $this->success('登陆成功','Index/index');
        }else{
            $this->error('验证码错误');
            exit;
        }
    }*/
}
