// exam.js

show.render.lasttime = document.getElementById('lasttime');
show.render.topiclist = document.getElementById('topiclist');
show.render.flag = document.getElementById('flag');
show.render.submit = document.getElementById('submit');


for(var k in topic.ids){
	if( ! topic.ids[k] || typeof topic.ids[k] !== 'number' ){
		continue;
	}
	var id = topic.ids[k];
	
	var a = document.createElement('A');
	a.setAttribute('data-id', id);
	a.href = 'javascript:topic.Q('+id+')';
	var num = 1+parseInt(k);
	show.setText(a, '<dd id="an_'+num+'">'+num+'</dd><dd class="a" id="bn_'+num+'"></dd>');

	show.render.topiclist.appendChild(a);
}

(function(){
var clear = document.createElement('span');
clear.className = 'clear';
show.render.topiclist.appendChild(clear);
})();


show.setResult = function(msg, classValue){
	var answer = topic.getAnswer(show.data.type, show.data.selected);
	if( answer ){
		show.setText(show.render.result, answer);
		/* message.setMousePoint(document.getElementById('exam'));
		if( message.pointData.x < 200 ){
			message.pointData.x = document.getElementById('exam').offsetLeft+120;
		}
		if( message.pointData.y < 60 ){
			message.pointData.y += 70;
		}
		message.pointData.y += 50; 
		message.show('您刚刚选择了&nbsp;&nbsp;<strong style="color:green;">'+ answer +'</strong>', 1000); */
	}
}

topic.usetime = 0;
topic.stop = false;

show.setTime = function(){
	if( show.timeout || topic.stop ){
		return ;
	}
	topic.usetime++;
	var f= topic.time *60;
	f=parseInt(f-topic.usetime);
	var f1='',f2='';
	f1=Math.floor(f/60);
	f2=Math.floor(f%60);
	if(f1<10)f1='0'+f1;
	if(f2<10)f2='0'+f2;
	show.setText(show.render.lasttime, f1+':'+f2);
	//
	if (document.cookie.length>0)
      {
      a_start=document.cookie.indexOf("activetime=")
      if (a_start==-1){
		EV_modeAlert('envon');
	   }
	}
	//
	if(f==300)
		message.show('离考试结束还有<b style="color:red;">5</b>分钟，请抓紧时间！', 30000);
	if(f<=0){
		message.show('考试时间到了，系统将自动交卷！', 10000);
		show.timeout = true;
		show.render.submit.click();
	}
	setTimeout(show.setTime, 999);
	
}



topic.Q = function(id){
	var obj = show.getItem(id);
	var classValue = 'select';
	if( typeof topic.currentid === 'number' ){
		show.removeClass(classValue, show.getItem(topic.currentid));
	}
	show.removeClass('error', show.getItem(id));
	show.addClass(classValue, show.getItem(id));
	this.getQuestion(id);
}


show.render.flag.onclick = function(){
	var obj = show.getItem(show.data.id);
	var classValue = 'flag';
	if( obj.className.indexOf(classValue) === -1){
		show.addClass(classValue, obj);
	}else{
		show.removeClass(classValue, obj);
	}
}


function _submit()
{
	this.items = show.render.topiclist.getElementsByTagName('A');
	this.submiturl = 'trueexam/submit/'+ examid +'/';

	this.checkNone = function(){
		var none = 0, all = 0;
		
		for(var k in this.items){
			if( this.items[k]==null || typeof this.items[k] !== 'object' ){
				continue;
			}
			var id = this.items[k].getAttribute('data-id');
			if( topic.data[id] == null || topic.data[id].firstSelected == null ){
				show.addClass('error', this.items[k]);
				none++;
			}
		}
		
		return {all:this.items.length, none:none};
	}
	
	this.getValue = function(){
		var postdata = [];
		
		for(var k in this.items){
			if( this.items[k]==null || typeof this.items[k] !== 'object' ){
				continue;
			}

			var topicid = this.items[k].getAttribute('data-id');
			if( ! topicid ){
				continue;
			} 
			if( topic.data[topicid] != null && topic.data[topicid].firstSelected != null ){
				var answer = topic.data[topicid].firstSelected;
			}else{
				var answer = '';
			}

			postdata.push([topicid, answer]);
		}
		
		return postdata;
	}

	this.send = function(data){
		var send = '';
		for(var k in data){
			if( ! data[k][0] ){
				continue;
			}
			send += (data[k][0] +'='+ data[k][1] +'&');
		}
		var ajax = new XMLHttpRequest();
		ajax.open('POST', base_url + this.submiturl);
		ajax.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		ajax.onreadystatechange = function(){
			message.hide(500);
			if( ajax.readyState !== 4 ){
				return ;
			}

			try{
				var response = JSON.parse(ajax.responseText);
				if( typeof response === 'object' ){
					message.show(response.msg+' 正在跳转到成绩详情页面', 3000);
				}
				if( response.code == 0 ){
					window.location.href= base_url+'scores/detail/'+examid;
				}
			}catch(e){
				alert('服务器遇到了未知的错误，或者也可能是您浏览器版本太老。建议您升级您的浏览器');
			}
		}
		ajax.send(send);
	}
}


show.render.submit.onclick = function(ev){
	var ev = ev || window.event;
	var submit = new _submit;
	if( ! show.timeout ){
		var num = submit.checkNone();
		if( num.none > 1 ){
			msg = '您还有 '+num.none+ ' /'+ num.all +'道题没做, 确定交卷吗?';
			if( ! confirm(msg) ){
				return ;
			}
		}
	}
	var data = submit.getValue();
	message.show("正在向服务器传送数据，请稍等 ...");
	submit.send(data);
}



var starttime = new Date();

// start !-!
topic.start();

// 计时
show.setTime();
