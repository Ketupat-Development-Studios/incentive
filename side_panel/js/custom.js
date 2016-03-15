$(document).ready(function(){
	chrome.storage.sync.get('on',function(isOn){
		if(isOn){
			throw new Error("you turned Keynes off");
		}
	});
	
	$("a.nav-logo-tagline.nav-sprite.nav-prime-try").text("Try Guan Today!");

	var allPrices = [];
	/*
		a.kfs-link
		span.kfs-price
	*/

	//the top row of suggested products below the address bar
	$("a.kfs-link").each(function(i,v){
		allPrices.push(
			new impulseBuy(
				$(this).clone().children().remove().end().text().trim(),
				$(this).children("span.kfs-price").children().length>0 ? $(this).children("span.kfs-price").children().remove().end() : $(this).children("span.kfs-price")
			)
		);
	});

	//main product
	$("div.product #listPrice").remove();
	$("div.product #youSave").remove();
	allPrices.push(
		new impulseBuy(
			$("div.buying #btAsinTitle").text().trim(),
			$("div.product b.priceLarge")
		)
	);

	//Accessories
	/*$("#kbbExtraItemsBottom div.cBoxInner tr td:nth-of-type(2)").each(function(i,v){
		new impulseBuy(
			$(this).children("label").clone().children().remove().end().text().trim(),
			$(this).children("span")
		)
	});*/
	$("#kbbExtraItemsBottom div.cBoxInner tr td:nth-of-type(2)").each(function(i,v){
		var name = $(this).children("label").clone().children().remove().end().text().trim();
		if(name.length === 1){
			name = $(this).children("label").clone().children("a").text().trim()
		}
		var price = $(this).children("label").children("span[id*='price']");
		if(price.children().length > 0){
			price = price.children("del").remove()
		}
		allPrices.push(
			new impulseBuy(
				name,
				price
			)
		);
	});

	$(allPrices).each(function(i,v){
		console.log(v);
		if(v.rawPrice > 0){
			v.priceObject.text("$"+v.inflatePrice(2).toFixed(2));
		}
	});
});