// topic.js

function _topic()
{
	var self = this;

	this.ids = [];
	this.url = '';
	
	this.callback = function(){};
	
	this.ajax = [];
	
	this.data = [];
	
	this.prev = null;
	this.next = null;
	
	this.code = new Array(
		'A', 'B', 'C', 'D',
		'AB', 'AC', 'AD', 'BC', 'BD', 'CD',
		'ABC', 'ABD','ACD', 'BCD', 'ABCD',
		'√', '×'
	);
	
	
	
	this.Q = function(id){
		if( typeof id !== 'number' ){
			return false;
		}
		this.getQuestion(id);
	}
	
	this.start = function(){
		for( var k in this.ids ){
			this.Q(this.ids[k]);
			return ;
		}
		message.show('抱歉，当前题库并没有任何试题，请您切换到其它题库看看', 8000);
	}
	
	this.getQuestion = function(id)
	{	
		this.starttime = new Date();
		this.currentid = parseInt(id);
		topic.setPrevNext(self.currentid);
		
		if( isNaN(this.currentid) ){
			message.show('往后没有试题了');
			return ;
		}
		
		if( typeof this.data[this.currentid] === 'undefined' ){
			var url  = this.url.replace('{$id}', id);
			try{
				this.ajax = new XMLHttpRequest();
			}catch(e){
				alert('抱歉，您的浏览器版本太老了，请升级到IE7+或换用其它浏览器');
			}
			show.setLoadding(true);
			this.ajax.open('GET', url);
				
			this.ajax.onreadystatechange = this.call;
			this.ajax.send();
		}else{
			self.callback(this.data[this.currentid], this.currentid);
		}
	}
	
	this.call = function(){
		if( self.ajax.readyState==4 ){
			if( self.ajax.status>=200 && self.ajax.status < 400){
				var json = self.ajax.responseText;
				try{
					self.data[self.currentid] = JSON.parse(json);
				}catch(e){
					message.show('试题加载错误，尝试跳往下一题', 2000);
					self.ignore();
				}
				setTimeout( function(){
					show.setLoadding(false);
					self.callback(self.data[self.currentid], self.currentid);
					}, 150);
			}else{
				self.ignore();
			}
		} 
	}
	
	this.ignore = function(){
		show.setLoadding(false);
		if( typeof self.next === 'number' ){
			self.Q(self.next);
		}else{
			message.show('试题加载错误，而且往后也没有试题了', 5000);
		}
	}

	this.setPrevNext = function(current){
		var last  = null;

		var offset = this.ids.indexOf(current);
		offset = parseInt(offset);
		if( offset === -1 ){
			return ;
		}else{
			this.prev = null; 
			this.next = null;

			var n = offset-1;
			while(n>-1 && !(this.prev= this.ids[n--]));
			var n = offset+1;
			while(n<=topic.count && !(this.next=this.ids[n++]));
		}

		this.prev || (this.prev=null);
		this.next || (this.next=null);
		if( this.data.length > 1 ){
			if( this.next === null ){
				message.show('往后没有试题了', 3000);
			}else if( this.prev === null ){
				message.show('往前没有试题了', 3000);
			}
		}

	}
	
	this.getNumber = function(id){	
		var n = this.ids.indexOf(id);
		return (n===-1) ? 1 : ++n;
	}
	
	
	this.addError = function(id, showmsg){
		var url = this.errorUrl.replace('{$id}', id);
		if(typeof this.data[id] !== 'object' || this.data[id].addError ){
			showmsg && message.show('您刚刚已经将这道题标记为错题了', 3000);
			return false;
		}
		this.data[id].addError = true;
		url = url.replace('{$answer}', this.data[id].firstSelected || 0);
		
		var ajax = new XMLHttpRequest();
		ajax.open('GET', url);
		ajax.onreadystatechange = function(){
			if( ajax.readyState !== 4 ){
				return ;
			}
			if( ajax.status===200 && ajax.responseText!=='' ){
				showmsg && message.show(ajax.responseText, 4000);
			}
		}
		ajax.send();
	}
	
	this.addRemove = function(id){
		var url = this.removeUrl.replace('{$id}', id);
		var ajax = new XMLHttpRequest();
		ajax.open('GET', url);
		ajax.onreadystatechange =  function(){
			if( ajax.readyState !== 4 ){
				return ;
			}
			if( ajax.status===200 && ajax.responseText!=='' ){
				message.show(ajax.responseText, 4000);
			}
		}
		ajax.send();
	}
	
	this.getAnswerCode = function(type, answer){
		if( typeof answer !== 'string' ){
			return false;
		}
		answer = answer.split('');
		answer = answer.sort().join('');
		var code = this.code.indexOf(answer);
		code = parseInt(code);
		if( code === -1 ){
			return false;
		}
		switch(type){
			case 0:
				code -= 14;
			break;
			case 2:
				(code>3) && (code+=2);
			case 1:
				code++;
		}
		code = parseInt(code);
		return code;
	}
	
	this.getAnswer = function(type, code){
		code = parseInt(code);
		switch(type){
			case 0:
				code += 14;
			break;
			case 2:
				(code>4) && (code-=2);
			case 1:
				code--;
		}
		return this.code[code];
	}
}






