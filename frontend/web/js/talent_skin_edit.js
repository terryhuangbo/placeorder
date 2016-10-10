/**
 *更改皮肤--可根据一定的路径规则扩展
 * */
function changeSkin(isMobile, skinid){
    var talentThemeName = "";
    var  baseSkinUrl = "";
    if(isMobile) {//移动端
        switch(skinid)
        {
            case 2:
                baseSkinUrl = "/css/talent_mobile_space";
                break;
            case 4:
                baseSkinUrl = "/skin/pithy/style";
                break;
           default:
                baseSkinUrl = "/css/talent_mobile_space";
                break;
        }
    }else{//PC端
        switch(skinid)
        {
            case 1:
                baseSkinUrl = "/css/talent_space";
                break;
            case 3:
                baseSkinUrl = "/skin/pithy/style";
                break;
            default:
                baseSkinUrl = "/css/talent_space";
                break;
        }
    }
    document.write('<link rel="stylesheet" type="text/css" href="' + baseSkinUrl + '.css" />');
}
changeSkin(_SKINTYPE, _SKINID);//更换皮肤



