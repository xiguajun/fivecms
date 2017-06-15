<?php
namespace app\admin\controller;

use think\Controller;
use app\admin\model\Category as Category2;
use app\admin\model\Article;
class Category extends Common
{
    public function index()
    {
        $list = model('category')->getList();
        foreach ($list as $k => $v) {
            $list[$k]['article_number'] = Article::where('catid', $v['catid'])->count();
        }
        $this->assign('list', $list);
        return $this->fetch();
    }
    public function add()
    {
        if (request()->isPost()) {
            $data = input('post.');
            $data = $this->data_check($data);
            Category2::insert($data);
            $this->success('添加成功', 'Category/index');
        }
        $catid = input('catid');
        $this->assign('list', model('category')->getList());
        $this->assign('catid', intval($catid));
        return $this->fetch();
    }
    public function batch()
    {
        if (request()->isPost()) {
            $data = input('post.');
            $data = $this->data_check($data);
            if (strpos($data['catname'], "\n") === false) {
                $data['catname'] = str_cut($data['catname'], 32);
                Category2::insert($data);
                $this->success('添加成功', 'Category/index');
            } else {
                $cat_arr = explode("\n", $data['catname']);
                foreach ($cat_arr as $key => $val) {
                    $val = trim($val);
                    if (!$val) {
                        continue;
                    }
                    $data['catname'] = str_cut($val, 32);
                    Category2::insert($data);
                }
                $this->success('添加成功', 'Category/index');
            }
        }
        $this->assign('list', model('category')->getList());
        return $this->fetch();
    }
    public function edit()
    {
        if (request()->isPost()) {
            $data = input('post.');
            $data = $this->data_check($data);
            Category2::update($data);
            $this->success('修改成功', 'Category/index');
        }
        $catid = input('catid');
        if (!$catid) {
            $this->error('参数错误');
        }
        $detail = Category2::get($catid);
        $this->assign('list', model('category')->getList());
        $this->assign('detail', $detail);
        return $this->fetch();
    }
    public function listorder()
    {
        if (request()->isPost()) {
            $data = input('post.');
            foreach ($data['listorder'] as $key => $val) {
                Category2::update(['catid' => $key, 'listorder' => intval($val)]);
            }
            $this->success('排序成功');
        }
    }
    public function delete()
    {
        $catid = input('catid');
        if (!$catid) {
            $this->error('参数错误');
        }
        Category2::where('catid', 'in', catid_str($catid))->delete();
        Article::where('catid', 'in', catid_str($catid))->delete();
        $this->success('删除成功');
    }
    private function data_check($data)
    {
        $check_data = ['catname' => $data['catname'], 'category' => $data['category'], 'list' => $data['list'], 'show' => $data['show']];
        $validate = validate('Category');
        if (!$validate->check($check_data)) {
            $this->error($validate->getError());
        }
        if (isset($data['content'])) {
            $data['content'] = model('upload', 'logic')->saveimage($data['content']);
        }
        $data['pn']=intval($data['pn'])?intval($data['pn']):20;
        return $data;
    }
}