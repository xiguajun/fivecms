<?php
namespace app\admin\controller;

use think\Controller;
use think\Config;
class Common extends Controller
{
    public $prefix;
    protected function _initialize()
    {
        if (!session('fivecms_admin_id') || !session('fivecms_admin_username') || request()->time() - session('fivecms_admin_logintime') > 2 * 60 * 60) {
            $this->redirect(url('Login/index'));
        }
        $config = Config::get('database');
        $this->prefix = $config['prefix'];
    }
    public function logout()
    {
        session('fivecms_admin_username', null);
        session('fivecms_admin_id', null);
        session('fivecms_admin_lasttime', null);
        session('fivecms_admin_logintime', null);
        session('fivecms_admin_lastip', null);
        $this->success('退出成功', 'Login/index');
    }
    public function cache()
    {
        $path = RUNTIME_PATH;
        delDirAndFile($path);
        $this->success('清除缓存成功');
    }
}