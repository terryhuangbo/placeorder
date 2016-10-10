<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Alert;
error_reporting(E_ERROR);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>添加角色</title>
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

        function checkAll(obj,boxid){
            $("#"+boxid+" input[type='checkbox']").prop('checked', $(obj).prop('checked'));
        }

    </script>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="main">
                <h1>添加角色</h1>
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

                <?php $form = ActiveForm::begin(['id' => 'add']); ?>
                <?= $form->field($model, 'role')->textInput(); ?>
                <?= $form->field($model, 'desc')->textInput(); ?>
                <?php foreach ($privilegeGroup as $grouptype => $groupname): ?>
                    <h1> <input type="checkbox" value="<?= $grouptype ?>" name="RoleForm[prilistgroup][]" onclick="checkAll(this,'box_<?= $grouptype ?>')" id="group_<?= $grouptype ?>"> <?= $groupname ?></h1>
                <div class="checkbox" style="padding: 0px 20px" id="box_<?= $grouptype ?>">
                    <?php foreach ($prilist[$grouptype] as $id => $desc): ?>
                        <label style="width: 250px"><input type="checkbox" value="<?= $id ?>" name="RoleForm[prilist][]"> <?= $desc ?></label>
                    <?php endforeach ?>
                    </div>
                <?php endforeach ?>

                <?= Html::submitButton('添加', ['class' => 'btn btn-primary']) ?>
                <?php ActiveForm::end() ?>
            </div>
        </div>
    </div>
</div>


</body>
</html>