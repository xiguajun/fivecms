<?php
namespace app\api\controller;

use think\Controller;
use think\Db;
class Count extends Controller
{
    public function index()
    {
        $id = intval(input('id'));
        if (!$id) {
            echo "document.write(0);\r\n";
        }
		db('article')->where('id',$id)->setInc('hits');
		$hits=db('article')->where('id',$id)->value('hits');
        echo "document.write('" . $hits . "');\r\n";
    }
}