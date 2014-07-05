// show topic
// show.js
// 0 => 判断
// 1 => 单选
// 2 => 多选


function _show()
{
	var self = this;

	this.prefix_id = 'quesion_show_';
	
	this.render = {
		image: document.getElementById('image'),
		tip: document.getElementById('tip'),
		question: document.getElementById('question'),
		items: document.getElementById('items'),
		item1: document.getElementById('item1'),
		item2: document.getElementById('item2'),
		item3: document.getElementById('item3'),
		item4: document.getElementById('item4'),
		button: document.getElementById('button'),
		result: document.getElementById('result'),
		trueresult: document.getElementById('trueresult'),
		useranswer: document.getElementById('useranswer'),
		prev: document.getElementById('prev'),
		next: document.getElementById('next'),
		autonext: document.getElementById('autonext'),
		runtime: document.getElementById('runtime'),
		target: document.getElementById('target'),
		count: document.getElementById('count'),
		bar: document.getElementById('bar'),
		baron: document.getElementById('baron'),
		barnum: document.getElementById('barnum'),
		listid: document.getElementById('listid'),
		submit_checkbox: document.getElementById('submit_checkbox'),
		loadding: document.getElementById('loadding')
	};
	
	
	this.create = function(data, id){
		this.data = data;
		this.id	  = parseInt(id);;
		
		this.set('runtime');
		
		try{
			if(this.data.thumb === ''){
				this.set('image', this.data.image);
			}else{
				this.set('image', this.data.thumb);
			}
		}catch(e){
			message.show('设置图片出错', 5000);
		}
		
		//this.set('target', topic.getNumber(this.id));
		this.set('question', '<b>'+topic.getNumber(this.id)+'.</b>&nbsp;'+this.data.question);
		
		this.set('type', this.data.type);
		this.set('tip', this.data.type);
		this.set('result');
		this.set('useranswer');
		
		if( typeof examid!=='undefined' && examid > 0 ){
			var answer = topic.getAnswer(show.data.type, show.data.selected);
			answer && show.setText(show.render.result, answer);
		}
		
		this.set('prev', topic.prev);
		this.set('next', topic.next);
		
	}
	
	this.set = function(field, text){
		var render = this.render[field];
		switch(field){

			case 'target':
				var result = text;
			break;
			case 'tip':
				switch(text){
					case 0:
						var result = '判断题，请选择对错！';
					break;
					case 1:
						var result = '单选题，请您认为正确的一项！';
					break;
					case 2:
						var result ='多选题，请您认为正确的项并提交！';
					break;
					default:
						var result = '类型错误';
				}
			break;
			case 'listid':
				render.value = '';
			break;
			case 'runtime':
				var endtime=new Date(),
					result=endtime.getTime()-topic.starttime.getTime();
				
				if(result>9){
					if(result>99){
						if(result>999){
							result=result/100;
						}else{
							result='0.'+result;
						}
					}else{
						result='0.0'+result;
					}
				}else{
					result='0.00'+result;
				}

			break;
			case 'result':
				this.setClass(render, '');
				this.clear(render);
			break;
			case 'useranswer':
				this.clear(render);
			break;
			case 'image':
				this.clear(render);
				if( text ){
					if( this.data.image.indexOf('.swf') !== -1 ){
						var result = this.createSwf(this.data.image);
					}else{
						var result = this.createImage(text, this.data.image);
					}
				}
			break;
			case 'question':
				var result = text;
			break;
			case 'type':
				this.clear(this.render.item1);
				this.clear(this.render.item2);
				this.clear(this.render.item3);
				this.clear(this.render.item4);
				this.clear(this.render.button);
				this.clear(this.render.submit_checkbox);
				switch(text){
					case 0:
						/* this.data.item1 = this.data.item1 || '正确';
						this.data.item2 = this.data.item2 || '错误';*/
						this.setRadio('item1', this.data.item1);
						this.setRadio('item2', this.data.item2);
						this.setButton('item1', this.data.item1);
						this.setButton('item2', this.data.item2); 
					break;
					case 1:
						this.setRadio('item1', this.data.item1);
						this.setRadio('item2', this.data.item2);
						this.setRadio('item3', this.data.item3);
						this.setRadio('item4', this.data.item4);
						
						this.setButton('item1', this.data.item1);
						this.setButton('item2', this.data.item2);
						this.setButton('item3', this.data.item3);
						this.setButton('item4', this.data.item4);
					break;
					case 2:
						this.setCheckBoxButton('submit_checkbox', '完成选择');
						this.setCheckbox('item1', this.data.item1);
						this.setCheckbox('item2', this.data.item2);
						this.setCheckbox('item3', this.data.item3);
						this.setCheckbox('item4', this.data.item4);
						
						this.setButton('item1', this.data.item1);
						this.setButton('item2', this.data.item2);
						this.setButton('item3', this.data.item3);
						this.setButton('item4', this.data.item4);
					break;
					default:
						typeof console !== 'undefined' && console.log("类型异常:", this.data);
				}
			break;
			case 'prev':
			case 'next':
				var go = this.render[field];
				if( text === null ){
					go.disabled=true;
					break;
				}
				go.disabled=false;
				go.onclick = function(){topic.Q(text);};
			break;
		}
		
		if( this.render[field] !== null && typeof this.render[field] !== 'undefined' ){
			if( result!==null ){
				if( typeof result === 'object' ){
					this.clear(this.render[field]);
					this.render[field].appendChild(result);
				}else{
					if( typeof result === 'string' || typeof result === 'number' ){
						this.setText(this.render[field], result);
					}
				}
			}
		}
	}
	
	this.createImage = function(thumb, link){
		var div = document.createElement('DIV'),
			a   = document.createElement('A'),
			img = document.createElement('IMG'),
			alt = document.createElement('DIV');
		
		img.id = 'imgsrc';
		img.src = this.img_path + thumb;
		img.setAttribute('data-src', this.img_path + link);
		img.setAttribute('data-thumb', this.img_path + thumb);
		img.onmouseout = function(){
			img.src = img.getAttribute('data-thumb');
			document.getElementById('imgaltbox').style.display = 'block';
		}
		img.onmouseover = function(){
            img.src = img.getAttribute('data-src');
			document.getElementById('imgaltbox').style.display = 'none';
        }
		
		alt.innerHTML = '鼠标移到图片上查看原图';
		alt.id = 'imgaltbox';
		show.addClass('imgalt', alt);
		show.addClass('imgzoom', div);
		a.appendChild(img);
		div.appendChild(a);
		div.appendChild(alt);
		return div;
	}
	
	this.createSwf = function(srclink){
		var div = document.createElement('DIV'),
			a   = document.createElement('A'),
			en  = document.createElement('embed');
		en.id = "imgsrc";
		if( en === null || typeof en !== 'object' || en.nodeType !== 1){
			message.show('您的浏览器不支持播放flash动画，建议您换用其它较新的浏览器查看');
			return false;
		}
		srclink = this.img_path + srclink;
		show.addClass('imgzoom', div);
	

		en.src = srclink;
		en.setAttribute('wmode', 'transparent');
		en.setAttribute('quality', 'high');
		en.setAttribute('bgcolor', '#869ca7');
		en.setAttribute('width', '220');
		en.setAttribute('height', '175');
		en.setAttribute('align', 'middle');
		en.setAttribute('name', 'movie');
		en.setAttribute('play', 'true');
		en.setAttribute('loop', 'true');
		en.setAttribute('type', 'application/x-shockwave-flash');
		en.setAttribute('pluginspage', 'http://www.macromedia.com/go/getflashplayer');
		
		
		try{
		a.appendChild(en);
		div.appendChild(a);
		}catch(e){
			return false;
		}
		return div;
	}
	
	
	this.setRadio = function(name, value){
		var render = this.render[name];
		this.setInput(render, value, 'radio', 'item');
	}

	this.setCheckbox = function(name, value){
		var render = this.render[name];
		this.setInput (render, value, 'checkbox', 'item[]');
	}
	
	this.setCheckBoxButton = function(name, value){
		var button = document.createElement('BUTTON');
		button.onclick = function(){
			self.setAnswerResult(self.data.checkboxTmpClick);
		}
		this.addClass('button', button);
		this.setText(button, value);
		this.clear(this.render[name]);
		this.render[name].appendChild(button);
	}
	
	this.setInput = function(render, value, type, name){
		//var label = document.createElement('LABEL');
		var input = document.createElement('INPUT');
		input.type = type;
		input.name = name;
		input.style.display = 'none';//不让radio显示
		var name = this.getName(render.getAttribute('data-id'));
		input.setAttribute('data-name', name);
		var code = topic.getAnswerCode(this.data.type, input.getAttribute('data-name'));
		if( this.data.selected == code ){
			input.setAttribute('defaultChecked', true);
			input.checked = true;
		}
		
		if( self.data.type == 2 && self.data.checkboxTmpClick ){
			if( self.data.checkboxTmpClick.indexOf(name) !== -1 ){
				input.setAttribute('defaultChecked', true);
				input.checked = true;
			}
		}
		

		this.listen(input);

		if(self.data.type!=0){
		var target  = document.createElement('SPAN');
		this.setText(target, input.getAttribute('data-name'));
		var span  = document.createElement('SPAN');
		this.setText(span, value);}
		
		render.appendChild(input);
		if(self.data.type!=0){
		render.appendChild(target);
		render.appendChild(span);
				}
		//render.appendChild(label);
	
	}
	
	this.setButton = function(name, data)
	{
		var render = this.render[name],
			a = document.createElement('input');
			a.type="button";
		var input = render.getElementsByTagName('input')[0];
		if( ! input )	return ;
		a.value = input.getAttribute('data-name');
		
		a.onclick = function(){input.click();
					
					if( show.render.topiclist != null ){
					var obj = show.getItem(self.data.id);
					if( obj != null ){//alert(obj);
						//obj.appendChild(input.getAttribute('data-name'));
						//this.setText(obj, input.getAttribute('data-name')); 
						//var intext = obj.innerText;
						obj.innerHTML=topic.getNumber(this.id)+input.getAttribute('data-name');
					}
				}
		};
		
		this.render.button.appendChild(a);
	}
	
	
	this.setLoadding = function(open)
	{
		self.render.loadding.style.display = (open ? 'block' : 'none');
	}
	
	
	this.clear = function(box){
		while(box.firstChild){
			box.removeChild(box.firstChild);
		}
	}
	
	this.listen = function(input){
		input.onclick = function(){
			var answer = input.getAttribute('data-name');
				
			if( self.data.type == 2 ){
				self.data.checkboxTmpClick = self.data.checkboxTmpClick || '';
				if( input.checked === true ){
					self.data.checkboxTmpClick += answer;
				}else{
					self.data.checkboxTmpClick = self.data.checkboxTmpClick.replace(answer, '');
				}
			}else{
				self.setAnswerResult(answer);
			}
			
		}
	}
	
	
	this.setAnswerResult = function(answer){

		var code = self.getCode(answer);
		
		if( typeof self.data.firstSelected === 'undefined' ){
			self.data.firstSelected = code;
		}
		self.data.selected = code;

		if( show.render.topiclist != null ){
			var obj = show.getItem(self.data.id);
			if( obj != null ){
				var classValue = 'answer';
				show.removeClass('error', obj);
				show.removeClass('flag', obj);
				show.addClass(classValue, obj);
			}
		}


		if( self.data.selected == self.data.answer){
			self.setTrue();
		}else{
			self.setFalse();
		}
	
	}
	
	
	this.setResult = function(text, classValue){ 
		var answer = this.getName(this.data.answer);
		text = text.replace('{$answer}', answer);
		
		this.setClass(this.render.result, classValue);
		this.setText(this.render.result, text); 
	}
	
	this.setTrue = function(){
		
		PASSNUM = PASSNUM+1;
		
		var sid = topic.getCookie('subjectid');
		sid = parseInt(sid);
		
		if(sid==2|| sid==4 || sid==6){
			if(PASSNUM==45)
			{EV_modeAlert('ResultAreaHtml');}
		}
		if(sid==1|| sid==3 || sid==5){
			if(PASSNUM==90)
			{EV_modeAlert('ResultAreaHtml');}
		}
	
		var text = this.msg_true;
		this.setResult(text, 'answer_true');
		
			//if( typeof ISEXAM ==='undefined'){
				var msg = '回答正确! &nbsp;&nbsp;<b style="color:green;">'+ this.getName(this.data.answer) +'</b>';
				message.show(msg, 900);
			//}
			
	}
	
	this.setFalse = function(){
	
		var text = this.msg_false;
		this.setResult(text, 'answer_false');
		//var msg = '答错了，正确答案： &nbsp;&nbsp;<b style="color:green;">'+ this.getName(this.data.answer) +'</b>';
		//message.show(msg, 900);
		// if is first submit
		if( this.data.firstSelected === this.data.selected ){
			topic.addError(this.id);
		}
		
		if( this.nextcase === 'all' ){
			if( this.render.autonext.checked === true ){
				this.render.next.click();
			}
		}
		
	}
	
	
	
	this.clickBar = function(e){
		var n = self.barLeft,
			x = e.x || e.layerX || 0,
			width = x-n;
		index = (width / self.barWidth) * topic.count;
		index = Math.ceil(index);
		var k = topic.ids[index-1];
		topic.Q(k);
	}
	
	this.showBar = function (e) {
		var n = self.barLeft,
			x = e.x || e.layerX || 0,
			width = x-n;
		index = (width / self.barWidth) * topic.count;
		index = Math.ceil(index);
		self.render.baron.style.width = width+'px';
		self.setText(self.render.barnum, index);
		self.render.barnum.style.backgroundPosition = width + "px 0px";
		self.render.barnum.style.paddingLeft = width+'px';
	}

	this.setBar = function() {
		if( topic.count === 0 ){
			var really = 0;
		}else{
			var num = topic.getNumber(show.id);
			var really = (num / topic.count) * self.barWidth;
		}
		
		self.render.baron.style.width = really + 'px';
		self.setText(self.render.barnum, topic.getNumber(show.id));
		self.render.barnum.style.backgroundPosition = really + "px 0px";
		self.render.barnum.style.paddingLeft = really+'px';
	}
	

	
	
	
	this.getCode = function(id){
		var code = topic.getAnswerCode(this.data.type, id);
		return code;
	}
	
	this.getName = function(code){
		return topic.getAnswer(this.data.type, code);
	}
	
	
	this.setClass = function(render, text){
		render.className = text;
	}
	
	this.addClass = function( classname, element ) {
		if(  !element || typeof element !== 'object' ){
			return ;
		}
		var cn = element.className;
		if( cn.indexOf( classname ) !== -1 ) {
			return;
		}
		if( cn != '' ) {
			classname = ' '+classname;
		}
		element.className = cn+classname;
	}

	this.removeClass = function( classname, element ) {
		if(  !element || typeof element !== 'object' ){
			return ;
		}
		var cn = element.className;
		var rxp = new RegExp( "\\s?\\b"+classname+"\\b", "g" );
		cn = cn.replace( rxp, '' );
		element.className = cn;
	}
	
	
	this.getItem = function(id){
		var items = show.render.topiclist.getElementsByTagName('a');

		for(var k in items){
			if(  !items[k] || typeof items[k] !== 'object' )	continue;
			var data_id = items[k].getAttribute('data-id');
			data_id = parseInt(data_id);
			if( id === data_id ){
				return items[k]
			}
		}
	}
	
	this.setText = function(render, text){
		render.innerHTML = text;
	}
	
	this.getText = function(render){
		return render.innerText;
	}
}
