$(document).ready(function() {
    $(".rank-box").on('click', function(event) {
        var _this = $(this),
            _obj = _this.next();
        if(_obj.is(':hidden'))
        {
            $(".topinfo").css({"display": "none"});
            _obj.slideToggle();
        }
    });

    $('.telent-navigater li').Tab({
        action: "click",
        container:".nav-box .telent-content",
        tabSwitch: function (mythis, index, container, classname) {
            var _this = $(mythis),
                _objs = $(container);
            _this.addClass("active").siblings().removeClass("active default");
            _objs.eq(index).show().siblings().hide();
            var act = _this.index();
            if(act == '2'){
                _this.children("span").hide();
                _this.prev().children("span").show();
            }
            else if(act == '1') {
                _this.children("span").hide();
                _this.next().children("span").hide();
            }
            else if(act == '0') {
                _this.next().children("span").hide();
                _this.next().next().children("span").show();
            }
        },
        tabSwitchClose: function(){}
    });
    $(".qq").mouseover(function() {
        $(this).parent().next().css({"display": "block"});
    }).mouseout(function() {
        $(this).parent().next().css({"display": "none"});
    });
    $(".weixin-box").mouseover(function() {
        $(this).css({"display": "block"});
    }).mouseout(function() {
        $(this).css({"display": "none"});
    });
});