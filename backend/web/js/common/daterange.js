/**
 * 今天本周本月，搜索的通用插件方法,基于bui.date
 */
function DateTimeRange(selector){
    var _self = this;
    _self.wrap = $(selector);
    _self.mask = 'yyyy-mm-dd HH:MM:ss';
    _self.format = function(date, mask){
        mask = mask ? mask : _self.mask;
        return BUI.Date.format(date, mask);
    };

    _self.init = function(){
        _self.wrap.find('[v-role=date-range-nolimit]').click(function(){
            _self.wrap.find('[v-role=date-range-start]').val('');
            _self.wrap.find('[v-role=date-range-end]').val('');
        });
        _self.wrap.find('[v-role=date-range-today]').click(function(){
            var date = new Date();
            var start = _self.getDayStart(date);
            var startStr = _self.format(start);
            var end = _self.getDayEnd(date);
            var endStr = _self.format(end);
            _self.wrap.find('[v-role=date-range-start]').val(startStr);
            _self.wrap.find('[v-role=date-range-end]').val(endStr);
        });
        _self.wrap.find('[v-role=date-range-yesterday]').click(function(){
            var date = new Date();
            date.setDate(date.getDate() - 1);
            var start = _self.getDayStart(date);
            var startStr = _self.format(start);
            var end = _self.getDayEnd(date);
            var endStr = _self.format(end);
            _self.wrap.find('[v-role=date-range-start]').val(startStr);
            _self.wrap.find('[v-role=date-range-end]').val(endStr);
        });
        _self.wrap.find('[v-role=date-range-week]').click(function(){
            var date = new Date();
            var start = _self.getWeekStart(date);
            var startStr = _self.format(start);
            var end = _self.getWeekEnd(date);
            var endStr = _self.format(end);
            _self.wrap.find('[v-role=date-range-start]').val(startStr);
            _self.wrap.find('[v-role=date-range-end]').val(endStr);
        });
        _self.wrap.find('[v-role=date-range-month]').click(function(){
            var date = new Date();
            var start = _self.getMonthStart(date);
            var startStr = _self.format(start);
            var end = _self.getMonthEnd(date);
            var endStr = _self.format(end);
            _self.wrap.find('[v-role=date-range-start]').val(startStr);
            _self.wrap.find('[v-role=date-range-end]').val(endStr);
        });
    };

    _self.getDayStart = function(date){
        date.setHours(0, 0, 0, 0);
        return date;
    };

    _self.getDayEnd = function(date){
        date.setDate(date.getDate() + 1);
        return date;
    };

    _self.getWeekStart = function(date){
        date.setDate(date.getDate() - date.getDay() + 1);//国际星期一为第一天，中国周一，so+1
        date.setHours(0, 0, 0, 0);
        return date;
    };

    _self.getWeekEnd = function(date){
        date.setDate(date.getDate() - date.getDay() + 8);
        date.setHours(0, 0, 0, 0);
        return date;
    };

    _self.getMonthStart = function(date){
        date.setDate(1);
        date.setHours(0, 0, 0, 0);
        return date;
    };

    _self.getMonthEnd = function(date){
        date.setMonth(date.getMonth() + 1);
        date.setDate(1);
        date.setHours(0, 0, 0, 0);
        return date;
    };

    init();
}