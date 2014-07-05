/**
 -------------  get question for JSON --------------
 
 */

 function question()
 {
	this.data = [];
	
	// 最底层的分类
	this.child = [];
	this.qboxs = [];
	
	
	var that = this;
	
	this.prefix_id = 'category-tree-id-';
	this.box_id    = 'box-tree-id-'
	
	this.run = function(){
		this.setCategoryOfQuestion(this.data.child);
		
		if(typeof this.child[0] == 'object'){
			var i = 0, data=[];
			while(data.length <= 0){
				if(typeof this.child[i] == 'object')
					var data = this.getQuestion(this.child[i].id);
				else
					break ;
				i++;
			}
			this.createQ(data);
			this.next(0);
		}
		
	}
	
	
	
	this.next = function(id){
		try{
			if(typeof this.qboxs[id] == 'undefined'){
				var end = false, cid =0;
				if( typeof this.qboxs[this.qboxs.length-1] != 'undefined' ){
					var ncid  = this.qboxs[this.qboxs.length-1].getAttribute('data-pid');
				}else{
					var end = true;
				}

				for(var n in this.child){
					if(end)	{
						var cid = this.child[n].id;
						break;
					}
					if(this.child[n].id == ncid){
						var end = true;
					}
				}
				if(cid == 0){
					alert('往后没有试题了');
					document.getElementById('page-next-a').href="#";
					document.getElementById('page-next-a').innerHTML = '没有题目可供显示';
				} 
			
				this.createHead(cid);
				var data = this.getQuestion(cid);
				this.createQ(data);
				
				if(typeof this.qboxs[id] == 'undefined'){
					document.getElementById('page-next-a').href="#";
					document.getElementById('page-next-a').innerHTML = '没有题目可供显示';
					return;
				}
				
			}
		

			if(typeof this.qboxs[id-1] !== 'undefined'){
				document.getElementById('page-pre-a').href = 'javascript:Q.prev('+(id-1)+')';
				document.getElementById('page-pre-a').innerHTML = '上一页';
			}
			
			this.createHead(this.qboxs[id].getAttribute('data-pid'));
			
			
			if(typeof this.qboxs[id-1] != 'undefined'){
				this.qboxs[id-1].style.display = 'none';
			}
			document.getElementById('page-pre-a').href = 'javascript:Q.prev('+(id-1)+')';
			document.getElementById('page-next-a').href = 'javascript:Q.next('+(id+1)+')';
			this.qboxs[id].style.display = 'block';
		}catch(err){}
	}
	
	this.prev = function(id){
		try{
		if(typeof this.qboxs[id] == 'undefined'){
			if(typeof this.qboxs[id] == 'undefined' ){
				document.getElementById('page-pre-a').href="#";
				document.getElementById('page-pre-a').innerHTML = '没有题目可供显示';
				return;
			}
		}
		if(typeof this.qboxs[id-1] == 'undefined'){
			document.getElementById('page-pre').href="#";
			if(typeof this.qboxs[id+1] !== 'undefined'){
				document.getElementById('page-next-a').href = 'javascript:Q.next('+(id+1)+');';;
				document.getElementById('page-next-a').innerHTML = '下一页';
			}
		}
		
		this.createHead(this.qboxs[id].getAttribute('data-pid'));
		
		if(typeof this.qboxs[id+1] !== 'undefined'){
			this.qboxs[id+1].style.display = 'none';
		}
		
		document.getElementById('page-pre-a').href = 'javascript:Q.prev('+(id-1)+');';
		document.getElementById('page-next-a').href = 'javascript:Q.next('+(id+1)+');';
		this.qboxs[id].style.display = 'block';
		}catch(err){}
	}
	
	
	
	this.checkNone = function(){
		var length = this.child.length;
		var tmp    = [];
		for(var k in this.child){
			for(var n in this.qboxs){
				var cid = this.qboxs[n].getAttribute('data-pid');
				cid = parseInt(cid);

				if(this.child[k].id == cid && typeof tmp[cid] =='undefined' ){
					tmp[cid] = true;
					length--;
				}
			}
		}
		return length;
	}
	

	
	this.getQuestion = function(id){
		 var http = createHttp();
		 http.open('GET', '../get/'+id+'/', false);
		 var data = {};
		 
		 var contin = false;
		 for(var k in this.child){
			if(this.child[k].id == id){
				contin = true;
			}
		 }
		
		 if( !contin ) return data; 
		 
		 
		 http.onreadystatechange=function()
		 {
			if (http.readyState==4){
				if( http.status==200 ){
					try{
							if( typeof JSON == 'object' ){
								data = JSON.parse(http.responseText);
							}else{
								data = eval('(' + http.responseText + ')');
							}
							
							if(data.length === 0){
								data[0] = {
										id: 0,
										csid:'0000000000',
										question: '这个类型下并没有试题，请点击下一页',
										option: {},
										picture: '',
										cid: id
									
									};
							}
							
					}catch(e){
						typeof console !== 'undefined' ? console.log(http.responseText) : alert(http.responseText);
					}
				}else if(http.status==404 || http.status==500 ){
					alert('加载试题失败。如果问题频繁，请重新打开考试页面');
				}
			}
		 }
		 http.send();
		 
		 return data;
	}

	
	this.createQ = function(data){
		var first = false;
		if( typeof data == null){
			return false;
		}		
		for(var k in data)
		{
			try{
				var question_section = this.createQuestion(data[k]);
				if( first ){
					first=false;
				}else{
					question_section.style.display = 'none';
				}
				
				this.qboxs.push(question_section);
				this.box.appendChild(question_section);
			}catch(err){

			}
		}
	}
	
	
	
	
	this.setCategoryOfQuestion = function(child){
		for(var k in child){
			
			var childInfo = {id:child[k].id, name:child[k].name};
			this.child.push(childInfo);
			
			if(typeof child[k].child === 'object' && child[k].child.length >0){
				that.setCategoryOfQuestion(child[k].child);
			}
		}
	}
	
	

	this.createQuestion = function(data){
		if(typeof data !== 'object' || data === null){
			return false;
		}
		var q = document.createElement('div');
		q.setAttribute('class', 'section-question');
		q.setAttribute('className', 'section-question');
		q.setAttribute('data-pid', data.cid);
		var s = document.createElement('p');
		var r = document.createElement('div');
		r.setAttribute('class', 'section-answer');
		r.setAttribute('className', 'section-answer');
		s.innerHTML = data.question;
		
		
		for(var k in data.options){
			var o = document.createElement('div');
			o.setAttribute('class', 'section-input');
			o.setAttribute("className", 'section-input');
			o.onclick = function(){checkedRadio(this);};
			var a = document.createElement('span');
			a.innerHTML = k;
			var i = document.createElement('input');
			i.setAttribute('type', 'radio');
			i.setAttribute('name', 'Q['+data.cid+']['+data.id+']');
			i.setAttribute('value', k);
			var t = document.createElement('span');
			t.innerHTML = data.options[k];
			
			o.appendChild(a);
			o.appendChild(i);
			o.appendChild(t);
			r.appendChild(o);
		}
		q.appendChild(s);
		
		if(typeof data.picture == 'string' && data.picture != '' ){
			var img = document.createElement('img');
			img.setAttribute('src', this.base_url + data.picture);
			img.style.width = 'auto';
			img.style.maxWidth = '80%';
			q.appendChild(img);
		}

		q.appendChild(r);
		return q;
	}
	
	
	this.createHead = function(cid){
		this.categoryHead.innerHTML = '';
		
		var category_info = lookInfo(cid, category_data);
		if(typeof category_info !== 'object'){
			return false;
		}

		var h = document.createElement('div');
		var s = document.createElement('span');
		s.innerHTML = '(共'+ category_info.weight +'分)';
		h.innerHTML = category_info.name;
		h.appendChild(s);
		this.categoryHead.appendChild(h);

	}
	
	
	
	this.addEventListen = function(id){
		
	}
	
	
	this.showTime = function(){
		var time=UseTime-=10; msg='', hour=0, min=0, sec=0;
		if(time < 360){
			if(time < 0){
				document.getElementById('exam').submit();
				return;
			}else{
				that.error.innerHTML = '剩余'+ Math.floor(time/60) +'即将强制交卷';
			}
		}
		(hour = Math.floor(time/3600))  	&& (msg += hour+'时');
		(min  = Math.floor((time%3600)/60) )&& (msg += min +'分');
		(sec  = Math.floor(time%60) ) 		&& (msg += sec +'秒');
		that.t.innerHTML = msg;
		
	}
	
	
	this.fixTime = function(){
		var http = createHttp();
		http.open('GET', '../time/'+this.data.id+'/', false);
		var data = {};
		http.onreadystatechange=function()
		{
			if (http.readyState==4 && http.status==200){
				try{
					var time = parseInt(http.responseText);
					if( !isNaN(time) ){
						UseTime = time;
					}
				}catch(e){
					if( typeof console !== 'underfined' ) 
						console.log(http.responseText);
				}
			}
		}
		http.send();
	}
	
}

 
 
 var checkedRadio = function(e){
	e.getElementsByTagName('input')[0].checked='On';
 }
 
 var lookParent = function(i, category, pid){
	for(var k in category){
		if( category[k].id == i ){
			return pid;
		}else{
			return lookParent(i, category[k].child, category[k].id);
		}
	}
 }

 var lookInfo = function(id, category){
	if( category.id == id ){
		return category;
	}else{
		for(var k in category.child){
			if( category.child[k].id == id ){
				return category.child[k];
			}else{
				var cid = lookInfo(id, category.child[k]);
				if(typeof cid !=='undefined' ){
					return cid;
				}
			}
		}
	}
	
 }
