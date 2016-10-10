/**
 * 企业、网站新闻 Created by jren on 2015/11/12.
 */
var news_ctl = {
    isLoading : false,
    /**
     * 加载热门新闻列表
     * */
    hotNewsList : function(obj_id){
        var self = this;
        $("#hot_news").loading(true);
        $.ajax({
            type : "POST",
            data:{
                obj_id : obj_id
            },
            url : '<?= yii::$app->urlManager->createUrl("enterprise/news/hot-list");?>',
            dataType : "json",
            success: function(json){
                $("#hot_news").loading(false);
                var html = "";
                $.each(json.list,function(index, element){
                    html += self.loadHotNewsHtml(element);
                });
                $("#hot_news").html(html);
            }
        });
    },
    /**
     * 加载单个HTML
     * */
    loadHotNewsHtml : function(model){
        var html = '<li>\
                        <a target="_blank" href="<?= yii::$app->urlManager->createUrl("enterprise-news-'+ model.id +'");?>">\
                            <i class="news-list-icon"></i>\
                            ' + model.title + '\
                        </a>\
                    </li>';
        return html;
    },
    /**
     * 新增新闻
    * */
    addNews : function(obj_id, title, content){
        title = $.trim(title);
        if (title == '') {
            alert("请输入动态标题");
            return false;
        }
        if (title.length > 20) {
            alert("标题最长20位");
            return false;
        }
        var self = this;
        if(!self.isLoading) {
            self.isLoading = true;
            $("#save_description_btn").attr("disabled", true);
            $.ajax({
                type: "POST",
                data: {
                    obj_id: obj_id,
                    title: title,
                    content: content
                },
                url: '<?= yii::$app->urlManager->createUrl("enterprise/news/create");?>',
                dataType: "json",
                success: function (json) {
                    if (json.result) {
                        location.href = "<?= yii::$app->urlManager->createUrl('/enterprise-news-"+ json.id +"');?>";
                    }
                    else{
                        self.isLoading = false;
                        $("#save_description_btn").attr("disabled", false);
                        alert(json.msg);
                    }

                }
            });
        }
    },
    /**
    * 修改新闻
    * */
    editNews : function(news_id, title, content){
        title = $.trim(title);
        if (title == '') {
            alert("请输入动态标题");
            return false;
        }
        if (title.length > 20) {
            alert("标题最长20位");
            return false;
        }
        var self = this;
        if(!self.isLoading) {
            self.isLoading = true;
            $("#save_description_btn").attr("disabled", true);
            $.ajax({
                type: "POST",
                data: {
                    id: news_id,
                    title: title,
                    content: content
                },
                url: '<?= yii::$app->urlManager->createUrl("enterprise/news/update");?>',
                dataType: "json",
                success: function (json) {
                    if (json.result) {
                        location.href = "<?= yii::$app->urlManager->createUrl('/enterprise-news-"+ news_id +"');?>";
                    }
                    else{
                        self.isLoading = false;
                        $("#save_description_btn").attr("disabled", false);
                        alert(json.msg);
                    }
                }
            });
        }
    },
    /**
    * 删除新闻
    * */
    removeNews : function(news_id){
        var self = this;
        if(!self.isLoading) {
            self.isLoading = true;
            $.ajax({
                type: "POST",
                data: {
                    id: news_id
                },
                url: '<?= yii::$app->urlManager->createUrl("enterprise/news/delete");?>',
                dataType: "json",
                success: function (json) {
                    self.isLoading = false;
                    $("#news_" + news_id).hide(200, function () {
                        $("#news_" + news_id).remove();
                    });
                    //alert(json.msg);
                }
            });
        }
    }
};