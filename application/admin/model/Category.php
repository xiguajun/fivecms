<?php
namespace app\admin\model;

use think\Model;
class Category extends Model
{
    protected $pk = 'catid';
    public function getIspartAttr($value)
    {
        $ispart = [0 => '列表', 1 => '<font color="#FF0000">频道</font>'];
        return $ispart[$value];
    }
    public function getIshiddenAttr($value)
    {
        $ishidden = [0 => '显示', 1 => '<font color="#FF0000">隐藏</font>'];
        return $ishidden[$value];
    }
    public function getList()
    {
        $list = $this->order('listorder desc')->select();
        $list = $this->_tree($list);
        return $list;
    }
    private function _tree($arr, $pid = 0, $level = 0)
    {
        static $tree = array();
        foreach ($arr as $v) {
            if ($v['pid'] == $pid) {
                //$v['level'] = str_repeat('&nbsp;└─&nbsp;', $level);
                $v['level'] = $level;
                $tree[] = $v;
                $this->_tree($arr, $v['catid'], $level + 1);
            }
        }
        return $tree;
    }
}