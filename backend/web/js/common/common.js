/**
 * 通用方法属性集合
 */
function CommonModule(){
    var _self = this;
    /**
     * 项目状态对应集合
     */
    _self.projectStatus = [
        {text:'进行中',value:0},
        {text:'归档（关闭）',value:1},
        {text:'冻结',value:2},
        {text:'关闭',value:3},
        {text:'删除',value:4},
        {text:'审核通过',value:5},
        {text:'审核不通过',value:6}
    ];

    /**
     * 人才类型对应集合
     */
    _self.talentTypes = [
        {text:'个人',value:1},
        {text:'企业',value:2},
        {text:'学校',value:6}
    ];

    /**
     * 人才账户状态对应集合
     */
    _self.talentStatuses = [
        {text:'激活',value:1},
        {text:'冻结',value:2}
    ];

    /**
     * 根据项目状态码获取相应显示文字
     */
    _self.getProjectStatusText = function(status){
        for(var i = 0; i < _self.projectStatus.length; i++){
            if(_self.projectStatus[i].value == status){
                return _self.projectStatus[i].text;
            }
        }
    };

    /**
     * 根据人才类型码获取相应显示文字
     */
    _self.getUserTypeText = function(type){
        for(var i = 0; i < _self.talentTypes.length; i++){
            if(_self.talentTypes[i].value == type){
                return _self.talentTypes[i].text;
            }
        }
    };

    /**
     * 根据人才状态码获取相应显示文字
     */
    _self.getUserStatusText = function(status){
        for(var i = 0; i < _self.talentStatuses.length; i++){
            if(_self.talentStatuses[i].value == status){
                return _self.talentStatuses[i].text;
            }
        }
    };
}
var cm = new CommonModule();