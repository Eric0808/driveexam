<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="<?php echo STATIC_IMG_PATH; ?>admin_img/admincp.css" rel="stylesheet" type="text/css" />
<link href="<?php echo STATIC_IMG_PATH; ?>admin_img/calendar.css" rel="stylesheet" type="text/css" />
</head>
<body>
<script charset="utf-8" src="<?php echo STATIC_JS_PATH; ?>common.js" type="text/javascript"></script>
<script charset="utf-8" src="<?php echo STATIC_JS_PATH; ?>admin/jquery.js" type="text/javascript"></script>
<script charset="utf-8" src="<?php echo STATIC_IMG_PATH; ?>admin_img/admincp.js" type="text/javascript"></script>
<script charset="utf-8" src="<?php echo STATIC_IMG_PATH; ?>admin_img/calendar.js" type="text/javascript"></script>
<table width="100%" border="0" cellspacing="0" cellpadding="0" height="24" bgcolor="#353c44">
<tr>
<td width="6%" height="19" valign="middle"><div align="center"><img src="<?php echo STATIC_IMG_PATH; ?>admin_img/tb.gif" width="14" style="ertical-align: middle;" height="14" /></div></td>
<td width="94%" valign="middle"><span style="color: #E1E2E3;font-size: 12px;"> 友情链接管理</span></td>
</tr>
</table>
<div class="container" id="cpcontainer">
<div class="explain-col">
1、友情链接地址请务必加上：http:// <br>
2、此页面可完成友情链接的添加，修改，排序，删除功能<br>
3、可以一次性添加多个友情链接
</div>
<?php echo form_open('admin/link_info/Newlinks',array('target'=>'rightFrame','name'=>'myform','id'=>'myform'));?>
<table class="tb tb2 " id="categorylist" style="width:95%;">
<tr class="header">
<th></th>
<th>排序</th>
<th style="padding-left:50px;">网站名称</th>
<th style="padding-left:50px;">网站地址</th>
<th>ID</th>
<th>Operation</th></tr>
<?php foreach($linklist as $link) {?>
<tr class="hover" >
<td></td>
<td width="20px"><input name="display[<?php echo $link->linkid;?>]" type="text" size="2" value="<?php echo $link->displayorder;?>" /></td>
<td style="padding-left:20px;" width="100px;"><input type="text" class="txtnobd" onblur="this.className='txtnobd'" onfocus="this.className='txt'" size="20" name="name[<?php echo $link->linkid;?>]" value="<?php echo $link->name;?>"></td>
<td style="padding-left:10px;" width="250px;"><input type="text" class="txtnobd" onblur="this.className='txtnobd'" onfocus="this.className='txt'" size="40" name="url[<?php echo $link->linkid;?>]" value="<?php echo $link->url;?>"></td>
<td><font class="tips2">(Linkid:<?php echo $link->linkid;?>)</font></td>
<td>
[<a href="link_info/Dellink?linkid=<?php echo $link->linkid;?>">删除</a>]
</td></tr>

<?php }?>
<tr class="hover"><td></td><td colspan="2"><a id="addcategory" href="javascript:return false;" class="addtr">添加一个友情链接</a></td><td></td><td></td><td></td><td></td><td></td></tr><tr><td colspan="15"><div class="fixsel"><div id="ajax_status_display"></div><input type="submit" class="btn" id="submit_listsubmit" name="listsubmit" title="按 Enter 键可随时提交您的修改" value="提交" /></div><br /><br /><br /><br /></td></tr>
</table>
</form>
<script type="text/javascript">
		$(function(){
			
			$("#addcategory").click(function(){
				$(this).parent().parent().before('<tr class="hover"><td></td><td><input type="text" value="0" size="2" name="newdisplay[]"></td><td style="padding-left:20px;" width="100px;"><input type="text" value="新建网站名称" onfocus="if(value==\'新建网站名称\') {value=\'\'}" onblur="if(value==\'\'){value=\'新建网站名称\'}" name="newlink[]" size="20" onfocus="this.className=\'txt\'" onblur="this.className=\'txtnobd\'" class="txtnobd" /></td><td style="padding-left:10px;" width="250px;"><input type="text" value="http://" onfocus="if(value==\'http://\') {value=\'\'}" onblur="if(value==\'\'){value=\'http://\'}" name="newurl[]" size="40" onfocus="this.className=\'txt\'" onblur="this.className=\'txtnobd\'" class="txtnobd" /></td><td></td><td></td></tr>');
			});

		});
	</script></body></html>