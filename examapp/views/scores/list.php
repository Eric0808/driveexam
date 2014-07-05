<div class="title" >历史成绩</div>
<div class="txt">
	<?php if( is_array($list) && !empty($list) ){ ?> 
	<div class="scorelist">
		<ul>
			<li class="guide">
				<span>错题练习</span>
				<span>查看试卷</span>
				<span>用时</span>
				<span>成绩</span>
				模拟考试时间
			</li>
		<?php foreach($list as $k=>$li): ?>
			<li class="bg<?php echo $k%2 ?>">
				<span>
					<a href="<?php echo base_url(); ?>scores/redo/<?php echo $li['id']; ?>/" style="color:red;" target="_blank">错题练习</a>
				</span>
				<span>
					<a href="<?php echo base_url(); ?>scores/detail/<?php echo $li['id']; ?>/" style="color:green;">查看试卷</a>
				</span>
				<span><?php echo ceil($li['usetime']/60); ?> 分钟</span>
				<span class="high"><?php echo (int)$li['score']; ?> 分</span>
				<?php echo date('Y-m-d H:i:s', $li['begintime']); ?>
			</li>
		<?php endforeach; ?>
		</ul>
	</div>
	<?php }else{ ?>
	<a href="<?php echo base_url(), 'exam/'; ?>" >还没有您考试的成绩单，请点击这里参加模拟考试</a>
	<?php } ?>
</div>