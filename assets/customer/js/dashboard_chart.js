function __cfg(c) {
	 return(cfg && cfg.cfg && cfg.cfg[c]) ? cfg.cfg[c]: false;
}
var chart_data;
var today_views_url=__cfg('path_absolute')+'customers/todayViews';
var total_views_url=__cfg('path_absolute')+'customers/totalViews';
var topplatformchart_url=__cfg('path_absolute')+'customers/topPlatForms';
function pieHover(event, pos, obj) 
{
	if (!obj)
	return;
	percent = parseFloat(obj.series.percent).toFixed(2);
	$("#pieHover").html('<span style="font-weight: bold; color: ' + obj.series.color + '">' + obj.series.label + ' (' + percent + '%)</span>');
}
function pieHovers(event, pos, obj) 
{
	if (!obj)
	return;
	percent = parseFloat(obj.series.percent).toFixed(2);
	$("#pieHover1").html('<span style="font-weight: bold; color: ' + obj.series.color + '">' + obj.series.label + ' (' + percent + '%)</span>');
}
function pieHovers1(event, pos, obj) 
{
	if (!obj)
	return;
	percent = parseFloat(obj.series.percent).toFixed(2);
	$("#pieHover2").html('<span style="font-weight: bold; color: ' + obj.series.color + '">' + obj.series.label + ' (' + percent + '%)</span>');
}
 $("#piechart").bind("plothover", pieHover);
 $("#donutchart").bind("plothover", pieHovers);
 $("#topplatformchart").bind("plothover", pieHovers1);
 
function todayViews()
{
	$.ajax({
				type: "POST",
				url: today_views_url,
				datatype:"json",
				success: function(data)
				{
					chart_data=jQuery.parseJSON(data);
					if(data=='null')
					{
						chart_data=[{"label":"No view Yet","Total":"0","data":"1"}];					
					}
					if ($("#piechart").length) {
						$.plot($("#piechart"), chart_data,
						{
							series: {
								pie: {
									show: true,
									innerRadius: 0.5,
									label: {
										show: true,
										radius: 1,
										formatter: function(label, series){
										return '<div style="font-size:8pt;text-align:center;padding:4px;color:white;border:1px solid;border-radius:5px;">'+label+'<br/>'+Math.round(series.percent)+'%</div>';
										},
										background: { opacity: 0.8 }
									}
								}
							},
						    colors: ["#009900","#cc0000","#660033","#ff0066",'#6600ff',"#fdd752",'#9966ff','#003300','#0066ff','#0000cc'],
							legend: {
								show: false
							},
							grid: {
								hoverable: true,
							},
							tooltip:true,
						});
					}
				}
	});
}

function totalViews()
{
	$.ajax({
				type: "POST",
				url: total_views_url,
				datatype:"json",
				success: function(data)
				{
					chart_data=jQuery.parseJSON(data);
					if(data=='null')
					{
						chart_data=[{"label":"No view Yet","Total":"0","data":"1"}];					
					}
					if ($("#donutchart").length) 
					{
						$.plot($("#donutchart"), chart_data,
						{
							series: {
								pie: {
									innerRadius: 0.0,
									show: true,
									label: {
										show: true,
										radius: 1,
										formatter: function(label, series){
										return '<div style="font-size:8pt;text-align:center;padding:4px;color:white;border:1px solid;border-radius:5px;">'+label+'<br/>'+Math.round(series.percent)+'%</div>';
										},
										background: { opacity: 0.8 }
										}
									}
								
							},
							colors: ["#009900","#cc0000","#660033","#ff0066",'#6600ff',"#fdd752",'#9966ff','#003300','#0066ff','#0000cc'],
							legend: {
								show: false
							},
							grid: {
								hoverable: true,
							},
							tooltip:true,
						});
					}
				}
	});
}

function topPlatforms()
{
	$.ajax({
			type: "POST",
			url: topplatformchart_url,
			datatype:"json",
			async:true,
			success: function(data)
			{
				chart_data=jQuery.parseJSON(data);
				if(chart_data==null || chart_data.length <= 0)
				{
					chart_data=[{"label":"No Platform Yet","Total":"0","data":"1"}];					
				}
				$.plot($("#topplatformchart"), chart_data,
				{
						series: {
							pie: {
								innerRadius: 0.5,
								show: true,
								label: {
									show: true,
									radius: 1,
									formatter: function(label, series){
									return '<div style="font-size:8pt;text-align:center;padding:4px;color:white;border:1px solid;border-radius:5px;">'+label+'<br/>'+Math.round(series.percent)+'%</div>';
									},
									background: { opacity: 0.8 }
								}
							}
						},
						colors: ["#009900","#cc0000","#660033","#ff0066",'#6600ff',"#fdd752",'#9966ff','#003300','#0066ff','#0000cc'],
						legend: {
							show: false
						},
						grid: {
							hoverable: true,
						},
						tooltip:true,
				});
			}
	});
	
}
$(document).ready(function() {	
todayViews();
totalViews();
topPlatforms();
});