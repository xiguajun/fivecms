<?php
namespace app\admin\validate;

use think\Validate;
class Article extends Validate
{
    protected $rule = ['catid' => 'is_catid', 
	                   'title' => 'require', 
					   'content' => 'require'
					  ];
					  
    protected $message = ['username.require' => '用户名必须填写',
	                      'title.require' => '标题必须填写', 
						  'content.require' => '内容必须填写'
						 ];
						 
    protected function is_catid($value, $rule, $data)
    {
        if (!intval($value)) {
            return '栏目必须选择';
        }
        return true;
    }
    
}