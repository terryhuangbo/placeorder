<?php

/**
 * @link https://github.com/BigKuCha/yii2-ueditor-widget
 * @link http://ueditor.baidu.com/website/index.html
 */
namespace common\widgets\ueditor;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\InputWidget;

class UEditor extends InputWidget
{
    //配置选项，参阅Ueditor官网文档(定制菜单等)
    public $clientOptions = [];
    //数组形式的输入框属性
    public $inputOptions = [];

    //默认配置
    protected $_options;

    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        $this->id = $this->hasModel() ? Html::getInputId($this->model, $this->attribute) : $this->id;
        $this->_options = [
            'serverUrl' => Url::to(['upload']),
            'initialFrameWidth' => '100%',
            'initialFrameHeight' => '400',
            'lang' => (strtolower(Yii::$app->language) == 'en-us') ? 'en' : 'zh-cn',
        ];
        $this->clientOptions = ArrayHelper::merge($this->_options, $this->clientOptions);
        parent::init();
    }

    public function run()
    {
        $this->inputOptions = array_merge($this->inputOptions, ['id' => $this->id]);
        $this->registerClientScript();
        if ($this->hasModel()) {
            return Html::activeTextarea($this->model, $this->attribute, $this->inputOptions);
        } else {
            return Html::textarea($this->id, $this->value, $this->inputOptions);
        }
    }

    /**
     * 注册客户端脚本
     */
    protected function registerClientScript()
    {
        UEditorAsset::register($this->view);
        lg($this->view);

        $clientOptions = Json::encode($this->clientOptions);
        $script = "UE.getEditor('" . $this->id . "', " . $clientOptions . ")";
        $this->view->registerJs($script, View::POS_READY);
    }
}