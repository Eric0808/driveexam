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
background: url('<?php echo base_url()?>static/images/admin_img/pages.png') no-repeat 0 5px;
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
<script charset="utf-8" src="<?php echo base_url()?>static/js/jquery.min.js" type="text/javascript"></script>
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
                <td width="6%" height="19" valign="bottom"><div align="center"><img src="<?php echo base_url()?>static/images/admin_img/tb.gif" width="14" height="14" /></div></td>
                <td width="94%" valign="bottom"><span class="STYLE1"> 会员测评信息管理</span></td>
              </tr>
            </table></td>
            <td><div align="right"><span class="STYLE1">
              <input type="checkbox" name="checkbox11" id="checkall" />
              全选      &nbsp; <img src="<?php echo base_url()?>static/images/admin_img/edit.gif" width="10" height="10" /> <a class="option" style="cursor:hand;" onclick='return confirm_clear();' target="rightFrame">批量重考</a>   &nbsp;</span><span class="STYLE1"> &nbsp;</span></div></td>
          </tr>
        </table></td>
      </tr>
	  <tr>
	  <td>
	  <div class="explain-col">
1、此页面将显示所有用户的考试状态：“已报考，未开始测评”、“正在测评”、“已完成测评”。<br>
2、“已报考，未开始测评”、“正在测评”的用户将不能进行“查看测评成绩”和“重新考试”操作。<br>
3、该功能可以针对单个用户操作“重新考试”，也可以批量操作。<br>
4、重新考试后，该用户的测评成绩将会被清空。
</div></td>
	  </tr>
    </table></td>
  </tr>
  <tr>
    <td>
	<?php echo form_open('admin/usermanage/clearexam_id',array('target'=>'rightFrame','name'=>'myform','id'=>'myform'));?>
	<table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#a8c7ce" class="table2">
      <tr>
        <td width="2%" height="20" bgcolor="d3eaef" class="STYLE10"><div align="center">
          <input type="checkbox" value="" id="check_box" />
        </div></td>
        <td width="3%" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">UID</span></div></td>
        <td width="5%" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">用户名</span></div></td>
		 <td width="5%" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">职业</span></div></td>
        <td width="5%" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">测评类型</span></div></td>
        <td width="9%" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">开始时间</span></div></td>
		<td width="9%" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">结束时间</span></div></td>
        <td width="8%" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">考试状态</span></div></td>
        <td width="10%" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">基本操作</span></div></td>
      </tr>
	  <?php foreach($userexamlist as $exam) {?>
	  <?php 
		$btime=strtotime($exam->starttime);
		$now=time();
		$diff=$now-$btime;
		$diffhour=(int)($diff/3600);
		//echo $diffhour;
		if($diffhour>0|| ($exam->endtime)!='' ||(($exam->starttime)=='' && ($exam->endtime)=='') ){
		
	  ?>
      <tr class="hover">
        <td height="20" bgcolor="#FFFFFF"><div align="center">
           <input type="checkbox" name="ids[]" value="<?php echo $exam->id;?>" />
        </div></td>
        <td height="20" bgcolor="#FFFFFF" class="STYLE6"><div align="center"><span class="STYLE19"><?php echo $exam->uid;?></span></div></td>
        <td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="center"><?php echo $exam->uname;?></div></td>
		<td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="center"><?php echo $exam->job;?></div></td>
        <td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="center"><?php echo $exam->cname;?></div></td>
        <td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="center"><?php echo $exam->starttime;?></div></td>
		<td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="center">
		<?php echo $exam->endtime;?>
		</div></td>
		<td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="center">
		<?php 
		 
		 if($exam->status==1){
		 echo '<div align="center" style="background-color:#fffc03;"><b style="color:black;">已报考，未开始测评</b></div>';}
		 if($exam->status==2 && $diffhour<2 ){
		 echo '<div align="center" style="background-color:#00cd1d;"><b style="color:black;">正在测评</b></div>';}
		 if($exam->status==3){
		 echo '<div align="center" style="background-color:#00cd1d;"><b style="color:black;">已完成测评</b></div>';}
		 if($exam->status==2 && $diffhour>2){
		 echo '<div align="center" style="background-color:#BB2B2B;"><b style="color:black;">测评超时未交卷</b></div>';}
		?>
		</div></td>
		
        <td height="20" bgcolor="#FFFFFF"><div align="center" class="STYLE21"> 
		<?php 
		if($exam->status==3){
		 echo '<a class="option1" href="'.site_url('admin/usermanage/lookexam_id').'?uid='.$exam->uid.'&cid='.$exam->cid.'&uname='.$exam->uname.'" target="rightFrame"><img src="'.base_url().'static/images/admin_img/cpcj.gif"/></a>&nbsp;&nbsp;';
		 echo '<a class="option1" href="javascript:linkok(\''.site_url('admin/usermanage/clearexam_id').'?id='.$exam->id.'\',\''.$exam->uname.'\',\''.$exam->cname.'\')" target="rightFrame"><img src="'.base_url().'static/images/admin_img/recp.gif"/></a>';
		 }
		 if($exam->status==2 && $diffhour>2){
		 echo '<a class="option1" href="javascript:linkok(\''.site_url('admin/usermanage/clearexam_id').'?id='.$exam->id.'\',\''.$exam->uname.'\',\''.$exam->cname.'\')" target="rightFrame"><img src="'.base_url().'static/images/admin_img/recp.gif"/></a>';
		 }
		?>
		</div></td>
      </tr>
	  <?php }?>
      <?php }?>
    </table>
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
    function linkok(url,name,cname){
    question = confirm("你确认要清除" + name +"的<"+cname+">测评记录吗？");
    if (question){
    window.location.href = url;
    }
    }
    //-->

function confirm_clear(){
	if(confirm('你确认要清除测评记录吗？')) $('#myform').submit();
}
</script>
</body>
</html>
