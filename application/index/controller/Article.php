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
                /*$target_path = "file/";
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
                }*/

                ////修复
                $uploaded_name = $_FILES[ 'file' ][ 'name' ];
                $uploaded_ext  = substr( $uploaded_name, strrpos( $uploaded_name, '.' ) + 1);
                $uploaded_size = $_FILES[ 'file' ][ 'size' ];
                $uploaded_type = $_FILES[ 'file' ][ 'type' ];
                $uploaded_tmp  = $_FILES[ 'file' ][ 'tmp_name' ];
                $target_path ="file\\";
                $target_file   =  md5( uniqid() . $uploaded_name ) . '.' . $uploaded_ext;//MD5加密随机uid+文件名
                $temp_file     = ( ( ini_get( 'upload_tmp_dir' ) == '' ) ? ( sys_get_temp_dir() ) : ( ini_get( 'upload_tmp_dir' ) ) );
                $temp_file    .= DIRECTORY_SEPARATOR . md5( uniqid() . $uploaded_name ) . '.' . $uploaded_ext;
                echo $uploaded_ext;
                if (in_array(strtolower($uploaded_ext),['jpg','jpeg','png'])&&($uploaded_size < 10000000)&&
                    ( $uploaded_type == 'image/jpeg' || $uploaded_type == 'image/png' ))//白名单，限制文件大小
                {
                    //抹除有害的元数据
                    if( $uploaded_type == 'image/jpeg' ) {
                        $img = imagecreatefromjpeg( $uploaded_tmp );
                        imagejpeg( $img, $temp_file, 100);
                    }
                    else {
                        $img = imagecreatefrompng( $uploaded_tmp );
                        imagepng( $img, $temp_file, 9);
                    }
                    //删除上传的源文件
                    imagedestroy( $img );
                    if( rename( $temp_file, ( getcwd() . DIRECTORY_SEPARATOR . $target_path . $target_file ) ) ) {
                        if(db('Comment')->insert($data)){
                            $this->success('添加评论成功！');
                        }else{
                            $this->error('添加评论失败！');
                        }
                    }
                    else {
                        $this->error('文件有问题');
                    }
                    //删除临时文件
                    if( file_exists( $temp_file ) ) unlink( $temp_file );
                }
                else{
                    $this->error('格式不对/文件太大');
                }
                ///end here
            }
        }

    }
}