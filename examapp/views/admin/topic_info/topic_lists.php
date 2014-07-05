<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<style type="text/css">
<!--
body {
	margin-left: 3px;
	margin-top: 0px;
	margin-right: 3px;
	margin-bottom: 0px;
	
}
.option {
	color: #e1e2e3;
	font-size: 12px;
	text-decoration: none;
}
.STYLE1 {
	color: #e1e2e3;
	font-size: 12px;
}
.STYLE6 {color: #000000; font-size: 12; }
.STYLE10 {color: #000000; font-size: 12px; }
.STYLE19 {
	color: #344b50;
	font-size: 12px;
}
.STYLE21 {
	font-size: 12px;
	color: #3b6375;
}
.option1 {
	color: #3b6375;
	font-size: 12px;
	text-decoration: none;
}
.STYLE22 {
	font-size: 12px;
	color: #295568;
}
#pages {
padding: 14px 0 10px;
font: 12px/1.5 tahoma,arial,宋体b8b\4f53,sans-serif;
font-family: 宋体;
text-align: right;
}
#pages a.a1 {
background: url('<?php echo STATIC_IMG_PATH?>admin_img/pages.png') no-repeat 0 5px;
width: 56px;
padding: 0;
}
#pages a:hover {
background: #F1F1F1;
color: black;
text-decoration: none;
}
#pages a {
display: inline-block;
height: 22px;
line-height: 22px;
background: white;
border: 1px solid #E3E3E3;
text-align: center;
color: #333;
padding: 0 10px;
text-decoration: none;
}
#pages span {
display: inline-block;
height: 22px;
padding: 0 10px;
line-height: 22px;
background: #5A85B2;
border: 1px solid #5A85B2;
color: white;
text-align: center;
}

.table2 tr.hover:hover td {
background: #d3eaef;
}
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
<script charset="utf-8" src="<?php echo STATIC_JS_PATH?>jquery.min.js" type="text/javascript"></script>
   <script type="text/javascript">
        $(function() {
           $("#checkall").add("#check_box").click(function() {
                $('input[name="ids[]"]').attr("checked",this.checked); 
            });
            var $subBox = $("input[name='ids[]']");
            $subBox.click(function(){
				$("#checkall").add("#check_box").attr("checked",$subBox.length == $("input[name='ids[]']:checked").length ? true : false);
            });
        });
    </script>
</head>

<body>
<style type="text/css">
	html{_overflow-y:scroll}
</style>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="30"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="24" bgcolor="#353c44"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="6%" height="19" valign="bottom"><div align="center"><img src="<?php echo STATIC_IMG_PATH?>admin_img/tb.gif" width="14" height="14" /></div></td>
                <td width="94%" valign="bottom"><span class="STYLE1"> 试题管理</span></td>
              </tr>
            </table></td>
            <td><div align="right"><span class="STYLE1">
              <input type="checkbox" name="checkbox11" id="checkall" />
              全选      &nbsp;&nbsp;<img src="<?php echo STATIC_IMG_PATH?>admin_img/add.gif" width="10" height="10" /> <a class="option" href='<?php echo site_url('admin/topic_info');?>' target="rightFrame">添加试题</a>&nbsp; <img src="<?php echo STATIC_IMG_PATH?>admin_img/del.gif" width="10" height="10" /> <a class="option" style="cursor:hand;" onclick='return confirm_delete();' target="rightFrame">删除</a>    &nbsp;</span><span class="STYLE1"> &nbsp;</span></div></td>
          </tr>
        </table></td>
      </tr>
	   <tr>
	  <td>
	  <div class="explain-col">
	  <?php echo form_open('admin/topic_info/Topiclist',array('target'=>'_self','name'=>'serform','id'=>'serform'));?>
      题目：<input type="text" name="ser_tilte" style="width:250px;" value="<?php echo $this->session->userdata('s_like'); ?>"/> 类别：
	  <select name="ser_cate" id="ser_cate"  title="请选择类别" >
		<option value="-1" <?php echo $this->session->userdata('s_cate')=='-1' ? 'selected="selected"' : '';?> >请选择类别</option>
		<?php foreach($catelist as $key=>$cate) {?>
		<option value="<?php echo $cate->cateid;?>" <?php echo $this->session->userdata('s_cate')=="{$cate->cateid}" ? 'selected="selected"' : '';?> ><?php echo $cate->name;?></option>
		<?php }?>
		</select>
		题型：
	  <select name="ser_type" id="ser_type"  title="请选择题型" >
		<option value="-1" <?php echo $this->session->userdata('s_type')=='-1' ? 'selected="selected"' : '';?> >请选择题型</option>
		<option value="0" <?php echo $this->session->userdata('s_type')=='0' ? 'selected="selected"' : '';?>>判断题</option>
		<option value="1" <?php echo $this->session->userdata('s_type')=='1' ? 'selected="selected"' : '';?>>单选题</option>
		<option value="2" <?php echo $this->session->userdata('s_type')=='2' ? 'selected="selected"' : '';?>>多选题</option>
		</select>
		题库：
	  <select name="ser_bank" id="ser_bank"  title="请选择题库" >
		<option value="-1" <?php echo $this->session->userdata('s_bank')=='-1' ? 'selected="selected"' : '';?> >请选择题库</option>
		<?php foreach($banklist as $key=>$bank) {?>
		<option value="<?php echo $bank->id;?>" <?php echo $this->session->userdata('s_bank')=="{$bank->id}" ? 'selected="selected"' : '';?> ><?php echo $bank->name;?></option>
		<?php }?>
		</select>
		章节：
	  <select name="ser_chapter" id="ser_chapter"  title="请选择章节" >
		<option value="-1" <?php echo $this->session->userdata('s_chapter')=="-1" ? 'selected="selected"' : '';?> >请选择章节</option>
		<?php foreach($chapterlist as $key=>$chapter) {?>
		<option value="<?php echo $chapter->chaptid;?>" <?php echo $this->session->userdata('s_chapter')=="{$chapter->chaptid}" ? 'selected="selected"' : '';?> ><?php echo $chapter->name;?></option>
		<?php }?>
		</select>
		<input type="submit" class="btn" id="submit_ser" name="submit_ser"  title="按 Enter 键可随时提交" value="查询" />
		</form>
      </div>
	  
