<?php
namespace backend\modules\common\controllers;

use Yii;
use common\lib\Upload;
use app\base\BaseController;

/**
 * Upload controller
 */
class FileController extends BaseController
{
    /**
     * 路由权限控制
     * @return array
     */
    public function limitActions()
    {
        return [];
    }

    /**
     * 上传文件
     * @return array
     */
    public function actionUpload() {
        $objtype = trim($this->req('objtype', 'pictures', true));
        $up_mdl = new Upload();

        $ret = $up_mdl->upload(yiiParams('img_save_dir'), $objtype);
        if ($ret['code'] > 0) {
            return $this->toJson(20000, $ret['msg'], $ret['data']);
        } else {
            return $this->toJson(-20000, $ret['msg']);
        }
    }

    /**
     * 删除文件
     * @return array
     */
    public function actionDelete() {
        $file_path = $this->req('filepath');
        if(empty($file_path)){
            return $this->toJson(-20001, '文件路径不能为空');
        }
        $file_dir = $_SERVER['DOCUMENT_ROOT'] . $file_path;
        $file_dir = str_replace('/', '\\', $file_dir);
        if(!file_exists($file_dir)){
            return $this->toJson(20001, '文件不存在');
        }
        //删除文件
        $result = @unlink($file_dir);
        if($result == false){
            return $this->toJson(-20002, '文件删除失败！');
        }
        return $this->toJson(20000, '删除成功！');
    }

}
