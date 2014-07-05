<div style="padding:8px 8px;line-height:20px;">
	<table border="0" cellpadding="4" cellspacing="0">
		<tbody>
			<?php foreach($subjects as $n=>$subject): 
			$id = implode('-', array_keys($subject['subjects']));
			?>
			<tr>
				<td width="88" rowspan="2" align="center" class="passtype" valign="middle">
					<a href="javascript:;" style="line-height:70px; font-size:48px;<?php 
						if(@$_COOKIE['subjectid']==$id) echo 'background-color: rgb(167, 186, 219);';
					?>" id="c1_km1" onclick="subject.setSubject('<?php echo $id; ?>')" class="km" >
						<?php echo $subject['drivetype'];?>
					</a>
				</td>
				<td height="32" colspan="2" align="left" valign="bottom" style="border-bottom:1px solid #eee;">
					<?php echo $subject['remark']; ?>
				</td>
			</tr>
			<tr valign="top" align="center">
				<?php $n=1; foreach($subject['subjects'] as $id=>$sub):
				$id =(string)$id;
				?>
				<td <?php if($n++%2===0){ ?> height="32" align="left"<?php }else{ ?> align="left" <?php } ?>valign="top">
					<a href='javascript:;' id="c1_km1" style="<?php 
						if(@$_COOKIE['subjectid']==$id) echo 'background-color: rgb(167, 186, 219);';
					?>" onclick="subject.setSubject(<?php echo $id; ?>)" class="km">
						<?php echo $sub;?>
					</a>
				</td>
				<?php endforeach; ?>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>