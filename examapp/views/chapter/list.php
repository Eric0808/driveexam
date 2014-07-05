<div class="title">章节练习</div>
<div class="txt" style="height:570px;">
<table width="100%" border="0" cellpadding="2" cellspacing="1" style="background-color:rgb(155, 185, 206);">
<tbody>
	<?php foreach($lists as $n=>$li): ?>
	<tr class="tr<?php echo $n%2; ?>">
		<td><?php echo $n+1; ?>、<?php echo $li['name']; ?></td>
		<td width="230">
			<a href="<?php echo base_url(), 'orderly/?chapter=', $li['chaptid']?>" class="button" style="float:left; margin:auto 10px;">顺序练习</a>
			<a href="<?php echo base_url(), 'random/?chapter=', $li['chaptid']?>" class="button" style="float:left; margin:auto 10px;">随机练习</a>
			<a class="clear"></a>
		</td>
	</tr>
	<?php endforeach; ?>
</tbody>
</table> 
</div>