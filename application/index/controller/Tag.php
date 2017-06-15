<?php
namespace app\index\controller;

use think\Controller;
class Tag extends Common
{
    public function index()
    {
        $tag = input('get.tag');
        $tag = strip_tags(trim($tag));
        $r = db('tag')->where('tag', $tag)->find();
        if (!$r) {
            $this->error('TAG不存在！');
        }
        $this->assign('tag', $tag);
        $tagid = $r['tagid'];
        $list = db('tag_data')->alias('t')->join('__ARTICLE__ a', 'a.id= t.contentid')->join('__CATEGORY__ c', 'a.catid= c.catid')->field('a.*,c.catname')->where('t.tagid', $tagid)->paginate(10, false, ['query' => ['tag' => $tag]]);
        $pages = $list->render();
        $this->assign('article_list', $list);
        $this->assign('pages', $pages);
        $seo = seo($tag . '-' . $this->seo['title'], $this->seo['keywords'], $this->seo['description']);
        $this->assign('seo', $seo);
        /*点击数start*/
        db('tag')->where('tag', $tag)->setInc('hits');
        /*点击数end*/
        return $this->fetch($this->template . 'tag_list.html');
    }
    public function tag()
    {
        $seo = seo($this->seo['title'], $this->seo['keywords'], $this->seo['description']);
        $this->assign('seo', $seo);
        return $this->fetch($this->template . 'tag.html');
    }
}