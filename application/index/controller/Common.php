<?php
namespace app\index\controller;

use think\Controller;
class Common extends Controller
{
    public $seo, $template;
    public function _initialize()
    {
        $this->seo = db('system')->find(1);
        $this->template = 'template_pc/' . $this->seo['template_pc'] . '/';
    }
}