
	/*chrome.storage.sync.get('on',function(isOn){
		if(isOn){
			throw new Error("you turned Keynes off");
		}
	});*/

	//get user id
	var uid = 5;

	var userTaxes = NaN;
	$.post("http://incentive.ketupat.me/php/verify_session.php").done(function(data){
		if(data === '-1'){
			alert("not logged in. pls log in in extension")
		} else {
			$.post("http://incentive.ketupat.me/php/api.php", {'uid':data,'action':'getTax'}).done(function(taxRates){
	    		userTaxes = $.parseJSON(taxRates);
	    		//console.log(userTaxes)
	    		$("a.nav-logo-tagline.nav-sprite.nav-prime-try").text("Try Guan Today!");

				var allPrices = [];

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
				$("div.product #listPrice,table.product td.listPrice").remove();
				$("div.product #youSave,table.product tr.savingsRow").remove();
				allPrices.push(
					new impulseBuy(
						$("div.buying #btAsinTitle").text().trim(),
						$("div.product b.priceLarge").length>0 ? $("div.product b.priceLarge") : $("table.product b.priceLarge")
					)
				);

				//alternative main product (for irritating pages)
				allPrices.push(
					new impulseBuy(
						$("#productTitle").text().trim(),
						$("#priceblock_ourprice")
					)
				);

				//Accessories
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

				//similar products
				$("#purchase-sims-feature li.a-carousel-card,#session-sims-feature li.a-carousel-card").each(function(i,v){
					allPrices.push(
						new impulseBuy(
							$(this).children("div").children("a.a-link-normal").text().trim(),
							$(this).children("div").children("div.a-row:last").children("span.a-size-base.a-color-price")
						)
					);
				});

				//sponsored products
				$("#sponsored-products-dp_feature_div ul.a-carousel li.shoveler-cell").each(function(i,v){
					allPrices.push(
						new impulseBuy(
							$(this).children("div").children("a").children("div.a-row").text().trim(),
							$(this).children("div").children("div.a-row.a-color-price").children().remove()
						)
					);
				});

				//searchResults
				$("#searchTemplate #atfResults li").each(function(i,v){
					if($(this).find("hr.a-divider-normal.s-result-divider").length>0){
						//subsribe and save deals
						$(this).find("div.a-row:nth-of-type(3)").remove()
						$(this).find("div.a-row:nth-of-type(3)").remove()
						$(this).find("hr").remove();
					}
					$(this).find("span.a-size-base.a-color-price.a-text-bold:not(span.a-size-base.a-color-price.a-text-bold:first)").remove()
					allPrices.push(
						new impulseBuy(
							$(this).find("h2.a-size-base.a-color-null.s-inline.s-access-title.a-text-normal,h2.a-size-medium.a-color-null.s-inline.s-access-title.a-text-normal").text().trim(),
							$(this).find("span.a-size-base.a-color-price.s-price.a-text-bold")
						)
					);
				});

				//remove sponsored products from searchResults
				$("div.pa-sponsored-products-atf").remove();

				//remove alternative prices for other formats (books/media)
				$("table.twisterMediaMatrix").remove();
				$("#MediaMatrix").remove();

				//Shopping Cart
				//check if in cart region then do this
				if(document.title === "Amazon.com Shopping Cart"){
					var itemTotal = 0;
					//modify cart
					$("#sc-active-cart div.sc-list-body div.a-row.sc-list-item").each(function(i,v){
						$(this).find("span.a-size-small.a-color-secondary.a-inline-block").remove();
						//alert($(this).find("div.a-row.sc-list-item.sc-list-item-border").getAttribute(""));
						itemInCart = new impulseBuy(
								$(this).find("a.a-link-normal.sc-product-link>span").text().trim(),
								$(this).find("span.a-size-medium.a-color-price.sc-price.sc-white-space-nowrap.sc-product-price.sc-price-sign.a-text-bold")
							)
						category = decideCategory(itemInCart);
						itemInCart.setCategory(category)
						itemTotal += itemInCart.inflatePrice(userTaxes[category]);
						itemInCart.deleteID = $(this).attr("data-itemid");
						allPrices.push(itemInCart);
					});	
					//update total(s)
					$("#gutterCartViewForm span.a-size-medium.a-color-price.sc-price.sc-white-space-nowrap.sc-price-sign").text("$"+itemTotal.toFixed(2));
					$("div.sc-subtotal.a-text-right.a-float-right span.a-size-medium.a-color-price.sc-price.sc-white-space-nowrap.sc-price-sign").text("$"+itemTotal.toFixed(2));

					//remove calculate tax
					$("div.a-box.sc-flc.sc-invisible-when-no-js").remove();

					//remove suggestions
					$("#sc-rec-right").remove();

					//add our own button background: linear-gradient(to bottom,#ffb8c6,#ff7070);
			}
					$("#sc-buy-box-ptc-button span").css("background","linear-gradient(to bottom,#ffb8c6,#ff7070)").children("span").text("Checkout with Incentive");
					/*$("div.sc-proceed-to-checkout").children().remove().end().append(
						$("<a class='waves-effect waves-light btn-large amber darken-4'>")
						.text("Checkout with Incentive")
					);*/

				//haha, remove all the rest
				$("span[class='a-size-small a-color-price'],span[class='a-color-price'],span[class='a-size-small a-color-secondary a-text-strike']").remove();
				
				$(allPrices).each(function(i,v){
					console.log(v);
					if(v.rawPrice > 0){
						category = decideCategory(v);
						v.setCategory(category);
						v.priceObject.text("$"+v.inflatePrice(userTaxes[category]).toFixed(2));
						v.priceObject.attr("title","$"+v.rawPrice.toFixed(2)+" w/o tax of "+(userTaxes[category]*100)+"% for "+category);
					}
				});

				$("div.sc-proceed-to-checkout").off("click").click(function(event){
					var cart = [];
					$(allPrices).each(function(i,v){
						url = v.priceObject.parents("div.sc-list-item-content");
						if(url.length>0){
							itemId = url.find("a.a-link-normal.sc-product-link").attr("href").substr(12,10);
							v.setItemId(itemId);
							//console.log(itemId)
						}
						if(v.name.length > 0){
							item = {
								'name':v.name,
								'rawPrice':v.rawPrice,
								'taxedPrice':v.taxedPrice,
								'itemId':v.itemId,
								'deleteID':v.deleteID
							};
							cart.push(item);
						}
					});
					//console.log(JSON.stringify(cart));
					$.redirect('http://incentive.ketupat.me/php/payment.php', {'items': JSON.stringify(cart)});
					event.stopPropagation();
					return false;
				});
			});
		}
	});


function decideCategory(v){
	foodWords = ["natural","fresh","fruit","fuji","potato","lemon","food","healthy","snacks","candy","flavour","mushroom"];
	electronicWords = ["tablet","smartphone","android","wire","cable","computer","laptop","chromebook","ultrabook","ssd","hard drive","tv","electronics","1080p","dongle","usb"];
	clothesWords = ["sweater","shoe","shirt","jacket","dress","shirt","cloth","woven","cotton","denim","jeans"];
	mediaWords = ["comic book","book","novel","hardcover","romance","movie","digital","big hero 6","imitation game","the matrix","tale of two cities","fairytale","disney","interstellar","avengers","iron man","marvel","dc comics"]
	wordLists = [foodWords,electronicWords,clothesWords,mediaWords]
	categories = ["food","electronics","clothes","media","misc"]
	chosen = categories[4]
	$(wordLists).each(function(listIndex,wordList){
		$(wordList).each(function(wordIndex,word){
			name = v.name.toLowerCase()
			if(name.indexOf(word) > -1){
				console.log(word)
				console.log(categories[listIndex])
				chosen = categories[listIndex]
				//console.log(listIndex)
				//v.setCategory(categories[listIndex]);
				return false;
			}
		})
	});
	return chosen;
}