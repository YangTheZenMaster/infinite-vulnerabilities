<?php
namespace app\index\controller;
use think\Controller;
use think\Db;

class Article extends Controller
{
    public function index()
    {
        return $this->fetch();
    }
    public function insert()
    {
        //dump($_POST);
        if(request()->isPost())
        {
            $data = [
                'author' => input('author'),
                'content' => input('content'),
                'create_time' => time(),
                'email'=>input('email')
            ];
            if($_FILES["file"]["error"])
            {
                echo $_FILES["file"]["error"];
            }
            else
            {

                /*最脆弱版本
                if($_FILES["file"]["size"]<1024000)
                {
                    //判断文件是否存在
                    if (file_exists("file/".$_FILES["file"]["name"]))
                    {
                        $this->error('评论失败，请检查您的文件');
                    }
                    else
                    {
                        //保存文件
                        move_uploaded_file($_FILES["file"]["tmp_name"], "file/".$_FILES["file"]["name"]);
                        //评论写入数据库
                        if(db('Comment')->insert($data)){
                            $this->success('添加评论成功！');
                        }else{
                            $this->error('添加评论失败！');
                        }
                    }
                }
                else
                {
                    $this->error('评论失败，请检查您的文件类型/文件大小');
                }
                */

                $target_path = "file/";
                //获取文件名时不能用$_FILES['file']['name']，它会自动去掉换行
                $filename=$_POST['manuelfilename'];
                $target_path = $target_path.$filename;
                $ext=pathinfo($filename,PATHINFO_EXTENSION);
                echo $ext;
                if (!in_array($ext,['php','phtml']))
                {
                    $temp_file=$_FILES['file']['tmp_name'];
                    if(!move_uploaded_file($temp_file, $target_path)) {
                        $this->error('文件有问题');
                    } else {
                        if(db('Comment')->insert($data)){
                            $this->success('添加评论成功！');
                        }else{
                            $this->error('添加评论失败！');
                        }
                    }
                }
                else{
                    $this->error('格式不对');
                }
            }
        }

    }
}