/**
 * Created by jren on 2015/11/12.
 */
var template = {
    change_template : function(type){
        $.ajax({
            type : "GET",
            data:{ type : type},
            url : '<?= yii::$app->urlManager->createUrl("personal/template/change-template");?>',
            dataType : "json",
            success: function(json){
                if(json.ret = 200){
                    $("#main").html(json.html);
                }
            }
        });
    }
};