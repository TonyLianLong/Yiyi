<?

session_start();
//header("Content-type: text/plain; charset=utf-8");
ini_set("display_errors", "On");
error_reporting(E_ALL | E_STRICT);
error_reporting(E_ERROR | E_WARNING | E_PARSE);  
//报告所有错误  
require("database.php");
function check_user($username,$password){
	global $con,$user_table_name;
	$query = mysql_query("SELECT * FROM `".$user_table_name."` WHERE `username`=\"".mysql_escape_string($username)."\"",$con);
	$result = mysql_fetch_array($query);
	if($result != false){
		if($result["password"] == $password){
			return $result;
		}
	}
	return false;
}

function box_info($name){
	global $access_table_name;
	global $con;
	$query = mysql_query("SELECT * FROM `".$access_table_name."` WHERE code=\"".mysql_escape_string($name)."\"",$con);
	$row = mysql_fetch_array($query);
	return $row;
}
$login = false;
if(isset($_SESSION["username"]) && isset($_SESSION["password"])){
	$userinfo = check_user($_SESSION["username"],$_SESSION["password"]);
	if($userinfo){
		$login = true;
	}
}
if($login == false){
?>
<script>
location.href="./";
</script>
<?
exit(0);
}
?>
<!DOCTYPE>
<head>
<meta charset="UTF-8"><title>用户中心</title>

<meta name="viewport" content="width=device-width,height=device-height,user-scalable=no,initial-scale=1,minimum-scale=1,maximum-scale=2">
<meta name="format-detection" content="telphone=no, email=no"/>
<meta http-equiv="Cache-Control" content="no-siteapp" />
<meta name="full-screen" content="yes">
<meta name="x5-fullscreen" content="true">
<meta name="browsermode" content="application">
<html lang="zh-cn">
<meta name="description" content="数据获取工具"/>
<meta name="keywords" content="数据获取工具"/>
<meta name="Tony" contect="tony, tonylianlong@tonylianlong.com" />
<link rel="shortcut icon" type="image/ico" href="/favicon.ico"/>
<link rel="apple-touch-icon-precomposed" sizes="57x57" href="./img/icon-57.png">
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="./img/icon-72.png">
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="./img/icon-114.png">
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="./img/icon-144.png">
<link rel="apple-touch-icon-precomposed" sizes="152x152" href="./img/icon-152.png">
<link rel="apple-touch-icon-precomposed" sizes="196x196" href="./img/icon-196.png">
<link rel="apple-touch-startup-image" sizes="2048x1496" href="./img/startup-2048x1496.png" media="screen and (min-device-width:481px) and (max-device-width:1024px) and (orientation:landscape) and (-webkit-min-device-pixel-ratio: 2)">
<link rel="apple-touch-startup-image" sizes="1536x2008" href="./img/startup-1536x2008.png" media="screen and (min-device-width:481px) and (max-device-width:1024px) and (orientation:portrait) and (-webkit-min-device-pixel-ratio: 2)">
<link rel="apple-touch-startup-image" sizes="1024x748" href="./img/startup-1024x748.png" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:landscape)">
<link rel="apple-touch-startup-image" sizes="768x1004" href="./img/startup-768x1004.png" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:portrait)">
<link rel="apple-touch-startup-image" sizes="640x920" href="./img/startup-640x920.png" media="screen and (max-device-width: 480px) and (-webkit-min-device-pixel-ratio: 2)">
<link rel="apple-touch-startup-image" sizes="320x460" href="./img/startup-320x460.png" media="screen and (max-device-width: 320)">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="msapplication-TileColor" content="#000"/>
<meta name="msapplication-TileImage" content="icon.png"/>
<meta name="msapplication-tap-highlight" content="no">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
<meta name="apple-mobile-web-app-title" content="空气状态显示">

