var talentThemeName = "";
var ua = navigator.userAgent;
var ipad = ua.match(/(iPad).*OS\s([\d_]+)/),
    isIphone = !ipad && ua.match(/(iPhone\sOS)\s([\d_]+)/),
    isAndroid = ua.match(/(Android)\s+([\d.]+)/),
    isMobile = isIphone || isAndroid;
if (isMobile) {
    talentThemeName = getCookie("talent-mobile-theme");
}
else {
    talentThemeName = getCookie("talent-theme");
    //talentThemeName = "pithy";
}
var baseSkinUrl = "";
switch (talentThemeName) {
    case "pithy":
        baseSkinUrl = "/skin/pithy/style";
        break;
    case "skin2":
        baseSkinUrl = "/css/talent_space2";
        break;
    case "skin3":
        baseSkinUrl = "/css/talent_space3";
        break;
    case "skin4":
        baseSkinUrl = "/css/talent_space4";
        break;
    default:
        if (isMobile) {
            baseSkinUrl = "/css/talent_mobile_space";
        }
        else {
            baseSkinUrl = "/css/talent_space";
        }
        break;
}
document.write('<link rel="stylesheet" type="text/css" href="' + baseSkinUrl + '.css" />');