<?php
namespace app\wap\controller;

use think\Controller;
class Common extends Controller
{
    public $seo, $tempalte;
    public function _initialize()
    {
        $this->seo = db('system')->find(1);
        $this->template = 'template_wap/' . $this->seo['template_wap'] . '/';
    }
}