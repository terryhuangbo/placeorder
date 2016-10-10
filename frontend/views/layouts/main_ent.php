<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use frontend\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<?php if(!isMobile())require_once(Yii::getAlias('@frontend') . '/views/rc/e_header.php')?>
<!--header-->
<?php if(!isMobile())require_once(Yii::getAlias('@frontend') . '/views/rc/index_header.php')?>
<!--/header-->
<?php $this->beginBody() ?>

<?= Breadcrumbs::widget([
    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
]) ?>
<?= Alert::widget() ?>
<?= $content ?>

<?php $this->endBody() ?>

<?php require_once(Yii::getAlias('@frontend') . '/views/rc/index_footer.php')?>