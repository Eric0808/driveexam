// COOKIE操作
function setcookie(n,v){var exp=new Date();exp.setTime(exp.getTime()+24*60*60*100);document.cookie=n+"="+escape(v)+";expires="+exp.toGMTString();}
function getcookie(n){var arr,reg=new RegExp("(^| )"+n+"=([^;]*)(;|$)");if(arr=document.cookie.match(reg)){return unescape(arr[2]);}else{return null;}}
// 驾照代码切换
function chgcars(id,type){
	carpass=type; // 加载用户最后的选择
	for(i=1;i<4;i++){
		if('p'+i==id){$('#p'+i).addClass('current');}else{$('#p'+i).removeClass('current');}
	}
	if(id=='p3'){$('.space').addClass('rline').css('width','249px');}else{$('.space').removeClass('rline').css('width','250px');}
	$('.htit span').html(type);
}
// 跳转
function gotourl(vkey,vurl){
	$.get('/ajax/change.asp',{act:'setpass',key:carpass+vkey,t:new Date().getTime()},function(data){if(data=='true') location.href=vurl;});
}
// 定义驾照代码
var carpass='';
// 主程序执行
$(function(){
	// 获取用户最后的驾照代码
	var carpass=getcookie('carpass')+'';
	// 智能判断知识
	switch(carpass.toLowerCase()){
		case 'a1':case 'a1_km1':case 'a1_km3':chgcars('p3','A1');break;
		case 'b2':case 'b2_km1':case 'b2_km3':chgcars('p2','B2');break;
		default:chgcars('p1','C1');break;
	}
	// 链接实例化
	$('.chgcars').mouseover(function(){chgcars($(this).attr('id'),$(this).attr('carpass'));});
	$('.chgcars').click(function(){chgcars($(this).attr('id'),$(this).attr('carpass'));});
});