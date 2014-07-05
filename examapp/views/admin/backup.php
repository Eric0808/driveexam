<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link rel="stylesheet" type="text/css" href="<?php echo STATIC_CSS_PATH; ?>table_form.css" charset="UTF-8"/>
<script type="text/javascript" src="<?php echo STATIC_JS_PATH; ?>jquery.min.js" charset="UTF-8"></script>
<script type="text/javascript" src="<?php echo STATIC_JS_PATH; ?>formvalidator.js" charset="UTF-8"></script>
<script type="text/javascript" src="<?php echo STATIC_JS_PATH; ?>formvalidatorregex.js" charset="UTF-8"></script>
<script type="text/javascript">
  $(document).ready(function() {
	$.formValidator.initConfig({autotip:true,formid:"myform",onerror:function(msg){}});
	$("#old_password").formValidator({empty:true,onshow:"输入密码方可进行操作。",onfocus:"输入密码方可进行操作。",oncorrect:"密码输入正确"}).inputValidator({min:5,max:20,onerror:"密码应该为5-20位之间"}).ajaxValidator({
	    type : "get",
		url : "<?php echo site_url('admin/dbbackup/ajaxck_oldpass')?>",
		data :"",
		datatype : "html",
		async:'false',
		success : function(data){	
            if( data == "1" )
			{
                return true;
			}
            else
			{
                return false;
			}
		},
		buttons: $("#dosubmit"),
		onerror : "密码输入错误",
		onwait : "请稍候..."
	});
	
  })
</script>
<style type="text/css">
<!--

.explain-col {
border: 1px solid #FFBE7A;
background: #FFFCED;
padding: 8px 10px;
line-height: 20px;
text-align: left;
margin:10px;
font: 12px/1.5 tahoma,arial,宋体b8b体4f53,sans-serif;
}


-->
</style>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="30"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="24" bgcolor="#353c44"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="6%" height="19" valign="bottom"><div align="center"><img src="<?php echo STATIC_IMG_PATH; ?>admin_img/tb.gif" width="14" height="14" /></div></td>
                <td width="94%" valign="bottom"><span class="STYLE1"> 数据库清空</span></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
	    <tr>
	  <td>
	  <div class="explain-col">
1、注意：此项功能请务必谨慎操作。操作前请备份数据库。

</div></td>
	  </tr>
    </table></td>
  </tr>
  <tr>
    <td>
	<?php echo form_open('admin/dbbackup/backup',array('target'=>'rightFrame','name'=>'myform','id'=>'myform'));?>
	<table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#a8c7ce">
     
      <tr>
        <td height="30" width="10%" bgcolor="#FFFFFF" class="STYLE6">
		<div class="input-div1"><span class="STYLE19">请输入密码：</span></div>
		</td>
        <td height="20" bgcolor="#FFFFFF" class="STYLE19">
		<div  class="input-div2"><input type="password" value="" id="old_password" class="input-text" name="old_password"></div>
		</td>
      </tr>
      
	  <tr>
        <td height="30" width="10%" bgcolor="#FFFFFF" colspan="2" class="STYLE6">
		<div class="input-div2"><input type="submit" value="清空数据库" id="dosubmit"/></div>
		</td>
        
      </tr>
    </table>
	</form>
	</td>
  </tr>
  
</table>
</body>
</html>
