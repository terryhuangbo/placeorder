<?php
namespace common\lib;

use Yii;
use yii\base\Exception;

/**
 * 手机端批量上传图片
 *
 */
class Mupload
{
    /**
     * 上传图片，默认路径为/frontend/web/upload/
     * @para string $temp 相对于/frontend/web/upload/的子目录
     * @return string 返回相对于/frontend/web/的图片路径
     *
     */
    public static function ajax_upload($temp = '', $id = 'myfile', $index = 0)
    {
        $ymd = date("Ymd");
        $path = Yii::getAlias('@upload') . "$temp/$ymd/";
        $tmpath = "/upload" . $temp . "/$ymd/";

        if (!empty($_FILES))
        {
            //得到上传的临时文件流
            $tempFile = $_FILES[$id]['tmp_name'][$index];

            //允许的文件后缀
            $fileTypes = array('jpg', 'jpeg', 'pjpeg', 'gif', 'png');

            //得到文件原名
            $fileName = iconv("UTF-8", "GB2312", $_FILES[$id]["name"][$index]);

            $filetype = substr(strrchr($fileName, '.'), 1); //扩展名
            $imgId = uniqid('images');
            $fileNew = $imgId . "." . $filetype;

            //保存路径
            $allPath = yii::$app->params['frontendurl'] . $tmpath . $fileNew; //相对路径

            //最后保存服务器地址
            if (!is_dir($path))
            {
                mkdir($path, 0777, true);
            }

            if (move_uploaded_file($tempFile, $path . $fileNew))
            {
                $info = $allPath;
            }
            else
            {
                $info = "";
            }

            return $info;
        }
    }
}
?>