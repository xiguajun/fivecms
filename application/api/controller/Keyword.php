<?php
namespace app\api\controller;

use think\Controller;
use think\Db;
class Keyword extends Controller
{
    public function get_keywords()
    {
        $number = input('number');
        $data = input('data');
        return $this->get_keywords_data($data, $number);
    }
    private function get_keywords_data($data, $number = 3)
    {
        $data = trim(strip_tags($data));
        if (empty($data)) {
            return '';
        }
        $http = new \org\Http();
        $data = iconv('utf-8', 'gbk', $data);
        $http->post('http://tool.phpcms.cn/api/get_keywords.php', array('siteurl' => __ROOT__, 'charset' => 'utf-8', 'data' => $data, 'number' => $number));
        if ($http->is_ok()) {
            return iconv('gbk', 'utf-8', $http->get_data());
        }
        return '';
    }
}