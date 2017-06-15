<?php
namespace app\admin\controller;

use think\Controller;
use think\Db;
use app\admin\model\Guestbook as Guestbook2;
class Guestbook extends Common
{
    public function index()
    {
        $list = Guestbook2::order('id desc')->paginate(10);
        $page = $list->render();
        $this->assign('list', $list);
        $this->assign('page', $page);
        return $this->fetch();
    }
    public function edit()
    {
        $id = intval($_GET['id']);
        if (!$id) {
            $this->error('非法参数');
        }
        $result = Guestbook2::get($id);
        if (!$result) {
            $this->error('留言不存在');
        }
        $this->assign('result', $result);
        return $this->fetch();
    }
    public function update()
    {
        if (request()->isPost()) {
            $data = input('post.');
            $data['replytime'] = request()->time();
            $data['status'] = 1;
            Guestbook2::update($data);
            $this->success('回复成功', 'guestbook/index');
        }
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
                Guestbook2::destroy($v);
            }
            $this->success('删除成功');
        } else {
            $id = intval($data['id']);
            if (!$id) {
                $this->error('非法参数');
            }
            Guestbook2::destroy($id);
            $this->success('删除成功');
        }
        $this->success('删除成功');
    }
    public function delete_all()
    {
        Db::execute('truncate ' . $this->prefix . 'guestbook');
        $this->success('删除成功');
    }
}