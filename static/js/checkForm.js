// check form in client

function checkForm(form)
{
	this.msg = [];
	
	
	this.checkNumeric = function(str){
		if( typeof str !== 'string' ){
			return false;
		}
		for(var key in str){
			if( isNaN(parseInt(str[key]) ) ){
				return key;
			}
		}
		return true;
	}
	
	this.checkLength = function(str, max, min)
	{
		if( typeof str !== 'string'){
			return false;
		}
		if( typeof max === 'number' && max > 0){
			if( max < str.length ){
				return false;
			}
		}
		if( typeof min === 'number' && min > 0){
			if( min > str.length ){
				return false;
			}
		}		
		return true;
	}
	
	
	
	this.checkPassword = function(pwd)
	{
		if(	typeof pwd !== 'string' || pwd.match(/[^A-Za-z0-9]/ig) ){
			return false;
		}else{
			return true;
		}
	}
	
	
	this.createMsg = function(){
		var list = '<ul>';
		for(var key in this.msg){
			list += '<li>'+ this.msg[key] + '</li>';
		}
		this.msg = [];
		return list;
	}
	
}