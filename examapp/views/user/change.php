<div class="title" >修改和补充个人信息</div>
<div class="txt" style="height:530px;">
	<table width="570" border="0" cellpadding="2" cellspacing="0">
		<form action="<?php echo base_url(); ?>user/change/" method="post">
			<tbody>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td align="right" style="text-align:right;">用户名：</td>
				<td width="272"><?php echo $username; ?></td>
			</tr>
			<tr>
				<td align="right">邮箱地址：</td>
				<td><?php echo $email; ?></td>
			</tr>
			<tr>
				<td align="right">QQ 号码：</td>
				<td><input name="qq" type="text" value="<?php echo $qq; ?>"></td>
			</tr>
			<tr>
				<td align="right">您的性别：</td>
				<td><input name="sex" type="radio" id="sex1" value="1" <?php if($sex=='1') echo "checked" ?> >
					<label for="sex1">男</label>
					<input name="sex" type="radio" id="sex2" value="2" <?php if($sex=='2') echo "checked" ?> >
					<label for="sex2">女</label></td>
			</tr>
			<tr>
				<td align="right">手机号码：</td>
				<td><input name="phone" type="text" value="<?php echo $phone; ?>"></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td colspan="2">
					<input type="submit" name="submit" class="button" value="提交修改" />
				</td>
			</tr>
			</tbody>
		</form>
	</table>
</div>