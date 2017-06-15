<?php
function seo($title = '', $keywords = '', $description = '')
{
    if (!empty($title)) {
        $title = strip_tags($title);
    }
    if (!empty($description)) {
        $description = strip_tags($description);
    }
    if (!empty($keywords)) {
        $description = strip_tags($keywords);
    }
    $seo['keywords'] = $keywords;
    $seo['description'] = $description;
    $seo['title'] = $title;
    foreach ($seo as $k => $v) {
        $seo[$k] = str_replace(array("\n", "\r"), '', $v);
    }
    return $seo;
}
function catid_str($catid)
{
    $list = db('category')->select();
    $list = getSubs($list, $catid);
    $str = '';
    foreach ($list as $k1 => $v1) {
        $str .= $v1['catid'] . ',';
    }
    $str = substr($str, 0, -1);
    if ($str == '') {
        $str = $catid;
    } else {
        $str = $catid . ',' . $str;
    }
    return $str;
}
function get_keywords($keywords)
{
    $keywords = kw_to_array($keywords);
    $str = '';
    foreach ($keywords as $v) {
        $str .= '<a  href="' . url('Tag/index', ['tag' => urlencode($v)]) . '" >' . $v . '</a>&nbsp;';
    }
    return $str;
}
function get_catpos($catid, $symbol = ' > ')
{
    $list = db('category')->field('catid,pid,catname')->select();
    $list = getParents($list, $catid);
    $str = '';
    foreach ($list as $v) {
        $str .= '<a href=' . url('Category/lists', ['catid' => $v['catid']]) . '>' . $v['catname'] . '</a>' . $symbol;
    }
    $str = '<a href=' . __ROOT__ . '>首页</a>' . $symbol . $str;
    return $str;
}
/*栏目列表*/
function catelist($pid = 0, $num = 5)
{
    $list = db('category')->where('ishidden', 0)->where('pid', $pid)->limit($num)->select();
    return $list;
}
/*子栏目列表*/
function subcatelist($catid, $num = 5)
{
    $list = db('category')->where('pid', $catid)->limit($num)->select();
    return $list;
}
/*指定栏目*/
function get_catname($catid)
{
    return db('category')->where('catid', $catid)->value('catname');
}