<meta http-equiv="pragma" content="no-cache">
<meta http-equiv="cache-control" content="no-cache">
<meta http-equiv="expires" content="0">   
<script src="./js/jquery.js" charset="UTF-8"></script>
<script src="./js/js.cookie.js" charset="UTF-8"></script>
<script src="./js/initialize.js" charset="UTF-8"></script>
<link rel="stylesheet" type="text/css" href="./style/jquery.mobile-1.4.5.min.css" charset="UTF-8"></link>
<link rel="stylesheet" type="text/css" href="./style/css.css" charset="UTF-8"></link>
<script src="./js/jquery.mobile-1.4.5.min.js" charset="UTF-8"></script>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=eCxLexfWlVudRn2MHwFmVgZ9u5dgGlYp"></script>
</head>
<body style='font-family:微软雅黑,"Microsoft YaHei"'>
<div data-role="header" role="banner" class="ui-header ui-bar-inherit">
<h1 class="ui-title" role="heading" aria-level="1">空气状态显示</h1>
	<button id="back-button" class="ui-btn-left ui-btn ui-btn-b ui-btn-inline ui-mini ui-corner-all ui-btn-icon-left ui-icon-check">返回</button>
	<button id="settings-button" class="ui-btn-left ui-btn ui-btn ui-btn-inline ui-mini ui-corner-all ui-btn-icon-left ui-icon-gear">设置</button>
	<button id="visit-button" class="ui-btn-right ui-btn ui-btn ui-btn-inline ui-mini ui-corner-all ui-btn-icon-right ui-icon-edit">访问</button>
	<button id="logout-button" class="ui-btn-right ui-btn ui-btn ui-btn-inline ui-mini ui-corner-all ui-btn-icon-right ui-icon-back">退出</button>
</div>
<div data-role="tabs" id="tab1">
	<div id="navbar1" data-role="navbar">
		<ul>
		  <li><a href="#current_location" data-ajax="false">当前</a></li>
		  <li><a href="#favorite_site" data-ajax="false">收藏</a></li>
		  <li><a href="#box" data-ajax="false">关注</a></li>
		</ul>
		<div id="current_location" class="ui-body-d ui-content">
			<table data-role="table" data-mode="reflow" class="ui-responsive data-table">
				<thead>
					<tr>
						<th data-priority="persist">数值</th>
						<th data-priority="persist">当前</th>
						<th data-priority="1">数据点数</th>
					</tr>
				</thead>
				<tbody id="data_tbody">
					<tr>
						<th>温度</th>
						<td>20</td>
						<td>2</td>
					</tr>
				</tbody>
			</table>
			<button id="show-datamap" class="ui-btn ui-corner-all default_hide">显示数据地图</button>
			<div id="mapplace" class=" default_hide" style="margin:0 auto;"></div>
		</div>
		<div id="favorite_site" class="ui-body-d ui-content">
			<label for="search" class="ui-hidden-accessible">搜索</label>
			<input type="search" name="search" id="search1" data-iconpos="right" value="" placeholder="搜索已收藏的位置或输入新位置" onsearch='refresh_search_result1()'>
			<div data-role="collapsibleset" data-inset="true" class="ui-grid-solo ui-corner-all ui-shadow">
				<?
				$fav_site = json_decode($userinfo["site"],true);
				if($fav_site){
					foreach ($fav_site as $sitenum => $val){
					?>
					<div data-role="collapsible" class="site_item ui-block-a" data-collapsed="true"><h3 lat="<? echo $val[0];?>" lng="<? echo $val[1];?>" address="<? echo $val[2];?>" sitenum="<? echo $sitenum;?>"><? if($val[3] && $val[3]!=""){
						echo $val[3];
					}else{
						echo $val[2];
					}?></h3>
					</div>
					<?
					}
				}
				?>
			</div>
			<button id="search_result1" class="ui-btn ui-corner-all">收藏新位置</button>
		</div>
		<div id="box" class="ui-body-d ui-content">
			<label for="search" class="ui-hidden-accessible">搜索</label>
			<input type="search" name="search" id="search2" value="" placeholder="搜索或输入号码" onsearch='refresh_search_result2()'>
			<ul data-role="listview" data-inset="true" class="ui-grid-solo ui-corner-all ui-shadow">
				<?
				$box_array_followed = json_decode($userinfo["box"],true);
				foreach ($box_array_followed as $boxcode => $val){
				?>
				<li  class="box_item ui-block-a"><a href="#" code="<? echo $boxcode; ?>"><? if($val != ""){
					echo $val;
				}else{
					$box = box_info($boxcode);
					echo $box["name"];
				}?></a></li>
				<?
				}
				?>
				<li class="ui-block-a"><a href="#" id="search_result2">进入号码为“”的盒子</a></li>
			</ul>
		</div>
	</div>
