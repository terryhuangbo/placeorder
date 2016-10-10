<?php
namespace common\widgets\ueditor;

use common\lib\Http;
use common\lib\HttpRequest;
use Yii;
use yii\base\Action;
use yii\helpers\ArrayHelper;

class UEditorAction extends Action {
    /**
     * @var array
     */
    public $config = [];


    public function init() {
        //close csrf
        Yii::$app->request->enableCsrfValidation = false;
        //默认设置
        $_config = require(__DIR__ . '/config.php');
        //load config file
        $this->config = ArrayHelper::merge($_config, $this->config);
        parent::init();
    }

    public function run() {
        $this->handleAction();
    }

    /**
     * 处理action
     */
    protected function handleAction() {
        $action = Yii::$app->request->get('action', 'uploadimage');
        switch ($action) {
            case 'config':
                $result = json_encode($this->config);
                break;
            case 'uploadimage':/* 上传图片 */
                $upload_type = yii::$app->request->get('upload_type');
                if ($upload_type == 2) {
                    $result = $this->actionUpload2();
                } else {
                    $result = $this->actionUpload();
                }
                break;
            case 'uploadscrawl':/* 上传涂鸦 */
                break;
            case 'uploadvideo':/* 上传视频 */
                break;
            case 'uploadfile':/* 上传文件 */
                $upload_type = yii::$app->request->get('upload_type');
                if ($upload_type == 2) {
                    $result = $this->actionUpload2();
                } else {
                    $result = $this->actionUpload();
                }
                break;
            case 'listimage':/* 列出图片 */
                break;
            case 'listfile':/* 列出文件 */
                $result = $this->actionList();
                break;
            case 'catchimage':/* 抓取远程文件 */
                $result = $this->actionCrawler();
                break;
            default:
                $result = json_encode([
                    'state' => '请求地址出错',
                ]);
                break;
        }
        /* 输出结果 */
        if (isset($_GET["callback"])) {
            if (preg_match("/^[\w_]+$/", $_GET["callback"])) {
                echo htmlspecialchars($_GET["callback"]) . '(' . $result . ')';
            } else {
                echo json_encode(array(
                    'state' => 'callback参数不合法'
                ));
            }
        } else {
            echo $result;
        }
    }

    /**
     * 上传
     * @return string
     */
    protected function actionUpload() {
        $base64 = "upload";
        switch (htmlspecialchars($_GET['action'])) {
            case 'uploadimage':
                $config = array(
                    "pathRoot" => ArrayHelper::getValue($this->config, "imageRoot", $_SERVER['DOCUMENT_ROOT']),
                    "pathFormat" => $this->config['imagePathFormat'],
                    "maxSize" => $this->config['imageMaxSize'],
                    "allowFiles" => $this->config['imageAllowFiles']
                );
                $fieldName = $this->config['imageFieldName'];
                break;
            case 'uploadscrawl':
                $config = array(
                    "pathRoot" => ArrayHelper::getValue($this->config, "scrawlRoot", $_SERVER['DOCUMENT_ROOT']),
                    "pathFormat" => $this->config['scrawlPathFormat'],
                    "maxSize" => $this->config['scrawlMaxSize'],
                    "allowFiles" => $this->config['scrawlAllowFiles'],
                    "oriName" => "scrawl.png"
                );
                $fieldName = $this->config['scrawlFieldName'];
                $base64 = "base64";
                break;
            case 'uploadvideo':
                $config = array(
                    "pathRoot" => ArrayHelper::getValue($this->config, "videoRoot", $_SERVER['DOCUMENT_ROOT']),
                    "pathFormat" => $this->config['videoPathFormat'],
                    "maxSize" => $this->config['videoMaxSize'],
                    "allowFiles" => $this->config['videoAllowFiles']
                );
                $fieldName = $this->config['videoFieldName'];
                break;
            case 'uploadfile':
            default:
                $config = array(
                    "pathRoot" => ArrayHelper::getValue($this->config, "fileRoot", $_SERVER['DOCUMENT_ROOT']),
                    "pathFormat" => $this->config['filePathFormat'],
                    "maxSize" => $this->config['fileMaxSize'],
                    "allowFiles" => $this->config['fileAllowFiles']
                );
                $fieldName = $this->config['fileFieldName'];
                break;
        }
        /* 生成上传实例对象并完成上传 */

        $up = new Uploader($fieldName, $config, $base64);
        /**
         * 得到上传文件所对应的各个参数,数组结构
         * array(
         *     "state" => "",          //上传状态，上传成功时必须返回"SUCCESS"
         *     "url" => "",            //返回的地址
         *     "title" => "",          //新文件名
         *     "original" => "",       //原始文件名
         *     "type" => ""            //文件类型
         *     "size" => "",           //文件大小
         * )
         */

        /* 返回数据 */
        return json_encode($up->getFileInfo());
    }


