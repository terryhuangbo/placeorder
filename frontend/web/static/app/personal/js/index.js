;(function ($) {
    var defaults = {
        action: "click",
        container:".tab-box .tab-content"
    };
    //创建对象

    $.fn.Tab = function (options) {
        var options = $.extend(defaults, options || {});
        var container = options.container;

        return this.each(function () {
            var tabAction = getAction(defaults.action);


            var className = options.className;
            var _this = this;
            if(tabAction=="onmousemove"){
                var index = $(_this).index();
                this.onmouseenter = function(){
                    options.tabSwitch(_this,index,container,className);
                }

                this.onmouseleave = function(){
                    options.tabSwitchClose(_this,index,container,className);
                }
            }
            if(tabAction=="onclick"){
                this.onclick = function(){
                    var index = $(_this).index();
                    options.tabSwitch(_this,index,container,className);
                }
            }
        });
    };
    //tab切换方法
    defaults.tabSwitch = function (_this,index,container,className) {
        $(_this).addClass("active").siblings().removeClass("active");
        $(container).eq(index).css({"z-index":"2"}).show();
        $(container).eq(index).stop(true).animate({"left":"240px"},300,function(){
        }).animate({"opacity":"0.98"},500,function(){});
    };
    defaults.tabSwitchClose = function (_this,index,container,className) {
        $(_this).removeClass("active");
        $(container).eq(index).stop(true).animate({"left":"230px","opacity":"0.8","z-index":"-1"},300,function(){
            $(container).eq(index).hide();
        });
    };
    $(".talent-classify-content").hover(function(){
        var index = $(this).index();
        $('.talent-classify-ul li').eq(index).mouseenter();
    },function(){
        var index = $(this).index();
        $('.talent-classify-ul li').eq(index).mouseleave();
    });
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

;(function ($) {
    var defaults = {
        action: "click",
        container:".tab-box .tab-content"
    };
    //创建对象

    $.fn.TabSwitch = function (options) {
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

$('.talent-classify-ul li').Tab({
    action: "hover",
    container:".talent-classify-box .talent-classify-content"
});



$(function(){
    $("img.lazy").lazyload({
        placeholder : "http://static.vsochina.com/public/images/transparent.gif",
        effect : "fadeIn",
        failurelimit: 500
    });
});
$('.dropdown-toggle').dropdown();


$('.w-box-title li').TabSwitch({
    action: "click",
    container:".tab-box .tab-content"
});
$(".ds-category-type").on("click",function(){
    var checkbox = $(this).find("i.checkbox");
    $(this).parent().find(".ds-category-type i.checkbox").removeClass("checked");
    $(this).find("input").prop("checked",true);
    checkbox.addClass("checked");

});

