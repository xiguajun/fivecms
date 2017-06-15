<?php
namespace app\admin\logic;

use think\Model;
use app\admin\model\System;
class Upload extends Model
{
    public function saveimage($body)
    {
        $body = new_stripslashes($body);
        if (!preg_match_all('/<img.*?src="(.*?)".*?>/is', $body, $img_array)) {
            return $body;
        }
        $img_array = array_unique($img_array[1]);
        set_time_limit(0);
        $imgPath = 'uploads/' . date("Ymd");
        $milliSecond = date("YmdHis");
        dir_create($imgPath);
        foreach ($img_array as $key => $value) {
            if (preg_match("#" . "http://" . $_SERVER["HTTP_HOST"] . "#i", $value)) {
                continue;
            }
            if (!preg_match("#^http:\\/\\/#i", $value)) {
                continue;
            }
            $value = trim($value);
            $imgAttr = get_headers($value, true);
            switch ($imgAttr['Content-Type']) {
                case 'image/png':
                    $ext = 'png';
                    break;
                case 'image/jpeg':
                    $ext = 'jpg';
                    break;
                case 'image/gif':
                    $ext = 'gif';
                    break;
                default:
                    $ext = 'jpg';
            }
            $get_file = @file_get_contents($value);
            $filename = mt_rand(100000, 999999) . $milliSecond . $key . '.' . $ext;
            $rndFileName = $imgPath . '/' . $filename;
            if ($get_file) {
                $fp = @fopen($rndFileName, "w");
                @fwrite($fp, $get_file);
                @fclose($fp);
                $webconfig = System::get(1);
                if ($webconfig['isthumb']) {
                    $image = \org\Image::open('./' . $rndFileName);
                    $image->thumb($webconfig['width'], $webconfig['height'])->save('./' . $rndFileName);
                }
                if ($webconfig['iswater']) {
                    $image = \org\Image::open('./' . $rndFileName);
                    if ($webconfig['pwater'] == 0) {
                        $webconfig['pwater'] = rand(1, 9);
                    }
                    $image->water('./public/admin/water/water.png', $webconfig['pwater'])->save('./' . $rndFileName);
                }
            }
            $body = str_replace($value, __ROOT__ . '/' . $rndFileName, $body);
        }
        return $body;
    }
}