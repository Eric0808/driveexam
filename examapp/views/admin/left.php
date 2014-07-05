<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>

<script type="text/javascript" src="<?php echo STATIC_JS_PATH; ?>jquery.js"></script>
<script type="text/javascript" src="<?php echo STATIC_JS_PATH; ?>chili-1.7.pack.js"></script>
<script type="text/javascript" src="<?php echo STATIC_JS_PATH; ?>jquery.easing.js"></script>
<script type="text/javascript" src="<?php echo STATIC_JS_PATH; ?>jquery.dimensions.js"></script>
<script type="text/javascript" src="<?php echo STATIC_JS_PATH; ?>jquery.accordion.js"></script>
<script language="javascript">
	jQuery().ready(function(){
		jQuery('#navigation').accordion({
			header: '.head',
			navigation1: true, 
			event: 'click',
			fillSpace: true,
			animated: 'bounceslide'
		});
	});
</script>
<style type="text/css">
<!--
body {
	margin:0px;
	padding:0px;
	font-size: 12px;
}
#navigation {
	margin:0px;
	padding:0px;
	width:150px;
}
#navigation a.head {
	cursor:pointer;
	background:url('<?php echo STATIC_IMG_PATH; ?>admin_img/main_34.gif') no-repeat scroll;
	display:block;
	font-weight:bold;
	margin:0px;
	padding:5px 0 5px;
	text-align:center;
	font-size:12px;
	text-decoration:none;
}
#navigation ul {
	border-width:0px;
	margin:0px;
	padding:0px;
	text-indent:0px;
}
#navigation li {
	list-style:none; display:inline;
}
#navigation li li a {
	display:block;
	font-size:12px;
	text-decoration: none;
	text-align:center;
	padding:3px;
}
#navigation li li a:hover {
	background:url('<?php echo STATIC_IMG_PATH; ?>admin_img/tab_bg.gif') repeat-x;
		border:solid 1px #adb9c2;
}
-->
</style>
</head>
<body>
<div  style="height:100%;">
  <ul id="navigation">
    <li> <a class="head">管理员管理</a>
      <ul>
        <li><a href='<?php echo site_url('admin/login/updatepass');?>' target="rightFrame">修改密码</a></li>
      </ul>
    </li>
	 <li> <a class="head">车型科目管理</a>
      <ul>
        <li><a href='<?php echo site_url('admin/drive_type');?>' target="rightFrame">添加车型/科目</a></li>
        <li><a href="<?php echo site_url('admin/drive_type/Managetype').'?page=1';?>" target="rightFrame">车型/科目信息管理</a></li>
      </ul>
    </li>
    <li> <a class="head">类别/章节管理</a>
      <ul>
        <li><a href='<?php echo site_url('admin/cate_info');?>'  target="rightFrame">试题类别管理</a></li>
		 <li><a href='<?php echo site_url('admin/chapter_info');?>'  target="rightFrame">章节管理</a></li>
      </ul>
    </li>
   
	<li> <a class="head">题库管理</a>
      <ul>
        <li><a href='<?php echo site_url('admin/bank_info');?>' target="rightFrame">添加题库</a></li>
        <li><a href="<?php echo site_url('admin/bank_info/Managebank').'?page=1';?>" target="rightFrame">题库管理</a></li>
		<li><a href='<?php echo site_url('admin/topic_info');?>' target="rightFrame">添加试题</a></li>
		<li><a href='<?php echo site_url('admin/topic_info/Topicspider');?>' target="rightFrame">采集试题</a></li>
		<li><a href='<?php echo site_url('admin/topic_info/Topiclist').'?page=1';?>' target="rightFrame">试题管理</a></li>
		<li><a href='<?php echo site_url('admin/topic_info/Makestaticfile');?>' target="rightFrame">重新生成题解</a></li>
      </ul>
    </li>
	 <li> <a class="head">资讯管理</a>
      <ul>
        <li><a href='<?php echo site_url('admin/news_info');?>'  target="rightFrame">发布文章</a></li>
		<li><a href='<?php echo site_url('admin/news_info/Newslist').'?page=1';?>' target="rightFrame">文章管理</a></li>
      </ul>
    </li>
	<li> <a class="head">会员管理</a>
      <ul>
        <li><a href='<?php echo site_url('admin/member_info/index').'?page=1';?>' target="rightFrame">会员管理</a></li>
      </ul>
    </li>
    <li> <a class="head">系统管理</a>
      <ul>
	  <li><a href='<?php echo site_url('admin/city_info');?>'  target="rightFrame">城市管理</a></li>
	  <li><a href='<?php echo site_url('admin/link_info');?>'  target="rightFrame">友情链接管理</a></li>
	   <li><a href='<?php echo site_url('admin/ads_info');?>'  target="rightFrame">添加广告展示</a></li>
	   <li><a href='<?php echo site_url('admin/ads_info/Adslist').'?page=1';?>'  target="rightFrame">管理广告展示</a></li>
        <!--<li><a href="AddLink.php" target="rightFrame">数据库备份</a></li>-->
        <!--<li><a href="<?php echo site_url('admin/dbbackup/index');?>" target="rightFrame">清空数据库</a></li>-->
      </ul>
    </li>
  </ul>
</div>
</body>
</html>
