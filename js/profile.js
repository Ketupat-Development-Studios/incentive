var charityNames = ["Every mother counts","Global Fund for women","Singapore Council of Women's Organizations","AWARE"];
var charityColor = {"Every mother counts":'#FFF',"Global Fund for women":'#FFF',"Singapore Council of Women's Organizations":'#FFF',"AWARE":'#FFF'};
function load_data(){
	var retData;
	var errData;
	var tmpJson;
	var dataReq = $.ajax({
		url: "http://incentive.ketupat.me/php/api.php",
		method: "POST",
		data: {'user_id':$.cookie('uid'),'howManyDays':7,'action':'getSummary'}
	});
	retData = dataReq.done(function(data, textStatus, jqXHR){
		$.cookie('curTaxData',data,{expires:1});
		//Initialize canvas sizes for charts
		var cT = $('#chart-tax');
		var cTX=cT[0].getContext('2d');
		var cC = $('#chart-charity');
		var cCX=cC[0].getContext('2d');
		cTX.canvas.height = $('#disp-tax-container').width()/2;
		cTX.canvas.width = $('#disp-tax-container').width()-10;
		cCX.canvas.height = $('#disp-donation-container').width()/2;
		cCX.canvas.width = $('#disp-donation-container').width()/2;
		plot_graphs(cTX,cCX);
	});
	errData = dataReq.fail(function(jqXHR, textStatus, errorThrown){
		console.log(textStatus+"|"+errorThrown);
		$.cookie('curTaxData',"[{}]",{expires:1});
	});
	dataReq.always(function(){
	});
	return;
}
function load_taxData(){
	console.log($.cookie('curTaxData'));
	if($.cookie('curTaxData')!=''){
		var jsonObj = JSON.parse($.cookie('curTaxData'));
		console.log(JSON.stringify(jsonObj));
		var totData = 0;
		var paidData = 0;
		var totTData = 0;
		var numData = [];
		var numTData = [];
		var dayLabels = [];
		for(var i=0;i<jsonObj.length;++i){
			var curObj=jsonObj[i];
			dayLabels.push(curObj['date']);
			numData.push(curObj['amount']);
			numTData.push(curObj['taxedAmount']+curObj['amount']);
			totData=totData+curObj['amount']+curObj['taxedAmount'];
			totTData+=curObj['taxedAmount'];
			paidData+=curObj['amount'];
		}
		
		dayLabels.reverse();
		numTData.reverse();
		numData.reverse();
		
		var lineData = {
			labels:dayLabels,
			datasets:[
				{
					fillColor:"rgba(231,76,60,0.4)",
					strokeColor:"#2980B9",
					pointColor:"#FFF",
					pointStrokeColor:"#2C3E50",
					data:numTData
				},
				{
					fillColor:"rgba(52,152,219,0.4)",
					strokeColor:"#2980B9",
					pointColor:"#FFF",
					pointStrokeColor:"#2C3E50",
					data:numData
				}
			]
		};	
		$('#disp-totAmt').html("$"+totData.toString());
		$('#disp-taxAmt').html("$"+totTData.toString());
		$('#disp-paidAmt').html("$"+paidData.toString());
	}
	else{
		var numData = [];
		var numTData = [];
		var dayLabels = [];
		var lineData = {
			labels:dayLabels,
			datasets:[
				{
					fillColor:"rgba(231,76,60,0.4)",
					strokeColor:"#2980B9",
					pointColor:"#FFF",
					pointStrokeColor:"#2C3E50",
					data:numTData
				},
				{
					fillColor:"rgba(52,152,219,0.4)",
					strokeColor:"#2980B9",
					pointColor:"#FFF",
					pointStrokeColor:"#2C3E50",
					data:numData
				}
			]
		};	
		$('#disp-moneyTot').html("$00.00");
		$('#disp-taxTot').html("$00.00");
	}
	return lineData;
}

function load_charity(){
	var pieData = [];
	var N = charityNames.length;
	var j=0;
	for(var i=0;i<360;){
		i+=360.0/(N);
		var Hue = i/2;
		var Sat = (50+Math.random()*10.0);
		var Lig = (50+Math.random()*4.0);
		var ranVal = Math.round(Math.random()*100);
		var ranCol = tinycolor({h: Hue,s: Sat,l: Lig});
		charityColor[charityNames[j]]=ranCol.toHexString();
		var curType = {value:ranVal,color:ranCol.toHexString(),label:charityNames[j]};
		pieData.push(curType);
		j++;
	}
	return pieData;
}
function plot_graphs(cTX,cCX){
	var taxData=load_taxData();
	var charityData=load_charity();
	var pieOptions = {
		segmentShowStroke: true,
		animateScale: false,
		responsive: false,
		showTooltips: false
	}
	var lChart = new Chart(cTX).Line(taxData);
	var pChart = new Chart(cCX).Pie(charityData, pieOptions);
	$('#chart-charity').each(function(i,obj){
		$(obj).css("margin-left",function(){
			return ($('#disp-donation-container').width()-$(obj).width())/2;
		});
	});
	cCX.canvas.onclick = function(evt){
		var activePoints = pChart.getSegmentsAtEvent(evt);
		var currentColor = '';
		currentColor = charityColor[activePoints[0].label];
		console.log(currentColor);
		$('#chart-curCol').css('background',currentColor);
		$('#chart-curLoc').html('<p>'+activePoints[0].label+'</p>');
		$('#chart-curVal').html('<p> $'+activePoints[0].value+'</p>');
	};
	return;
}
$(document).ready(function(){	
	//Run a login Session check first to establish base case...
	var sessionCookie = $.cookie('uid');
	$.cookie('curTaxData','',{expires: 1});
	if(sessionCookie>=0){
		load_data();
	}
	$('#preferencesBtn').click(function(){
		window.location.replace("http://incentive.ketupat.me/php/preferences.php");
	});
});