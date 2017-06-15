<?php
namespace app\admin\model;

use think\Model;
class Article extends Model
{
    protected $pk = 'id';
    public function getStatusAttr($value)
    {
        $status = [0 => '<font color="#FF0000">未审核</font>', 1 => '已审核'];
        return $status[$value];
    }
    public function category()
    {
        return $this->belongsTo('Category','catid')->field('catname');
    }
}