<div class="citys">
<?php $n=1; foreach($citys as $first => $name ): $n++?>
<div class="city-row">
	<div class="area-first" >
		<strong><?php echo $first; ?></strong>
	</div>
	<ul>
<?php foreach($name as $city): 
list($id, $c) = each($city);
?>
	<li class="area-city" id="<?php echo $id; ?>"><a href="javascript:area.setArea(<?php echo $id; ?>);" ><?php echo $c; ?></a></li>
<?php endforeach; ?>
	</ul>
</div>
<?php if($n==(ceil(count($citys)/2)+1)): ?>
	<div class="clear"></div>
	</div>
	<div class="citys">
<?php endif; ?>
<?php endforeach; ?>
<div class="clear"></div>