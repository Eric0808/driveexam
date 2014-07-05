<div class="title">按题型分类</div>
<div class="form">
<form action="<?php echo base_url(); ?>select/" method="POST" >
	<?php foreach($categorys as $cate): ?>
<div class="checkbox">
		<label for="<?php echo 'cate_', $cate->cateid; ?>" >
			<input type="checkbox" name="categroy[]" value="<?php echo $cate->cateid; ?>" id="<?php echo 'cate_', $cate->cateid; ?>"/>
			<span><?php echo $cate->name; ?></span>
		</label>
	</div>
	<?php endforeach; ?>
	<div class="clear"></div>
	<div style="text-align:center; margin:18px auto;">
		<input type="submit" value="开始练习" class="button" style="float:none; margin:auto;"/>
		<div class="clear"></div>
	</div>
</form>
</div>
</div>

<div class="box mtop">
	<div class="title">按答题类型</div>
	<div class="txt" style="height:149px;">
		<form id="frm3" name="frm3" method="post" action="<?php echo base_url(), 'select/'; ?>">
			<div>
			<label>
				<input name="catalogval" type="radio" value="1">
				选A的题</label>
			<label>
				<input name="catalogval" type="radio" value="2">
				选B的题</label>
			<label>
				<input name="catalogval" type="radio" value="3">
				选C的题</label>
			<label>
				<input name="catalogval" type="radio" value="4">
				选D的题</label>
			<label>
				<input name="catalogval" type="radio" value="5">
				选正确的题</label>
			<label>
				<input name="catalogval" type="radio" value="6">
				选错误的题</label>
			<label style="color:blue;">
				<input name="catalogval" type="radio" value="7">安全文明多选题</label>
			<div class="clear"></div>
			</div>
			<div style="text-align:center;">
				<input type="submit" value="开始练习" class="button" style="float:none; margin:auto;"/>
				<div class="clear"></div>
			</div>
		</form>
	</div>