</div>
<div id="settings" class="default_hide">
	<div data-role="tabs" id="tabs2">
	  <div id="navbar2" data-role="navbar">
		<ul>
		  <li><a href="#item1-0" data-ajax="false">位置设置</a></li>
		  <li><a href="#item1-1" data-ajax="false">显示设置</a></li>
		  <li><a href="#item1-2" data-ajax="false">用户设置</a></li>
		</ul>
		<div id="item1-0" class="ui-body-d ui-content">
			<h1>位置设置</h1>
			<form id="radio-location">
				<fieldset data-role="controlgroup" data-iconpos="right">
					<legend>定位方式设置</legend>
					<input type="radio" name="radio-location" id="radio-location-1" value="1">
					<label for="radio-location-1">通过浏览器定位</label>
					<input type="radio" name="radio-location" id="radio-location-2" value="2">
					<label for="radio-location-2">固定位置</label>
				</fieldset>
			</form>
			<div id="loc_thru_brw">
				<p>您的位置：</p>
				<p>您的地址：</p>
			</div>
			<form id="loc_fixed">
				<label for="address">地址：</label>
				<input type="text" name="address" id="address" value="" placeholder="X市X区X路X号">
				<p class="red-text" id="address-text"></p>
			</form>
			<button id="apply-1" class="ui-btn ui-corner-all">应用</button>
			<script>
				if(settings["get_location"] == 2){
					$("#loc_thru_brw").hide();
					$("#address").val(settings["location_str"]);
					$("input[name='radio-location']").eq(0).attr("checked",false);
					$("input[name='radio-location']").eq(1).attr("checked","checked");
					location_lat = settings["location_lat"];
					location_lng = settings["location_lng"];
				}else{
					$("#loc_fixed").hide();
					$("input[name='radio-location']").eq(0).attr("checked","checked");
					$("input[name='radio-location']").eq(1).attr("checked",false);
					showloc();
					if(settings["get_location"] != 1){
						settings["get_location"] = 1;
						update_settings();
					}
				}
				$(document).ready(function(){
						$("#radio-location").change(function() {
							if($("input[name='radio-location']:checked").val() == "1"){
								showloc();
								$("#loc_thru_brw").show();
								$("#loc_fixed").hide();
							}else if($("input[name='radio-location']:checked").val() == "2"){
								$("#loc_thru_brw").hide();
								$("#loc_fixed").show();
								$("#address-text").text("请填入地址");
							}
						});
						$("#apply-1").click(function(){
							if($("input[name='radio-location']:checked").val() == "1"){
								showloc();
								settings["get_location"] = 1;
								update_settings();
							}else{
								var geoc = new BMap.Geocoder();
								geoc.getPoint($("#address").val(), function(point){
								if (point) {
									$("#address-text").text("应用成功 经度："+point.lat+" 纬度："+point.lng);
									settings["get_location"] = 2;
									settings["location_lat"] = point.lat;
									settings["location_lng"] = point.lng;
									settings["location_str"] = $("#address").val();
									update_settings();
								}else{
									$("#address-text").text("您的地址没有解析结果!");
								}},"");//City name
							}
						});
				});
			</script>
		</div>
		<div id="item1-1" class="ui-body-d ui-content">
			<h1>显示设置</h1>
			<!-- Edit in box.htm also. -->
			<p>显示设置只对本电脑的本浏览器有效。</p>
			<label for="dotnumber">显示点数（0为显示所有点）：</label>
			<input type="range" name="dotnumber" id="dotnumber" min="0" max="1000" value="100">
			<label>
				<input type="checkbox" name="dotdate_select" id="dotdate_select">日期限制
			</label>
			<label for="dotdate">显示日期（0为显示所有点）：</label>
			<input type="text" name="dotdate" id="dotdate" class="date-input-inline" data-inline="true" data-role="date" data-role="date">
			<!--<label for="dotperiod">显示点间隔：</label>
			<input type="range" name="dotperiod" id="dotperiod" min="0" max="20" value="1">-->
			<div class="ui-field-contain">
				<label for="datacal_sel">算法：</label>
				<select name="datacal_sel" id="datacal_sel">
					<option id="datacal_sel0" value="0">直接显示</option>
					<option id="datacal_sel1" value="1">从后到前平均</option>
					<option id="datacal_sel2" value="2">从前到后平均</option>
				</select>
			</div>
			<label for="autorefreshtime">自动刷新间隔（0为不自动刷新，单位：分钟）：</label>
			<input type="range" name="autorefreshtime" id="autorefreshtime" min="0" max="60" step="0.5" value="0">
			<button id="display_sure">确定</button>
			<script>
			$("#dotnumber").attr("value",maxdotnumber);
			$("#autorefreshtime").attr("value",autorefreshtime);
			$(document).ready(function(){
				$("#display_sure").click(function(){
					Cookies.set('dotnumber', $("#dotnumber").val(), { expires: 3650, path: '/' });
					//Cookies.set('dotperiod', $("#dotperiod").val(), { expires: 3650, path: '/' });
					Cookies.set('autorefreshtime', $("#autorefreshtime").val(), { expires: 3650, path: '/' });
					Cookies.set('datacal0', $("#datacal_sel").val(), { expires: 3650, path: '/' });
					location.reload(true);
				});
			});
			</script>
		</div>
		<div id="item1-2" class="ui-body-d ui-content">
			<h1>用户设置</h1>
			<label for="username">用户名：</label>
			<input type="text" name="username" id="username" value="" disabled="disabled">
		</div>
	  </div>
	</div>

