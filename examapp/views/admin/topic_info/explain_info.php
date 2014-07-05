<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php echo $question;?> | <?php echo $this->config->config['site_name']; ?></title>
<meta name="keywords" content="<?php echo $this->config->config['site_keyword']; ?>">
<meta name="description" content="<?php echo $explain;?>">
<!--[if IE]>
<script type="text/javascript" src="<?php echo base_url(); ?>/static/js/json.js" ></script>
<![endif]-->
<link href="<?php echo base_url(); ?>static/css/style.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url(); ?>static/css/box.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url(); ?>static/css/cms.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
var base_url =  base_url || '<?php echo base_url(); ?>';

Array.prototype.indexOf||(Array.prototype.indexOf=function(e){for(var t in this)if(this[t]===e)return t;return-1});
</script>
</head>
<body>
<div class="wrap">
	<div id="loadding" style="display:none; left: 50%;position:absolute;top:40%;">
		<img src="<?php echo base_url(); ?>static/images/loadding.gif" />
	</div>
	<div id="messageShowBox">
		<span id="messageShow"></span>
	</div>
	<div class="top">
		<div class="user" id="userinfo">
			<a href="<?php echo base_url(); ?>user/login/">请登录</a> | 
			<a href="<?php echo base_url(); ?>user/signup/">免费注册</a>
		</div>
		<div id="topnews" style="float: left;" >
		</div>
		<div class="fav">
			<a href="Javascript:addFavorite(document.location.href, document.title)" style="color:rgb(243, 39, 11);" >加入收藏</a>
		</div>
		<div class="clear"></div>
	</div>
	<div class="header">
		<div class="logo"></div>
		<div class="sets setarea">
			<strong id="cityname">全国</strong>
			<span>[<a href="javascript:;" id="setarea">选择城市</a>]</span>
		</div>
		<div class="sets setpass">
			<strong id="subjectname">
				C1	
			</strong>
			<span>[<a href="javascript:;" id="setsubject">选择题库</a>]</span>
		</div>
		<div class="banner"></div>
		<div class="search"></div>
		<div class="clear"></div>
		<div id="area"></div>
		<div id="subject"></div>
	</div>
	<div class="main">
		<div class="left">
			<div class="nav">
				<ul>
			<li class="home"><a href="<?php echo base_url(); ?>">考证首页</a></li>
			<li class="chapter"><a href="<?php echo base_url(); ?>chapter/">章节练习</a></li>
			<li class="orderly"><a href="<?php echo base_url(); ?>orderly/">顺序练习</a></li>
			<li class="random"><a href="<?php echo base_url(); ?>random/">随机练习</a></li>
			<li class="select"><a href="<?php echo base_url(); ?>select/">筛选练习</a></li>
			<li class="exam"><a href="<?php echo base_url(); ?>exam/">模拟考试</a></li>
			<li class="scores"><a href="<?php echo base_url(); ?>scores/">历史成绩</a></li>
			<li class="wrong"><a href="<?php echo base_url(); ?>wrong/">我的错题</a></li>
			<li class="remove"><a href="<?php echo base_url(); ?>remove/">排除的题</a></li>
					</ul>
			</div>
			<div class="end"></div> 
		</div>
		<div class="right">
			<div class="box" id="chapter">
				<div class="title">试题解释</div>
				<div class="txt">
					<div class="artview">
						<div>
							<h2>题：<?php echo $question;?></h2>
							<div class="content" style="margin-top:-10px;">
							<div>
							<?php if(!empty($image) && (strpos($image, '.jpg')!==FALSE || strpos($image, '.gif')!==FALSE)){?>
								<img src="<?php echo ROOT_PATH . 'uploads/' . $image;?>">
								<?php } ?>
								
								<?php if(!empty($image) && strpos($image, '.swf')!==FALSE){?>
								<embed src="<?php echo ROOT_PATH . 'uploads/' . $image;?>" width="220" height="102" allowscriptaccess="always" allowfullscreen="true" type="application/x-shockwave-flash" wmode="transparent" quality="high">
								<?php } ?>
								</div>
								<div class="q qjieshi">
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
		
								</div>
							</div>
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
		<div class="footer">
			<span>Copyright © 2013</span>
			<a href="<?php echo base_url(); ?>">
				<?php echo $this->config->config['site_name']; ?>
			</a>
			版权所有
		</div>
</div>
<script src="<?php echo base_url(); ?>static/js/select.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>static/js/message.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>static/js/load.js" type="text/javascript"></script>

<script type="text/javascript">
var cookieexpiredays = 3600*24*30;
</script>

</body>
</html>