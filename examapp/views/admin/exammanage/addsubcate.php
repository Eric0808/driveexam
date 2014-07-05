<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="<?php echo base_url()?>static/images/admin_img/admincp.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url()?>static/images/admin_img/calendar.css" rel="stylesheet" type="text/css" />
</head>
<body>
<script charset="utf-8" src="<?php echo base_url()?>static/js/common.js" type="text/javascript"></script>
<script charset="utf-8" src="<?php echo base_url()?>static/js/admin/jquery.js" type="text/javascript"></script>
<script charset="utf-8" src="<?php echo base_url()?>static/images/admin_img/admincp.js" type="text/javascript"></script>
<script charset="utf-8" src="<?php echo base_url()?>static/images/admin_img/calendar.js" type="text/javascript"></script>
<table width="100%" border="0" cellspacing="0" cellpadding="0" height="24" bgcolor="#353c44">
<tr>
<td width="6%" height="19" valign="middle"><div align="center"><img src="<?php echo base_url()?>static/images/admin_img/tb.gif" width="14" style="ertical-align: middle;" height="14" /></div></td>
<td width="94%" valign="middle"><span style="color: #E1E2E3;font-size: 12px;"> 添加【<?php echo $_GET['catname']?>】的子类别</span></td>
</tr>
</table>
<div id="append_parent"></div>
<div class="container" id="cpcontainer">
<table class="tb tb2 " id="tips" style="width:100%;">
<tr><th  class="partition">提示</th></tr>
<tr ><td class="tipsblock" ><ul id="tipslis"><li>若该类别下无试题，则以下表单中的试题规则处可忽略不填</li>
<li>若该类别下有试题且每题分数相同，例：遵纪守法下有5道题每题0.48分，则只需填写表单：题目数(前)：	5	每道题分数：0.48	</li>
<li>若该类别下有试题且每题分数不同，例：某某类别下有前50道题每题0.24分，后40道题每题0.125分，则需填写表单：题目数(前)：50	每道题分数：0.24 题目数(后)：40每道题分数：0.125	</li>
<li>评价规则：例：0=有待提升自身心理素质、适应岗位要求（换行）18=心理素质优良，符合岗位基本要求。（换行） 24=心理素质过硬，工作适应性强。0代表低于18，18代表18到24分，24代表大于等于24分	</li>
<li>评价规则：分数和评价之间的”=“两边无空格	</li>
</ul></td></tr></table>
<?php echo form_open('admin/category/addsubcate',array('target'=>'rightFrame','name'=>'myform','id'=>'myform'));?>
<input type="hidden" value="<?php echo $_GET['catid']?>"  name="fcate">
<input type="hidden" value="<?php echo $_GET['catname']?>"  name="fcatename">
<table class="tb tb2 " id="categorylist" style="width:100%;">
<tr class="header">
<th></th>
<th>排序</th>
<th>类型/级别名称</th>
<th>权重</th>
<th>级别</th>
<th>编号</th>
<th>评价规则</th>
</tr>

<tr class="hover"><td width="10"></td>
<td width="10"><input type="text" value="0" size="2" name="newsubdisplay"></td>
<td width="200"><input type="text" value="新建类型名称" onfocus="if(value=='新建类型名称') {value=''}" onblur="if(value==''){value='新建类型名称'}" name="newsubcategory" size="30" onfocus="this.className='txt'"   /></td>
<td width="80"><input type="text" name="newsubweight" value="" size="4">%</td>
<td width="80"><input type="text" name="newsublevel" value="" size="4"></td>
<td width="80"><input type="text" name="newsubnumid" value="" size="4"></td>
<td width="400"><textarea name="newsubrule" rows="2" cols="20" id="options" style="height:60px;width:350px;"></textarea>
<font class="tips2">例：</font>
</td>
</tr>
<tr><td colspan=8>
<table width="100%">
<tr class="hover">
<td width="10"></td>
<td width="120">题目数(前)：</td>
<td width="25"><input type="text"  class="txtnobd" onblur="this.className='txtnobd'" onfocus="this.className='txt'"  value="5" size="4" name="newqnum[]"></td>
<td width="140">每道题分数：</td>
<td width="25"><input type="text"  class="txtnobd" onblur="this.className='txtnobd'" onfocus="this.className='txt'"  value="" size="4" name="newqscore[]"></td>
<td width="120">题目数(后)：</td>
<td width="25"><input type="text"  class="txtnobd" onblur="this.className='txtnobd'" onfocus="this.className='txt'"  value="" size="4" name="newqnum[]"></td>
<td width="140">每道题分数：</td>
<td width="25"><input type="text"  class="txtnobd" onblur="this.className='txtnobd'" onfocus="this.className='txt'"  value="" size="4" name="newqscore[]"></td>
<td width="1200"></td>
</tr>
</table>
</td></tr>

<tr class="hover"><td></td><td colspan="2"></td><td></td><td></td><td></td><td></td><td></td></tr><tr><td colspan="15"><div class="fixsel"><div id="ajax_status_display"></div><input type="submit" class="btn" id="submit_listsubmit" name="listsubmit" title="按 Enter 键可随时提交您的修改" value="提交" /></div><br /><br /><br /><br /></td></tr>
</table>
</form>
<script type="text/javascript">
		$(function(){
			$("#addcategory").click(function(){
				$(this).parent().parent().before('<tr class="hover"><td></td><td><input type="text" value="0" size="2" name="newsubdisplay"></td><td><input type="text" value="新建类型名称" onfocus="if(value==\'新建类型名称\') {value=\'\'}" onblur="if(value==\'\'){value=\'新建类型名称\'}" name="newsubcategory" size="25" onfocus="this.className=\'txt\'" onblur="this.className=\'txtnobd\'" class="" /></td><td><input type="text" name="newsubweight" value="" size="4">%</td><td><input type="text" name="newsublevel" value="" size="4"></td><td><input type="text" name="newsubnumid" value="" size="4"></td><td><input type="text" name="newsubmax" value="" size="4"></td><td><textarea name="newsubrule" rows="2" cols="20" id="options" style="height:60px;width:350px;"></textarea></td>'+
				'<tr><td colspan=8><table width="100%"><tr class="hover"><td width="10"></td><td width="120">题目数(前)：</td><td width="25"><input type="text"  class="txtnobd" onblur="this.className=\'txtnobd\'" onfocus="this.className=\'txt\'"  value="5" size="4" name="newqnum"></td><td width="140">每道题分数：</td><td width="25"><input type="text" class="txtnobd" onblur="this.className=\'txtnobd\'" onfocus="this.className=\'txt\'"  value="" size="4" name="newqscore"></td><td width="120">题目数(后)：</td><td width="25"><input type="text" class="txtnobd" onblur="this.className=\'txtnobd\'" onfocus="this.className=\'txt\'"  value="" size="4" name="newhnum"></td><td width="140">每道题分数：</td><td width="25"><input type="text" class="txtnobd" onblur="this.className=\'txtnobd\'" onfocus="this.className=\'txt\'"  value="" size="4" name="newhscore"></td><td width="1200"></td></tr></table></td></tr>');
			});

		});
	</script>
</body></html>