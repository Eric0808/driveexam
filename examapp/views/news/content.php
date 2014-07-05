<div class="title"><?php echo '资讯' ?></div>
<div class="txt">
	<div class="artview">
		<h1><?php echo $title;?></h1>
		<div class="info">发布于: <?php echo date('Y-m-d', $inputtime); ?>
		</div>
		<div class="content">
		<?php echo $content; ?>
<div id="pages" style="text-align: left; margin-top:30px; border-top:1px solid #C0C0C0; ">
</div>
<div id="pages" style="text-align: left; margin-bottom:30px;">
</div>

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