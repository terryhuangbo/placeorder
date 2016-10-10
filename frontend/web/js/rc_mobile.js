$(function(){
    var _box = $('.part-intro-contentbox'),
        _para = _box.find('.part-intro-content'),
        ph = _para.outerHeight(),
        bh = _box.outerHeight();
    if(ph > bh)
    {
        _box.next('.part-intro-slide').css('display', 'block');
    }
    $('.part-intro-slide').on('click', function(event) {
        var _this = $(this),
            _par = _this.parent('.me-part-contentbox');
        if(_par.hasClass('down'))
        {
            _box.css('height', ph);
            _par.removeClass('down').addClass('up');
        }
        else if(_par.hasClass('up'))
        {
            _box.css('height', bh);
            _par.removeClass('up').addClass('down');
        }
    });
    $('.me-nav-option').on('click', function(event) {
        stopPropagtion(event);
    });
    $('.me-nav-opbtn').on('click', function(event) {
        stopPropagtion(event);
        $(this).next('.me-nav-opcontent').toggle();
    });
    $(document).on('click', function(event) {
        $('.me-nav-opcontent').hide();
    });
});

function stopPropagtion (event) {
    if(event.stopPropagation())
    {
        event.stopPropagtion();
    }
    else
    {
        event.cancelBubble = true;
    }
}