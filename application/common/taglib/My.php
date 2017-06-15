<?php
namespace app\Common\taglib;

use think\template\TagLib;
class My extends Taglib
{
    // 标签定义
    protected $tags = [
	'clist' => ['attr' => 'pid,num,order,name', 'close' => 1], //分类列表
	'alist' => ['attr' => 'cateid,num,order,name', 'close' => 1],//文章列表
	'tlist' => ['attr' => 'num,order,name', 'close' => 1], //tag列表
	'flist' => ['attr' => 'num,order,name', 'close' => 1]//友情链接
	];
	
	public function tagClist($tag, $content)
    {
        $pid = isset($tag['pid']) ? $tag['pid'] : 0;
        $num = $tag['num'];
        $order = isset($tag['order']) ? $tag['order'] : 'catid desc';
        $parseStr = $parseStr = '<?php ';
        $parseStr .= '$__LIST__ = db(\'category\')->where(\'pid\',' . $pid . ')->where(\'ishidden\',0)->order("' . $order . '")->limit(' . $num . ')->select();';
        $parseStr .= '?>{volist name="$__LIST__" id="' . $tag['name'] . '"}';
        $parseStr .= $content;
        $parseStr .= '{/volist}';
        //解析模板
        $this->tpl->parse($parseStr);
        return $parseStr;
    }
    public function tagAlist($tag, $content)
    {
        $num = $tag['num'];
        $order = isset($tag['order']) ? $tag['order'] : 'id desc';
        $where = 'status=1';
        if (isset($tag['catid']) && intval($tag['catid'])) {
            $where .= ' and catid in (' . catid_str($tag['catid']) . ')';
        }
        $parseStr = $parseStr = '<?php ';
		$parseStr .= '$__LIST__ =db(\'article\')->alias(\'a\')->join(\'__CATEGORY__ c \',\'c.catid= a.catid\')->field(\'a.*,c.catname\')->where("' . $where . '")->order("' . $order . '")->limit(' . $num . ')->select();';
        $parseStr .= '?>{volist name="__LIST__" id="' . $tag['name'] . '"}';
        $parseStr .= $content;
        $parseStr .= '{/volist}';
        //解析模板
        $this->tpl->parse($parseStr);
        return $parseStr;
    }
    
    public function tagTlist($tag, $content)
    {
        $num = $tag['num'];
        $order = isset($tag['order']) ? $tag['order'] : 'tagid desc';
        $parseStr = $parseStr = '<?php ';
        $parseStr .= '$__LIST__ = db(\'tag\')->order("' . $order . '")->limit(' . $num . ')->select();';
        $parseStr .= '?>{volist name="__LIST__" id="' . $tag['name'] . '"}';
        $parseStr .= $content;
        $parseStr .= '{/volist}';
        //解析模板
        $this->tpl->parse($parseStr);
        return $parseStr;
    }
    public function tagFlist($tag, $content)
    {
        $num = $tag['num'];
        $order = isset($tag['order']) ? $tag['order'] : 'id desc';
        $parseStr = $parseStr = '<?php ';
        $parseStr .= '$__LIST__ = db(\'flink\')->order("' . $order . '")->limit(' . $num . ')->select();';
        $parseStr .= '?>{volist name="__LIST__" id="' . $tag['name'] . '"}';
        $parseStr .= $content;
        $parseStr .= '{/volist}';
        //解析模板
        $this->tpl->parse($parseStr);
        return $parseStr;
    }
   
}