<?php
namespace app\admin\controller;
use app\admin\model\Article as ArticleModel;
use think\Controller;

class Article extends Base
{
    public function articlelist()
    {
        $data = ArticleModel::paginate(5);
        $page=$data->render();
        $this->assign('data',$data);
        $this->assign('page',$page);
        return $this->fetch();
    }
    public function delete()
    {
        $id=input('get.id');
        $ret=ArticleModel::destroy($id);//软删除
        if($ret){
            $this->success('删除文章成功','Article/articlelist');
        }else{
            $this->error('删除文章失败');
        }
    }

}