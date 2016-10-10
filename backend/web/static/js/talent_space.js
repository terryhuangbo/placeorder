$(".w-charts").each(function(){
       var precessBar = $(this).parents(".w-evaluation-conter").next(".w-evaluation-right").find(".w-evaluation_view").html().split("/");
       var _precessBar = precessBar[0] / precessBar[1]; //进度条的比例
       var startWidth = 16; //每颗星星的距离
       var startSpace = 5; //星星和星星的间距
       var scale = 1/5; //每隔星星占的比例
       var startInteger = precessBar[0].substr(0, 1);
       var startFloat = precessBar[0] - startInteger;
       //var thisWidth = Math.floor(_precessBar/scale) * (startWidth+startSpace) + startWidth * (Math.floor(_precessBar/scale) * scale);
       var thisWidth = startInteger * (startWidth + startSpace) + startFloat * startWidth;
       $(this).width(thisWidth);
    });



;(function ($) {
    var defaults = {
        action: "click",
        container:".tab-box .tab-content"
    };
    //创建对象

    $.fn.Tab = function (options) {
        var options = $.extend(defaults, options || {});

        return this.each(function () {
            var tabAction = getAction(defaults.action);
            var container = options.container;

            var _this = this;
            if(tabAction=="onmousemove"){
                this.onmousemove = function(){
                    var index = $(_this).index();
                    tabSwitch(_this,index,container);
                }
            }
            if(tabAction=="onclick"){
                this.onclick = function(){
                    var index = $(_this).index();
                    tabSwitch(_this,index,container);
                }
            }
        });
    };
    //tab切换方法
    var tabSwitch = function (_this,index,container) {

        $(_this).addClass("active").siblings().removeClass("active");
        $(container).eq(index).show().siblings().hide();
    };

    //获得某些参数的方法
    function getAction(action) {
        var tabAction;
        switch (action) {
            case "click":
                tabAction = "onclick";
                break;
            case "hover":
                tabAction = "onmousemove";
                break;
        }
        return tabAction;
    };
})(jQuery);


$('.w-box-title li').Tab({
    action: "click",
    container:".tab-box .tab-content"
});


$(".ds-category-type").on("click",function(){
    var checkbox = $(this).find("i.checkbox");
    $(this).parent().find(".ds-category-type i.checkbox").removeClass("checked");
    $(this).find("input").prop("checked",true);
    checkbox.addClass("checked");
    
});


/*==========此代码放在最后一行===========*/
window._bd_share_config = {
		share : [{
			"bdSize" : 16
		}]
	}
	with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?cdnversion='+~(-new Date()/36e5)];