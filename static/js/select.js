// main.js


function _select(set, show)
{
	var self = this;

	this.set = set;
	this.show = show;
	
	this.isfocus = false;

	this.set.onmouseover = function(){
		self.showAreaChoose();
		self.isfocus = 1;
		self.hiddenArea();
	}

	this.set.onmouseout = function(){
		self.isfocus = false;
		self.show.onmouseover = function(){
			self.isfocus = 2;
			self.hiddenArea();
		}
		self.show.onmouseout = function(){
			self.isfocus = false;
		}
	}

	this.hiddenArea = function(){
		clearTimeout(this.work);
		this.work = setTimeout( 
		function(){
			if( self.isfocus == false ){
				setTimeout(function(){self.show.style.display = 'none';}, 100);
				self.show.className = 'selectnone';
			}else{
				self.hiddenArea();
			}
		}, 100);
	}

	this.showArea = function(){
		self.show.className = 'selectaction';
		self.show.style.display = 'block';
	}

}


var area = new _select( document.getElementById('setarea'), 
					document.getElementById('area') );
area.show.style.top = area.set.offsetTop + 20 +'px';
area.show.style.left = ((area.set.offsetLeft-(area.show.style.width/2))) +'px';

area.setArea = function(id){
	var ajax = new XMLHttpRequest(),
		url = base_url+'city/change/'+encodeURIComponent(id)+'/';
	ajax.open('GET', url);
	ajax.onreadystatechange = function(){
		if(ajax.readyState!==4){
			return ;
		}
		document.getElementById('cityname').innerHTML = ajax.responseText;
		
		var exdate=new Date()
		exdate.setDate(exdate.getDate()+cookieexpiredays)
		if( typeof ajax.responseText === 'string' && ajax.responseText.length < 20 ){
			document.cookie="city=" +encodeURIComponent(ajax.responseText)+";path=/;expires="+exdate.toGMTString();
		}
	}
	ajax.send();
}

area.showAreaChoose = function(){
	if( area.show.firstChild !== null){
		return area.showArea();
	}
	var ajax = new XMLHttpRequest();
	ajax.open('GET', base_url+'city/');
	ajax.onreadystatechange = function(){
		if(ajax.readyState!==4){
			return ;
		}
		area.show.id = 'area';
		area.show.innerHTML = ajax.responseText;
		area.showArea();
	}
	ajax.send();
}









var subject = new _select( document.getElementById('setsubject'), 
					document.getElementById('subject') );
subject.show.style.top = subject.set.offsetTop + 20 +'px';
subject.show.style.left = ((subject.set.offsetLeft-(subject.show.style.width/2))) +'px';

subject.setSubject = function(id){
	var ajax = new XMLHttpRequest(),
		url = base_url+'subject/change/'+id+'/';
	ajax.open('GET', url);
	ajax.onreadystatechange = function(){
		if(ajax.readyState!==4){
			return ;
		}
		try{
			var response = JSON.parse(ajax.responseText);
		}catch(e){
			typeof console !== 'undefined' && console.log('获取科目数据出错', ajax.responseText);
			return ;
		}

		document.getElementById('subjectname').innerHTML = response.name;
		var exdate=new Date();
		exdate.setDate(exdate.getDate()+cookieexpiredays);
		document.cookie="subjectid=" +encodeURIComponent(response.id)+";path=/;expires="+exdate.toGMTString();
		
		if( document.cookie.indexOf('subjectid') !== -1 ){
			window.location.reload();
		}
	}
	ajax.send();
}

subject.showAreaChoose = function(){
	if( subject.show.firstChild !== null){
		return subject.showArea();
	}
	var ajax = new XMLHttpRequest();
	ajax.open('GET', base_url+'subject/');
	ajax.onreadystatechange = function(){
		if(ajax.readyState!==4){
			return ;
		}
		subject.show.id = 'subject';
		subject.show.innerHTML = ajax.responseText;
		subject.showArea();
	}
	ajax.send();
}



if( document.cookie.indexOf('subjectid') === -1 ){
	subject.setSubject(0);
} 













