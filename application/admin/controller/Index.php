<?php
namespace app\admin\controller;
use think\Controller;
use app\admin\model\User;

class Index extends Controller
{
    public function login()//调出登录界面
    {
        return $this->fetch();
    }
    public function check()//检验用户名、密码
    {
        //下面是使用了thinkphp框架手册中推荐的方法访问数据库的代码
        /*
        $data=input('post.');
        $user=new User();
        $result=$user->where('name',$data['name'])->find();
        if($result){
            if($result['password']===md5($data['password'])){
                session('name',$data['name']);
            }else{
                $this->error('密码不正确');
                exit;
            }
        }else{
            $this->error('用户名不存在');
            exit;
        }
        */


        //thinkphp使用了pdo查询数据库，难以构造sql注入。这里使用原生sql语句，以构造sql注入点
        header("Content-Type:text/html;charset=gbk");
        $data=input('post.');
        $name=$data['name'];
        $name=addslashes($name);//可以很好地防御字符型注入
        $password=$data['password'];
        $backpassword=md5($password);
        $con=mysqli_connect("localhost","root","root");
        if($con)
        {
            mysqli_select_db($con,'think');
            mysqli_query($con,"set names gbk");
            $sql = "SELECT * FROM think_user WHERE (name = '$name' AND password = '$backpassword') AND `think_user`.`delete_time` IS NULL LIMIT 1";
            $ret=mysqli_query($con,$sql);
            $row=mysqli_fetch_array($ret);
            if($row)
            {
                if(captcha_check($data['code'])){
                    session('name',$data['name']);
                    $this->success('登陆成功','User/index');
                }else{
                    $this->error('验证码错误');
                    exit;
                }
            }
            else {
                $this->error('登录失败');
                exit;
            }
        }
        else{
            $this->error('数据库连接失败');
            exit;
        }

    }
    public function logout()//用户退出
    {
        session(null);
        $this->success('退出登录成功','Index/login');
    }
}