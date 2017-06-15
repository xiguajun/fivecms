<?php
namespace app\admin\validate;

use think\Validate;
class Flink extends Validate
{
    protected $rule = ['title'  => 'require|max:50',
					  ];
					  
    protected $message = ['title.require' => '标题必须填写',
	                      'title.max' => '标题最多不能超过100个字符', 
						 ];
						 
    
}