</div>
<div data-role="popup" id="popup1" data-theme="a" class="ui-corner-all">
	<form action="./box.htm" method="get" data-ajax="false">
		<div style="padding:10px 20px;">
			<div data-role="header" data-theme="a">
				<h3>输入号码</h3>
			</div>
			<label for="box_code" class="ui-hidden-accessible">盒子号码：</label>
			<input type="text" nid="box_code" value="" placeholder="盒子号码" data-theme="a">
			<label for="box_password" class="ui-hidden-accessible">访问密码：</label>
			<input type="password" id="box_password" value="" placeholder="密码" data-theme="a">
			<button type="submit" class="ui-btn ui-corner-all ui-shadow ui-btn-a ui-btn-icon-left ui-icon-check">访问</button>
		</div>
	</form>
</div>
<div data-role="popup" id="popup2" data-theme="a" class="ui-corner-all">
	<form id="fav_site_form" data-ajax="false">
		<div style="padding:10px 20px;">
			<div data-role="header" data-theme="a">
				<h3>收藏新位置</h3>
			</div>
			<label for="site_name">名称：</label>
			<input type="text" id="site_name" value="" placeholder="名称" data-theme="a">
			<label for="site_address">地址：</label>
			<input type="text" id="site_address" value="" placeholder="地址" data-theme="a">
			<fieldset data-role="controlgroup" data-type="horizontal" id="fav_site_time">
				<legend>收藏时间：</legend>
				<input type="checkbox" id="checkbox-current" time="-1">
				<label for="checkbox-current">当前</label>
				<input type="checkbox" id="checkbox-8" time="8">
				<label for="checkbox-8">8:00</label>
				<input type="checkbox" id="checkbox-9" time="9">
				<label for="checkbox-9">9:00</label>
				<input type="checkbox" id="checkbox-12" time="12">
				<label for="checkbox-12">12:00</label>
				<input type="checkbox" id="checkbox-14" time="14">
				<label for="checkbox-14">14:00</label>
				<input type="checkbox" id="checkbox-18" time="18">
				<label for="checkbox-18">18:00</label>
				<input type="checkbox" id="checkbox-20" time="20">
				<label for="checkbox-20">20:00</label>
			</fieldset>
			<button type="submit" class="ui-btn ui-corner-all ui-shadow ui-btn-a ui-btn-icon-left ui-icon-star">收藏</button>
		</div>
	</form>
	<form>
