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
    <title>编辑角色</title>
    <?= Html::cssFile('@web/css/bootstrap.min.css') ?>
    <?= Html::cssFile('@web/css/site.css') ?>
    <?= Html::jsFile('@web/Js/jquery.js') ?>
    <?= Html::jsFile('@web/Js/bootstrap.js') ?>
    <script>
        $(function () {
            ckinfo();
            prilist();
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
                    $(".text").fadeOut(800);
                    window.location.href="<?php echo Yii::$app->urlManager->createUrl(['team/role/list']);?>";
                }, 1000)
            }

        })
        function checkAll(obj,boxid){
            $("#"+boxid+" input[type='checkbox']").prop('checked', $(obj).prop('checked'));
        }
    </script>
</head>
<style>
    .field-roleform-id {
        display: none
    }
</style>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="main">
                <h1>编辑角色</h1>
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
                <?= $form->field($model, 'id')->HiddenInput(); ?>
                <?= $form->field($model, 'role')->textInput(); ?>
                <?= $form->field($model, 'desc')->textInput(); ?>
                <?php foreach ($privilegeGroup as $grouptype => $groupname): ?>
                    <h1> <input type="checkbox" value="<?= $grouptype ?>" name="RoleForm[prilistgroup][]" onclick="checkAll(this,'box_<?= $grouptype ?>')" id="group_<?= $grouptype ?>"> <?= $groupname ?></h1>
                    <div class="checkbox" style="padding: 0px 20px" id="box_<?= $grouptype ?>">
                        <?php foreach ($prilist[$grouptype] as $item): ?>
                            <label style="width: 250px;<?= $item['css'] ?>"><input type="checkbox" value="<?= $item['id'] ?>" name="RoleForm[prilist][]" <?= $item['chk'] ?>> <?= $item['desc'] ?></label>
                        <?php endforeach ?>
                    </div>
                <?php endforeach ?>
                <?= Html::submitButton('保存编辑', ['class' => 'btn btn-primary']) ?>
                <?php ActiveForm::end() ?>
            </div>
        </div>
    </div>
</div>


</body>
</html>