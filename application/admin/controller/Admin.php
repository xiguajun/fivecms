<?php
namespace app\admin\controller;

use think\Controller;
use app\admin\model\Admin as Admin2;
class Admin extends Common
{
    public function password()
    {
        if (request()->isPost()) {
            $data = input('post.');
            $id = session('fivecms_admin_id');
            $r = Admin2::get($id);
            if ($r['password'] != five_password($data['password_o'], $r['encrypt'])) {
                $this->error('原密码错误');
            }
            if ($data['password_n'] != $data['password_r']) {
                $this->error('新密码与重复密码不一致');
            }
            $encrypt = five_random_str();
            $password = five_password($data['password_n'], $encrypt);
            Admin2::update(['id' => $id, 'password' => $password, 'encrypt' => $encrypt]);
            $this->success('密码修改成功', 'Login/index');
        }
        return $this->fetch();
    }
}