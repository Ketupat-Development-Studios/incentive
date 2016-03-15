chrome.pageAction.onClicked.addListener(function(){
	location.reload();
	isOn = chrome.storage.sync.get('on');
	chrome.storage.sync.set({'on': !isOn}, function() {
        message('Settings saved');
    });
});
