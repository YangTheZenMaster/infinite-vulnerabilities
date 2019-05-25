<?php
namespace app\admin\controller;
use app\admin\controller\Base;
use app\admin\model\User as UserModel;
use app\admin\validate\User as UserValidate;

class User extends Base{

    public function index()//这里的方法名要与/app/admin/view/user中的模板名一致
    {
        return $this->fetch();
    }
    public function userlist()//list名称只能在php7以上使用，为防止出错
    {
        $data = UserModel::paginate(5);//通过分页显示用户列表
        $page=$data->render();
        $this->assign('data',$data);
        $this->assign('page',$page);
        return $this->fetch();
    }
    public function add()
    {
        return $this->fetch();
    }
    public function edit()
    {
        $id=$_GET["id"];

        //反射型XSS漏洞修复代码：
        $id=htmlspecialchars($id, ENT_QUOTES);


        /*貌似搞复杂了，htmlspecialchars完全可以cover
        $id1=strtolower($id);
        $ra1 = Array('javascript', 'vbscript', 'expression', 'applet', 'meta', 'xml', 'blink', 'link', 'style', 'script', 'embed', 'object', 'iframe', 'frame', 'frameset', 'ilayer', 'layer', 'bgsound', 'title', 'base');
        $ra2 = Array('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterchange', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowenter', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload');
        $ra = array_merge($ra1, $ra2);
        for ($i = 0; $i < sizeof($ra); $i++)
        {
            if(strpos($id1,$ra[$i]))
            {
                $this->error('存在敏感字符','User/userlist');
            }
        }*/
        //end here

        //vulnerable code

        //$id=strtolower($id);
       // $id=str_replace("script","scr_ipt",$id);
        //end here

        if(session('name')=="yangke")
        {//只有登录用户名为yangke的账户才会要求get这个testip用于管理员测试
            $test_ip=$_GET["testip"];

            //命令执行漏洞修复代码：
            $test_ip=escapeshellcmd($test_ip);
            echo $test_ip;
            //end here

        }
        else{
            $test_ip=null;
        }
        $preg = "/\A((([0-9]?[0-9])|(1[0-9]{2})|(2[0-4][0-9])|(25[0-5]))\.){3}(([0-9]?[0-9])|(1[0-9]{2})|(2[0-4][0-9])|(25[0-5]))\Z/";
        exec("ipconfig", $out, $stats);
        if (!empty($out))
        {
            foreach ($out AS $row)
            {
                if (strstr($row, "IP") && strstr($row, ":") && !strstr($row, "IPv6"))
                {
                    $tmpIp = explode(":", $row);
                    if (preg_match($preg, trim($tmpIp[1])))
                    {
                        $local_ip=$tmpIp[1];
                    }
                }
            }
        }
        $data=UserModel::get($id);
        $this->assign('data',$data);
        $this->assign('id',$id);
        if($test_ip==null){
            $this->assign('ip',$local_ip);
            $this->assign('local_ip',$local_ip);
        }
        else{
            $this->assign('ip',$test_ip);
            $this->assign('local_ip',$local_ip);
        }
        return $this->fetch();
    }
    public function update()
    {
        $data=input('post.');
        $id=input('post.id');
        $val=new UserValidate();
        if(!$val->check($data)) {
            $this->error($val->getError());//验证失败
            exit;
        }
        $user=new UserModel();
        $ret=$user->allowField(true)->save($data,['id'=>$id]);
        if($ret){
            $this->success('修改用户信息成功','User/userlist');
        }else{
            $this->error('修改用户信息失败');
        }

    }
    public function insert()//新增用户的方法，接受表单的提交
    {

        $data=input('post.');
        $val=new UserValidate();
        if(!$val->check($data)) {
            $this->error($val->getError());//验证失败
            exit;
        }
        $user=new UserModel($data);
        $ret=$user->allowField(true)->save();//接收用户信息传输到数据库的结果
        if($ret)
        {
            $this->success('新增成功','User/userlist');//跳转到新的页面
        }else{
            $this->error('新增失败');
        }

    }
    public function changepassword()
    {
        return $this->fetch();
    }
    public function change()//csrf
    {
        /*vulnerable code
        if($_SERVER['HTTP_REFERER'])
        {
            $data=input('post.');
            if($data['password']!=$data['repassword'])
            {
                $this->error('两次密码不一致');
                exit;
            }
            $con=mysqli_connect("localhost","root","root");
            if($con)
            {
                mysqli_select_db($con,'think');
                $name=session('name');
                $password=md5($data['password']);
                $sql="UPDATE think_user SET password = '$password', repassword= '$password' WHERE name = '$name'";
                $ret=mysqli_query($con,$sql);
                if($ret)
                {
                    $this->success('密码修改成功','User/index');

                }else {
                    $this->error('两次密码不一致');
                }
            }
            else{
                $this->error('非法请求');
                exit;
            }
        }*/

        //漏洞修复
        if($_SERVER['HTTP_REFERER'])
        {
            $data=input('post.');
            if($data['password']!=$data['repassword'])
            {
                $this->error('两次密码不一致');
                exit;
            }
            $con=mysqli_connect("localhost","root","root");
            if($con)
            {
                mysqli_select_db($con,'think');
                $name=session('name');
                $password=md5($data['password']);
                $sql="UPDATE think_user SET password = '$password', repassword= '$password' WHERE name = '$name'";
                $ret=mysqli_query($con,$sql);
                if($ret)
                {
                    session(null);////////////////////////////强制退出登录、并清除session
                    $this->success('密码修改成功，请重新登录','Index/login');
                    exit;
                }else {
                    session(null);
                    $this->error('两次密码不一致！出于安全考虑，请退出重新登录！','Index/login');
                    exit;
                }
            }
            else{
                $this->error('非法请求');
                exit;
            }
        }
    }
    public function delete()//软删除，硬删除会导致性能问题，且不可以数据恢复
    {
        $id=input('get.id');
        $ret=UserModel::destroy($id);//软删除
        if($ret){
            $this->success('删除用户成功','User/userlist');
        }else{
            $this->error('删除用户失败');
        }
        /*$id=input('get.id');
        $ret=UserModel::destroy($id,1);//硬删除
        if($ret){
            $this->success('删除用户成功','User/userlist');
        }else{
            $this->error('删除用户失败');
        }*/
    }
}

