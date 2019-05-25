<?php
namespace app\admin\controller;
use app\admin\model\Link as LinkModel;
use app\admin\model\User as UserModel;
use app\admin\validate\User as UserValidate;
use think\Controller;

class Link extends Base
{
    public function linklist()
    {
        $data = LinkModel::paginate(5);
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

        /*
        //file injection point here////////////////////
        $id = str_replace( array( "http://", "https://" ), "", $id );
        //远程文件包含防御
        $id = str_replace( array( "../", "..\\"), "", $id );
        //本地文件包含防御
        if(!is_numeric($id)) {include ($id);}
        $data=LinkModel::get($id);
        $this->assign('data',$data);
        return $this->fetch();
        */

        //漏洞修复：使用文件包含白名单
        if( $id == "link1.php" || $id == "link2.php" || $id == "link3.php" )
        {
            $id=substr($id,-5);
            $id=substr($id,0,1);
            if(!is_numeric($id)) {include ($id);}
            $data=LinkModel::get($id);
            $this->assign('data',$data);
            return $this->fetch();
        }
        else{
            $this->error();
        }
    }
    public function update()
    {
        $data=input('post.');
        $id=input('post.id');
        $link=new LinkModel();
        $ret=$link->allowField(true)->save($data,['id'=>$id]);
        if($ret){
            $this->success('修改友情链接信息成功','Link/linklist');
        }else{
            $this->error('修改友情链接信息失败');
        }
    }
    public function insert()
    {
        //安全版本
/*
        $data=input('post.');
        $data['name']=htmlspecialchars($data['name'], ENT_QUOTES);
        $data['url']=htmlspecialchars($data['url'], ENT_QUOTES);//只有设置了quotestyle 选项为ENT_QUOTES才会过滤单引号
        $link=new LinkModel($data);
        $ret=$link->allowField(true)->save();
        if($ret)
        {
            $this->success('新增成功','Link/linklist');
        }else{
            $this->error('新增失败');
        }
*/
        //end here


        $data=input('post.');
        $name=strtolower($data['name']);
        $url=strtolower($data['url']);
        $name=str_replace("script","scr_ipt",$name);
        $url=str_replace("script","scr_ipt",$url);
        $con=mysqli_connect("localhost","root","root");
        if($con)
        {
            mysqli_select_db($con,'think');
            $sql="INSERT INTO think_link (name,url) VALUES ('$name', '$url')";
            $ret=mysqli_query($con,$sql);
            if($ret)
            {
                $this->success('新增成功','Link/linklist');

            }else {
                    $this->error('新增失败');
            }
        }
        else {
            $this->error('数据库连接失败');
        }

    }
    public function delete()
    {
        $id=input('get.id');
        $ret=LinkModel::destroy($id);//软删除
        if($ret){
            $this->success('删除友情链接成功','Link/linklist');
        }else{
            $this->error('删除友情链接失败');
        }
    }

}