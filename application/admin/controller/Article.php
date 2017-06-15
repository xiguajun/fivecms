<?php
namespace app\admin\controller;

use think\Controller;
use think\Db;
use app\admin\model\Article as Article2;
use app\admin\model\ArticleData;
use app\admin\model\Tag;
use app\admin\model\TagData;
class Article extends Common
{
    public function index()
    {
        $q = input('q');
        $catid = input('catid');
        if ($q) {
            $map['title'] = ['like', '%' . strip_tags(trim($q)) . '%'];
        }
        if ($catid) {
            $map['catid'] = intval($catid);
        }
        if (!isset($map)) {
            $map = 1;
        }
        $article_list = Article2::where($map)->order('listorder desc,id desc')->paginate(10, false, ['query' => ['q' => $q, 'catid' => $catid]]);
        $page = $article_list->render();
        $this->assign('q', $q);
        $this->assign('catid', $catid);
        $this->assign('article_list', $article_list);
        $this->assign('cate_list', model('category')->getList());
        $this->assign('page', $page);
        return $this->fetch();
    }
    public function add()
    {
        if (request()->isPost()) {
            $data = input('post.');
            $data = $this->data_check($data);
            $data['inputtime'] = $data['updatetime'] = request()->time();
            $data['status'] = 1;
            $id = Article2::insertGetId($data);
            if (!$id) {
                return FALSE;
            }
            ArticleData::insert(['id' => $id, 'content' => $data['content'], 'gallery' => $data['gallery']]);
            if (isset($data['keywords'])) {
                $this->go_to_tag($id, $data['keywords']);
            }
            if (isset($data['dosubmit'])) {
                $this->success('添加成功', 'Article/index');
            } else {
                $this->success('添加成功');
            }
        }
        $catid = input('catid');
        $this->assign('list', model('category')->getList());
        $this->assign('catid', intval($catid));
        return $this->fetch();
    }
    public function edit()
    {
        if (request()->isPost()) {
            $data = input('post.');
            $data = $this->data_check($data);
            $data['updatetime'] = request()->time();
            $id = intval($data['id']);
            Article2::update($data);
            ArticleData::update(['id' => $id, 'content' => $data['content'], 'gallery' => $data['gallery']]);
            if (isset($data['keywords'])) {
                $this->go_to_tag($id, $data['keywords']);
            }
            $this->success('修改成功', 'Article/index');
        }
        $id = intval($_GET['id']);
        if (!$id) {
            $this->error('非法参数');
        }
        $r = db('article')->alias('a')->join('__ARTICLE_DATA__ d ', 'a.id= d.id')->where('a.id', $id)->find();
        if (!$r) {
            $this->error('文章不存在');
        }
        $this->assign('list', model('category')->getList());
        $this->assign('result', new_html_entity_decode($r));
        return $this->fetch();
    }
    public function delete()
    {
        $data = input('param.');
        if (!isset($data['id']) || empty($data['id'])) {
            $this->error('参数错误');
        }
        if (is_array($data['id'])) {
            foreach ($data['id'] as $v) {
                $v = intval($v);
                Article2::destroy($v);
                ArticleData::destroy($v);
                TagData::destroy(['contentid' => $v]);
            }
            $this->success('删除成功');
        } else {
            $id = intval($data['id']);
            if (!$id) {
                $this->error('非法参数');
            }
            Article2::destroy($id);
            ArticleData::destroy($id);
            TagData::destroy(['contentid' => $id]);
            $this->success('删除成功');
        }
        $this->success('删除成功');
    }
    public function delete_all()
    {
        Db::execute('truncate ' . $this->prefix . 'article');
        Db::execute('truncate ' . $this->prefix . 'article_data');
        Db::execute('truncate ' . $this->prefix . 'tag');
        Db::execute('truncate ' . $this->prefix . 'tag_data');
        $this->success('删除成功');
    }
    public function listorder()
    {
        $data = input('post.');
        if (!$data) {
            $this->error('参数错误');
        }
        foreach ($data['listorder'] as $k => $v) {
            $k = intval($k);
            Article2::update(['id' => $k, 'listorder' => $v]);
        }
        $this->success('更新成功');
    }
    public function status()
    {
        $data = input('post.');
        if (!isset($data['id']) || empty($data['id'])) {
            $this->error('参数错误');
        }
        foreach ($data['id'] as $v) {
            $v = intval($v);
            $status = Article2::where('id', $v)->value('status');
            $status = $status ? 0 : 1;
            Article2::update(['id' => $v, 'status' => $status]);
        }
        $this->success('更新成功');
    }
    private function go_to_tag($contentid, $data)
    {
        $data = preg_split('/[ ,]+/', $data);
        if (is_array($data) && !empty($data)) {
            foreach ($data as $v) {
                $v = safe_replace(addslashes($v));
                $v = str_replace(['//', '#', '.'], ' ', $v);
                $r = Tag::get(['tag' => $v]);
                if (!$r) {
                    $tagid = Tag::insertGetId(['tag' => $v, 'count' => 1]);
                } else {
                    Tag::where('tagid', $r['tagid'])->setInc('count', 1);
                    $tagid = $r['tagid'];
                }
                if (!TagData::get(['tagid' => $tagid, 'contentid' => $contentid])) {
                    TagData::insert(['tagid' => $tagid, 'contentid' => $contentid]);
                }
            }
        }
    }
    private function data_check($data)
    {
        if (!isset($data['content'])) {
            $data['content'] = '';
        }
        $check_data = ['catid' => $data['catid'], 'title' => $data['title'], 'content' => $data['content']];
        $validate = validate('Article');
        if (!$validate->check($check_data)) {
            $this->error($validate->getError());
        }
        $data['title'] = safe_replace($data['title']);
        $data['content'] = model('upload', 'logic')->saveimage($data['content']);
        //自动提取摘要
        if ($data['description'] == '') {
            $description_length = 200;
            $data['description'] = str_cut(str_replace(["'", "\r\n", "\t", '&ldquo;', '&rdquo;', '&nbsp;'], '', strip_tags(stripslashes($data['content']))), $description_length);
            $data['description'] = addslashes($data['description']);
        }
        //自动提取缩略图
        if (!isset($data['thumb'])) {
            $auto_thumb_no = 0;
            if (preg_match_all("/(src)=([\"|']?)([^ \"'>]+\\.(gif|jpg|jpeg|bmp|png))\\2/i", stripslashes($data['content']), $matches)) {
                $data['thumb'] = $matches[3][$auto_thumb_no];
            }
        }
        $data['description'] = str_replace(['/', '\\', '#', '.', "'"], ' ', $data['description']);
        $data['keywords'] = str_replace(['/', '\\', '#', '.', "'"], ' ', $data['keywords']);
        if (isset($data['gallery'])) {
            if (count($data['gallery']) > 20) {
                $this->error('组图图片不能超过20张');
            }
            $data['gallery'] = array2string($data['gallery']);
        } else {
            $data['gallery'] = '';
        }
        return $data;
    }
}