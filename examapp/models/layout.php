<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php if( isset($title) && !empty($title) ) echo $title, ' | '; ?><?php echo $this->config->config['site_name']; ?></title>
<meta name="keywords" content="<?php echo $this->config->config['site_keyword']; ?>">
<meta name="description" content="<?php echo $this->config->config['site_description']; ?>">

<!--[if IE]>
<script type="text/javascript" src="<?php echo STATIC_JS_PATH;?>json.js" ></script>
<![endif]-->
<?php if(isset($prev)): ?>
<link rel="prev" title="<?php echo $prev['title']; ?>" href="<?php echo base_url(), 'news/', $prev['id']; ?>" />
<?php endif; ?>
<?php if(isset($next)): ?>
<link rel="next" title="<?php echo $next['title']; ?>" href="<?php echo base_url(), 'news/', $next['id']; ?>" />
<?php endif; ?>
<?php 
if( isset($css) && is_array($css) ):
	foreach($css as $name):
?>
<link href="<?php echo STATIC_CSS_PATH;?><?php echo $name; ?>.css" rel="stylesheet" type="text/css">
<?php 
	endforeach;
endif; ?>
<script type="text/javascript">
var base_url =  base_url || '<?php echo base_url(); ?>';

if( ! Array.prototype.indexOf ){
	Array.prototype.indexOf = function(find){
		for(var k in this){
			if(this[k] === find){
				return k;
			}
		}
		return -1;
	}
}

</script>
</head>
<body>
<div class="wrap">
	<div id="loadding" style="display:none; left: 50%;position:absolute;top: 40%;">
		<img src="<?php echo STATIC_IMG_PATH; ?>loadding.gif" />
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
			<strong id="cityname"><?php echo isset($_COOKIE['city']) ? $_COOKIE['city']: '全国'; ?></strong>
			<span>[<a href="javascript:;" id="setarea">选择城市</a>]</span>
		</div>
		<div class="sets setpass">
			<strong id="subjectname">
				<?php if(isset($subjectname)){
				echo htmlspecialchars($subjectname);
				}?>	
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
			<li class="home<?php if($current==='main'){ echo ' current';} ?>"><a href="<?php echo base_url();?>">考证首页</a></li>
	<?php foreach($menu as $pro=>$name): ?>
		<li class="<?php echo str_replace('/', '-', $pro);?><?php if($pro===$current){ echo ' current';} ?>"><a href="<?php echo base_url();?><?php echo $pro;?>/"><?php echo $name;?></a></li>
	<?php endforeach; ?>
				</ul>
			</div>
			<div class="end"></div> 
		</div>
		<div class="right">
			<div class="box" id="<?php echo $current; ?>">
				<?php if(isset($content)) echo $content; ?>
				<div class="clear"></div>
			</div>
		
		<div class="clear"></div>
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
<?php 
if( isset($javascript) && is_array($javascript) ):
	foreach($javascript as $name):
?>
<script src="<?php echo STATIC_JS_PATH;?><?php echo $name; ?>.js" type="text/javascript"></script>
<?php 
	endforeach;
endif; ?>

<script type="text/javascript">
var cookieexpiredays = 3600*24*30;
</script>

<script type="text/javascript">
<?php if( isset($msg) && !empty($msg) ): ?>
showmsg('<?php echo htmlspecialchars($msg) ?>');
<?php endif; ?>


<?php
if( !isset($gcrand) ) $gcrand = 1000;
// 启动GC 销毁过期数据
if( true || rand(0, $gcrand) === 1 ): ?>
(function(){
var ajax = new XMLHttpRequest();
ajax.open('GET', '<?php echo base_url(), 'clear/'; ?>', true);
ajax.send();
})();
<?php endif; ?>

</script>

</body>
</html>
