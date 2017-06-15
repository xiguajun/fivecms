<?php
namespace app\admin\validate;

use think\Validate;
class Category extends Validate
{
    protected $rule = ['catname'  => 'require|max:30', 
	                   'category' => 'require|is_html', 
					   'list'     => 'require|is_html',
					   'show'     => 'require|is_html'
					  ];
					  
    protected $message = ['catname.require' => '栏目名称必须填写',
	                      'category.require' => '频道模板必须填写', 
						  'list.require' => '列表模板必须填写',
						  'show.require'=>'文章模板必须填写'
						 ];
						 
    protected function is_html($value, $rule, $data)
    {
        if (!preg_match('/^(.+).html$/', $value)) {
            return '模板格式错误';
        }
        return true;
    }
   
}