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
            //消息消失动画
            function fadeInfo() {
                setTimeout(function () {
                    $(".text").fadeOut(800);
                }, 1000)
            }
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
                <div class="tool">
                    <a class="btn btn-primary btn-sm "
                       href="<?= Yii::$app->urlManager->createUrl('team/role/add') ?>">添加角色</a>
                </div>
                <table class="table table-hover">
                    <tr>
                        <th>序号</th>
                        <th>角色名称</th>
                        <th>角色描述</th>
                        <th>角色操作</th>
                    </tr>
                    <?php if (count($roles) > 0): ?>
                        <?php foreach ($roles as $k => $v): ?>
                            <tr>
                                <td><?= $v->id ?></td>
                                <td><a href="<?= Yii::$app->urlManager->createUrl(['team/role/review', 'id' => $v->id]) ?>" class="btn btn-group review"><?= $v->role ?></a></td>
                                <td><?= $v->desc ?></td>
                                <td>
                                    <a class="btn btn-sm btn-success" href="<?= Yii::$app->urlManager->createUrl(['team/role/update', 'id' => $v->id]) ?>">编辑</a>
                                    <a class="btn btn-sm btn-danger msgshow" href="<?= Yii::$app->urlManager->createUrl(['team/role/del', 'id' => $v->id]) ?>">删除</a>
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

                <h3>确认要删除该记录吗？一旦删除后信息将无法恢复！</h3>
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
                <h4 class="modal-title" id="myModalLabel">角色预览</h4>
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