<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="<?php echo STATIC_IMG_PATH; ?>admin_img/admincp.css" rel="stylesheet" type="text/css" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo STATIC_PATH; ?>upload/jquery.uploadify.min.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="<?php echo STATIC_PATH; ?>upload/uploadify.css">
</head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0" height="24" bgcolor="#353c44">
<tr>
<td width="6%" height="19" valign="middle"><div align="center"><img src="<?php echo STATIC_IMG_PATH; ?>admin_img/tb.gif" width="14" style="ertical-align: middle;" height="14" /></div></td>
<td width="94%" valign="middle"><span style="color: #E1E2E3;font-size: 12px;">添加试题</span></td>
</tr>
</table>
<div class="pad-10">
<div class="explain-col">
1、添加试题时，必须选择该试题是什么类别。<br>2、此表单除了“上传图片”为选填项，其他均为必填项。
</div>
<div class="bk10"></div>
<form id="myform" name="myform"  method="post" action="<?php echo site_url('admin/topic_info/Addtopic')?>">
<div class="table-list">
<table width="80%" cellspacing="0">
<thead>
<tr>
<th align="center" >题目名称</th>
<th align="center" >所属题库</th>
<th align="center">所属题型</th>
<th align="center">所属章节</th>
</tr>
</thead>

<tbody height="200" class="nHover td-line">
	<tr> 
      <td align="center" rowspan="6" width="150">
	<textarea name="topic_name" id="topic_name" style="width:350px;height:35px;"></textarea>
	</td>
    </tr>
	<tr> 
		<td align="center" rowspan="6" width="150">
		<select name="bankid[]" id="catids" multiple="multiple" style="height:100px;" title="请选择题库按住“Ctrl”或“Shift”键可以多选，按住“Ctrl”可取消选择">
		<option value="-1" selected="selected">请选择题库</option>
		<?php foreach($banklist as $key=>$bank) {?>
		<option value="<?php echo $bank->id;?>" ><?php echo $bank->name;?></option>
		<?php }?>
		</select>
		</td>
    </tr>
	<tr> 
		<td align="center" rowspan="6" width="150">
		<select name="cateid" id="cateid"  title="请选择题型" >
		<option value="-1" selected="selected">请选择题型</option>
		<?php foreach($catelist as $key=>$cate) {?>
		<option value="<?php echo $cate->cateid;?>" ><?php echo $cate->name;?></option>
		<?php }?>
		</select>
		</td>
    </tr>
	<tr> 
		<td align="center" rowspan="6" width="150">
		<select name="chapterid" id="chapterid"  title="请选择章节" >
		<option value="-1" selected="selected">请选择章节</option>
		<?php foreach($chapterlist as $key=>$chapter) {?>
		<option value="<?php echo $chapter->chaptid;?>" ><?php echo $chapter->name;?></option>
		<?php }?>
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
<th align="center" >填写该题目的选项信息</th>
</tr>
</thead>

<tbody height="auto" class="nHover td-line">
	<tr> 
      <td align="center" rowspan="6" valign="middle" >
		A:<textarea name="answer[]" style="width:300px;height:35px;"></textarea>
		<input name="yes[]" id="yes_1" type="checkbox" style="margin-left:5px;" value="A" /><label for="yes_1" style="margin-right:10px;">打钩为答案</label>
		B:<textarea name="answer[]" style="width:300px;height:35px;"></textarea>
		<input name="yes[]" id="yes_2" type="checkbox" style="margin-left:5px;" value="B" /><label for="yes_2" style="margin-right:10px;">打钩为答案</label></br>
		C:<textarea name="answer[]" style="width:300px;height:35px;"></textarea>
		<input name="yes[]" id="yes_3" type="checkbox" style="margin-left:5px;" value="C" /><label for="yes_3" style="margin-right:10px;">打钩为答案</label>
		D:<textarea name="answer[]" style="width:300px;height:35px;"></textarea>
		<input name="yes[]" id="yes_4" type="checkbox" style="margin-left:5px;" value="D" /><label for="yes_4" style="margin-right:10px;">打钩为答案</label><br/><br/>
		<input name="yes_no[]" id="yes_no_1" type="checkbox" style="margin-left:5px;" value="1" onClick="chooseOne(this);" /><label for="yes_no_1" style="margin-right:10px;">正确</label>
		<input name="yes_no[]" id="yes_no_2" type="checkbox" style="margin-left:5px;" value="2" onClick="chooseOne(this);" /><label for="yes_no_2" style="margin-right:10px;">错误</label>
		
	  </td>
    </tr>
	
	</tbody>
</table>
</div>
<div class="table-list">
<table width="80%" cellspacing="0">
<thead>
<tr>
<th align="center" >添加试题解析<span style="color:red;">（必填）</span></th>
<th align="center" >上传图片或flash动画文件</th>
</tr>
</thead>

<tbody height="auto" class="nHover td-line">
	<tr> 
      <td align="center" rowspan="6" valign="middle" >
		<textarea name="explain" id="explain" style="width:300px;height:40px;"></textarea>
	  </td>
    </tr>
	<tr> 
		<td align="center" rowspan="6" >
			<form>
				<div id="queue"></div>
				<input id="file_upload" name="file_upload" type="file" multiple="true">
			</form>

			<script type="text/javascript">
				<?php $timestamp = time();?>
				$(function() {
					$('#file_upload').uploadify({
						'formData'     : {
							'timestamp' : '<?php echo $timestamp;?>',
							'token'     : '<?php echo md5('unique_salt' . $timestamp);?>'
						},
						'swf'      : '<?php echo STATIC_PATH; ?>upload/uploadify.swf',
						'uploader' : '<?php echo site_url('admin/topic_info/Uploadify');?>'
					});
				});
			</script>
		</td>
    </tr>
	</tbody>
</table>
</div>
<div style="margin-top:25px;">
<input type="submit" class="btn" id="submit_listsubmit" name="listsubmit" onclick="return checksumit();" title="按 Enter 键可随时提交" value="添加一个试题" />
</div>
</form>
</div>
<script type="text/javascript">
	function chooseOne(cb){
	var obj = document.getElementsByName("yes_no[]");
	for (i=0; i<obj.length; i++){
	    if (obj[i]!=cb) obj[i].checked = false; 
		else  obj[i].checked = cb.checked; 
	  }
	}
	function checksumit()
	{
	  if($('#topic_name').val() == '')
	  {
		alert("题目不能为空");
		$('#topic_name').focus();
		return false;
	  }
	   if($('#bankid').val() == '-1')
	  {
		alert("请选择题库");
		$('#bankid').focus();
		return false;
	  }
	  if($('#cateid').val() == '-1')
	  {
		alert("请选择所属题型");
		$('#cateid').focus();
		return false;
	  }
	  
	  if($('#explain').val() == '')
	  {
		alert("题解不能为空");
		$('#explain').focus();
		return false;
	  }
	  if ($('#explain').val().length > 100) 
	  {
		alert("题解内容太长，最多 100 个文字");
		return false;
	  }
	  return true;
	}
</script>
</body></html>