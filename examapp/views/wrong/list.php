<?php if( !isset($list) ) exit; ?>

<div class="title">
	我的错题
</div>
<div class="txt">
	<div class="artview">
		<div style="height:35px;padding: 5px;">
			<div id="pages" style="text-align: left; float:left;">
			<?php echo $pages; ?>
			</div>
			<div style="float:right;margin-top:15px;">
				<a href="<?php echo base_url(); ?>wrong/redo/" class="oldbutton" title="练习我所有的错题" >
					错题重做
				</a>
				<a href="<?php echo base_url(); ?>wrong/clear/" class="oldbutton" title="清空我所有的错题" onclick="return confirm('您确认清空所有的错题记录吗？');">
					清空错题
				</a>
			</div>
			<div class="clear"></div>
		</div>
		<div class="content">

<?php $num = (($page-1)*$limit) +1; ?>
<?php foreach($list as $n=>$li): ?>
<div class="q qc<?php echo ($num-1)%2; ?>">
	<div class="q1"><?php echo $num++; ?>、<?php echo $li['question'];?></div>
	<ul class="q2">
		<?php $type = @$li['type']; echo showItem::show($type, $li); ?>
	</ul>
	<div class="q3">
		<?php if( isset($li['falsh']) ){ ?>
			<?php echo $li['falsh']; ?>
		<?php }elseif(!empty($li['image'])){ ?>
			<img src="<?php echo STATIC_UPLOAD_PATH;?><?php echo $li['image']; ?>" />
		<?php } ?>
	</div>
	<div class="clear"></div>
	<div class="q4" style="color:red;padding-bottom:10px;">
		<?php if( ! empty($li['useranswer']) ): ?>
		您的答案：<img src="<?php echo STATIC_IMG_PATH; ?>choose/<?php echo $li['type']; ?>_<?php echo $li['useranswer']; ?>.jpg">
		<?php endif; ?>
		&nbsp; &nbsp; 做错次数：<strong><?php echo $li['errcount']; ?></strong> 次 
		&nbsp; &nbsp; 记录时间：<?php echo $li['addtime']; ?>
	</div><div class="q4">
		<span style="float:right;">
			<a href="<?php echo base_url(); ?>wrong/clear/<?php echo $li['id']?>/" style="color:gray;">移除错题</a>
		</span>
		正确答案：<img src="<?php echo STATIC_IMG_PATH; ?>choose/<?php echo $li['type']; ?>_<?php echo $li['answer']; ?>.jpg">
		<span class="q5">
			&nbsp; &nbsp; <a href="<?php echo base_url(); ?>jieshi/<?php echo $li['id']?>.html" target="_blank">查看题解</a>
		</span>
	</div>
</div>
<?php endforeach; ?>
		</div>
	</div>
	<div class="clear"></div>
</div>
