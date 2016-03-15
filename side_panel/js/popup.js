$(document).ready(function(){
	var loginRequest;
	/*var curWidth = $(html).width();
	$('.xCenter').each(function(i,obj){
		obj.marginLeft(curWidth/2-obj.width()/2);
	});*/
	$('.xCenter').each(function(i,obj){
		$(obj).css("margin-left",function(){
			return ($(window).width()-$(obj).width())/2;
		});
	});
	$('#button').click(function(){
		var phpLoc = "http://keynes.ketupat.me/php/process_login.php";
		
		var loginEmail = $('#loginEmail').val();
		var loginPassword = $('#loginPassword').val();
		
		//alert(loginEmail+" "+loginPassword);
		
		loginRequest = $.ajax({
			url: phpLoc,
			method: "POST",
			data: { 'email': loginEmail, 'password': loginPassword }
		}).done(function(data, textStatus, jqXHR){
			$('.formField').each(function(i,obj){
				$(obj).removeClass('has-error');
			});
			$('#switchState').click();
		}).fail(function(jqXHR, textStatus, errorThrown){
			console.log("Error: "+jqXHR.status+" | "+textStatus+" | "+errorThrown);
			$('.formField').each(function(i,obj){
				$(obj).addClass('has-error');
			});
		}).always(function(){
			//DO Nothing
		});

	});
	$('#switchState').click(function(){
		$('#logged-in').toggle();
		$('#logged-out').toggle();
	});
	$('#disp-switch').click(function(){
		
	});
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