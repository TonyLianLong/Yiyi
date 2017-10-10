RETURN_CHAR = "\n";
var server = 1;
var box_type_array = ["未设置","客厅","厨房","阳台","窗台","卧室","办公室"];
sensor_name = ["PM2.5","VOC","温度","湿度","气压","6号","7号"];
suffix_array = ["微克/立方米","RS/RS(Air)","°C","%","kPa"," "," "];
status_pm_array = ["1级","2级","3级","4级","5级","6级","污染过强"];
status_RSRS_array = ["污染较轻","中度污染","污染严重"];
var maxdotnumber = Number(Cookies.get('dotnumber'));
if(isNaN(maxdotnumber)){
	maxdotnumber = 100;
}
var autorefreshtime = Number(Cookies.get('autorefreshtime'));
if(isNaN(autorefreshtime)){
	autorefreshtime = 0;
}
var resolution_tips = Cookies.get('resolution_tips');
if(resolution_tips != "true"){
	resolution_tips = false;
}else{
	resolution_tips = true;
}
settings = JSON.parse(Cookies.get('settings'));
console.log(settings);
function update_settings(){
	console.log(JSON.stringify(settings));
	Cookies.set('settings', JSON.stringify(settings), { expires: 3650, path: '/' });
}
function GetQueryString(name)
{
    var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
    var r = window.location.search.substr(1).match(reg);
    if(r!=null)return  unescape(r[2]); return null;
}
if(($("body").width()<$("body").height())&&(resolution_tips!=true)){
	alert("横屏访问更好。");
	Cookies.set('resolution_tips', "true", { expires: 3650, path: '/' });
}
function center(){
	var user_login = false;
	if(info){
		if(info.login){
			user_login = true;
		}
	}
	if(user_login){
		location.href = "./center.php";
	}else{
		location.href = "./";
	}
}
$(document).ready(function(){
	if (/msie/.test(navigator.userAgent.toLowerCase())) {
		$('input:radio').click(function () { 
			this.blur();
			this.focus();
		});
	};
});