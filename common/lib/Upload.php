<?php
namespace common\lib;

use Yii;

/**
 * 上传图片类
 *
 */
class Upload
{
    /**
     * 上传图片，默认路径为/frontend/web/upload/
     * @para string $temp 相对于/frontend/web/upload/的子目录
     * @return string 返回相对于/frontend/web/的图片路径
     *
     */
    function upload($path, $objtype = 'user')
    {
        $file = $_FILES['attachment'];

        //允许上传的 文件类型
        $type = array("jpg", "gif", "bmp", "jpeg", "png", "doc", "docx", "pdf", "txt");
        $filetype = substr(strrchr($file['name'], '.'), 1); //扩展名
        $filename = $file['name'];//原文件名

        $gen_dir = $this->_gen_dir();

        //文件完整路径-用于保存文件
        $fileDir =  $_SERVER['DOCUMENT_ROOT'] . rtrim($path, '/') . '/' . $objtype . $gen_dir;
        //文件相对路径-用于web访问
        $filePath = rtrim($path, '/') . '/' . $objtype . $gen_dir;
        //文件名
        $fileName = $this->_gen_img_name($objtype) . '.' . $filetype;
        if (!in_array(strtolower($filetype), $type)) {
            $text = implode(",", $type);
            $result = [
                'code' => -20001,
                'msg' => "您只能上传以下类型文件: ,$text,"
            ];
            return $result;
        }

        //判断路径
        if (!is_dir($fileDir)) {
            @mkdir($fileDir, 0777, true);
        }

        if (@move_uploaded_file($file['tmp_name'], $fileDir . $fileName)) {
            $result = [
                'code' => 20000,
                'msg' => '上传成功',
                'data' => [
                    'fileName' => $fileName, //file现在的名称
                    'orgname' => $filename,//file原来的名称
                    'fileDir' => $fileDir . $fileName,
                    'filePath' => $filePath . $fileName,
//                    'url' => 'http://' . $_SERVER['SERVER_NAME'] . $fileDir . $fileName,
                    'url' => $fileDir . $fileName
                ],
            ];
            return $result;
        } else {
            $result = [
                'code' => -20000,
                'msg' => '上传失败'
            ];
            return $result;
        }
    }

    /**
     * 生成图片名称
     * @return string
     */
    protected function _gen_img_name($objtype) {
        return md5(microtime() . $objtype . rand(0, 10000));
    }

    /**
     * 生成图片路径
     * @return string
     */
    protected function _gen_dir() {
        return '/' . date('Y', time()) . '/' . date('m', time()). '/' . date('d', time()) . '/';
    }

}
?>