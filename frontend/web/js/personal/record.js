var record_ctl = {
    isLoading: false,
    page: 1,
    type: 1,
    username: "",
    /**
     * 初始化信息
     * */
    initCtl: function (page, type, username) {
        this.username = ( username || this.username );
        this.type = ( type || this.type );
        this.page = ( page || this.page );
    },
    /**
     * 获取交易记录
     */
    recordList: function () {
        var self = this;
        if (!self.isLoading) {
            self.isLoading = true;
            $("#record_list" + self.type).loading(true);
            $.ajax({
                type: "GET",
                data: {
                    username: self.username,
                    type: self.type,
                    page: self.page
                },
                url: '<?= yii::$app->urlManager->createUrl("enterprise/record/record-history");?>',
                dataType: "json",
                success: function (json) {
                    self.isLoading = false;
                    $("#record_list" + self.type).loading(false);
                    if (json.data == 0) {
                        self.page = self.page - 1;
                        return;
                    }
                    var html = "";
                    $.each(json.data.list, function (index, element) {
                        html += self.loadRecordHtml(element);
                    });
                    $("#record_list" + self.type).html(html);
                    var total_page = Math.ceil(parseInt(json.data.total_count) / parseInt("<?= yii::$app->params['record_general_page_size']?>"));
                    self.loadPageList(self.page, total_page);
                }
            });
        }
    },
    loadRecordHtml: function (model) {
        var cach = 0;
        var name = "";
        var name_href = "javascript:;";
        if (model.model_id == 3) {
            cach = model.single_cash;
        }
        else if (model.model_id == 13 || model.model_id == 14) {
            cach = model.real_cash;
        }
        else {
            cach = model.task_cash;
        }
        if (this.type == 1 && model.pub_username != undefined) {
            name = model.pub_username;
            name_href = "/talent/" + model.pub_uid;
        }
        else if (this.type == 2) {
            if (model.bid_username1 != undefined) {
                name = model.bid_username1;
                name_href = "/talent/" + model.bid_uid1;
            }
            else {
                name = model.bid_username;
                name_href = "/talent/" + model.bid_uid;
            }
        }
        var html = '<tr>\
                        <td class="f14"><a href="' + name_href + '">' + name + '</a></td>\
                        <td><a href="<?= yii::$app->params["record_url_h"]?>' + model.pub_task_id + '">' + model.task_title + '</a></td>\
                        <td>' + model.model_name + '</td>\
                        <td><span class="color-orange">' + cach + '</span></td>\
                        <td class="color-gray">' + unix_to_datetime(model.sub_time) + '</td>\
                    </tr>';
        return html;
    },
    /**
     * 加载列表分页信息
     * */
    loadPageList: function (current, count) {
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
        $(".pagelist .normal-page").click(function () {
            var data_page = $(this).attr("data-page");
            self.page = data_page;
            self.recordList();
        });
        $(".pagelist .to-page").click(function () {
            var data_page = $(".pagelist .to-page-value").val();
            self.page = data_page;
            self.recordList();
        });
    }
};
function unix_to_datetime(unix) {
    var now = new Date(parseInt(unix) * 1000);
    return now.toLocaleDateString().replace(/年|月|\//g, "-").replace(/日/g, " ");
}