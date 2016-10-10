<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Alert;

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <?= Html::cssFile('@web/css/bootstrap.min.css') ?>
    <?= Html::cssFile('@web/css/site.css') ?>
    <?= Html::jsFile('@web/Js/jquery.js') ?>
    <?= Html::jsFile('@web/Js/bootstrap.js') ?>
    <script>
        $(function () {
            ckinfo();
            //检查信息框
            function ckinfo() {
                var len = $(".text").length;
                if (len) {
                    fadeInfo();
                }
            }

            //消息消失动画
            function fadeInfo() {
                setTimeout(function () {
                    //alert('消息框即将消失！');
                    $(".text").fadeOut(800);
                }, 1000)
            }
        })
    </script>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="main">
                <h1>编辑成员</h1>
                <?php if (Yii::$app->session->hasFlash('success')): ?>
                    <div class="alert alert-success text">
                        <b><?= Yii::$app->session->getFlash('success') ?></b>
                    </div>
                <?php endif ?>
                <?php if (Yii::$app->session->hasFlash('error')): ?>
                    <div class="alert alert-error text">
                        <b><?= Yii::$app->session->getFlash('error') ?></b>
                    </div>
                <?php endif ?>

                <?php $form = ActiveForm::begin(['id' => 'teamupdate']); ?>
                <?= $form->field($model, 'username')->textInput(); ?>
                <?= $form->field($model, 'nickname')->textInput(); ?>
                <?= $form->field($model, 'email')->textInput(); ?>
                <?= $form->field($model, 'role_id')->dropDownList($rolearr); ?>
                <?= $form->field($model, 'password')->passwordInput(['placeholder' => '密码']); ?>
                <?= Html::submitButton('保存', ['class' => 'btn btn-primary']) ?>
                <?php ActiveForm::end() ?>
            </div>
        </div>
    </div>
</div>


</body>
</html>