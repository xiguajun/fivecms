<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
class Index extends Common
{   
   public function index()
    {   $mysql=Db::query('select VERSION() as version');
	    $server_info  = [
		                'THINKPHP版本'=>THINK_VERSION,
						'服务器软件'     => strpos($_SERVER['SERVER_SOFTWARE'], 'PHP')===false ? $_SERVER['SERVER_SOFTWARE'].'PHP/'.phpversion() : $_SERVER['SERVER_SOFTWARE'],
						'MYSQL版本'=>$mysql[0]['version']?$mysql[0]['version']:'unknown',
						'上传附件限制' => @ini_get('file_uploads') ? ini_get('upload_max_filesize') :'unknown',
						'执行时间限制' => ini_get('max_execution_time').'秒',
						'磁盘剩余空间 '=> round((@disk_free_space(".")/(1024*1024)),2).'M',
					    ];
	    $this->assign('server_info',$server_info);
	    return $this->fetch();
	}
		
   	
}
