<?php

// 定义应用目录
define('APP_PATH', __DIR__ . '/application/');
define('BIND_MODULE','admin');

// 检测程序安装
if(!is_file(__DIR__ . '/data/install.lock')){
	header('Location: ./install.php');
	exit;
}
require __DIR__ . '/base.php';
// 加载框架引导文件
require __DIR__ . '/thinkphp/start.php';
