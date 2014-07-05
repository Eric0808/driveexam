// load.js


// set city
(function(){
	try{
		var arr = document.cookie.match(new RegExp("(^| )city=([^;]*)(;|$)"));
		if( arr && arr[2] ){
			document.getElementById('cityname').innerHTML = decodeURIComponent(arr[2]);
			return;
		}
	}catch(e){}
	var s = document.createElement('script');
	s.src="http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=js";
	s.type="text/javascript";
	s.onload = s.onreadystatechange = function(){
	if(  ! this.readyState || this.readyState=='loaded' || this.readyState=='complete' ){
		if(typeof remote_ip_info != null ){
			var name = remote_ip_info.province;
			area.setArea(name);
		}
	}
	};
	document.body.appendChild(s);
}());

var addFavorite = function(url, title){
	try{
		if (window.sidebar) { 
			window.sidebar.addPanel(title, url, null); 
		}else if( document.all ) {
			window.external.AddFavorite(url, title);
		}else{
			throw "抱歉，您的浏览器不支持自动加入收藏夹，请使用ctrl+D添加";
		}
	}catch(e){
		alert(e);
	}
};


// get top news
(function(){
	var ajax = new XMLHttpRequest();
	ajax.open('GET', base_url+'news/top/');
	ajax.onreadystatechange= function(){
		if( ajax.readyState !== 4 ) return ;
		try{
			if( ajax.status <200 || ajax.status >=400 ){
				throw "服务器错误";
			}
			var user = document.getElementById('topnews');
			if( ajax.responseText.length > 0 )
				user.innerHTML = ajax.responseText;
		}catch(e){
			message && message.show('当前加载头条置顶新闻失败', 7000);
		}
	}
	ajax.send();
})();


// get user info
(function(){
	if( document.cookie.indexOf('id=')!==-1 && 
		document.cookie.indexOf('ismember=1')!==-1 ){
		var ajax1 = new XMLHttpRequest();
		ajax1.open('GET', base_url+'user/info/');
		ajax1.onreadystatechange= function(){
			if( ajax1.readyState !== 4 ) return ;
			try{
				if( ajax1.status <200 || ajax1.status >=400 ){
					throw "服务器错误";
				}
				var user = document.getElementById('userinfo');
				if( ajax1.responseText.length > 0 )
					user.innerHTML = ajax1.responseText;
			}catch(e){
				message && message.show('当前加载用户信息失败', 7000);
			}
		}
		ajax1.send();
	}
})();