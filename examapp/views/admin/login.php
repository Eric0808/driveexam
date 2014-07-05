<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>后台登录-在线测评系统</title>
<link rel="stylesheet" type="text/css" href="<?php echo STATIC_CSS_PATH; ?>style_admin.css"/>
<script type="text/javascript" src="<?php echo STATIC_JS_PATH; ?>js.js"></script>
<SCRIPT language=javascript>
<!--
function SetFocus()
{
if (document.Login.user.value=="")
	document.Login.user.focus();
else
	document.Login.user.select();
}
function CheckForm()
{
	if(document.Login.user.value=="")
	{
		alert("请输入用户名！");
		document.Login.user.focus();
		return false;
	}
	if(document.Login.pwd.value == "")
	{
		alert("请输入密码！");
		document.Login.pwd.focus();
		return false;
	}
	if (document.Login.CheckCode.value==""){
       alert ("请输入您的验证码！");
       document.Login.CheckCode.focus();
       return(false);
    }
}


//-->

</SCRIPT>
</head>
<body>
<div id="top"> </div>
<?php echo form_open('admin/login/check',array('onSubmit'=>'return CheckForm();','target'=>'_parent','name'=>'Login'));?>
  <div id="center">
    <div id="center_left"></div>
    <div id="center_middle">
      <div class="user">
        <label>用户名：
        <input type="text" name="user" id="user" />
        </label>
      </div>
      <div class="user">
        <label>密　码：
        <input type="password" name="pwd" id="pwd" />
        </label>
      </div>
      <!--<div class="chknumber">
        <label>验证码：
        <input name="chknumber" type="text" id="chknumber" maxlength="4" class="chknumber_input" />
        </label>
        <img src="images/checkcode.png" id="safecode" />
      </div>-->
    </div>
    <div id="center_middle_right"></div>
    <div id="center_submit">
      <div class="button"> <INPUT onMouseOver="this.style.backgroundColor='#ffffff'" style="BORDER-RIGHT: #e1f4ee 1px solid; BORDER-TOP: #e1f4ee 1px solid; FONT-SIZE: 9pt; BORDER-LEFT: #e1f4ee 1px solid; WIDTH: 60px; COLOR: #000000; BORDER-BOTTOM: #e1f4ee 1px solid; HEIGHT: 19px; BACKGROUND-COLOR: #e1f4ee" onMouseOut="this.style.backgroundColor='#E1F4EE'" type=submit value=" 确&nbsp;认 " name=Submit> </div>
      <div class="button"> 
	  <INPUT id=reset onMouseOver="this.style.backgroundColor='#ffffff'" style="BORDER-RIGHT: #e1f4ee 1px solid; BORDER-TOP: #e1f4ee 1px solid; FONT-SIZE: 9pt; BORDER-LEFT: #e1f4ee 1px solid; WIDTH: 60px; COLOR: #000000; BORDER-BOTTOM: #e1f4ee 1px solid; HEIGHT: 19px; BACKGROUND-COLOR: #e1f4ee" onMouseOut="this.style.backgroundColor='#E1F4EE'" type=reset value=" 清&nbsp;除 " name=reset>
	  </div>
    </div>
	</form>
    <div id="center_right"></div>
  </div>
  <span style="color:#FF0000"><?php echo $xinxi;?></span>

<div id="footer"></div>
<SCRIPT language=JavaScript type=text/JavaScript>
CheckBrowser();
SetFocus(); 
</SCRIPT>
</body>
</html>