    /**
     * 媒体中心-上传
     * @return string
     */
    protected function actionUpload2() {
        $base64 = "upload";
        $_cloud_file_root = yiiParams('cloud_mall')['mount_dir'];
        $shop_id = yii::$app->request->get('shop_id');
        $goods_id = yii::$app->request->get('goods_id');
        $username = urlencode(yii::$app->request->get('username'));

        $_files = current($_FILES);
//        $file_name = md5(time() . $username . rand(0, 1)) . '.' . pathinfo($_files['name'])['extension'];

        /*$_relation_ext_arr = [
            'image/jpeg' => '.jpg',
            'image/png' => '.png',
        ];

        $_http_lib = new HttpRequest();
        $_http_lib->setConfig([
            'ip' => 'ssl://mall.vsochina.com',
            'host' => 'https://mall.vsochina.com' . yiiParams('cloud_box')['upload'] . '?' . http_build_query([
                    'username' => $username,
                    'createFolder' => 'true',
                    'filename' => 'filename',
                ]),
            'port' => '443',
            'errno' => '',
            'errstr' => '',
            'timeout' => 30,
            'url' => yiiParams('cloud_box')['upload'],
        ]);

        $_http_lib->setConfig([
            'ip' => 'tcp://192.168.1.196',
            'host' => 'http://192.168.1.196:3200/',
            'port' => 3200,
            'errno' => '',
            'errstr' => '',
            'timeout' => 30,
            'url' => '/upload',//yiiParams('cloud_box')['upload'],
        ]);

        $new_file_name = md5(microtime() . $username . rand(0, 1)) . $_relation_ext_arr[$_files['type']];
        $new_file_path = dirname($_files['tmp_name']) . '/' . $new_file_name;
        rename($_files['tmp_name'], $new_file_path);

        $_http_lib->setFormData([
            'folder' => '/test',
            'name' => $new_file_name,
        ]);

        $_http_lib->setFileData([
            [
                'name' => $new_file_name,
                'filename' => basename($new_file_name),
                'path' => $new_file_path,
            ]
        ]);

        $ret = $_http_lib->send('multipart');

        echo ($ret);
        exit;*/

        $file_name = md5(microtime() . $username . rand(0, 1));

        $folder = '/' . $shop_id . '/goods/' . $goods_id . '/content';
        $son_dir = '/users/' . $username{0} . '/' . $username{1} . '/' . $username{2} . '/' . $username{3} . '/' . $username . $folder . '/' . $file_name;

        $_ret_path = $folder . '/' . $file_name . '.' . pathinfo($_files['name'])['extension'];

        switch (htmlspecialchars($_GET['action'])) {
            case 'uploadimage':
                $config = array(
                    "pathRoot" => $_cloud_file_root,
                    "pathFormat" => $son_dir,
                    "maxSize" => $this->config['imageMaxSize'],
                    "allowFiles" => $this->config['imageAllowFiles']
                );
                $fieldName = $this->config['imageFieldName'];
                break;
            case 'uploadscrawl':
                $config = array(
                    "pathRoot" => $_cloud_file_root,
                    "pathFormat" => $son_dir,
                    "maxSize" => $this->config['scrawlMaxSize'],
                    "allowFiles" => $this->config['scrawlAllowFiles'],
                    "oriName" => "scrawl.png"
                );
                $fieldName = $this->config['scrawlFieldName'];
                $base64 = "base64";
                break;
            case 'uploadvideo':
                $config = array(
                    "pathRoot" => $_cloud_file_root,
                    "pathFormat" => $son_dir,
                    "maxSize" => $this->config['videoMaxSize'],
                    "allowFiles" => $this->config['videoAllowFiles']
                );
                $fieldName = $this->config['videoFieldName'];
                break;
            case 'uploadfile':
            default:
                $config = array(
                    "pathRoot" => $_cloud_file_root,
                    "pathFormat" => $son_dir,
                    "maxSize" => $this->config['fileMaxSize'],
                    "allowFiles" => $this->config['fileAllowFiles']
                );
                $fieldName = $this->config['fileFieldName'];
                break;
        }
        /* 生成上传实例对象并完成上传 */

        $up = new Uploader($fieldName, $config, $base64);
        /**
         * 得到上传文件所对应的各个参数,数组结构
         * array(
         *     "state" => "",          //上传状态，上传成功时必须返回"SUCCESS"
         *     "url" => "",            //返回的地址
         *     "title" => "",          //新文件名
         *     "original" => "",       //原始文件名
         *     "type" => ""            //文件类型
         *     "size" => "",           //文件大小
         * )
         */

        $ret = $up->getFileInfo();
        $ret['url'] = rtrim(yiiParams('shop_index_url'), '/') . yiiParams('cloud_box')['thumbnail'] . '?' . http_build_query(['username' => $username, 'path' => $_ret_path, 'width' => '600', 'options' => 'fit', 'watermark' => '水印.png']);

        /* 返回数据 */
        return json_encode($ret);
    }

