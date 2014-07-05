<?php if( !isset($list) ) exit; ?>

<div class="title">
	我排除的题
</div>
<div class="txt">
	<div class="artview">
		<div style="height:35px;padding: 20px;">
			<div id="pages" style="text-align: left; float:left;">
			<?php echo $pages; ?>
			</div>
			<div style="float:right;padding-top:5px;">
				<a href="<?php echo base_url(); ?>remove/clear/" class="oldbutton" title="取消我排除的所有题" onclick="return confirm('您确认取消所有排除记录吗？');">
					清空排除的题
				</a>
			</div>
			<div class="clear"></div>
		</div>
		<div class="content">

<?php $num = (($page-1)*$limit) +1;  ?>
<?php foreach($list as $n=>$li): ?>
<div class="q qc<?php echo ($num-1)%2; ?>">
	<div class="q1"><?php echo $num++; ?>、<?php echo $li['question'];?></div>
	<ul class="q2">
		<?php echo showItem::show($li['type'], $li); ?>
	</ul>
	<div class="q3">
		<?php if( isset($li['falsh']) ){ ?>
			<?php echo $li['falsh']; ?>
		<?php }elseif(!empty($li['image'])){ ?>
			<img src="<?php echo STATIC_UPLOAD_PATH;?><?php echo $li['image']; ?>" />
		<?php } ?>
	</div>
	<div class="clear"></div>
	<div class="q4">
		<span style="float:right;">
			<a href="<?php echo base_url(); ?>remove/clear/<?php echo $li['id']?>/" style="color:gray;">取消排除</a>
		</span>
		正确答案：<img src="<?php echo STATIC_IMG_PATH; ?>choose/<?php echo $li['type']; ?>_<?php echo $li['answer']; ?>.jpg">
		<span class="q5">
			&nbsp; &nbsp; <a href="<?php echo base_url();?>jieshi/<?php echo $li['id']?>.html" target="_blank">查看题解</a>
		</span>
	</div>
</div>
<?php endforeach; ?>
		</div>
	</div>
	<div class="clear"></div>
</div>
