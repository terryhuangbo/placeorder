<?php
class Upload
{
    private $rst;
    function __construct() {
        date_default_timezone_set('PRC');//其中PRC为“中华人民共和国”
    }
    /**
     * 上传图片，默认路径为/frontend/web/upload/
     * @para string $temp 相对于/frontend/web/upload/的子目录
     * @return string 返回相对于/frontend/web/的图片路径
     *
     */
    public function ajax_upload($temp = '')
    {

        $ymd = date("Ymd");
        $path = $_SERVER['DOCUMENT_ROOT'] . "/upload" . "$temp/$ymd/";
        $tmpath = "/upload" . $temp . "/$ymd/";

        if (!empty($_FILES))
        {
            //得到上传的临时文件流
            $tempFile = $_FILES['filedata']['tmp_name'];

            //允许的文件后缀
            $fileTypes = array('jpg', 'jpeg', 'gif', 'png');

            //得到文件原名
            $fileName = iconv("UTF-8", "GB2312", $_FILES["filedata"]["name"]);

            $filetype = substr(strrchr($fileName, '.'), 1); //扩展名
            $imgId = uniqid('images');
            $fileNew = $imgId . "." . $filetype;

            //保存路径
            $allPath = "http://" . $_SERVER['SERVER_NAME'] . $tmpath . $fileNew; //相对路径

            //最后保存服务器地址
            if (!is_dir($path))
            {
                mkdir($path);
            }

            if (move_uploaded_file($tempFile, $path . $fileNew))
            {
                $info = $allPath;
            }
            else
            {
                $info = "";
            }

            $this -> rst = $info;
        }
    }

    public function getResult() {
        return $this -> rst;
    }


}

$upload = new Upload();
$upload ->ajax_upload("/company_banner");
$response = array(
    'state'  => 200,
    'result' => $upload -> getResult()
);

echo json_encode($response);