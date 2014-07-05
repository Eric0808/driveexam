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
<td width="94%" valign="middle"><span style="color: #E1E2E3;font-size: 12px;"> 试题分类管理</span></td>
</tr>
</table>
<div class="container" id="cpcontainer">
<div class="explain-col">
1、为保证试题由类别归属请在此添加所需要的所有类别 <br>
2、此功能可完成试题类别的批量添加、删除、批量修改<br>
</div>
<?php echo form_open('admin/cate_info/Newcategory',array('target'=>'rightFrame','name'=>'myform','id'=>'myform'));?>
<table class="tb tb2 " id="categorylist" style="width:95%;">
<tr class="header">
<th></th>
<th>排序</th>
<th style="padding-left:50px;">试题分类名称</th>
<th>ID</th>
<th>Operation</th></tr>
<?php foreach($catelist as $cate) {?>
<tr class="hover" >
<td></td>
<td width="20px"><input name="display[<?php echo $cate->cateid;?>]" type="text" size="2" value="<?php echo $cate->displayorder;?>" /></td>
<td style="padding-left:50px;" width="250px;"><input type="text" class="txtnobd" onblur="this.className='txtnobd'" onfocus="this.className='txt'" size="20" name="name[<?php echo $cate->cateid;?>]" value="<?php echo $cate->name;?>"></td>
<td><font class="tips2">(catid:<?php echo $cate->cateid;?>)</font></td>
<td>
[<a href="cate_info/Delcate?cateid=<?php echo $cate->cateid;?>">删除</a>]
</td></tr>

<?php }?>
<tr class="hover"><td></td><td colspan="2"><a id="addcategory" href="javascript:return false;" class="addtr">添加一个试题类型</a></td><td></td><td></td><td></td><td></td><td></td></tr><tr><td colspan="15"><div class="fixsel"><div id="ajax_status_display"></div><input type="submit" class="btn" id="submit_listsubmit" name="listsubmit" title="按 Enter 键可随时提交您的修改" value="提交" /></div><br /><br /><br /><br /></td></tr>
</table>
</form>
<script type="text/javascript">
		$(function(){
			
			$("#addcategory").click(function(){
				$(this).parent().parent().before('<tr class="hover"><td></td><td><input type="text" value="0" size="2" name="newdisplay[]"></td><td style="padding-left:50px;" width="250px;"><input type="text" value="新建分类名称" onfocus="if(value==\'新建分类名称\') {value=\'\'}" onblur="if(value==\'\'){value=\'新建分类名称\'}" name="newcategory[]" size="20" onfocus="this.className=\'txt\'" onblur="this.className=\'txtnobd\'" class="txtnobd" /></td><td></td><td></td></tr>');
			});

		});
	</script></body></html>