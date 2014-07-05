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
<td width="94%" valign="middle"><span style="color: #E1E2E3;font-size: 12px;"> 编辑试题</span></td>
</tr>
</table>
<div class="pad-10">
<div class="explain-col">
1、当设置有发布点时，生成静态页面完成后，请访问 内容 &gt; 发布管理 &gt; 同步到发布点 &gt; <br>2、只有栏目选择生成静态页面时，右侧“栏目范围”才会出现对应栏目。
</div>
<div class="bk10"></div>
<form id="upform" name="upform" enctype="multipart/form-data" method="post" action="<?php echo site_url('admin/question/editby_id')?>">
<input type="hidden" name="editid" value="<?php echo $_GET['id'];?>" />
<div class="table-list">
<table width="80%" cellspacing="0" >
<thead>
<tr>
<th align="center" >选择测评类型</th>
<th align="center" >选择一级类别</th>
<th align="center">选择二级类别</th>
<th align="center">选择三级类别</th>
<th align="center">选择四级类别</th>
</tr>
</thead>

<tbody height="200" class="nHover td-line">
	<tr> 
      <td align="center" rowspan="6" width="150">
	<select name="modelid" class="bindlist" size="2" style="height:200px;width:130px;" level="0"  onclick="bindlist(this);">
	<option value="-1" >请选择测评类型</option>
	<?php foreach($catelist as $cate) {?>
	<option value="<?php echo $cate->id.'-'.$cate->sid;?>" <?php echo ($cate->id==$examid) ? 'selected="selected"' :'' ;?>><?php echo $cate->name;?></option>
	<?php }?>
	</select>
	</td>
    </tr>
	<tr> 
		<td align="center" rowspan="6" width="150">
		<select name="level1" id="catids1" multiple="multiple" style="height:200px;" title="请选择下级类别" level="1"  onclick="bindlist(this);">
		<option value="-1" >请选择下级类别</option>
		<?php echo $select1;?>
		</select>
		</td>
    </tr>
	<tr> 
		<td align="center" rowspan="6" width="150">
		<select name="level2" id="catids2" multiple="multiple" style="height:200px;" title="请选择下级类别" level="2"  onclick="bindlist(this);">
		<option value="-1" >请选择下级类别</option>
		<?php echo $select2;?>
		</select>
		</td>
    </tr>
	<tr> 
		<td align="center" rowspan="6" width="150">
		<select name="level3" id="catids3" multiple="multiple" style="height:200px;" title="请选择下级类别" level="3"  onclick="bindlist(this);">
		<option value="-1" >请选择下级类别</option>
		<?php echo $select3;?>
		</select>
		</td>
    </tr>
	<tr> 
		<td align="center" rowspan="6" width="150">
		<select name="level4" id="catids4" multiple="multiple" style="height:200px;" title="请选择下级类别" level="4"  onclick="bindlist(this);">
		<option value="-1" <?php echo ($select4=='') ? 'selected="selected"' :'' ;?>>请选择下级类别</option>
		<?php echo $select4;?>
		</select>
		</td>
    </tr>
	</tbody>
</table>

</div>
<div class="table-list">
<table width="90%" cellspacing="0">
<thead>
<tr>
<th align="center" >题目标题</th>
<th align="center" >选项信息(选项：A 比重：0.15% 选项标题：)</th>
<th align="center">上传图片</th>

</tr>
</thead>

<tbody height="auto" class="nHover td-line">
	<tr> 
      <td align="center" rowspan="6" >
	<textarea id="qtitle" name="qtitle" style="width:200px;height:70px;" ><?php echo $title;?></textarea>
	</td>
    </tr>
	<tr> 
		<td align="center" rowspan="6" >
		<table class="tb tb2 " id="categorylist" style="width:95%;">
			<?php foreach($options as $option) {?>
			   <tr class="hover" >
				<td width="10px">
				<input name="selvalue[]" type="text" size="2" value="<?php echo $option['s'];?>" />
				</td>
				 <td width="20px"><input name="sellevel[]" type="text" size="8" value="<?php echo $option['l'];?>" /></td>
				<td><textarea name="seltext[]" style="width:250px;height:40px;" ><?php echo $option['v'];?></textarea>
				</td>
				</tr>
	        <?php }?>
		
		<tr class="hover"><td></td><td colspan="2"><a id="addoption" href="javascript:return false;" class="addtr">添加一个选择项</a></td><td></td></tr>
		</table>
		</td>
    </tr>
	<tr> 
		<td align="center" rowspan="6" >
		<input type="hidden" name="imgpath" value="<?php echo $imgpath;?>" />
		  <input type="file" name="upfile" id="fileField" />
		  <?php if($imgpath!='') {?>
		  <div>
		  <img src="<?php echo base_url().$imgpath;?>" width="150" height="150"/>
		  </div>
		  <?php }?>
		</td>
    </tr>
	
	</tbody>
</table>

<script type="text/javascript">
		//$(function(){
			function bindlist(obj) {
				$(obj).unbind();
				var catid = $(obj).val();
				var levelid=$(obj).attr("level");
				var levelnext=parseInt(levelid)+1;
				if(catid!='-1'){
				//$(obj).parent().parent().hide();admin.php?action=category&op=showchild&inajax=1&type=shop { catid: catid }
				$.get("<?php echo site_url()?>/admin/category/bindsubajax?inajax=1&level="+levelid+"&catid="+catid,
				  function(data){
					//$(obj).parent().parent().after(data);
					if(levelid=='0'){
						$("#catids1").empty();
						$("#catids1").append('<option value="-1" selected="selected">请选择下级类别</option>')
						$("#catids2").empty();
						$("#catids2").append('<option value="-1" selected="selected">请选择下级类别</option>')
						$("#catids3").empty();
						$("#catids3").append('<option value="-1" selected="selected">请选择下级类别</option>')
						$("#catids4").empty();
						$("#catids4").append('<option value="-1" selected="selected">请选择下级类别</option>')
					    $("#catids"+levelnext).append(data);
					}
					else{
					$("#catids"+levelnext).empty();
					$("#catids"+levelnext).append('<option value="-1" selected="selected">请选择下级类别</option>')
					$("#catids"+levelnext).append(data);}
				  });
				  }
				  
				
			}
			$("#addoption").click(function(){
				$(this).parent().parent().before('<tr class="hover" ><td width="10px"><input name="selvalue[]" type="text" size="2" value="" /></td><td width="20px"><input name="sellevel[]" type="text" size="8" value="" /></td><td><textarea name="seltext[]" style="width:250px;height:40px;"></textarea></td></tr>');  
			     });
			//});
			
			/* function checksumit(){
				 for(var i=0;i<document.upform.elements.length-1;i++)
               {
                  if(document.upform.elements[i].value=="")
                  {
                     alert("当前表单不能有空项");
                     document.upform.elements[i].focus();
                     return false;
                  }
               }
               return true;
			} */
			</script>
</div>
<div style="margin-top:25px;">
<input type="submit" class="btn" id="submit_listsubmit" name="listsubmit" onclick="return checksumit();" title="按 Enter 键可随时提交" value="更新试题" />
</div>
</form>
</div>
</body></html>