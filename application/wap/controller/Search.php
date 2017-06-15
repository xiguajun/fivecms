<?php
namespace app\wap\controller;

use think\Controller;
class Search extends Common
{
    public function index()
    {
        $q = input('q');
        if (!$q) {
            $this->error('参数错误');
        }
        $q = strip_tags(trim($q));
        $this->assign('q', $q);
        $db = db('article');
        $article_list = $db->alias('a')->join('__CATEGORY__ c', 'c.catid= a.catid')->field('a.*,c.catname')->where('a.title', 'like', '%' . $q . '%')->where('a.status', 1)->order('a.listorder desc,a.id desc')->paginate(10, false, ['query' => ['q' => $q]]);
        $pages = $article_list->render();
        $this->assign('article_list', $article_list);
        $this->assign('pages', $pages);
        /*文章列表end*/
        /*seo start*/
        $seo = seo($q . '搜索' . '-' . $this->seo['title'], $this->seo['keywords'], $this->seo['description']);
        $this->assign('seo', $seo);
        /*seo end*/
        return $this->fetch($this->template . 'search.html');
    }
}