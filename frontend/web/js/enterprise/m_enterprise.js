/**
* 企业案例js方法 rj
* */
var ment_ctl = {
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
            url : '/enterprise/work/case-list',
            dataType : "json",
            success: function(json){
                $("#main-case-list").loading(false);
                var html = "";
                $.each(json.list,function(index, element){
                    html += self.loadCaseHtml(element);
                });
                var _list = $(".part-caseshow-list");
                _list.html(html);
                _MAXPAGE = json.totalCount;
                var wid = _list.width() / 2 - 10,
                    ratio = 386 / 220;
                cutImg(_list, wid, ratio);
            }
        })
    },
    /**
     * 加载列表单个html
     * */
    loadCaseHtml : function(model){
        var pTypeName = $("#ptype_" + model.ptype).val();
        var html = '<li class="col-xs-6">\
                        <a href="' +_WORKDETAIL_URL + '/'+ model.id + '">\
                        <div class="caseshow-imgbox"><img src="' + model.work_url + '"></div>\
                            <p class="me-list-name">' + model.work_name + '</p>\
                            <p class="me-list-price">参考价格：<span class="me-list-num">&yen;' + model.work_price + '</span></p>\
                        </a>\
                    </li>';
        return html;
    }

};

function cutImg(_list, wid, ratio){
    var _li = _list.find("li"),
        _img = _li.find("img"),
        _el,
        w,
        h,
        r,
        lh = parseInt(wid / ratio);
    _li.css('height', lh + 75 + 'px');
    $('.caseshow-imgbox').outerHeight(lh);
    _img.each(function(index, el) {
        _el = $(el);
        _el.load(function() {
            h = _el.outerHeight();
            r = wid / h;
            if(r > ratio)
            {
                h = lh;
                w = parseInt(h * r);
            }
            _el.css({
                'width': w + 'px',
                'height': h + 'px'
            });
        });
    });
}