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
<td width="94%" valign="middle"><span style="color: #E1E2E3;font-size: 12px;"> 测评类型/级别管理</span></td>
</tr>
</table>
<div class="container" id="cpcontainer">
<div class="explain-col">
1、添加跟分类必须先添加根级类型，例：注册会计师 <br>
2、您添加根分类后，请务必添加该分类的二、三 或四级分类<br>
3、考试类型的级别“level”默认为0 其下边的类别依次增加，再添加试题后，请不要随意修改类别的级别编号信息。这样会导致类别下的试题无效。
</div>
<!-- <table class="tb tb2 " id="tips" style="width:100%;">
 <tr><th  class="partition">提示</th></tr>
<tr ><td class="tipsblock" ><ul id="tipslis"><li>添加跟分类必须先添加根级类型，例：注册会计师</li><li>您添加根分类后，请务必添加该分类的二、三 或四级分类</li></ul></td></tr></table>-->
<?php echo form_open('admin/category/newexamtype',array('target'=>'rightFrame','name'=>'myform','id'=>'myform'));?>
<table class="tb tb2 " id="categorylist" style="width:95%;">
<tr class="header">
<th></th>
<th>排序</th>
<th>类型/级别名称</th>
<th>权重</th>
<th>级别</th>
<th>评价规则</th>

<th>编号</th>
<th>ID</th>
<th>Operation</th></tr>
<?php foreach($catelist as $cate) {?>
<tr class="hover" >
<td width="10px"><a class="showchild" <?php if(empty($cate->subid)) {echo 'style="display:none;"';} ?> catid="<?php echo $cate->id;?>" upid="<?php echo $cate->pid;?>" href="javascript:return return;">+</a></td>
<td width="20px"><input name="display[<?php echo $cate->id;?>]" type="text" size="2" value="<?php echo $cate->displayorder;?>" /></td>
<td><input type="text" class="txtnobd" onblur="this.className='txtnobd'" onfocus="this.className='txt'" size="15" name="name[<?php echo $cate->id;?>]" value="<?php echo $cate->name;?>">&nbsp;&nbsp;<a class="addtr newchild"  title="添加相关子类别" href='<?php echo site_url('admin/category/addsubcate')."?catid=".$cate->id."&catname=".$cate->name;?>'  target="rightFrame"> </a></td>
<td><input type="text" name="weight[<?php echo $cate->id;?>]" value="<?php echo $cate->weight;?>" size="8">%</td>
<td><input type="text" name="level[<?php echo $cate->id;?>]" id="level<?php echo $cate->id;?>" value="<?php echo $cate->level;?>" size="8"></td>
<td><input type="text" name="rule[<?php echo $cate->id;?>]" value="<?php echo $cate->rule;?>" size="8"></td>

<td><input type="text" name="numid[<?php echo $cate->id;?>]" value="<?php echo $cate->sid;?>" size="8"></td>
<td><font class="tips2">(catid:<?php echo $cate->id;?>)</font></td>
<td> [<a href="category/deletecate?catid=<?php echo $cate->id;?>&levelid=<?php echo $cate->level;?>&fid=<?php echo $cate->pid;?>">删除</a>]
[<a href="category/editcate?catid=<?php echo $cate->id;?>&levelid=<?php echo $cate->level;?>&fid=<?php echo $cate->pid;?>">编辑</a>]
</td></tr>

<?php }?>
<tr class="hover"><td></td><td colspan="2"><a id="addcategory" href="javascript:return false;" class="addtr">添加考试类型</a></td><td></td><td></td><td></td><td></td><td></td></tr><tr><td colspan="15"><div class="fixsel"><div id="ajax_status_display"></div><input type="submit" class="btn" id="submit_listsubmit" name="listsubmit" title="按 Enter 键可随时提交您的修改" value="提交" /></div><br /><br /><br /><br /></td></tr>
</table>
</form>
<script type="text/javascript">
		$(function(){
			function showchild(obj) {
				$(obj).unbind();
				var catid = $(obj).attr("catid");
				var levelid=$("#level"+catid).val();
				//$(obj).parent().parent().hide();admin.php?action=category&op=showchild&inajax=1&type=shop
				$.get("category/showsubajax?inajax=1&level="+levelid, { catid: catid },
				  function(data){
					$(obj).parent().parent().after(data);
					$(obj).attr("local", "lock");
					togglebind();
					togglebind_newchild();
					$(obj).unbind();
					$(obj).click(function(){
						hiddenchild(this);
					});
					$(obj).empty();
					$(obj).append("-");
				  });
			}
			function hiddenchild(obj) {
				var catid = $(obj).attr("catid");
				var childs = $(".showchild[upid='"+catid+"']");
				for(var i = 0; i < childs.length; i++) {
					$(childs[i]).parent().parent().hide();
					hiddenchild(childs[i]);
				}
				$(obj).unbind();
				$(obj).click(function(){
					showchild_local(this);
				});
				$(obj).empty();
				$(obj).append("+");

			}
			function showchild_local(obj) {
				var catid = $(obj).attr("catid");
				$(".showchild[upid='"+catid+"']").parent().parent().show();
				$(obj).unbind();
				$(obj).click(function(){
					hiddenchild(this);
				});
				$(obj).empty();
				$(obj).append("-");
			}
			function togglebind() {
				$(".showchild[local!='lock']").unbind();
				$(".showchild[local!='lock']").click(function(){
					showchild(this);
					//$(this).parent().parent().hide();
				});
			}
			function togglebind_newchild() {
				$(".newchild").unbind();
				$(".newchild").click(function(){
					var catid = $(this).attr("catid");
					var tds = $(this).parent().parent().find("td");
					var pre = $(tds[2]).text();
					var ss = pre.split("|----");
					if(ss.length == 1) {
						pre = "|----";
					} else {
						pre = pre+"|----";
					}
					if(ss.length >= 4) {
						location.href="admin.php?action=category&op=newchild&upid="+catid+"&type=shop";
						return false;
					}
					$(this).parent().parent().after('<tr class="hover"><td><a style="display:none;" class="showchild" upid="'+catid+'" href="javascript:return return;">+</a></td><td><input type="text" value="0" size="2" name="newchilddisplay['+catid+'][]"></td><td>'+pre+'<input type="text" value="新建子分类名称" name="newchildcategory['+catid+'][]" size="15" onfocus="this.className=\'txt\'" onblur="this.className=\'txtnobd\'" class="txtnobd"></td><td></td><td></td></tr>');
				});
			}
			togglebind();
			//togglebind_newchild();
			$("#addcategory").click(function(){
				$(this).parent().parent().before('<tr class="hover"><td></td><td><input type="text" value="0" size="2" name="newdisplay[]"></td><td><input type="text" value="新建类型名称" onfocus="if(value==\'新建类型名称\') {value=\'\'}" onblur="if(value==\'\'){value=\'新建类型名称\'}" name="newcategory[]" size="15" onfocus="this.className=\'txt\'" onblur="this.className=\'txtnobd\'" class="txtnobd" /></td><td><input type="text" name="newweight[]" value="100" size="8">%</td><td><input type="text" name="newlevel[]" value="0" size="8"></td><td></td><td><input type="text" name="newnumid[]" value="" size="8"></td></tr>');
			});

		});
	</script></body></html>