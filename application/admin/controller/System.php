<?php
namespace app\admin\controller;

use think\Controller;
use app\admin\model\System as System2;
class System extends Common
{
    public function set()
    {
        if (request()->isPost()) {
            $data = input('post.');
            $data['isthumb'] = isset($data['isthumb']) ? 1 : 0;
            $data['iswater'] = isset($data['iswater']) ? 1 : 0;
            $data['width'] = intval($data['width']);
            $data['height'] = intval($data['height']);
            if ($data['width'] == 0) {
                $data['width'] = 320;
            }
            if ($data['height'] == 0) {
                $data['height'] = 320;
            }
            $data['pwater'] = intval($data['pwater']);
            $data['id'] = 1;
            if (!$data['template_pc']) {
                $data['template_pc'] = 'default';
            }
            if (!$data['template_wap']) {
                $data['template_wap'] = 'default';
            }
            $path1 = APP_PATH . 'index/config.php';
            if (file_exists($path1)) {
                $arr1 = (include $path1);
                $arr1['template']['view_path'] = './template_pc/' . $data['template_pc'] . '/';
                if (is_writable($path1)) {
                    @file_put_contents($path1, '<?php return ' . var_export($arr1, true) . ';?>');
                } else {
                    $this->error('index/config.php文件不可写');
                }
            }
            $path2 = APP_PATH . 'wap/config.php';
            if (file_exists($path2)) {
                $arr2 = (include $path2);
                $arr2['template']['view_path'] = './template_wap/' . $data['template_wap'] . '/';
                if (is_writable($path2)) {
                    @file_put_contents($path2, '<?php return ' . var_export($arr2, true) . ';?>');
                } else {
                    $this->error('wap/config.php文件不可写');
                }
            }
            System2::update($data);
            $this->success('设置成功');
        }
        $detail = System2::get(1);
        $this->assign('detail', $detail);
        $this->assign('pc_template_list', pc_template_list());
        $this->assign('wap_template_list', wap_template_list());
        return $this->fetch();
    }
}