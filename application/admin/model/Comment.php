<?php
namespace app\admin\model;
use think\Model;
use traits\model\SoftDelete;//引入软删除功能

class Comment extends Model
{
    use SoftDelete;
    protected static $deleteTime = 'delete_time';

}
