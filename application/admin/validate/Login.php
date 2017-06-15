<?php
namespace app\admin\validate;

use think\Validate;
class Login extends Validate
{
    protected $rule = ['username' => 'require|is_username', 
	                   'password' => 'require|is_password', 
					   'code' => 'require|is_code'
					  ];
					  
    protected $message = ['username.require' => '用户名必须填写',
	                      'password.require' => '密码必须填写', 
						  'code.require' => '验证码必须填写'
						 ];
						 
    protected function is_username($value, $rule, $data)
    {
        if (!preg_match('/^[a-zA-Z0-9_-]{5,18}$/', $value)) {
            return '用户名格式错误';
        }
        return true;
    }
    protected function is_password($value, $rule, $data)
    {
        if (!preg_match('/^[a-zA-Z0-9_-]{5,18}$/', $value)) {
            return '密码格式错误';
        }
        return true;
    }
    protected function is_code($value, $rule, $data)
    {
        if (!preg_match('/^[a-zA-Z0-9]{4}$/', $value)) {
            return '验证码格式错误';
        }
        return true;
    }
}