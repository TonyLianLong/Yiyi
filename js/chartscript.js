Lcolor = ['#808080','#7cb5ec', '#434348', '#90ed7d', '#f7a35c', 
		    '#8085e9', '#f15c80', '#e4d354', '#2b908f', '#f45b5b', '#91e8e1'];
RSRS_MED_VALUE = 0.8;
RSRS_MIN_VALUE = 0.5;
function showcontainer(dataarr,datatype_current){//-1 all
	console.log("Show container "+datatype_current);
	if($(".dataitem").length > 0){
		$(".dataitem").remove();
	}
	$("#show1_div").append('<div class="dataitem ui-body-d ui-content"><div id="container'+String(datatype_current)+'" style="min-width: 400px; height: 300px;margin: 0 auto"></div><br/></div>');
	if(datatype_current == -1){
		timearray = new Array();
		for(var i = 0;i<data.length;i++){
			timearray.push(data[i][1]);
		}
		seriesobject = new Object();
		for(var i = 0;i<data.length;i++){
			//for(k in data[i][0]){
			for(var j = 0;j<datatype.length;j++){
				k = datatype[j];
				if(!seriesobject[k]){
					seriesobject[k] = new Object({name:sensor_name[Number(k)],data:new Array(),tooltip: {
						valueSuffix: suffix_array[Number(k)]
					}});
				}
				if(data[i][0][k]){
					seriesobject[k]["data"].push(Number(data[i][0][k]));
				}else{
					seriesobject[k]["data"].push(0);
				}
			}
		}
		seriesarray = new Array();
		for(k in seriesobject){
			seriesarray.push(seriesobject[k]);
		}
		if(data.length > 0){
		latest = timearray[timearray.length-1];
		subtitle = "上次测量时间："+latest;
		}else{
			subtitle="无数据";
		}
		suffix = "数值 ";
		title = "";
		for(var i = 0;i<datatype.length;i++){
			suffix+=suffix_array[datatype[i]];
			title+=sensor_name[datatype[i]];
			if(i != datatype.length-1){
				suffix+=" ";
				title+=" ";
			}
		}
	}else{
		timearray = new Array();
		for(var i = 0;i<dataarr[datatype_current].length;i++){
			timearray.push(dataarr[datatype_current][i][1]);
		}
		dataarray = new Array();
		for(var i = 0;i<dataarr[datatype_current].length;i++){
			dataarray.push(Number(dataarr[datatype_current][i][0]));
		}
		seriesarray = [{
			name: sensor_name[datatype_current],
			data: dataarray,
			tooltip: {
				valueSuffix: suffix
			}
		}];
		if(dataarr[datatype_current].length > 0){
			latest = dataarr[datatype_current][dataarr[datatype_current].length-1];
			switch(datatype_current){
				case 0:
					if(Number(latest[0]) < 35){
						status = status_pm_array[0];
					}else if(Number(latest[0]) < 75){
						status = status_pm_array[1];
					}else if(Number(latest[0]) < 115){
						status = status_pm_array[2];
					}else if(Number(latest[0]) < 150){
						status = status_pm_array[3];
					}else if(Number(latest[0]) < 250){
						status = status_pm_array[4];
					}else if(Number(latest[0]) < 500){
						status = status_pm_array[5];
					}else if(Number(latest[0])){
						status = status_pm_array[6];
					}
					subtitle = "上次测量时间："+latest[1]+" 目前状态："+status;
					break;
				case 1:
					if(Number(latest[0]) < RSRS_MIN_VALUE){
						status = status_RSRS_array[2];
					}else if(Number(latest[0]) < RSRS_MED_VALUE){
						status = status_RSRS_array[1];
					}else{
						status = status_RSRS_array[0];
					}
					subtitle = "上次测量时间："+latest[1]+" 目前状态："+status;
					break;
				default:
					subtitle = "上次测量时间："+latest[1];
			}
		}else{
			subtitle = "无数据";
		}
		suffix = suffix_array[datatype_current];
		title = sensor_name[datatype_current];
	}
	/*console.log("Timearray:"+timearray);
	console.log("Loading"+String(n));*/
	$('#container'+String(datatype_current)).highcharts({
		title: {
			text: title,
			x: -20 //center
		},
		subtitle: {
			text: subtitle,
			x: -20
		},
		xAxis: {
			categories: timearray
		},
		yAxis: {
			title: {
				text: suffix
			},
			plotLines: [{
				value: 0,
				width: 1,
				color: '#808080'//Lcolor[n]
			}]
		},
		legend: {
			layout: 'vertical',
			align: 'right',
			verticalAlign: 'middle',
			borderWidth: 0
		},
		series: seriesarray
	});
			/*plotOptions: {
            line: {
                dataLabels: {
                    enabled: true
                },
                enableMouseTracking: false
            }
        },*/
}