</form>
</div>
<div data-role="footer" role="banner" class="ui-footer ui-bar-inherit">
	<h1 class="ui-title" role="heading" aria-level="1">http://air.tonylianlong.com</h1>
</div>
<script>
function showloc(){
	var geolocation = new BMap.Geolocation();
	geolocation.getCurrentPosition(function(r){
		if(this.getStatus() == BMAP_STATUS_SUCCESS){
			console.log(r);
			$("#loc_thru_brw p").eq(0).text('您的位置（经纬）：'+r.point.lat+','+r.point.lng);
			location_lat = r.point.lat;
			location_lng = r.point.lng;
			var geoc = new BMap.Geocoder();
			var pt = r.point;
			geoc.getLocation(pt, function(rs){
				var addComp = rs.addressComponents;
				console.log(addComp);
				$("#loc_thru_brw p").eq(1).text("您的地址：" + addComp.province + ", " + addComp.city + ", " + addComp.district + ", " + addComp.street + ", " + addComp.streetNumber);
			});
		}
		else {
			$("#loc_thru_brw p").text('定位失败，错误代码：'+this.getStatus());
		}
	},{enableHighAccuracy: true})
	$("#loc_thru_brw p").text("正在定位中……");
}
$("#back-button").hide();
$("#user").hide();
function refresh_search_result1(e){
	$(".site_item").each(function(){
		if($(this).children("h3").text().toUpperCase().indexOf($("#search1").val().toUpperCase())==-1){
			if($(this).css("display") != "none"){
				$(this).hide();
			}
		}else{
			if($(this).css("display") == "none"){
				$(this).show();
			}
		}
	});
}
function refresh_search_result2(e){
	$(".box_item").each(function(){
		if($(this).children("a").text().toUpperCase().indexOf($("#search2").val().toUpperCase())==-1){
			if($(this).css("display") != "none"){
				$(this).hide();
			}
		}else{
			if($(this).css("display") == "none"){
				$(this).show();
			}
		}
	});
	if(($("#search2").val() != "")&&($("#search2").val().length >= 5)){
		console.log($("#search2").val());
		$("#search_result2").text("进入号码为“"+$("#search2").val()+"”的盒子");
		if(!search_result_status){
			$("#search_result2").show();
			search_result_status = true;
		}
	}else{
		if(search_result_status){
			$("#search_result2").hide();
			search_result_status = false;
		}
	}
}
$(document).ready(function(){
	$(".default_hide").hide();
	$("#search_result2").hide();
	$("#logout-button").hide();
	search_result_status = false;
	$( ".site_item" ).on( "collapsiblecollapse", function( event, ui ) {
		$(this).children(".ui-collapsible-content").empty();
	});
	$( ".site_item" ).on( "collapsibleexpand", function( event, ui ) {
		$(this).children(".ui-collapsible-content").append("<p class=\"col_content\">加载中……</p>");
		//collapsibleset("refresh")
	});
	$("#fav_site_form").submit(function(e){
		e.preventDefault();
		console.log(e);
		var geoc = new BMap.Geocoder();
		geoc.getPoint($("#site_address").val(), function(point){
			if (point) {
				time = new Array();
				$("#fav_site_time input:checked").each(function(){
					time.push(Number($(this).attr("time")));
				});
				$.ajax({ 
				type:"GET", 
				url:"user.php", 
				dataType:"json", 
				data:{command:"favor",lat:point.lat,lng:point.lng,addr:$("#site_address").val(),site_name:$("#site_name").val(),time:JSON.stringify(time)},
				success:function(result){
					alert("收藏成功。");
					console.log(result);
					$("#popup2").popup("close");
					location.reload(true);
				},
				failure:function (result) { 
					alert("收藏错误。");
				}
				});
			}else{
				alert("您的地址没有解析结果!");
			}},"");//City name
	});
	$(".box_item a").click(function(e){
		console.log(this);
		code = $(this).attr("code");
		location.href="./box.htm?box_code="+code;
	});
	$("#search1").bind("input propertychange",refresh_search_result1);
	$("#search_result1").click(function(e){
		$("#popup2").popup("open");
	});
	$("#search2").bind("input propertychange",refresh_search_result2);
	$("#search_result2").click(function(e){
		location.href="./box.htm?box_code="+$("#search2").val();
	});
	$("#visit-button").click(function(e){
		$("#popup1").popup("open");
	});
	$("#settings-button").click(function(e){
		$("#tab1").hide();
		$("#settings").show();
		$("#settings-button").hide();
		$("#logout-button").show();
		$("#back-button").show();
	});
	$("#back-button").click(function(e){
		$("#tab1").show();
		$("#settings").hide();
		$("#settings-button").show();
		$("#logout-button").hide();
		$("#back-button").hide();
	});
	$("#logout-button").click(function(e){
		$.ajax({ 
		type:"GET", 
		url:"user.php", 
		dataType:"json", 
		data:{command:"logout"},
		success:function(result){
			console.log(result);
			if((result.result == "success") && (result.login == false)){
				location.href="/";
			}else{
				console.log(result);
			}
		},
		failure:function (result) { 
			console.log(result);
		}
		});
	});
	$("#show-datamap").click(function(e){
		$("#show-datamap").hide();
		var mapwid = $("#navbar1").width()*0.5;
		$("#mapplace").width(mapwid);
		$("#mapplace").height(mapwid/4*3);
		var map = new BMap.Map("mapplace", {minZoom:15,maxZoom:19,enableMapClick:false});
		if(map){
			var current_loc_point = new BMap.Point(location_lng,location_lat);
			map.centerAndZoom(current_loc_point, 16);
			var circle = new BMap.Circle(current_loc_point,circle_radius,{strokeColor:"blue", strokeWeight:0.5, strokeOpacity:0.5,fillColor:"blue",fillOpacity:0.7});
			map.addOverlay(circle);
			map.enableScrollWheelZoom();
			if (document.createElement('canvas').getContext){
				var points = [];
				for (var i = 0; i < point_data.length; i++) {
				  points.push(new BMap.Point(point_data[i][0],point_data[i][1]));
				}
				console.log(points);
				var options = {
					size: BMAP_POINT_SIZE_SMALL,
					shape: BMAP_POINT_SHAPE_STAR,
					color: '#d340c3'
				}
				var pointCollection = new BMap.PointCollection(points, options);
				pointCollection.addEventListener('click', function (e) {
					console.log(e);
					alert('单击点的坐标为：' + e.point.lng + ',' + e.point.lat);
				});
				map.addOverlay(pointCollection);
			} else {
				alert('请在Chrome、Safari、IE8+以上浏览器查看地图');
			}
		}
	});
	var radius = 0.001;
	$.ajax({
		type:"GET", 
		url:"user.php", 
		dataType:"json", 
		data:{command:"getdatasrc",location_lat:location_lat,location_lng:location_lng,rad:radius},
		success:function(result){
			console.log(result);
			$("#mapplace").show();
			if(!result["data"]){
				$("#mapplace").text("无数据");
				return;
			}
			point_data = result["src_points"];
			circle_radius = radius*1110000;
			if(circle_radius < result["max_distance"]){
				circle_radius = result["max_distance"];
			}
			console.log(circle_radius);
			$("#mapplace").text("");
			var tbody_html = "";
			for(var i in result["data"]){
				tbody_html += "<tr><th>"+sensor_name[i]+"</th>";
				tbody_html += "<td>"+result["data"][i].toFixed(2)+"</td>";
				tbody_html += "<td>"+result["dot_number"][i]+"</td>";
				tbody_html += "</tr>";
			}
			$("#data_tbody").html(tbody_html);
			$("#show-datamap").show();
		},
		failure:function (result) { 
			console.log(result);
			$("#mapplace").text("加载失败");
			$("#mapplace").show();
		}
	});
});

</script>
</body>