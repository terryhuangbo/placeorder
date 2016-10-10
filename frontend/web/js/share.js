
var  linkWeixin ="";
     function share(url,title,pic,desc,summary,obj){
        var linkQQ = "http://connect.qq.com/widget/shareqq/index.html";
        var linkQzone = "http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey";
        var linkTsina = "http://service.weibo.com/share/share.php";

        if(url !=null){
            linkQQ = linkQQ+"?url="+url,
            linkQzone = linkQzone+"?url="+url,
            linkWeixin = url;

            if (url.indexOf("#") > 0)
            {
                url = url.substr(0, url.indexOf("#"));
            }
            linkTsina = linkTsina+"?url="+url;
        }

        if(title !=null){
            linkQQ = linkQQ+"&title="+title
            linkQzone = linkQzone+"&title="+title
            //linkTsina = linkTsina+"&title="+title+desc
        }

        if(desc !=null){
            linkQQ = linkQQ+"&desc="+desc
            linkQzone = linkQzone+"&desc="+desc
            //linkTsina = linkTsina+"&desc="+desc
        }

        if(pic !=null){
            linkQQ = linkQQ+"&pics="+pic
            linkQzone = linkQzone+"&pics="+pic
            linkTsina = linkTsina+"&pics="+pic
        }

        if(summary !=null){
            linkQQ = linkQQ+"&summary="+summary
            linkQzone = linkQzone+"&summary="+summary
            linkTsina = linkTsina+"&title="+summary
        }

         obj.find("[data-cmd = 'qq']").attr("href",linkQQ).attr("target","_blank");
         obj.find("[data-cmd = 'qzone']").attr("href",linkQzone).attr("target","_blank");
         obj.find("[data-cmd = 'tsina']").attr("href",linkTsina).attr("target","_blank");

         obj.find("[data-cmd = 'weixin']").find(".weixin-box .weixin-box-img").html("");

        

         if (navigator.userAgent.indexOf('MSIE') > 0) {
                    var DEFAULT_VERSION = "8.0";
                    var ua = navigator.userAgent.toLowerCase();
                    var version = ua.match(/msie ([\d+.]+)/) ? ua.match(/msie ([\d+.]+)/)[1] : false;
                    if (version && parseInt(version) <= parseInt(DEFAULT_VERSION)) {
                    /*
                        $.ajax({
                            type: "GET",
                            dataType: "json",
                            data: {url: linkWeixin},
                            contentType: "application/x-www-form-urlencoded",
                            url: '/project/project/get-project-qr',
                            success: function(json) {
                                if (json.ret == 200)
                                {
                                    obj.find("[data-cmd = 'weixin']").find(".weixin-box .weixin-box-img").append("<img src='"+json.msg+"' style='width:256px;' />");
                                }
                            }
                        });
                        */
                        obj.find("[data-cmd = 'weixin']").find(".weixin-box .weixin-box-img").html("你的浏览器版本过低，无法预览二维码");
                        return false;
                    }
                }else{
                      obj.find("[data-cmd = 'weixin']").find(".weixin-box .weixin-box-img").qrcode({"width":150,"height":150,"text":linkWeixin});
                     
                }
    }


    $(".vsoShare a").on("click",function () {

        var VsoShareStyle = $(this).attr("data-cmd");
        switch(VsoShareStyle)
        {
        case "qq":
            break;
        case "qzone":
            break;
        case "tqq":
            break;
        case "tsina":
            break;
        case "weixin":
            $('.output').html("");
             
            $(".bd_weixin_popup").show()

           
            if (navigator.userAgent.indexOf('MSIE') > 0) {
                    var DEFAULT_VERSION = "8.0";
                    var ua = navigator.userAgent.toLowerCase();
                    var version = ua.match(/msie ([\d+.]+)/) ? ua.match(/msie ([\d+.]+)/)[1] : false;
                    if (version && parseInt(version) <= parseInt(DEFAULT_VERSION)) {
                    /*
                        $.ajax({
                            type: "GET",
                            dataType: "json",
                            data: {url: linkWeixin},
                            contentType: "application/x-www-form-urlencoded",
                            url: '/project/project/get-project-qr',
                            success: function(json) {
                                if (json.ret == 200)
                                {
                                    $(".output").append("<img src='"+json.msg+"' style='width:256px;' />");
                                }
                            }
                        });
                        */
                        alert("ie8");
                        return false;
                    }
                }else{
                     $('.output').qrcode({
                        width: 150,
                        height: 150,
                        "text": linkWeixin
                    });
                }
            
            break;
        default:
            break;

        }

    });

    $(document).on("click",".bd_weixin_popup_close",function(){
        $('.output').html("");
        $(this).parents(".bd_weixin_popup").hide();
    });


    $(document).on("click",function(){
         $(".vsoShare").hide();
    });