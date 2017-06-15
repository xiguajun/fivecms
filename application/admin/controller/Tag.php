<?php
namespace app\admin\controller;

use think\Controller;
use think\Db;
use app\admin\model\Tag as Tag2;
use app\admin\model\TagData;
use app\admin\model\Category;
use app\admin\model\Article;
class Tag extends Common
{
    public function index()
    {
        $this->check();
        $list = Tag2::order('tagid desc')->paginate(10);
        $page = $list->render();
        $this->assign('list', $list);
        $this->assign('page', $page);
        return $this->fetch();
    }
    private function check()
    {
        Tag2::where('tag', '')->delete();
        if (!Category::find() || !Article::find()) {
            Db::execute('truncate ' . $this->prefix . 'tag');
            Db::execute('truncate ' . $this->prefix . 'tag_data');
        }
    }
    public function delete()
    {
        $data = input('param.');
        if (!isset($data['tagid']) || empty($data['tagid'])) {
            $this->error('参数错误');
        }
        if (is_array($data['tagid'])) {
            foreach ($data['tagid'] as $v) {
                $v = intval($v);
                Tag2::destroy($v);
                TagData::destroy(['tagid' => $v]);
            }
            $this->success('删除成功');
        } else {
            $tagid = intval($data['tagid']);
            if (!$tagid) {
                $this->error('非法参数');
            }
            Tag2::destroy($tagid);
            TagData::destroy(['tagid' => $tagid]);
            $this->success('删除成功');
        }
        $this->success('删除成功');
    }
}