<?php
namespace app\admin\controller;

use think\Controller;
use app\admin\model\Admin;
class Login extends Controller
{
    public function index()
    {
        return $this->fetch('login');
    }
    public function check()
    {
        if (request()->isPost()) {
            $username = input('username');
            $password = input('password');
            $code = input('code');
            $check_data = ['username' => $username, 'password' => $password, 'code' => $code];
            $validate = validate('Login');
            if (!$validate->check($check_data)) {
                $this->error($validate->getError());
            }
            $captcha = new \org\Captcha();
            if (!$captcha->check($code)) {
                $this->error('验证码错误');
            }
            $r = Admin::where('username', $username)->field('id,password,lasttime,lastip,encrypt')->find();
            if (!$r) {
                $this->error('用户名不存在');
            }
            if ($r['password'] != five_password($password, $r['encrypt'])) {
                $this->error('密码错误');
            }
            session('fivecms_admin_id', $r['id']);
            session('fivecms_admin_username', $username);
            session('fivecms_admin_lasttime', $r['lasttime']);
            session('fivecms_admin_lastip', $r['lastip']);
            session('fivecms_admin_logintime', request()->time());
            Admin::where('username', $username)->update(['lastip' => request()->ip(), 'lasttime' => request()->time()]);
            $this->success('登录成功', 'Index/index');
        }
    }
}