//用来记录要显示的DIV的ID值
var EV_MsgBox_ID=""; //重要

//弹出对话窗口(msgID-要显示的div的id)
function EV_modeAlert(msgID){
	topic.stop = true;
	//创建大大的背景框
	var bgObj=document.createElement("div");
	bgObj.setAttribute('id','EV_bgModeAlertDiv');
	document.body.appendChild(bgObj);
	//背景框满窗口显示
	EV_Show_bgDiv();
	//把要显示的div居中显示
	EV_MsgBox_ID=msgID;
	EV_Show_msgDiv();
}

//关闭对话窗口
function EV_closeAlert(){
	topic.stop = false;
	show.setTime();
	
	var msgObj=document.getElementById(EV_MsgBox_ID);
	var bgObj=document.getElementById("EV_bgModeAlertDiv");
	msgObj.style.display="none";
	document.body.removeChild(bgObj);
	EV_MsgBox_ID="";
}

//窗口大小改变时更正显示大小和位置
window.onresize=function(){
	if (EV_MsgBox_ID.length>0){
		EV_Show_bgDiv();
		EV_Show_msgDiv();
	}
}

//窗口滚动条拖动时更正显示大小和位置
window.onscroll=function(){
	if (EV_MsgBox_ID.length>0){
		EV_Show_bgDiv();
		EV_Show_msgDiv();
	}
}

//把要显示的div居中显示
function EV_Show_msgDiv(){
	var msgObj   = document.getElementById(EV_MsgBox_ID);
	msgObj.style.display  = "block";
	var msgWidth = msgObj.scrollWidth;
	var msgHeight= msgObj.scrollHeight;
	var bgWidth  = document.documentElement.clientWidth || document.body.clientWidth || 0;
	var bgHeight = document.documentElement.clientHeight || document.body.clientHeight || 0;
	var bgTop  = window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop || 0;
	var bgLeft = window.pageXOffset || document.documentElement.scrollLeft || document.body.scrollLeft || 0;
	var msgTop=bgTop+Math.round((bgHeight-msgHeight)/2);
	var msgLeft=bgLeft+Math.round((bgWidth-msgWidth)/2);
	msgObj.style.position = "absolute";
	msgObj.style.top      = msgTop+"px";
	msgObj.style.left     = msgLeft+"px";
	msgObj.style.zIndex   = "10001";
	
}
//背景框满窗口显示
function EV_Show_bgDiv(){
	var bgObj=document.getElementById("EV_bgModeAlertDiv");
	var bgWidth  = document.documentElement.clientWidth || document.body.clientWidth || 0;
	var bgHeight = document.documentElement.clientHeight || document.body.clientHeight || 0;
	var bgTop  = window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop || 0;
	var bgLeft = window.pageXOffset || document.documentElement.scrollLeft || document.body.scrollLeft || 0;
	bgObj.style.position   = "absolute";
	bgObj.style.top        = bgTop+"px";
	bgObj.style.left       = bgLeft+"px";
	bgObj.style.width      = bgWidth + "px";
	bgObj.style.height     = bgHeight + "px";
	bgObj.style.zIndex     = "10000";
	bgObj.style.background = "#777";
	bgObj.style.filter     = "progid:DXImageTransform.Microsoft.Alpha(style=0,opacity=60,finishOpacity=60);";
	bgObj.style.opacity    = "0.6";
}















