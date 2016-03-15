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
	});
	errData = dataReq.fail(function(jqXHR, textStatus, errorThrown){
		console.log(textStatus+"|"+errorThrown);
		$.cookie('curTaxData',"[{}]",{expires:1});
	});
	return;
}
function load_taxData(){
	if($.cookie('curTaxData')!=''){
		var jsonObj = JSON.parse($.cookie('curTaxData'));
		console.log(JSON.stringify(jsonObj));
		var totData = 0;
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
		}
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
		$('#disp-moneyTot').html("$"+totData.toString());
		$('#disp-taxTot').html("$"+totTData.toString());
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
function load_charityData(jsonObj){

}
function load_tax(){
	var numData = [];
	for(var i=0;i<7;++i){
		numData.push(Math.round(Math.random()*100+1));
	}
	var lineData = {
		labels:["1","2","3","4","5","6","7"],
		datasets:[
			{
				fillColor:"rgba(52,152,219,0.4)",
				strokeColor:"#2980B9",
				pointColor:"#FFF",
				pointStrokeColor:"#2C3E50",
				data:numData
			}
		]
	};
	return lineData;
}
function load_charity(){
	var pieData = [];
	var N = charityNames.length;
	var j=0;
	for(var i=0;i<360;){
		i+=360.0/(N);
		var Hue = i;
		var Sat = (90+Math.random()*10.0);
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
function plot_graphs(){
	$('#logged-in').show();
	$('#logged-out').hide();
	$('#signupBtn').hide();
	//Initialize canvas sizes for charts
	var cT = $('#chart-tax'),cTX=cT[0].getContext('2d');
	var cC = $('#chart-charity'),cCX=cC[0].getContext('2d');
	cTX.canvas.height = $(window).width()/2;
	cTX.canvas.width = $(window).width()-10;
	cCX.canvas.height = $(window).width()/2;
	cCX.canvas.width = $(window).width()/2;
	//var taxData=load_tax();			//Random Data
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
			return ($(window).width()-$(obj).width())/2;
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
		$('#disp-data').scrollTop = $('#disp-data').scrollHeight;
	};
	return;
}
$(document).ready(function(){	
	//Use slimScroll instead of the default scrollbars
	$(function(){
		$('#disp-data').slimScroll();
	});
	
	//Initialize all accordions to be collapsed
	$('#collapseOne').collapse("hide");
	$('#collapseTwo').collapse("hide");
	if($('#disp-tax-toggle').hasClass('collapsed')){
		$('#disp-tax').removeClass('fui-triangle-up-small');
		$('#disp-tax').addClass('fui-triangle-down-small');
	}
	else{
		$('#disp-tax').removeClass('fui-triangle-down-small');
		$('#disp-tax').addClass('fui-triangle-up-small');
	}
	if($('#disp-charity-toggle').hasClass('collapsed')){
		$('#disp-charity').removeClass('fui-triangle-up-small');
		$('#disp-charity').addClass('fui-triangle-down-small');
	}
	else{
		$('#disp-charity').removeClass('fui-triangle-down-small');
		$('#disp-charity').addClass('fui-triangle-up-small');
	}
	
	//Run a login Session check` first to establish base case...
	var sessionCookie = $.cookie('uid');
	$.ajax({
		url: "http://incentive.ketupat.me/php/verify_session.php",
		method: "POST",
		data: {}
	}).done(function(data, textStatus, jqXHR){
		if(data==-1){
			$('#logged-in').hide();
			$('#logged-out').show();
		}
		else{
			if(typeof sessionCookie === 'undefined'||$.cookie('uid')!=data){
				$.cookie('uid',data,{expires: 365});
				$.cookie('curTaxData','',{expires: 1});
			}
			load_data();
			plot_graphs();
		}
	}).fail(function(jqXHR, textStatus, errorThrown){
		console.log(textStatus+"|"+errorThrown);
	}).always(function(){
	
	});
	
	//General horizontal centering program with class xCenter
	$('.xCenter').each(function(i,obj){
		$(obj).css("margin-left",function(){
			return ($(window).width()-$(obj).width())/2;
		});
	});
	
	//Login functionality
	$('#loginButton').click(function(){
		var phpLoc = "http://incentive.ketupat.me/php/process_login.php";
		
		var loginEmail = $('#loginEmail').val();
		var loginPassword = $('#loginPassword').val();
		var loginSubmit = $('#loginButton').val();
		
		$.ajax({
			url: phpLoc,
			method: "POST",
			data: { 'email': loginEmail, 'password': loginPassword, 'submit': loginSubmit }
		}).done(function(data, textStatus, jqXHR){
			if(data==-1){
				$('.formField').each(function(i,obj){
					$(obj).addClass('has-error');
				});
			}
			else{
				$('.formField').each(function(i,obj){
					$(obj).removeClass('has-error');
				});
				load_data();
				plot_graphs();
			}
		}).fail(function(jqXHR, textStatus, errorThrown){
			console.log("Error: "+jqXHR.status+" | "+textStatus+" | "+errorThrown);
		}).always(function(){
			//DO Nothing
		});
	});
	
	//DEBUG Switching case button
	$('#signupBtn').click(function(){
		window.open('http://incentive.ketupat.me/php/signup.php','_blank');
	});
	
	//DEBUG Logout function
	$('#logoutBtn').click(function(){
		$.ajax({
			url: "http://incentive.ketupat.me/php/process_logout.php",
			method: "POST",
			data: {}
		}).done(function(data, textStatus, jqXHR){
			if(typeof sessionCookie !== 'undefined'){
				$.removeCookie('uid');
			}
			$("#body").animate({height:'toggle',opacity:'toggle'},'fast',function(){window.close();});
		}).fail(function(jqXHR, textStatus, errorThrown){
			console.log(textStatus+"|"+errorThrown);
		}).always(function(){
			
		});
	});
	
	//Toggle viewing of statistics
	$('#disp-tax-toggle').click(function(){
		if($('#disp-tax-toggle').hasClass('collapsed')){
			$('#disp-tax').removeClass('fui-triangle-down-small');
			$('#disp-tax').addClass('fui-triangle-up-small');
		}
		else{
			$('#disp-tax').removeClass('fui-triangle-up-small');
			$('#disp-tax').addClass('fui-triangle-down-small');
		}
	});
	$('#disp-charity-toggle').click(function(){
		if($('#disp-charity-toggle').hasClass('collapsed')){
			$('#disp-charity').removeClass('fui-triangle-down-small');
			$('#disp-charity').addClass('fui-triangle-up-small');
		}
		else{
			$('#disp-charity').removeClass('fui-triangle-up-small');
			$('#disp-charity').addClass('fui-triangle-down-small');
		}
	});
	
	//Reset Login Error Displays
	$('#loginEmail').focus(function(){
		$('.formField').each(function(i,obj){
			$(obj).removeClass('has-error');
		});
	});
	$('#loginPassword').focus(function(){
		$('.formField').each(function(i,obj){
			$(obj).removeClass('has-error');
		});
	});
});