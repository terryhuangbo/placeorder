<?php
header("Content-Type:text/html;charset=utf-8");
error_reporting(E_ERROR | E_WARNING);
date_default_timezone_set("Asia/Shanghai");
include "Uploader.class.php";
//上传配置
//上传文件目录
$Path = "../../../upload/projects/";

$config = array(
    "savePath" => $Path,             //存储文件夹
    "maxSize" => 100 * 1024 * 1024,                   //允许的文件最大尺寸，单位KB
    "allowFiles" => array(".gif", ".png", ".jpg", ".jpeg", ".bmp", ".GIF", ".PNG", ".JPG", ".JPEG", ".BMP"),  //允许的文件格式
);
$up = new Uploader("upfile", $config);
$type = $_REQUEST['type'];
$callback = $_GET['callback'];

$info = $up->getFileInfo();
/**
 * 返回数据
 */
if ($callback)
{
    echo '<script>' . $callback . '(' . json_encode($info) . ')</script>';
}
else
{
    echo json_encode($info);
}
