// adds mobile browser class to html tag
var ua = navigator.userAgent.toLowerCase();
	function removeSpaces(ua) {
		return ua.split(' ').join('');
	}
	ua = removeSpaces(ua);
var iOS = ua.match(/(iphone|ipod|ipad)/);
	if(iOS) {
		$('html').addClass('ios');
	}
var iPad = ua.match(/(ipad)/);
	if(iPad) {
		$('html').addClass('ios');
	}
var iPhone = ua.match(/(ios)/);
	if(iPhone) {
		$('html').addClass('ios');
	}
var android = ua.indexOf("android") > -1; 
	if(android) {
		$('html').addClass('android');
	}
var android4 = ua.indexOf("android") > -1; 
	if(android4) {
		$('html').addClass('android');
	}
var android2 = ua.indexOf("android") > -1; 
	if(android2) {
		$('html').addClass('android');
	}
