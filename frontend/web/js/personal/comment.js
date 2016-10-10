var comment = {
    //平台注册id
    username: null,
    //对象id，例如商品id，服务id等
    obj_id: null,
    //评论父id 0-为新增一级评论，否则为添加二级评论
    p_id: 0,
    //对象名称
    obj_name: null,
    //当前登录用户username
    vso_uname: false,
    //用户昵称
    user_nick: null,
    //评论分类,商品评论，服务评论等
    type: 1,
    //评论页数
    page: 1,
    //每页数量
    pageSize: 10,
    //总页数
    totalPage: 0,
    //是否登录
    is_login: false,
    //是否是用户自己
    is_self: false,
    //点赞功能开关
    switch_praise: true,
    //收藏功能开关
    switch_collect: true,
    //评论功能开关
    switch_comment: true,
    //异步收藏功能url
    alter_collect_url: null,
    //异步点赞功能url
    alter_praise_url: null,
    //添加评论url
    add_comment_url: null,
    //删除评论url
    del_comment_url: null,
    //加载评论url
    load_comments_url: null,

    //详情页入口，初始化
    init: function(){
        var self = this;
        self.initParam();
        self.bindEvt();
        self.shareWork();
    },

    //参数初始化
    initParam: function(){
        var self = this;

    },
    //绑定事件
    bindEvt: function(){
        //版权设置
        $(".upload-content-copyright .dropdown-menu li").on('click', function (event) {
            var _this = $(this),
                _obj = $(".upload-content-copyright .copyright-btn"),
                iconClass = _this.find('i').prop("className"),
                txt = _this.find('.copyright-desc').html();
            _this.addClass('copyright-selected').siblings().removeClass('copyright-selected');
            //                    _obj.addClass('copyright-dark').find('i').removeClass().addClass(iconClass).next('.copyright-desc').html(txt);
            _obj.addClass('copyright-dark').find('i').attr('class', '').addClass(iconClass).next('.copyright-desc').html(txt);
        });
        // 人气
        $(".w-popularity-btn").on('click', function(event) {
            stopPropagation(event);
            $(this).next(".w-popularity-down").toggle();
        });
        $(".w-popularity-down").on('click', function(event) {
            stopPropagation(event);
        });
        $(document).on('click', function(event) {
            $(".w-popularity-down").hide();
        });
        //分享
        $(document).on("mouseenter",".icon-share-box", function(event){
            var self = $(this);
            var top = self.offset().top ;
            var left = self.offset().left + 45;
            $(".sharework").css({"top":top+"px","left":left+"px"}).show();
        });
        $(document).on("mouseleave ",".icon-share-box", function(event){
            $(".sharework").hide();
        });
        $(document).on("mouseenter",".sharework",function(){
            $(this).show();
        });
        $(document).on("mouseleave",".sharework",function(){
            $(this).hide();
        });
    },
    //分享功能
    shareWork: function(){
        var self = this;
        var url = window.location.href;
        var username = self.username;
        var title = self.user_nick + "的商品";
        var desc = null;
        var pic = null;
        var objname = self.obj_name;
        var summary = "高大上！"+username+"的作品，来自蓝海创意云的创意商城。蓝海创意云-一个云端的创客空间";
        if(objname!=""){
            summary = "高大上！"+username+"的作品："+objname+"，来自蓝海创意云的创意商城。蓝海创意云-一个云端的创客空间";
        }
        share(url,title,pic,desc,summary,$(".sharework"));
    },
    //点赞功能
    addPraise: function(dom){
        var self = this;
        if(!self.switch_praise){
            return false;
        }
        if (! self.is_login) {
            alert("登录后才能进行此操作");
            return false;
        }
        var params = {};
        params.username = self.vso_uname;
        params.obj_id = self.obj_id;
        params.status = $(dom).hasClass("on") ? 0 : 1;
        params.type = self.type;
        self.switch_praise = false;
        $.ajax({
            type: 'POST',
            url: self.alter_praise_url,
            data: params,
            dataType: 'JSON',
            success: function(json){
                if(json.result){
                    $(dom).toggleClass("on");
                    self.switch_praise = true;
                    //更新状态
                    var fire = parseInt($("#fire_num").text());
                    params.status ? $("#fire_num").text(fire+1) : $("#fire_num").text(fire-1);
                    var like = parseInt($("#like_num").text());
                    params.status ? $("#like_num").text(like+1) : $("#like_num").text(like-1);
                }

            },
            fail: function(json){}
        });
    },
    //收藏功能
    addCollect: function(dom){
        var self = this;
        if(!self.switch_collect){
            return false;
        }
        if (! self.is_login) {
            alert("登录后才能进行此操作");
            return false;
        }
        var params = {};
        params.username = self.vso_uname;
        params.obj_id = self.obj_id;
        params.status = $(dom).hasClass("active") ? 0 : 1;
        params.type = self.type;
        self.switch_collect = false;

        $.ajax({
            type: 'POST',
            url: self.alter_collect_url,
            data: params,
            dataType: 'JSON',
            success: function(json){
                if(json.result){
                    $(dom).toggleClass("active");
                    self.switch_collect = true;
                    //更新状态
                    var fire = parseInt($("#fire_num").text());
                    params.status ? $("#fire_num").text(fire+1) : $("#fire_num").text(fire-1);
                    var collect = parseInt($("#collect_num").text());
                    params.status ? $("#collect_num").text(collect+1) : $("#collect_num").text(collect-1);
                    params.status ? alert('收藏成功') : null;

                }
            },
            fail: function(json){}
        });
    },
    //保存评论内容
    addComment: function(){
        var self = this;
        if(!self.switch_comment){
            return false;
        }
        if (! self.is_login) {
            alert("登录后才能进行此操作");
            return false;
        }
        var content = $.trim($("#content").val());
        if (content == '') {
            $(".color-red").show();
            $("#content").focus();
            return false;
        }else {
            $(this).removeAttr("disabled");
            $(".color-red").hide();
        }
        $("#create_comment").attr("disabled", true);

        var params = {};
        params.username = self.vso_uname;
        params.content = content;
        params.obj_id = self.obj_id;
        params.p_id = self.p_id;
        params.type = self.type;
        self.switch_comment = false;
        $.ajax({
            type: 'POST',
            url: self.add_comment_url,
            data: params,
            dataType: 'JSON',
            success: function(json){
                if(json.result){
                    alert('添加成功!');
                    var html = '';
                    self.switch_comment = true;
                    //清空评论输入框
                    $("#content").val('');
                    //置灰评论按钮
                    $("#create_comment").attr("disabled", false);
                    //隐藏提示
                    $("._comment_empty").hide();
                    if(self.p_id == 0) {//添加评论
                        //添加评论html
                        html = self.addCommentHtml(json.new_comment);
                        $(".w-remarklist").prepend(html);
                        //更新状态
                        var fire = parseInt($("#fire_num").text());
                        $("#fire_num").text(fire+1);
                        var comment = parseInt($("#comment_num").text());
                        $("#comment_num").text(comment+1);
                        $("span[name=count_comment]").text(comment+1);
                    }else{              //添加回复
                        html = self.addReplyHtml(json.new_comment);
                        $(".w-commentitem[comment_id="+ self.p_id +"]").after(html);
                    }
                }else{
                    alert('添加失败!');
                }
            },
            fail: function(json){alert('添加失败!');}
        });
    },
    //添加评论功能
    addReply: function(p_id, p_name){
        var self = this;
        //判断是否登录
        if (!self.is_login) {
            return false;
        }
        self.p_id = p_id;
        self.p_name = p_name;
        $("#content").val('');
        $("#content").focus();
    },
    //删除评论功能
    delComment: function(comment_id){
        var self = this;
        //判断是否登录
        if (!self.is_login) {
            return false;
        }
        //true-删除评论  false-删除回复
        var is_comment = $(".w-reply[comment_id="+ comment_id +"]").hasClass("del_reply") ?  false : true;
        var params = {};
        params.comment_id = comment_id;
        params.obj_id = self.obj_id;
        params.is_comment = is_comment ? 1 : 0;
        $.ajax({
            type: 'POST',
            url: self.del_comment_url,
            data: params,
            dataType: 'JSON',
            success: function(json){
                if(json.result){
                    alert('删除成功！');
                    if(is_comment){//删除评论和子评论
                        $(".w-commentitem[comment_id="+ comment_id +"]").remove();
                        $(".w-replyitem[comment_id="+ comment_id +"]").remove();
                        var total = parseInt($("span[name=count_comment]").text());
                        $("span[name=count_comment]").text(total-1);
                        //更新状态
                        var fire = parseInt($("#fire_num").text());
                        $("#fire_num").text(fire-1);
                        var comment = parseInt($("#comment_num").text());
                        $("#comment_num").text(comment-1);
                    }else{//删除子评论
                        $(".w-replyitem[comment_id="+ comment_id +"]").remove();
                        $(".w-reply[comment_id="+ comment_id +"]").remove();
                    }

                }else{
                    alert('删除失败！');
                }

            },
            fail: function(json){alert('删除失败！');}
        });
    },
    //添加评论html
    addCommentHtml: function(data){
        var self = this;
        var html = '';
        html +=
            '<li class="w-commentitem" comment_id="'+ data.id +'" username="'+ data.username +'">'+
            '    <a target="_blank" href="/talent/'+ data.username +'">'+
            '    <img src="'+ data.avatar +'" alt="'+ data.nickname +'">'+
            '    </a>';
        if(self.vso_uname != data.username){
        html +=
            '    <a href="javascript:;" class="w-reply del_comment" onclick="return comment.addReply('+ data.id +', '+ data.username +')" nickname="'+ data.nickname +'" comment_id="'+ data.id +'">回复</a>';
        }else{
        html +=
            '    <a href="javascript:;" class="w-reply del_comment" onclick="return comment.delComment('+ data.id +')" comment_id="1">删除</a>';
        }
        html +=
            '    <p class="w-remarkdetail">'+
            '        <a class="w-nickname" target="_blank" href="/talent/'+ data.username +'">'+ data.nickname +'</a>'+
            '        <span class="w-towords" comment_id="'+ data.id +'">'+ data.content +'</span>'+
            '    </p>'+
            '</li>';
        return html;
    },
    //添加回复html
    addReplyHtml: function(data, param){
        var self = this;
        var html = '';
        if( typeof(param) == "undefined" ){
            data.p_nick = $(".w-reply[comment_id="+ self.p_id +"]").attr("nickname");
            data.p_content = $(".w-towords[comment_id="+ self.p_id +"]").text();
        }
        html +=
            '<li class="w-replyitem" p_id="'+ data.p_id +'" comment_id="'+ data.id +'" username="'+ data.username +'"> '+
            '    <a href="javascript:;" class="w-reply del_reply" onclick="return comment.delComment('+ data.id +')" comment_id="'+ data.id +'">删除</a>'+
            '    <a target="_blank" href="/talent/'+ data.username +'">'+
            '    <img src="'+ data.avatar +'" alt="'+ data.nickname +'">'+
            '    </a>'+
            '    <div class="w-remarkdetail">'+
            '        <div class="w-replyto">'+
            '            <a target="_blank" href="/talent/'+ data.username +'" class="w-nickname">'+ data.nickname +'</a>'+
            '            <span>'+ data.diftime +'</span>'+
            '            <p>回复'+
            '                <a target="_blank" href="/talent/'+ data.p_uname +'" class="w-replyname">'+ data.p_nick +'</a>：'+
            '                <span>'+ data.p_content +'</span>'+
            '            </p>'+
            '        </div>'+
            '        <span class="w-replycontent w-towords">'+ data.content +'</span>'+
            '    </div>'+
            '</li>';
        return html;
    },
    //加载评论
    loadComments: function(dom){
        var self = this;
        var total = parseInt($("span[name=count_comment]").text());
        var html = '';
        var params = {};
        params.page = self.page = self.page + 1;
        params.obj_id = self.obj_id;
        $.ajax({
            type: 'POST',
            url: self.load_comments_url,
            data: params,
            dataType: 'JSON',
            success: function(json){
                if(json.result){
                    $("#_show_more_comment").attr("_now_page", self.page);
                    //加载html
                    var comments = json.comments;
                    var totalNum = json.totalNum;
                    $.each(comments, function(i, comment){
                        var subcomments = comment.subComments;
                        html += self.addCommentHtml(comment);
                        $.each(subcomments, function(j, subcomment){
                            subcomment.p_nick = comment.nickname;
                            subcomment.p_content = comment.content;
                            html += self.addReplyHtml(subcomment, true);
                        });
                    });
                    $(".w-remarklist").append(html);
                    if(self.page * self.pageSize > totalNum){
                        $("#_show_more_comment").hide();
                    }
                }else{}
            },
            fail: function(json){}
        });
    },


}