<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

?>
<!DOCTYPE HTML>
<html>
<head>
    <title>VSO通用后台登录</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <script src="http://static.vsochina.com/libs/respond/1.4.2/respond.min.js"></script>
    <?= Html::cssFile('@web/css/bootstrap.css') ?>
</head>
<body>
<style>
    body {
        background: #009A61
    }

    .login {
        background: #fff;
        padding: 3em;
        margin-top: 10em;
        border-radius: 0.5em;
    }

    label {
        display: none;
    }

    .mr20 {
        margin-right: 20px;
    }

    h3 {
        font-family: "microsoft yahei", "黑体"
    }
    .col-md-4{
        width: 400px;
    }
</style>
<div class="container">
    <div class="row">
        <div class="col-md-4 sm col-sm-1"></div>
        <div class="col-md-4 sm col-sm-1 login">
            <h3><p><span class='glyphicon glyphicon-user'></span>&nbsp;积分商城管理后台</p></h3>
            <?php $form = ActiveForm::begin(
                [
                    'id' => 'login',
                    'enableAjaxValidation' => false,
                    'options' => ['enctype' => 'multipart/form-data']
                ]
            ); ?>

            <?= $form->field($model, 'username')->textInput(["placeholder" => "用户名"]); ?>
            <?= $form->field($model, 'password')->passwordInput(['placeholder' => '密码']); ?>
            
            <?= Html::submitButton('登录', ['class' => 'btn btn-primary btn-lg btn-block', 'name' => 'submit-button']) ?>
            <?php ActiveForm::end(); ?>
        </div>
        <div class="col-md-4 sm col-sm-1"></div>
    </div>
</div>
</body>
</html>

