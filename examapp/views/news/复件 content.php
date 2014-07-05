<div class="title"><?php echo '资讯' ?></div>
<div class="txt">
	<div class="artview">
		<h1><?php echo $title;?></h1>
		<div class="info">发布于: <?php echo date('Y-m-d', $inputtime); ?>
		</div>
		<div class="content">
		<?php echo $content; ?>
		
<?php if( isset($pages) ): ?>
<div id="pages" style="text-align: left; margin-top:30px; border-top:1px solid #C0C0C0; ">
<?php echo $pages; ?>
</div>
<?php endif; ?>
<?php if( isset($lists) && is_array($lists) ): ?>
<?php $page<=0 && ($page=1); $num = (($page-1)*20)+1; ?>
<?php foreach($lists as $n=>$li): ?>
<div class="q qc<?php echo ($num-1)%2; ?>">
	<div class="q1"><?php echo $num++; ?>、<?php echo $li['question'];?></div>
	<ul class="q2">
		<?php echo showItem::show($li['type'], $li); ?>
	</ul>
	<div class="q3">
		<?php if(!empty($li['thumb'])): ?>
			<img src="<?php echo STATIC_UPLOAD_PATH;?><?php echo $li['thumb']; ?>" />
		<?php endif; ?>
	</div>
	<div class="clear"></div>
	<div class="q4">
		正确答案：<img src="<?php echo STATIC_IMG_PATH; ?>choose/<?php echo $li['type']; ?>_<?php echo $li['answer']; ?>.jpg">
		<span class="q5">
			&nbsp; &nbsp; <a href="<?php echo base_url();?>jieshi/<?php echo $li['id']?>.html" target="_blank">查看题解</a>
		</span>
	</div>
</div>
<?php endforeach; ?>
<?php endif; ?>

<?php if( isset($pages) ): ?>
<div id="pages" style="text-align: left; margin-bottom:30px;">
<?php echo $pages; ?>
</div>
<?php endif; ?>
		</div>
		<div class="prenext">
			<?php if(isset($prev)): ?>
			上一篇: <a href="<?php echo base_url(), 'news/', $prev['id'], '.html'; ?>"><?php echo $prev['title']; ?></a><br>
			<?php endif; ?>
			<?php if(isset($next)): ?>
			下一篇: <a href="<?php echo base_url(), 'news/', $next['id'], '.html'; ?>"><?php echo $next['title']; ?></a><br>
			<?php endif; ?>
		</div>
	</div>
</div>