</td>
	  </tr>
    </table></td>
  </tr>
  <tr>
    <td>
	<?php echo form_open('admin/topic_info/Deletetopic',array('target'=>'rightFrame','name'=>'myform','id'=>'myform'));?>
	<table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#a8c7ce" class="table2">
      <tr>
        <td width="1%" height="20" bgcolor="d3eaef" class="STYLE10"><div align="center">
          <input type="checkbox" value="" id="check_box" />
        </div></td>
        <td width="2%" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">ID</span></div></td>
        <td width="12%" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">题目</span></div></td>
		 <td width="3%" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">类别</span></div></td>
		 <td width="3%" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">题型</span></div></td>
        <td width="3%" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">正确答案</span></div></td>
        <td width="5%" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">所属题库</span></div></td>
		<td width="8%" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">所属章节</span></div></td>
        <td width="3%" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">基本操作</span></div></td>
      </tr>
	  <?php foreach($topiclist as $topic) {?>
      <tr class="hover">
        <td height="20" bgcolor="#FFFFFF"><div align="center">
           <input type="checkbox" name="ids[]" value="<?php echo $topic->id;?>" />
        </div></td>
        <td height="20" bgcolor="#FFFFFF" class="STYLE6"><div align="center"><span class="STYLE19"><?php echo $topic->id;?></span></div></td>
        <td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="center"><?php echo mb_substr($topic->question, 0, 30, 'utf-8');?></div></td>
		 <td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="center"><?php echo $topic->name;?></div></td>
        <td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="center">
		<?php 
		switch($topic->type){
			case 0:
			echo '判断题';break;
			case 1:
			echo '单选题';break;
			case 2:
			echo '多选题';break;
			default:
			echo '题型暂无';break;
		}
		
		?>
		</div></td>
        <td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="center"><?php echo $answer[$topic->answer];?></div></td>
		<td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="center">
		<?php if($topic->bankid!='') {?>
		<?php foreach($banklist as $key=>$bank) {?>
			<?php if(in_array($bank->id,explode(',',$topic->bankid))){?>
			<?php echo $bank->name;?>
			<?php }?>
		<?php }?>
		<?php } else{?>
		<?php echo '不在任何题库';?>
		<?php }?>
		</div></td>
		<td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="center">
		<?php foreach($chapterlist as $key=>$chapter) {?>
			<?php if($chapter->chaptid==$topic->chapid){?>
			<?php echo $chapter->name; break;?>
			<?php }?>
		<?php }?>
		</div></td>
        <td height="20" bgcolor="#FFFFFF"><div align="center" class="STYLE21">
		<a class="option1" title="详情" href="<?php echo site_url('admin/topic_info/Detailby_id').'?id='.$topic->id;?>" target="rightFrame"><img src='<?php echo STATIC_IMG_PATH?>admin_img/detail.png'/></a> &nbsp;
		<a class="option1" title="编辑" href="<?php echo site_url('admin/topic_info').'?id='.$topic->id;?>" target="rightFrame"><img src='<?php echo STATIC_IMG_PATH?>admin_img/edit.png'/></a> &nbsp;
		<a class="option1" title="删除" href="javascript:linkok('<?php echo site_url('admin/topic_info/Deletetopic').'?id='.$topic->id;?>')" target="rightFrame"><img src='<?php echo STATIC_IMG_PATH?>admin_img/delete.gif'/></a> 
		
		</div></td>
      </tr>
      <?php }?>
    </table>
	<div style="text-align: left;padding: 5px;">
	<select name="mov_chapter" id="mov_chapter"  title="请选择章节" >
		<option value="-1" >请选择章节</option>
		<?php foreach($chapterlist as $key=>$chapter) {?>
		<option value="<?php echo $chapter->chaptid;?>" ><?php echo $chapter->name;?></option>
		<?php }?>
		</select>
		<select name="mov_cate" id="mov_cate"  title="请选择类别" >
		<option value="-1" >请选择类别</option>
		<?php foreach($catelist as $key=>$cate) {?>
		<option value="<?php echo $cate->cateid;?>" ><?php echo $cate->name;?></option>
		<?php }?>
		</select>
		<input type="button" name="move" value=" 批量移动 " onclick="myform.action='<?php echo site_url('admin/topic_info/Movechapter')?>';myform.submit();" >
	</div>
	</form>
	</td>
  </tr>
  <tr>
  <td>
    <div id="pages">
	  <?php echo $pagestr;?>
	  </div>
   </td>
  </tr>
</table>
<script type="text/javascript">
<!--
    function linkok(url){
    question = confirm("你确定要删除该试题吗？");
    if (question){
    window.location.href = url;
    }
    }
    //-->
function confirm_delete(){
	if(confirm('你确定要删除试题吗？')) $('#myform').submit();
}
</script>
</body>
</html>
