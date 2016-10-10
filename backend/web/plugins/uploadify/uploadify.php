<?php
/*
Uploadify
Copyright (c) 2012 Reactive Apps, Ronnie Garcia
Released under the MIT License <http://www.opensource.org/licenses/mit-license.php>
*/

date_default_timezone_set("Asia/Shanghai");
$uniqid = uniqid(rand());
// Define a destination
$targetFolder = '/upload/' . $_POST['upload_path'] . "/" . date("Ymd"); // Relative to the root

$verifyToken = md5('unique_salt' . $_POST['timestamp']);

if (!empty($_FILES) && $_POST['token'] == $verifyToken)
{
    $tempFile = $_FILES['Filedata']['tmp_name'];
    $targetPath = dirname($_SERVER['DOCUMENT_ROOT']).'/webrc' . $targetFolder;
    //$targetFile = rtrim($targetPath, '/') . '/' . $_FILES['Filedata']['name'];
    $expArr = explode('.', $_FILES['Filedata']['name']);
    $extension = end($expArr);
    $targetFile = rtrim($targetPath, '/') . "/{$uniqid}.{$extension}";

    // Validate the file type
    $fileTypes = array('jpg', 'jpeg', 'gif', 'png', 'bmp', 'JPG', 'JPEG', 'GIF', 'PNG', 'BMP'); // File extensions
    $fileParts = pathinfo($_FILES['Filedata']['name']);

    if (in_array($fileParts['extension'], $fileTypes))
    {
        $pfolder = dirname($targetPath);
        if (!is_dir($targetPath)) {
            mkdir($targetPath, 0777, true);
        }
        move_uploaded_file($tempFile, $targetFile);
        $path = $targetFolder . "/{$uniqid}." . $extension;
//        echo "http://" . $_SERVER['SERVER_NAME'] . $path;
        echo "http://rc.vsochina.com" . $path;
    }
    else
    {
        echo 'Invalid file type.';
    }
}
?>