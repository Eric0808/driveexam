<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
	<title><?php echo $question;?></title>
	<meta name="keywords" content="<?php echo $question;?>" />
	<meta name="description" content="<?php echo $question;?>-由金手指考试(www.jszks.com)专业提供解释！" />
	<link href="<?php echo STATIC_CSS_PATH; ?>style.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo STATIC_CSS_PATH; ?>cms.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo STATIC_JS_PATH; ?>jquery.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="<?php echo STATIC_JS_PATH; ?>jquery.js"></script>
	<script type="text/javascript" src="<?php echo STATIC_JS_PATH; ?>jquery.poshytip.js"></script>
	<script type="text/javascript" src="<?php echo STATIC_JS_PATH; ?>jquery.powerfloat.js"></script>
</head>
<body>
	<div class="wrap">
		<div class="top">
			<div class="user"></div>
			<div class="fav"><script type="text/javascript" src="<?php echo STATIC_JS_PATH; ?>top.js"></script></div>
			<div class="clear"></div>
		</div>
		<div class="header">
			<div class="logo"><a href="http://www.jszks.com/"><img src="<?php echo STATIC_IMG_PATH; ?>logo.png" width="178" height="50" border="0" /></a></div>
			<div class="sets setarea"></div>
			<div class="sets setpass"></div>
			<div class="banner"><script type="text/javascript" src="<?php echo STATIC_JS_PATH; ?>ding.js"></script></div>
			<div class="search"></div>
			<div class="clear"></div>
		</div>
		<div class="main">
			<div class="left">
				<div class="nav">
					<ul>
						<li class="home"><a href="http://www.jszks.com/">考证首页</a></li>
						<li class="chapter"><a href="http://www.jszks.com/chapter/">章节练习</a></li>
						<li class="list"><a href="http://www.jszks.com/list/">顺序练习</a></li>
						<li class="random"><a href="http://www.jszks.com/random/">随机练习</a></li>
						<li class="select"><a href="http://www.jszks.com/select/">筛选练习</a></li>
						<li class="exam"><a href="http://www.jszks.com/exam/">模拟考试</a></li>
						<li class="scores"><a href="http://www.jszks.com/scores/">历史成绩</a></li>
						<li class="wrong"><a href="http://www.jszks.com/wrong/">我的错题</a></li>
						<li class="remove"><a href="http://www.jszks.com/remove/">排除的题</a></li>
					</ul>
					<script>$(function(){$('.jieshi').addClass('current');});</script>
				</div>
				<div class="end"></div>
			</div>
			<div class="right">
				<div class="box">
					<div class="title">试题解释
					</div>
					<div class="txt">
						<div class="artview">
							<div>
								<center style="padding-top:10px;">
								<script src="http://js.jszks.com/cms.banner.js"></script>
								</center>
								<h2>题：<?php echo $question;?></h2>
								<div class="content" style="margin-top:-10px;">
									<div class="q qjieshi">
									<div><img src="http://img.jszks.com/images/question/80003299.jpg"></div>
										<ul class="q2">
										<?php if($type!=0){?>
											<li>A、<?php echo $item1;?></li>
											<li>B、<?php echo $item2;?></li>
											<li>C、<?php echo $item3;?></li>
											<li>D、<?php echo $item4;?></li>
											<?php } else{ ?>
											<li>正确</li>
											<li>错误</li>
											<?php }?>
										</ul>
										<div class="clear"></div>
										<div class="clear"></div>
										<div class="q4">正确答案：
										<?php if($type!=0){?>
										<img src="<?php echo STATIC_IMG_PATH; ?>2_<?php echo $answer?>.jpg" />
										<?php } else{ ?>
										<img src="<?php echo STATIC_IMG_PATH; ?>0_<?php echo $answer?>.jpg" />
										<?php }?>
										</div>
										<div class="q6">试题解释：<?php echo $explain;?>
										</div>
										<div class="q7"><form method="post" target="_blank" action="http://www.jszks.com/select/"><input name="catalog" type="hidden" value="3"><input name="catalogval" type="hidden" value="16"><input type="image" src="http://img.jszks.com/images/catalog/3-16.jpg"></form></div>
									</div>
								</div>
								<center style="padding-top:10px;"><script type="text/javascript" src="http://js.jszks.com/mm/728-90.js"></script></center>
							</div>
							<div class="prenext"> 
							<script type="text/javascript" src="<?php echo site_url('admin/topic_info/Getnextup').'?eid='.$explianId;?>"></script>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="clear"></div>
		</div>
		<script type="text/javascript" src="http://www.jszks.com/user/state/"></script>
		<div class="footer">Copyright &copy; 2007-2013 <a href="http://www.jszks.com">金手指考试</a> www.jszks.com 版权所有
		</div>
		<span style="display:none"><script src="http://s96.cnzz.com/stat.php?id=819062&web_id=819062" language="JavaScript"></script></span>
	</div>
</body>
</html>