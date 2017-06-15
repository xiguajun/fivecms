<?php
function pc_template_list()
{
    $list = glob(ROOT_PATH . 'template_pc' . DIRECTORY_SEPARATOR . '*', GLOB_ONLYDIR);
    $arr = array();
    foreach ($list as $key => $v) {
        $dirname = basename($v);
        if (file_exists($v . DIRECTORY_SEPARATOR . 'config.php')) {
            $arr[$key] = (include $v . DIRECTORY_SEPARATOR . 'config.php');
        } else {
            $arr[$key]['name'] = $dirname;
        }
        $arr[$key]['dirname'] = $dirname;
    }
    return $arr;
}
function wap_template_list()
{
    $list = glob(ROOT_PATH . 'template_wap' . DIRECTORY_SEPARATOR . '*', GLOB_ONLYDIR);
    $arr = array();
    foreach ($list as $key => $v) {
        $dirname = basename($v);
        if (file_exists($v . DIRECTORY_SEPARATOR . 'config.php')) {
            $arr[$key] = (include $v . DIRECTORY_SEPARATOR . 'config.php');
        } else {
            $arr[$key]['name'] = $dirname;
        }
        $arr[$key]['dirname'] = $dirname;
    }
    return $arr;
}