    /**
     * 获取已上传的文件列表
     * @return string
     */
    protected function actionList() {
        /* 判断类型 */
        switch ($_GET['action']) {
            /* 列出文件 */
            case 'listfile':
                $allowFiles = $this->config['fileManagerAllowFiles'];
                $listSize = $this->config['fileManagerListSize'];
                $path = $this->config['fileManagerListPath'];
                break;
            /* 列出图片 */
            case 'listimage':
            default:
                $allowFiles = $this->config['imageManagerAllowFiles'];
                $listSize = $this->config['imageManagerListSize'];
                $path = $this->config['imageManagerListPath'];
        }
        $allowFiles = substr(str_replace(".", "|", join("", $allowFiles)), 1);

        /* 获取参数 */
        $size = isset($_GET['size']) ? htmlspecialchars($_GET['size']) : $listSize;
        $start = isset($_GET['start']) ? htmlspecialchars($_GET['start']) : 0;
        $end = (int)$start + (int)$size;

        /* 获取文件列表 */
        $path = $_SERVER['DOCUMENT_ROOT'] . (substr($path, 0, 1) == "/" ? "" : "/") . $path;
        $files = $this->getfiles($path, $allowFiles);
        if (!count($files)) {
            return json_encode(array(
                "state" => "no match file",
                "list" => array(),
                "start" => $start,
                "total" => count($files)
            ));
        }

        /* 获取指定范围的列表 */
        $len = count($files);
        for ($i = min($end, $len) - 1, $list = array(); $i < $len && $i >= 0 && $i >= $start; $i--) {
            $list[] = $files[$i];
        }
//倒序
//for ($i = $end, $list = array(); $i < $len && $i < $end; $i++){
//    $list[] = $files[$i];
//}

        /* 返回数据 */
        $result = json_encode(array(
            "state" => "SUCCESS",
            "list" => $list,
            "start" => $start,
            "total" => count($files)
        ));

        return $result;
    }

    /**
     * 抓取远程图片
     * @return string
     */
    protected function actionCrawler() {
        /* 上传配置 */
        $config = array(
            "pathFormat" => $this->config['catcherPathFormat'],
            "maxSize" => $this->config['catcherMaxSize'],
            "allowFiles" => $this->config['catcherAllowFiles'],
            "oriName" => "remote.png"
        );
        $fieldName = $this->config['catcherFieldName'];

        /* 抓取远程图片 */
        $list = array();
        if (isset($_POST[$fieldName])) {
            $source = $_POST[$fieldName];
        } else {
            $source = $_GET[$fieldName];
        }
        foreach ($source as $imgUrl) {
            $item = new Uploader($imgUrl, $config, "remote");
            $info = $item->getFileInfo();
            array_push($list, array(
                "state" => $info["state"],
                "url" => $info["url"],
                "size" => $info["size"],
                "title" => htmlspecialchars($info["title"]),
                "original" => htmlspecialchars($info["original"]),
                "source" => htmlspecialchars($imgUrl)
            ));
        }

        /* 返回抓取数据 */
        return json_encode(array(
            'state' => count($list) ? 'SUCCESS' : 'ERROR',
            'list' => $list
        ));
    }

    /**
     * 遍历获取目录下的指定类型的文件
     * @param $path
     * @param $allowFiles
     * @param array $files
     * @return array|null
     */
    protected function getfiles($path, $allowFiles, &$files = array()) {
        if (!is_dir($path)) return null;
        if (substr($path, strlen($path) - 1) != '/') $path .= '/';
        $handle = opendir($path);
        while (false !== ($file = readdir($handle))) {
            if ($file != '.' && $file != '..') {
                $path2 = $path . $file;
                if (is_dir($path2)) {
                    $this->getfiles($path2, $allowFiles, $files);
                } else {
                    if (preg_match("/\.(" . $allowFiles . ")$/i", $file)) {
                        $files[] = array(
                            'url' => substr($path2, strlen($_SERVER['DOCUMENT_ROOT'])),
                            'mtime' => filemtime($path2)
                        );
                    }
                }
            }
        }
        return $files;
    }
}