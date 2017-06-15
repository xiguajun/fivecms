<?php
namespace app\admin\model;

use think\Model;
class Guestbook extends Model
{
    protected $pk = 'id';
    public function getStatusAttr($value)
    {
        $status = [0 => '<font color="#FF0000">未回复</font>', 1 => '已回复'];
        return $status[$value];
    }
}