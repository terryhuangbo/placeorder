<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Alert;
use yii\widgets\LinkPager;

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

            //查看信息
            $(".msgshow").click(function () {
                var href = $(this).attr('href');
                $("#myModal").attr('url', href);
                $('#myModal').modal('show');
                return false;
            });
            //确定按钮
            $(".sure").click(function () {
                var href = "http://" + window.location.host + $("#myModal").attr('url');
                // alert(href);
                $('#myModal').modal('hide');
                window.location.href = href;
            })
            //预览
            $(".review").click(function () {
                var href = "http://" + window.location.host + $(this).attr('href');
                $(".frame").attr('src', href);
                $("#review").modal('show');
                return false;
            })
        })
    </script>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <form class="navbar-form navbar-left" role="search" method="get" action="<?= Yii::$app->urlManager->createUrl(['team/team/list']) ?>">
                <div class="form-group">
                    <input type="text" class="form-control" value="<?=$searchKey?>" placeholder="显示名称，账号" name="key" size="100">
                </div>
                <button type="submit" class="btn btn-default">查找</button>
            </form>
            <div class="main">
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
                <table class="table table-hover">
                    <tr>
                        <th>序号</th>
                        <th>成员名称</th>
                        <th>成员昵称</th>
                        <th>成员角色</th>
                        <th>成员邮箱</th>
                        <th>成员操作</th>
                    </tr>
                    <?php if (count($users) > 0): ?>
                        <?php foreach ($users as $k => $v): ?>
                            <tr>
                                <td><?= $k ?></td>
                                <td><a href="<?= Yii::$app->urlManager->createUrl(['team/team/review', 'id' => $v->uid]) ?>" class="btn btn-group review"><?= $v->username ?></a></td>
                                <td><?= $v->nickname ?></td>
                                <td><?= isset($rolearr[$v->role_id]) ? $rolearr[$v->role_id] : first($rolearr) ?></td>
                                <td><?= $v->email ?></td>
                                <td>
                                    <a class="btn btn-sm btn-success" href="<?= Yii::$app->urlManager->createUrl(['team/team/update', 'id' => $v->uid]) ?>">编辑</a>
                                    <a class="btn btn-sm btn-danger msgshow" href="<?= Yii::$app->urlManager->createUrl(['team/team/del', 'id' => $v->uid]) ?>">删除</a>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5">暂无记录！</td>
                        </tr>
                    <?php endif ?>
                </table>
                <div class="page">
                    <?= LinkPager::widget(['pagination' => $page]) ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" url='' tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">消息提示</h4>
            </div>
            <div class="modal-body">
                <p class='text-info'>

                <h3>一旦删除，资料也将被删除，如果你想禁用，可以修改密码，继续删除请点确认</h3>
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary sure">确定</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->

<!-- Modal iframe-->
<div class="modal fade" id="review" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">成员预览</h4>
            </div>
            <div class="modal-body">
                <iframe class="frame" src="" style="width: 100%;height: auto;overflow: auto;border: none"/>
            </div>
            <!--            <div class="modal-footer">-->
            <!--                <button type="button" class="btn btn-primary sure">确定</button>-->
            <!--                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>-->
            <!--            </div>-->
        </div>
    </div>
</div>
<!-- Modal -->

</body>
</html>