chrome.runtime.onInstalled.addListener(function() {
	chrome.tabs.create({
		selected: true,
		url: "http://incentive.ketupat.me/php/signup.php"
	});
});

chrome.runtime.onMessage.addListener(
  function(request, sender, sendResponse) {
    console.log(sender.tab ?
                "from a content script:" + sender.tab.url :
                "from the extension");
    if (request.whatIsTax.length>0){
    	//sendResponse({farewell:"uh oh"})
	    $.post("http://incentive.ketupat.me/php/api.php", {'uid':uid,'action':'getTax'}).done(function(data){
	    		theTaxes = $.parseJSON(data);
	    		chrome.storage.sync.set({'taxes': theTaxes}, function() {
				  message('Settings saved');
				});
				sendResponse({farewell: userTaxes});
		}).always(function(){sendResponse({farewell:"test"})});
	    return true;
    }
});