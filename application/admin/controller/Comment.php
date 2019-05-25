<?php
namespace app\admin\controller;
use app\admin\model\Comment as CommentModel;

class Comment extends Base
{
    public function commentlist()
    {
        $data = CommentModel::paginate(5);
        $page=$data->render();
        $this->assign('data',$data);
        $this->assign('page',$page);
        return $this->fetch();
    }
    public function delete()
    {
        $id=input('get.id');
        $ret=CommentModel::destroy($id);//软删除
        if($ret){
            $this->success('删除评论成功','Comment/commentlist');
        }else{
            $this->error('删除评论失败');
        }
    }
}