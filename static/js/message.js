// message.js

function _message(render)
{
	var self = this;
	this.render = render || document.getElementById('messageShow');
	this.timeout = 0;
	this.point = false;
	
	this.show = function(msg, lifetime){
		clearTimeout(self.timeout);
		self.render.innerHTML = msg;
		if( self.point ){
			self.pointShow(self.pointData);
		}else{
			var top = 140;
			self.render.parentNode.style.top = top+'px';
		}
		self.render.parentNode.style.display = 'block';
		self.render.parentNode.style.opacity = 1;
		
		if(lifetime!==null && lifetime>4){
			self.hide(lifetime);
		}
	}
	
	this.hide = function(lifetime){
		self.timeout = setTimeout(function(){
			self.render.parentNode.style.opacity = 0;
			self.timeout = setTimeout(function(){
				self.render.parentNode.style.display = 'none';
			}, 1000);
		}, lifetime);
	}
	
	this.pointShow = function(point){
		var box = self.render.parentNode;
		box.style.top = point.y +'px';
		box.style.left = point.x +'px';
	}
	
	
	this.setMousePoint = function(obj){
		self.point = true;
		var point = {x:0,y:0};
		
		if(typeof window.pageYOffset != 'undefined') {
			point.x = window.pageXOffset;
			point.y = window.pageYOffset;
		}else if(typeof document.compatMode != 'undefined' && document.compatMode != 'BackCompat') {
			point.x = document.documentElement.scrollLeft;
			point.y = document.documentElement.scrollTop;
		}else if(typeof document.body != 'undefined') {
			point.x = document.body.scrollLeft;
			point.y = document.body.scrollTop;
		}
		
		point.x = obj.offsetLeft - (obj.offsetWidth*0.6) - point.x;
		if( point.x < 0 )	point.x = 0-point.x;
		point.y = obj.offsetTop-(self.render.offsetHeight/2) - point.y;
		point.y += 40;
		
		self.pointData = point;
	}
	
	this.__setMousePoint = function(ev) {
		self.point = true;
		var point = {x:0,y:0};
	 
		if(typeof window.pageYOffset != 'undefined') {
			point.x = window.pageXOffset;
			point.y = window.pageYOffset;
		}else if(typeof document.compatMode != 'undefined' && document.compatMode != 'BackCompat') {
			point.x = document.documentElement.scrollLeft;
			point.y = document.documentElement.scrollTop;
		}else if(typeof document.body != 'undefined') {
			point.x = document.body.scrollLeft;
			point.y = document.body.scrollTop;
		}
		point.x += ev.clientX;
		point.y += ev.clientY;

		self.pointData = point;
	}
}

var message = new _message();
var showmsg = function(msg){
	message.show(msg, 3000);
}