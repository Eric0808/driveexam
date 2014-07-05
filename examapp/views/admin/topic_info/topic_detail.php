<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link href="<?php echo STATIC_CSS_PATH; ?>style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo STATIC_CSS_PATH; ?>cms.css" rel="stylesheet" type="text/css" />
</head>

<body>
<style type="text/css">
	html{_overflow-y:scroll}
</style>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>
	<div class="main">
	<div class="right" style="float:left;margin-left:50px;">
		<div class="box">
					<div class="title">
					试题详情
					</div>
					<div class="txt">
						<div class="artview">
							<div>
						
								<h2>题：<?php echo $topic['question'];?></h2>
								<div class="content" style="margin-top:-10px;">
								<div>
							<?php if(!empty($topic['image']) && (strpos($topic['image'], '.jpg')!==FALSE || strpos($topic['image'], '.gif')!==FALSE)){?>
								<img src="<?php echo ROOT_PATH . 'uploads/' . $topic['image'];?>">
								<?php } ?>
								
								<?php if(!empty($topic['image']) && strpos($topic['image'], '.swf')!==FALSE){?>
								<embed src="<?php echo ROOT_PATH . 'uploads/' . $topic['image'];?>" width="220" height="102" allowscriptaccess="always" allowfullscreen="true" type="application/x-shockwave-flash" wmode="transparent" quality="high">
								<?php } ?>
								</div>
									<div class="q qjieshi">
										<ul class="q2">
										<?php if($topic['type']!=0){?>
											<li>A、<?php echo $topic['item1'];?></li>
											<li>B、<?php echo $topic['item2'];?></li>
											<li>C、<?php echo $topic['item3'];?></li>
											<li>D、<?php echo $topic['item4'];?></li>
											<?php } else{ ?>
											<li>正确</li>
											<li>错误</li>
											<?php }?>
										</ul>
										<div class="clear"></div>
										<div class="clear"></div>
										<div class="q4">正确答案：
										<?php if($topic['type']!=0){?>
										<img src="<?php echo STATIC_IMG_PATH; ?>2_<?php echo $topic['answer'];?>.jpg" />
										<?php } else{ ?>
										<img src="<?php echo STATIC_IMG_PATH; ?>0_<?php echo $topic['answer'];?>.jpg" />
										<?php }?>
										</div>
										<div class="q6">试题解释：<?php echo $topic['explain'];?>
										</div>
										
									</div>
								</div>
								
							</div>
						</div>
					</div>
				</div>
				</div>
		</div>		
   </td>
  </tr>
</table>

</body>
</html>
