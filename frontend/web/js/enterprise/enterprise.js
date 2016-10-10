/**
* 企业案例js方法 rj
* */
var ent_ctl = {
    isLoading : false,
    type : 0,
    username : "",
    page : 1,
    /**
     * 加载列表
     * */
    getList : function(){
        var self = this;

        $(".ins_type").removeClass("active");
        $("#type_" + self.type).addClass("active");

        $("#main-case-list").loading(true);
        $.ajax({
            type : "POST",
            data:{
                username : self.username,
                type : self.type,
                page : self.page
            },
            url : '<?= yii::$app->urlManager->createUrl("enterprise/work/case-list");?>',
            dataType : "json",
            success: function(json){
                $("#main-case-list").loading(false);
                var html = "";
                $.each(json.list,function(index, element){
                    html += self.loadCaseHtml(element);
                });
                $("#main-case-list").html(html);
                self.loadPageList(self.page, json.totalCount);
            }
        })
    },
    /**
     * 加载列表单个html
     * */
    loadCaseHtml : function(model){
        var pTypeName = $("#ptype_" + model.ptype).val();
        var is_self = "<?= $this->context->is_self;?>";
        var edit_html = '';
        var del_span_html = '';
        if (is_self) {
            edit_html = '<a href="<?= yii::$app->urlManager->createUrl("enterprise-work-update?id='+ model.id +'");?>">\
                            <div class="hotcase-set">\
                                <span class="hotcase-set-bg"></span>\
                                <span class="glyphicon glyphicon-cog"></span>\
                            </div>\
                        </a>';
            del_span_html = '<span class="glyphicon glyphicon-trash pull-right" onclick="confirmDeleteWork(' + model.id + ')"></span>';
        }
        var html = '<li>\
                        <div class="hotcase-list-img">\
                            <a target="_blank" href="<?= yii::$app->urlManager->createUrl("enterprise-work-'+ model.id +'");?>">\
                                <img src="' + model.work_url + '">\
                            </a>' + edit_html + '\
                        </div>\
                        <div class="hotcase-list-desc">\
                            <p class="hotcase-list-name"><a href="javascript:void(0);" class="hotcase-list-tag" data-type="'+ model.ptype +'">' + pTypeName + '</a> <a target="_blank" href="<?= yii::$app->urlManager->createUrl("enterprise-work-'+ model.id +'");?>" title="' + model.work_name + '">' + model.work_name + '</a></p>\
                            <p class="hotcase-list-price">类似服务价格：<span class="case-pricenum" title="' + model.work_price + '">¥ ' + model.work_price + ' </span>起 ' + del_span_html + '</p>\
                        </div>\
                    </li>';
        return html;
    },
    /**
     * 加载列表分页信息
     * */
    loadPageList : function(current, count) {
        var self = this;
        var html = '';

        html += '<ul class="items">';
        //判断是否是第一页
        current = parseInt(current);
        if (current == 1 || count == 0) {
            html += '<li class="item prev disabled">\
                              <span class="num">\
                                  <span class="glyphicon glyphicon-menu-left"></span>\
                                  <span>上一页</span>\
                              </span>\
                          </li>';
        }
        else {
            html += '<li class="item prev">\
                              <a class="num normal-page" data-page="' + (current - 1) + '">\
                                  <span class="glyphicon glyphicon-menu-left"></span>\
                                  <span>上一页</span>\
                              </a>\
                          </li>';
        }
        var start = 1;
        var end = count;
        if (count > 10) {
            if (current <= 5) {
                end = 10;
            }
            else if ((current + 5) <= count) {
                start = current - 4;
                end = current + 5;
            }
            else {
                start = count - 9;
                end = count;
            }
        }

        for (var i = start; i < end + 1; i++) {
            html += '<li class="item';
            if (i == current) {
                html += ' active ';
            }
            html += '"><span class="num normal-page" data-page="' + i + '" >' + i + '</span></li>';

        }

        //判断是否是最后页
        if (current == count || count == 0) {
            html += '<li class="item next disabled">\
                          <span class="num">\
                              <span>下一页</span>\
                              <span class="glyphicon glyphicon-menu-right"></span>\
                          </span>\
                      </li>';
        }
        else {
            html += '<li class="item next">\
                          <a class="num normal-page" data-page="' + (current + 1) + '" >\
                              <span>下一页</span>\
                              <span class="glyphicon glyphicon-menu-right"></span>\
                          </a>\
                      </li>'
        }

        html += '</ul>';
        html += '<div class="total">共 ' + count + ' 页</div>';

        html += '<div class="form">\
        <span class="text">到第</span>\
            <!--<input class="input" type="number" value="2" min="1" max="100" >-->\
        <input class="input to-page-value" type="text" value="' + current + '">\
        <span class="text">页</span>\
        <span class="btn to-page" role="button" tabindex="0">确定</span>\
        </div>';

        $(".pagelist").html(html)

        $(".pagelist .normal-page").click(function(){
            var data_page = $(this).attr("data-page");
            self.page = data_page;
            self.getList();
        });
        $(".pagelist .to-page").click(function(){
            var data_page = $(".pagelist .to-page-value").val();
            self.page = data_page;
            self.getList();
        });
    },
    /**
     * 点赞
     * */
    zan : function(id){
        $.ajax({
            type : "POST",
            data:{ id : id},
            url : '<?= yii::$app->urlManager->createUrl("enterprise/work/zan");?>',
            dataType : "json",
            success: function(json){
                if(json.result){
                    $("#zan").val("攒(" + json.zan + ")");
                }
            }
        });

    },
    editDesc : function(id, description){
        var self = this;
        if(!self.isLoading) {
            self.isLoading = true;
            $("#save_description_btn").attr("disabled", true);
            $.ajax({
                type: "POST",
                data: {id: id, description: description},
                url: '<?= yii::$app->urlManager->createUrl("enterprise/default/edit-company");?>',
                dataType: "json",
                success: function (json) {
                    if (json.result) {
                        var desc = json.data.description || "";
                        if(desc == ""){
                            $("#edit_description_btn").html(" + 新增简介");
                        }
                        else{
                            $("#edit_description_btn").html(" - 编辑简介");
                        }
                        $("#save_description_btn").attr("disabled", false);
                        $("#edit_description_txt_show").html(desc);
                        umCompanyDesc.setContent(desc);
                        $(".edui-editor").slideUp(200, function () {
                            umCompanyDesc.setHide();
                            $("#edit_description_txt_show").show();
                            self.isLoading = false;
                        });
                        $(".edit-enterprise-btn-group").fadeOut(200, function () {
                            $("#edit_description_btn").fadeIn(100);
                        });
                    }
                    else{
                        alert(json.msg);
                        self.isLoading = false;
                        $("#save_description_btn").attr("disabled", false);
                    }
                }
            });
            $("#edit_description_txt").show();
        }
    },
    /**
     * 加载热门案例列表
     * */
    hotCaseList : function(username){
        var self = this;
        $("#hot_cases").loading(true);
        $.ajax({
            type : "POST",
            data:{
                username : username
            },
            url : '<?= yii::$app->urlManager->createUrl("enterprise/work/hot-list");?>',
            dataType : "json",
            success: function(json){
                $("#hot_cases").loading(false);
                var html = "";
                $.each(json.list,function(index, element){
                    html += self.loadHotCaseHtml(element);
                });
                $("#hot_cases").html(html);
            }
        })
    },
    /**
    * 加载单个HTML
    * */
    loadHotCaseHtml : function(model){
        var html = '<li>\
                        <div class="hotcase-list-img">\
                            <a target="_blank" href="<?= yii::$app->urlManager->createUrl("enterprise-work-'+ model.id +'");?>">\
                               <img src="' + model.work_url + '">\
                            </a>\
                        </div>\
                        <div class="hotcase-list-desc">\
                            <p class="hotcase-list-name"><a target="_blank" href="<?= yii::$app->urlManager->createUrl("enterprise-work-'+ model.id +'");?>">' + model.work_name + '</a></p>\
                            <p class="hotcase-list-price">类似服务价格：<span class="case-pricenum">&yen;' + model.work_price + '</span>起</p>\
                        </div>\
                    </li>';
        return html;
    },
    /**
    * 新增案例
    * */
    addCase : function (model){

    },
    /**
     * 修改案例
     * */
    editCase : function (model){

    },
    /**
    * 删除案例
    * */
    removeCase : function(id){
        $.ajax({
            type: "POST",
            data: {id: id, obj_username: self.username},
            url: '<?= yii::$app->urlManager->createUrl("enterprise/work/delete");?>',
            dataType: "json",
            success: function (json) {
                if (json.result) {
                    ent_ctl.getList();
                }
                else {
                }
            }
        });
    },
    /**
    * 修改企业基础设置
    * */
    updateEnterprise : function(){

    }

};

