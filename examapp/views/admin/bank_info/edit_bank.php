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
<td width="94%" valign="middle"><span style="color: #E1E2E3;font-size: 12px;">编辑题库信息</span></td>
</tr>
</table>
<div class="pad-10">
<div class="explain-col">
1、添加试题时，必须选择该试题是什么类别。<br>2、此表单除了“上传图片”为选填项，其他均为必填项。
</div>
<div class="bk10"></div>
<form id="upform" name="upform"  method="post" action="<?php echo site_url('admin/bank_info/Updatebank')?>">
<input  type="hidden" name="edit_id" value="<?php echo $editid;?>"/>
<div class="table-list">
<table width="80%" cellspacing="0">
<thead>
<tr>
<th align="center" >题库名称</th>
<th align="center" >题库年份</th>
</tr>
</thead>

<tbody height="200" class="nHover td-line">
	<tr> 
      <td align="center" rowspan="6" width="150">
	<input name="bank_name" type="text" style="width:350px;" value="<?php echo $bankinfo['name'];?>" />
	</td>
    </tr>
	<tr> 
		<td align="center" rowspan="6" width="150">
		<select name="year" id="year"  title="请选择年份" >
		<option value="-1" selected="selected">请选择年份</option>
		<option value="2015" <?php echo $bankinfo['year']=='2015' ? 'selected="selected"' : '';?> >2015年</option>
		<option value="2014" <?php echo $bankinfo['year']=='2014' ? 'selected="selected"' : '';?> >2014年</option>
		<option value="2013" <?php echo $bankinfo['year']=='2013' ? 'selected="selected"' : '';?> >2013年</option>
		<option value="2012" <?php echo $bankinfo['year']=='2012' ? 'selected="selected"' : '';?> >2012年</option>
		<option value="2011" <?php echo $bankinfo['year']=='2011' ? 'selected="selected"' : '';?> >2011年</option>
		<option value="2010" <?php echo $bankinfo['year']=='2010' ? 'selected="selected"' : '';?> >2010年</option>
		</select>
		</td>
    </tr>
	</tbody>
</table>

</div>
<div class="table-list">
<table width="80%" cellspacing="0">
<thead>
<tr>
<th align="center" >选择该题库包含的题型</th>
</tr>
</thead>

<tbody height="auto" class="nHover td-line">
	<tr> 
      <td align="center" rowspan="6" valign="middle" >
	   <?php $arrcates = @unserialize($bankinfo['cateids']);?>
	  <?php foreach($catelist as $key=>$cate) {?>
	<input name="cate_name[]" id="<?php echo "radio_$key";?>" type="checkbox" <?php echo in_array($cate->cateid,$arrcates) ? 'checked="checked"' : "";?> style="margin-right:10px;margin-top:10px;" value="<?php echo $cate->cateid;?>" />
	<label for="<?php echo "radio_$key";?>"><?php echo $cate->name;?></label>
	<?php }?>
	</td>
    </tr>
	</tbody>
</table>
</div>
<div style="margin-top:25px;">
<input type="submit" class="btn" id="submit_listsubmit" name="listsubmit"  title="按 Enter 键可随时提交" value="更新题库" />
</div>
</form>
</div>
</body></html>